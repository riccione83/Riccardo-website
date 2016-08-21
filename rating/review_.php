<?php

	require_once("config/db.php");
	session_start();

	$command = $_REQUEST['command'];
	if(isset($command))
	{
		switch ($command) {
			case 'get_review':
				$lat = $_REQUEST['latitude'];
				$lon = $_REQUEST['longitude'];
				$rad = $_REQUEST['radius'];
				$address = $_REQUEST['address'];
				if(isset($address))
				{	
					$latlong = getPosFromAddress($address);
     				$map = explode(',' ,$latlong);
     				$lat = $map[0];
     				$lon = $map[1];
				}
				if(!isset($rad))
				{
					$rad = 0.5;
				}
				if(isset($lat) AND isset($lon) AND isset($rad))
					getReview($lat,$lon,$rad);
				else
					echo '{"error":"Unknow command."}';
				break;
			case 'set_review':
					$user_id = $_REQUEST['user_id'];
					$lat = $_REQUEST['latitude'];
					$lon = $_REQUEST['longitude'];
					$address = $_REQUEST['address'];
					$title = $_REQUEST['title'];
					$description = $_REQUEST['description'];
					if(isset($user_id) AND ((isset($lat) AND isset($lon)) OR isset($address)) AND isset($title) AND isset($description)) {
						setReview($user_id,$lat,$lon,$address,$title,$description);
					}
					else 
						echo '{"error":"Unknow command."}';
				break;
			case 'set_rating':
					$review_id = $_REQUEST['review_id'];
					$user_id = $_REQUEST['user_id'];
					$rate = $_REQUEST['rate'];
					if(isset($review_id) AND isset($user_id) AND isset($rate)) {
						setRatingForReview($review_id,$user_id,$rate);
					}
					else 
						echo '{"error":"Unknow command."}';
				break;
			default:
				echo '{"error":"Unknow command."}';
				break;
		}
	}

//echo showReviewForPosition(10.00001,10.00001);
//setRatingForReview("1","1",5);
//getReview(37.497975,15.088133,10);
//getReviewFromAddress("via salvatore tomaselli, 7 Gravina di Catania",0.1);
//setReview("1","","","via salvatore tomaselli, 7 Gravina di catania","Casa di mamma","Qui ci abita la mamma");

function setRatingForReview($review_id,$user_id,$rate) {
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$conn->connect_errno) 
	{

		$sql = "SELECT * FROM Rating WHERE review_id = '".$review_id."' AND user_id = '".$user_id."';";
	
    	$query_check_user_name = $conn->query($sql);

   		if ($query_check_user_name->num_rows > 0) 
   		{
        	echo '{"error":"Non puoi votare ancora"}';
    	} 
    	else 
    	{
  		  /* Prepare an insert statement */
			$sql = "INSERT INTO Rating(review_id,user_id,rate_point) VALUES(".$review_id.",'".$user_id."',".$rate.")";
    		$stmt = mysqli_prepare($conn, $sql);
        
    		/* Execute the statement */
   			 mysqli_execute($stmt);
    
    		/* Return the affected rows for the statement */
    		$affected_rows = mysqli_stmt_affected_rows($stmt);
    
    		/* Close the statement */
    		mysqli_stmt_close($stmt);

    		echo '{"message":"OK"}';
		}
    }
}

function getRatingForReview($review_id) {
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    if (!$db_connection->set_charset("utf8")) {
        $errors[] = $db_connection->error;
    }

    if (!$db_connection->connect_errno) 
    {
		$sql = "SELECT SUM(Rating.rate_point)/(SELECT COUNT(*) FROM  Rating,Users,Reviews WHERE Rating.review_id = Reviews.review_id AND Rating.user_id = Users.user_id AND Reviews.review_id='".$review_id."') as rating FROM Rating,Users,Reviews WHERE Rating.review_id = Reviews.review_id AND Rating.user_id = Users.user_id AND Reviews.review_id='".$review_id."'";

		$result = mysqli_query($db_connection,$sql)or die(mysqli_error());
        $json_array = array();
        while($row = mysqli_fetch_array($result)) 
        {
            $rating = $row['rating'];
           // $json_array[] = array("review_id"=>$review_id,"rating"=>$rating);
        }
        //echo json_encode($json_array);
        mysqli_close($db_connection);
        return $rating;
    }
    else 
    {
        echo "Errore";
    }
}

function getReviewFromAddress($location,$rad) {
	 $latlong = getPosFromAddress($location);
     $map = explode(',' ,$latlong);
     $mapLat = $map[0];
     $mapLong = $map[1];
     getReview($mapLat,$mapLong,$rad);
}

// function to get  the address
function getPosFromAddress($address) {
    $address = str_replace(" ", "+", $address);
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}

function setReview($user_id,$lat,$lon,$address,$title,$description) {
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$conn->connect_errno) 
	{
			if(isset($address))
			{
				$latlong = getPosFromAddress($address);
     			$map = explode(',' ,$latlong);
     			$lat = $map[0];
     			$lon = $map[1];
			}

			$sql = "INSERT INTO Reviews(user_id,review_lat,review_lon,review_title,review_description) VALUES('".$user_id."','".$lat."','".$lon."','$title','$description')";
    		$stmt = mysqli_prepare($conn, $sql);
   			mysqli_execute($stmt);
    		$affected_rows = mysqli_stmt_affected_rows($stmt);
    		mysqli_stmt_close($stmt);
    		//echo $sql;
    		echo '{"message":"OK"}';
    }
}

function getReview($lat, $lon, $rad) {
            $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$db_connection->set_charset("utf8")) {
                $errors[] = $db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$db_connection->connect_errno) 
            {
                //$sql = "SELECT * FROM Reviews,Users Where Reviews.user_id = Users.user_id AND review_lat='".$lat."' AND review_lon='".$lon."' ORDER BY review_created_at";

    		$R = 6371;  // earth's mean radius, km

			$maxLat = $lat + rad2deg($rad/$R);
  			$minLat = $lat - rad2deg($rad/$R);
  
  			// compensate for degrees longitude getting smaller with increasing latitude
  			$maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
  			$minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));

  			// convert origin of filter circle to radians
  			$lat = deg2rad($lat);
  			$lon = deg2rad($lon);
  			$sql = "SELECT * FROM Reviews
      				WHERE review_lat>$minLat AND review_lat<$maxLat
        			AND review_lon>$minLon AND review_lon<$maxLon
    				AND acos(sin($lat)*sin(radians(review_lat)) + cos($lat)*cos(radians(review_lat))*cos(radians(review_lon)-$lon))*$R < $rad";

            $result = mysqli_query($db_connection,$sql)or die(mysqli_error());
            $json_array = array();
            while($row = mysqli_fetch_array($result)) 
            {
                		    $review_id = $row['review_id'];
                        $review_lat = $row['review_lat'];
                        $review_lon = $row['review_lon'];
                        $title = $row['review_title'];   
                        $description = $row['review_description'];
                        $review_create_at = date("d-m-Y H:i:s", strtotime($row['review_created_at']));
                        $image = "https://maps.googleapis.com/maps/api/streetview?size=400x400&location=".$review_lat.",".$review_lon."&fov=90&heading=235&pitch=10";
                        $json_array[] = array("id"=>$review_id,"lat"=>$review_lat,"lon"=>$review_lon,"title"=>$title,"description"=>$row['review_description'],"CreatedAt"=>$review_create_at,"rating"=>getRatingForReview($review_id),"image"=>$image);
            }
            echo json_encode($json_array);    
            mysqli_close($db_connection);
            }
            else {
                echo "Errore";
            }
        }