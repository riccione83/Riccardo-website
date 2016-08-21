<?php
    require 'views/views.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Riccardo Rizzo - website</title>

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
 
  <ul class="collection">
    <li class="collection-item avatar">
      <img src="img/ratingme.png" alt="" class="circle">
      <span class="title">RatingMe</span>
      <p>RatingMe has approved and is available on the AppStore <br>
         Download it now! It's Free Forever!
      </p>
      <a href="https://itunes.apple.com/us/app/ratingme/id1062799247" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
	
    <li class="collection-item avatar">
      <img src="img/ratingmeweb.png" alt="" class="circle">
      <span class="title">RatingMe Website</span>
      <p>Online the website. Register for free and share your question with the world! <br>
         Free forever!
      </p>
      <a href="http://www.ratingme.eu" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
	
    <li class="collection-item avatar">
      <img src="img/multi1.png" alt="" class="circle">
      <span class="title">MultiFiles</span>
      <p>Still in development. The App is fine but I think that other functionality can be inserted. <br>
         Stay tuned for MultiFiles news
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
    <li class="collection-item avatar">
      <img src="img/multiweb.png" alt="" class="circle">
      <span class="title">MultiFiles Website</span>
      <p>The website is done. Was written in PHP, but now I have some knowledge of Rails and I'll rewrite it soon. <br>
         I need only some time to make it. 
      </p>
      <a href="http://www.riccardorizzo.eu/dev" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
  </ul>
  
  <br>
  <br>
  <br>
 
 <?php printFooter() ?>



 </body>
     
</html>