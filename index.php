<!DOCTYPE html>
<html lang="en">
     <head>
     <title>Home</title>
     <meta charset="utf-8">
     <link rel="stylesheet" href="css/style.css">
	 <script type='text/javascript' language='javascript' src='disclaimer.js'></script>
        <script src="js/jquery.js"></script>
     <script src="js/jquery-migrate-1.1.1.js"></script>
     <script src="js/jquery.equalheights.js"></script>
     <script src="js/jquery.ui.totop.js"></script>
     <script src="js/jquery.easing.1.3.js"></script>
   <script>
        $(document).ready(function(){

          $().UItoTop({ easingType: 'easeOutQuart' });
        }) 
     </script>

  
     <!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
         </a>
    <![endif]-->
    <!--[if lt IE 9]>
    
      <script src="js/html5shiv.js"></script>
      <link rel="stylesheet" media="screen" href="css/ie.css">
    <![endif]-->
    <!--[if lt IE 10]>
      <link rel="stylesheet" media="screen" href="css/ie1.css">
    <![endif]-->
    
     </head>
     <body class="page1">

<!--==============================header=================================-->
 <header> 
  <div class="container_12">
   <div class="grid_12"> 
    <h1><a href="index.php"><img src="images/logo.png" alt="Boo House"></a> </h1>
    <div class="menu_block">


    <nav id="bt-menu" class="bt-menu">
        <a href="#" class="bt-menu-trigger"><span>Menu</span></a>
        <ul>
         <li class="current bt-icon"><a href="index.php">Home</a></li>
         <li class="bt-icon"><a href="index2.php?act=theme&id=0">Restaurants</a></li>
         <li class="bt-icon"><a href="index.html"></a></li>
         <li class="bt-icon"><a href="index2.php?act=panier&id=0">
         
		 <?php
		if (isset($_SESSION['liste'])){
			$int = count($_SESSION['liste']);
			echo "Panier (".$int.")";
		}else echo "Panier";
		 ?>
         
         </a></li>
         <li class="bt-icon"><a href="index2.php?act=cont&id=0">Contact</a></li>
         <li class="bt-icon"><a href="index.html"></a></li>
         <li class="bt-icon"><a href="index.html"></a></li>
        </ul>
      </nav>
    
 <div class="clear"></div>
</div>
<div class="clear"></div>
          </div>
      </div>
</header>

<!--==============================Content=================================-->

<div class="content">

<a href="index2.php" class="block1">
  <img src="images/blur_img1.jpg" alt="">
  <span class="price"><span>Pizza Classique</span><span>14.99<small>&euro;</small></span><strong></strong></span>
</a>
<a href="index2.php" class="block1">
  <img src="images/blur_img2.jpg" alt="">
  <span class="price"><span>Sushi Crevette</span><span>4.00<small>&euro;</small></span><strong></strong></span>
</a>

<?php 
include_once("Base.php");
include("Nouveaute.php"); ?> 

</div>

<!--==============================footer=================================-->

<footer>    
  <div class="container_12">
    <div class="grid_6 prefix_3">
      <a href="index.html" class="f_logo"><img src="images/logo.png" alt=""></a>
      <div class="copy">
      &copy; JEAN MI DU 88 <br>
      </div>
    </div>
  </div>
</footer>
  <script>
      $(document).ready(function(){ 
         $(".bt-menu-trigger").toggle( 
          function(){
            $('.bt-menu').addClass('bt-menu-open'); 
          }, 
          function(){
            $('.bt-menu').removeClass('bt-menu-open'); 
          } 
        ); 
      }) 
    </script>
</body>
</html>