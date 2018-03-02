   <?php
     require_once 'functions/ErrorHandler.php';
  require_once 'functions/Validator.php';
  require_once 'functions/functions.php';
  require_once 'functions/prime_functions.php';
  require_once 'css/validation.php';
     
  



?>
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
          <nav>
    <div class="nav-wrapper">
      <a href="GuestIndex.php?Home" class="brand-logo">Home</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="sass.html">About</a></li>
        <li><a href="badges.html">Contact Us</a></li>
        <li><a href="collapsible.html">All Portfolio</a></li>
      </ul>
    </div>
  </nav>
         <script src = "js/jquery-1.11.3.min.js"></script>    
          <script type="text/javascript" src="../js/materialize.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js"></script> 
<script>
    var socket  = io.connect('http://localhost:3100'); 
</script>  
        <div class = "container">
              <?php 
             if(isset($_GET['ClientViewPortfolio'])){
              include('ClientViewPortfolioG.php');
              }
              if(isset($_GET['Home'])){
              include('HomePage.php');
              }
        
        
        ?>
        
        </div>
     <script>
        $(document).ready(function(){
    
 
//Update profile picture thumbnails end    
$('.tooltipped').tooltip({delay: 50});
 
$('#slide-out').show();
  
           //initialize sidenavbar
           $('.carousel.carousel-slider').carousel({fullWidth: true});
           $('.button-collapse').sideNav();
           $('.modal').modal();
           $('select').material_select();
});
    </script> 
        
        
        
      <!--Import jQuery before materialize.js-->
      
    </body>
  </html>
 