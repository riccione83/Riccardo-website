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
 
  <div class="container">

       <div class="section">
         <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Contact me</span>
              <p>
                  <b>Riccardo Rizzo</b><br>
                  Catania (CT) - Italy<br>
              </p>
            </div>
            <div class="card-action">
              <a href="mailto:r.riki@tiscali.it&subject=Informazioni dal sito">Email me</a>
            </div>
          </div>
     </div>

 </div> 
 <?php printFooter() ?>

 </body>
     
</html>