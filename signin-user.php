
<?php
session_start();
require_once 'functions/ErrorHandler.php';
require_once 'functions/Validator.php';
require_once 'functions/functions.php';
?>
<style> 
body, html {
    height: 100%;
    margin: 0;
}
.bg{
    /* The image used */
    background-image: url("background.JPG");
    /* Full height */
    height: 100%; 
    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
#SignInCard{
    opacity:0.5;
    position: absolute;
    margin-top:8em;
}
 /* label focus color */
 .input-field input:focus + label {
   color: white !important;
 }
.input-field label {
     color: white !important;
}
 /* label underline focus color */
.input-field input:focus {
   border-bottom: 1px solid white !important;
   box-shadow: 0 1px 0 0 white !important
 }
 #btnSubmit{
    border-radius: 25px;
    background:none;
    border: 2px solid white;
    padding:0.5em; 
    width: 6em;
    height: 3.5em;
    color : white;
    
}
.verifiers{
   margin-top:2em;
   color:white;
   background-color:green;
   cursor:default;
 
}
.footerwrap {
height : 250px;
background-color : #f06292;

}

.footerlogo {
float : left;
margin-left : 10px;
margin-top : 30px;
}

.footerright {
float : right;
width : 30%;

}

.footerhead {

font-family : "Impact";
font-weight: bold;
color : white;

}

.footerlistli {
list-style-type: none;
margin-bottom : 20px;
text-align : left;
font-family : "Trebuchet MS";
color : #ecf0f1;
text-decoration: none;

}

.footerlistul {
margin-top : 65px;
}

.footerlinks {
text-decoration: none;
color : #ecf0f1;

}
</style>
 
 <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 
    </head>      
      
      
    <body>
<!-- Navigation for sign and sigup -->
       <nav>
      <div class="nav-wrapper pink lighten-2">
        <a href="#!" class="brand-logo" >
		<img src="Logo.png" height="60px">
		</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse "><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down ">
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
        </ul>
      </div>
    </nav>
 <div class = "row">
 <div id  = "SignInCard" class = "card  black col s12 l6 offset-l3">
           <div class="card-content white-text">
            <div class = "center-align">
              <span class="card-title">Sign in</span>
            </div>    
             <!--  Username and Password textbox start-->
          <form id="login" action="" method = "POST"class="col s12">
            <div class="row">
                <div class="input-field col s11">
                  <input name = "loginUsername" id="username" type="text" class="validate">
                  <label for="username">Username</label>
                        <p id = 'errorusername2'  class = "#ef5350 red lighten-1 white-text"></p>
                </div>
               
                
                <a id = "usernameVerified"  class=" tooltipped verifiers col s1" style = "color:white" data-position="right" data-delay="50" data-tooltip="Verified">
                     <i class="material-icons">check</i>
                </a>
 
        
            </div>
            <div class = "row">
                <div class="input-field col s11">
                  <input name = "loginPassword" type = "password" id="password" type="text" class="validate">
                  <label for="password">Password</label>
                     <p id = 'ErrorMessage' class = "ef5350 red lighten-1 white-text"></p> 
                </div>
             
                     <a id = "passwordVerified"  class=" tooltipped verifiers col s1" style = "color:white" data-position="right" data-delay="50" data-tooltip="Verified">
                     <i class="material-icons">check</i>
                </a>
            </div>
                      <div class = "row">
                    <div class = " col s2  offset-s5">
                 
        <input type="submit"  id = 'btnSubmit' name = "login" class="btn btn-success btn-block" value = 'Sign in'>
                
                          </div>
                </div>
           </form>    
                
       
             <!--  Username and Password textbox End-->
           </div>
    <br><br>     
</div> <!-- Card end div --> 
   
    <div class = "bg">
    </div>
     <!--Foooter Start -->
              <div class="footerwrap">
<img src="LogoFooter.png" width=250 class="footerlogo">
<div class="footerright">
<ul class="footerlistul"><li class="footerlistli"><b class="footerhead">DIRECTORY</b></li>
<li class="footerlistli"><a href="" class="footerlinks">Login</a></li>
<li class="footerlistli"><a href="" class="footerlinks">Careers</a></li>
<li class="footerlistli"><a href="" class="footerlinks">Contact Us</a></li>
</div>
</div>
<!--Footer End -->
</div> 
    <!--Import jQuery before materialize.js-->
    <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
     <script src = "http://localhost:3100/socket.io/socket.io.js"></script> 

<script>
$(document).ready(function(){
    var socket = io.connect('http://localhost:3100');
    $('#btnSubmit').prop('disabled',true); //Disable The sign in button    
    $('#usernameVerified').hide();
    $('#passwordVerified').hide(); 
             
jQuery('#username').on('input propertychange paste', function(){    
            //alert('hello world');
             socket.emit('Check Username',$('#username').val(),'user_iid','username','users',function(variable_value,u_primary_id_col_n,variable_col_n,tblName){});      
  
});
 socket.on('Username Error',function(data){
                   $('#errorusername2').empty();
     if ($('#username').val().length < 11){
                     $('#usernameVerified').hide();  
    }else{
         if (data.rows == 0 ){
             console.log("data.rows value: "+data.rows);
             $('#errorusername2').append('Username does not exist');
             $("#errorusername2").css("color", "red");
             $('#usernameVerified').hide();  
             $('#btnSubmit').prop('disabled', true);
          }else{
             $('#usernameVerified').show();
             console.log("data.rows value: "+data.rows);
          }
    }
});
jQuery('#password').on('input propertychange paste', function() {
             $('#ErrorMessage').empty();
              if($('#password').val().length > 10){
                   socket.emit('Check Login',$('#username').val(),$('#password').val(),function(username,password){}); 
                     $('#ErrorMessage').empty();
              }else{ 
                   $('#passwordVerified').hide(); 
                    $('#btnSubmit').prop('disabled', true);
                     $('#ErrorMessage').append('Username and password does not match');
              }
});
socket.on('Accept Login',function(data){
    $('#loadingLogin').show();
    $('#ErrorMessage').empty();
    if(data.result === true){
       $('#loadingLogin').hide();
       console.log('Enabled');
       $('#btnSubmit').prop('disabled', false);
       $('#ErrorMessage').empty();
       $('#passwordVerified').show(); 
    }else{
       $('#btnSubmit').prop('disabled', true);
       $('#passwordVerified').hide(); 
       $('#ErrorMessage').append('Username and password does not match');
                          
    }
});
 
});        
</script>
<?php
      
   if(isset($_POST['login'])&&(isset($_POST['loginUsername']))&&(isset($_POST['loginPassword']))){
         echo  $_POST['loginUsername'];
            $loginUsername  =  sanitizeString($_POST['loginUsername']);
               $loginPassword  =  sanitizeString($_POST['loginPassword']);
                $result = queryMysql("SELECT * FROM users where username = '$loginUsername'");
                $row  = mysqli_fetch_array($result);              
                $user_id    = $row['user_iid'];
                $user_level = $row['levels'];
                  
                     if($user_level == "Client"  || $user_level == "Interior Designer"){
                          //echo "<script>alert('The username and password does not match')</script>";
                           $_SESSION['user_level']= $user_level;
                          $_SESSION['user_id'] = $user_id;
                           echo "<script>window.open('clientmainpage.php','_self')</script>";
                     }else{
                         //echo "shit";
                          $_SESSION['user_level']= $user_level;
                          $_SESSION['user_id'] = $user_id;
                         echo "<script>window.open('admin_meta_index.php?dashboard','_self')</script>";
                     }         
   }
        
?> 
    </body>
  </html>

