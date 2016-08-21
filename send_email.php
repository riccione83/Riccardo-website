<?php
date_default_timezone_set('Europe/Rome');

require 'views/views.php';
require 'phpmailer/PHPMailerAutoload.php';

$email_submitted = false;

if (!empty($_GET["first_name"]) && !empty($_GET["last_name"]) && !empty($_GET["email"]) && !empty($_GET["notes"])) {

            $first_name =$_GET["first_name"];
            $last_name =$_GET["last_name"];
            $email =$_GET["email"];
            $notes =$_GET["notes"];

            $d='upload/';
    	    $de=$d . basename($_FILES['file']['name']);
    		move_uploaded_file($_FILES["file"]["tmp_name"], $de);
			$fileName = $_FILES['file']['name'];
    		$filePath = $_FILES['file']['tmp_name'];

            email($first_name,$last_name,$email,$notes,$_FILES['file']['tmp_name']);
        //  header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
    } 


function email($fname,$lname,$email,$notes,$attachment) {
	date_default_timezone_set('Europe/Rome');
	
	$messaggio = new PHPmailer();
	$messaggio->IsSMTP();
	$messaggio->Host	   = "out.itesys.it";
	$messaggio->SMTPAuth   = true;                  // enable SMTP authentication
	$messaggio->Host       = "out.itesys.it"; 		// sets the SMTP server
	$messaggio->Port       = 25;                    // set the SMTP port for the GMAIL server
	$messaggio->Username   = "rizzo@2858.it"; 		// SMTP account username
	$messaggio->Password   = "Sabrina1009";         // SMTP account password


	//definiamo le intestazioni e il corpo del messaggio
	$messaggio->From = 'rizzo@2858.it';
	$messaggio->AddAddress('rizzo@2858.it');
	//$messaggio->AddReplyTo('r.riki@tiscali.it'); 
	$messaggio->Subject='Richiesta info dal sito 2858.it';
	$messages = "Richiesta informazioni da: ".$fname." ".$lname." (".$email.")\r\n";
	$messages .= $notes;
	//echo $messages;
	$messaggio->Body=stripslashes($messages);

	echo $attachment;
	if (isset($attachment)) {
    	$messaggio->AddAttachment($attachment,$attachment);
	}


	//definiamo i comportamenti in caso di invio corretto 
	//o di errore
	if(!$messaggio->Send()) { 
		$email_submitted = false; 
		echo $messaggio->ErrorInfo; 
	}
	else { 
		$email_submitted = true; //echo 'Email inviata correttamente!';
	}
	//chiudiamo la connessione
	$messaggio->SmtpClose();
	unset($messaggio);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>2858.it</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">					           <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Indie+Flower|Arvo' rel='stylesheet' type='text/css'>   <!-- Fonts -->
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
</head>
<body>

<?php printNavBar(); ?>
 
  <div class="container">
     <div class="section">
        <h2 class="header">Thankyou!</h2>
        <div class="section">
           <h5>Email was submitted succesfully.</h5>
        </div>
     </div>
  </div>
 
 <?php printFooter() ?>
 
 </body>
</html>