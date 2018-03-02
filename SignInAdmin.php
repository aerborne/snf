
<?php
session_start();
require_once '../functions/ErrorHandler.php';
require_once '../functions/Validator.php';
require_once '../functions/functions.php';
 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>See and Feel Company |</title>
  
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
     
  </head>
  <body>

     
      
<div class="card">
    <div class="card-image waves-effect waves-block waves-light">
      <img class="activator" src="background.JPG">
    </div>
    <div class="card-content">
      <span class="card-title activator grey-text text-darken-4">Click to Sign In<i class="material-icons right">more_vert</i></span>
    </div>
    <div class="card-reveal card-panel #f3e5f5 purple lighten-5">
       <div class = "container">
          <div class  = "col s3">    
            <div class = "center-align">
                 <div class = "card">
                     <h1  style = "font-size:3em"class="text-center flow-text"> Turning visions to reality.. <small>  </small></h1>
                 </div>
            </div>
           </div>
        </div>
        <br><br><br>    
        
        
      <span class="card-title grey-text text-darken-4">Sign In<i class="material-icons right ">close</i></span>
        <br><br>
              <form id="login" action="" method = "POST" class="well">
                    <div class="input-field col s12">
                    <label>Username</label>
                    <input id = "username" type="text" name = "loginUsername" class="validate" placeholder="Enter Username">
                      <p id = 'errorusername2' style = 'color:red;'></p>
                  </div>
                    <div class="input-field col s12">
                    <label>Password</label>
                    <input id = "password" type="password" name = "loginPassword" class="validate" placeholder="Password">
                  </div>
                <p id = 'ErrorMessage' style = 'color:red'></p> 
                    
                      <input type="submit"  id = 'btnSubmit' name = "login" class="btn btn-success btn-block" value = 'Login'>
                     
                <br>
        </form>
     
    </div>
  </div>
 

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
              
              
              
          
          </div>
        </div>
      </div>
    </header>

 
      
        
    <section id="main">
      <div class="container">
        <div class="row">
              <div class="col-md-4  col-md-offset-4 ">
      
                     
                
                
                <script src = "js/jquery-1.8.0.js"></script>
                <!--
      <script src = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
-->
    <script src = "../js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script> 
     <script>
               $(document).ready(function(){
                    $('#btnSubmit').prop('disabled', true);
                     var socket = io.connect('http://localhost:3100');
                     $('#login').submit(function(e){
                     
                        
                     }); 
                   
         
                   
       jQuery('#username').on('input propertychange paste', function() {
             socket.emit('Check Username',$('#username').val(),function(username){});        
                       
        });
        socket.on('Username Error',function(data){
                
                   $('#errorusername2').empty();
               if ($('#username').val().length < 11){
                       //alert('Username is less than  11');  
                }else{
                if (data.rows == 0 ){
                     //alert(data.rows);
                    $('#errorusername2').append('Username does not exist');
                     $("#errorusername2").css("color", "red");
                     $('#btn_submit').prop('disabled', false);
                }else{
                    //alert(data.rows);
                 $("#errorusername2").css("color", "green");
                    $('#errorusername2').append('Username does exist ');
                    $('#btn_submit').prop('disabled', true);
                }
                }
            
           });
                   
              jQuery('#password').on('input propertychange paste', function() {
                    
                          //alert('HEllo');
                          socket.emit('Check Login',$('#username').val(),$('#password').val(),function(username,password){});      
                      //alert($('#username').val()); 
              });
               socket.on('Accept Login',function(data){
                   //alert(data.result);
                    $('#ErrorMessage').empty();
                       if(data.result === true){
                            console.log('Enabled');
                           $('#btnSubmit').prop('disabled', false);
                          $('#ErrorMessage').empty();
                       }else{
                           $('#btnSubmit').prop('disabled', true);
                           $('#ErrorMessage').append('Username and password does not match');
                          
                       }
               });
                   
               });
     </script>
     
                <?php 
        if(isset($_POST['login'])&&(isset($_POST['loginUsername']))&&(isset($_POST['loginPassword']))){
            
               $loginUsername  =  sanitizeString($_POST['loginUsername']);
               $loginPassword  =  sanitizeString($_POST['loginPassword']);
                $result = queryMysql("SELECT * FROM users where username = '$loginUsername'");
                $row  = mysqli_fetch_array($result);              
                $user_id    = $row['user_iid'];
                $user_level = $row['levels'];
                  
                     if($user_level == "Client"  || $user_level == "Interior Designer"){
                          echo "<script>alert('The username and password does not match')</script>";
                     }else{
                         //echo "shit";
                          $_SESSION['user_level']= $user_level;
                          $_SESSION['user_id'] = $user_id;
                         echo "<script>window.open('index.php','_self')</script>";
                     }         
        }
        ?>
      
          </div>
        </div>
      </div>
    </section>

    <footer id="footer" class="footer navbar-fixed-bottom">
 
    </footer>

  <script>
     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
         <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html> 
