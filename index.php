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
  
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58428963-1', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>
<script src="/cookiechoices.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function(event) {
    cookieChoices.showCookieConsentBar('This website uses cookies to ensure you get the best experience on my website.',
      'close message', 'learn more', 'http://www.garanteprivacy.it/web/guest/home/docweb/-/docweb-display/docweb/2142939');
  });
</script>  
<?php printNavBar(); ?>
  
  <div class="parallax-container valign-wrapper">
   <div class="slider">
    <ul class="slides">
      <li>
        <img src="img/background1.jpg"> <!-- random image -->
        
        <div class="caption center-align">
         <div class="container">
          <div class="card blue-grey lighten-5"  style="opacity:0.8;">
            <div class="card-content black-text">
                  <h3 class="darken-4">Welcome</h3>
                  <h4 class="black-text">to my personal website.</h4>
            </div>
            </div>
          </div>
        </div>
        
      </li>
      <li>
      <img src="img/background2.jpg"> <!-- random image -->
        <div class="caption left-align">
          <h3>Watch my porfolio</h3>
          <a href="portfolio.php" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Go!</a>
          <!--<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
        </div>
      </li>
	  
      <li>
      <img src="img/background3.jpg"> <!-- random image -->
        <div class="caption right-align">
          <h3>Something about me</h3>
          <a href="about_me.php" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Go!</a>
        </div>
      </li>
	  
      <li>
        <img src="img/background4.jpg"> <!-- random image -->
        <div class="caption center-align">
          <h3>Feel free to contact me.</h3>
          <a href="contact.php" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Contact</a>
        </div>
      </li>
    </ul>
  </div>
  </div>
<br>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h3>Contact me via social</h3>
          

		  <!--   Icon Section   -->
      <div class="row">
        <div class="col s4">
          <div class="icon-block">
            <h2 class="center brown-text"><img src="img/facebook.png" width="40" height="40" alt="facebook icon"></h2>
            <h5 class="center">Follow me on Facebook</h5>
            <a href="https://www.facebook.com/riccione83" class="light center">Follow me on Facebook.</a>
          </div>
        </div>

        <div class="col s4">
          <div class="icon-block">
            <h2 class="center brown-text"><img src="img/github.gif" width="40" height="40" alt="facebook icon"></h2>
            <h5 class="center">Watch my sources</h5>
            <a href="https://www.github.com/riccione83" class="light center">Watch my sources on GitHub</a>
          </div>
        </div>
		
        <div class="col s4">
          <div class="icon-block">
            <h2 class="center brown-text"><img src="img/twitter.png" width="40" height="40" alt="twitter icon"></h2>
            <h5 class="center">Follow me on Twitter</h5>

            <a href="http://twitter.com/riccione83" class="light center">Follow me on Twitter.</a>
          </div>
        </div>
      </div>
	 
        </div>
      </div>
  <hr>

</div>
  </div>

  <?php printFooter() ?>

  <script type="text/javascript">
    $(document).ready(function () {
    // Plugin initialization
    $('.slider').slider();
})
  </script>


  </body>
</html>
