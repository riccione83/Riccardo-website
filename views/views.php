<?php
 if(!isset($_SESSION)) 
 { 
	session_start();
 }


function printNavBar() {
    echo '
        <div class="navbar-fixed">
            <nav class="#81d4fa light-blue lighten-3" role="navigation">
                <div class="nav-wrapper">
	
                	<ul id="dropdown1" class="dropdown-content">
                		<li><a href="#!">Services</a></li>
                		<li><a href="#!">Technologies</a></li>
                		<!--  <li class="divider"></li>  -->
                		<li><a href="#!">three</a></li>
                	</ul>
                    <a id="logo-container" href="index.php" class="brand-logo font-logo" style="font-logo"><img src="img/logo.png" width="100" height="40" alt="LOGO" style="vertical-align: middle;"></a>

                    <ul id="nav-menu-mobile" class="right hide-on-med-and-down">
                      <li><a href="index.php">Home</a></li>
                      <li><a href="about_me.php">About me</a></li>
                      <li><a href="portfolio.php">Portfolio</a></li>
                	  	<li><a href="news.php">News</a></li>
                		  <li><a href="contact.php">Contact me</a></li>;';
              echo' </ul>
                    <ul id="nav-mobile" class="side-nav">
                      <li><a href="/index.php">Home</a></li>
            		      <li><a href="about_me.php">About me</a></li>
            		      <li><a href="portfolio.php">Portfolio</a></li>
            		      <li><a href="news.php">News</a></li>
            		      <li><a href="contact.php">Contact me</a></li>';
	    
                echo '</ul>
                      <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons">menu</i></a>
                      </div>
                      </nav>
                      </div>';
}

function printSmallFooter() {
  echo '
   <footer class="page-footer #81d4fa light-blue lighten-3">
    <div class="footer-copyright">
        <a class="black-text text-lighten-4 left" href="#!"> © 2015 Riccardo Rizzo</a>
    </div>
  </footer>
  ';
}

function printFooter() {
	printSmallFooter();
}

?>