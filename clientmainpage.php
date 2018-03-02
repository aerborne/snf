
<?php
 
  session_start();
  require_once 'functions/ErrorHandler.php';
  require_once 'functions/Validator.php';
  require_once 'functions/functions.php';
  require_once 'functions/prime_functions.php';
  require_once 'css/validation.php';
 
  if(!$loggedin)
  die();
  $user_id = $_SESSION['user_id']; 
  $logged_in_user_level = $_SESSION['user_level'];
    
 $select_username  = queryMysql("SELECT  username from users where user_iid = '$user_id'");
  $row_select_username  = mysqli_fetch_array($select_username);
  $select_username_result =  $row_select_username['username'];

  $availability_result = queryMysql("SELECT  *   FROM  users where user_iid =  '$user_id' and available = 0 ");
    $row_availability = mysqli_fetch_array($availability_result);
      $availability_result = $row_availability['levels'];
    if($availability_result  == "Client"){

        

?>  

<?php 
///Setting Current Profile Picture
  $logged_user_id  = $_SESSION['user_id'];
  $select_current_profile_picture  = queryMysql("select  * from users left join user_images on users.user_iid = user_images.user_iid  where  user_images.selected = 0  and users.user_iid = '$logged_user_id' ");
  $row_select_current_profile_picture    = mysqli_fetch_array($select_current_profile_picture);
  $current_user_images_id =  $row_select_current_profile_picture['user_images_id'];
  $current_path = $row_select_current_profile_picture['path'];
  if( $current_user_images_id == ""){
      $current_path = 'simages/no_picture.png';
  }else{
     // echo  "There is a photo";
  }
///Create a row first then execute query
?>

<div id  = "logged_user_id" style = display:none><?php  echo $user_id;?></div>
<div id  = "logged_user_level" style = display:none><?php  echo   $logged_in_user_level;?></div>
<div id  = "logged_username" style = display:none><?php  echo    $select_username_result;?></div>
<head>
        <link type="text/css" rel="stylesheet" href="css/AddProjectProgress.css"  media="screen,projection"/>
  <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
   <link type="text/css" rel="stylesheet" href="css/ionicons/css/ionicons.min.css"  media="screen,projection"/>
        <link href="css/style2.css" rel="stylesheet">
    <link href="css/ThumbGallery.css" rel="stylesheet">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

 <script src = "js/jquery-1.11.3.min.js"></script>    
<script src = "http://localhost:3100/socket.io/socket.io.js"></script> 
<script>
    var socket  = io.connect('http://localhost:3100'); 
    socket.on('connect', function() {    
      
        
        socket.emit('addUser',$('#logged_user_id').html(),$('#logged_username').html(),$('#logged_user_level').html(),' ',' ',' ',' ',' ');
});  
  socket.on('countMessagesValuesClient',function(countMessagesValues){
           $('#messageCounter').empty();
           $.each(countMessagesValues,function(key,value){
               $('#messageCounter').prepend('<div>'+value+'</div>');
           });
      $('#MessageClick').click(function(){
      
         socket.emit('Seen Messsages Client'); 
});
      $('#notification_click').click(function(){
          //alert('notification click has been triggered'); 
          socket.emit('Seen Notification');
}); 
});
socket.on('ProjectNotificationHistory',function(data){
           $('#notification_content').append('<a href="'+data.reference_link+'" style = "color:black"><hr>'+data.username+' '+data.notification_message+'<hr></a>');
});
socket.on('countNotification',function(countNotification){
          $('#notification_value').empty();
           $.each(countNotification,function(key,value){
               $('#notification_value').prepend('<div>'+value+'</div>');
           });
});        
               


</script>  


        <ul id="slide-out" class="side-nav  #f3e5f5 purple lighten-3 white-text">
              <a  href = "">
            <li>
 
          
          </li>
                   </a>
        <li>
           <div class = "divider">
           </div>    
        </li>
          <li>
              <a class = "white-text" href="clientmainpage.php?myprojects">MyProjects</a>
          </li>
          
         <li> 
           <a class = "white-text" href = "#">About Us</a>    
         </li>
          <li>
            <a class = "white-text" href="clientmainpage.php?allportfolio">Portfolio</a>
          </li>
            <li>
            <a class = "white-text" href="">Featured Projects</a>
          </li>
            <li>
            <a class = "white-text" href="#">Contact</a>
          </li>
 
  
          <li>
            <div  class="divider"></div>
          </li>
          <li>
            <a  class = "white-text" class="waves-effect modal-trigger" href="ClientMainPage.php?Logout">Sign Out</a>
          </li>       
        </ul>

<div class=" #e040fb purple accent-2 navbar-fixed" style = "position:relative;width:100%;height:2.5em">
     
          <a href="" data-activates="slide-out" class="button-collapse" ><i class="small material-icons white-text">menu</i></a> 
 
    
    
          <span  class = "NavAccountProfileImage">
                <a  class="waves-effect waves-light modal-trigger" href="#NavAccountInformationModal">
                    
                    <img id =  "UpperRightProfileThumb" src="<?php echo $current_path; ?>" alt="" class="circle responsive-img" style = "height:2em" > 
              </a>
          </span>
    
  <!-- Modal Structure -->

    
    
    
          <span class = "MyAccountIcons">
               <a id = "MessageClick" href = "clientmainpage.php?messagepanel" class = "iconHoverColor" style = "cursor:pointer">
                     <span style = "position:relative"><i class="small material-icons  white-text">mail_outline</i><span id = "messageCounter" class = "NavAccountNotifCounterBox">10</span></span>
              </a>
             <a id = "" class = "iconHoverColor" style = "cursor:pointer">
            <span style = "position:relative"><i class="small material-icons  white-text">language</i><span class = "NavAccountNotifCounterBox">19</span></span> 
             </a> 
          </span>  
    </div>

<div id="MyProfileInfoPanelPicUploadB" class="modal">
    <div class="modal-content">
              
    <?php include('ChangeMyProfilePicture.php'); ?>

    </div>
</div>  
 <!-- NavAccountInformationModal start --> 
<div id="NavAccountInformationModal" class="modal">
    <div class="modal-content">
          <!-- Edit  input fields Start -->
<div class ="container">
  <!-- Modal Structure -->
<div class="row">
<div class = "col s12" >
     <div class = "displaySelectedPhoto">
         <div class = "textCenterOfPhotoBG">
             <div id = "DisplaySelectedProfilePic">
                   <a  class=" modal-trigger modal-close"   href="#MyProfileInfoPanelPicUploadB"><img  id =  "DisplayEditProfileThumb"  src="<?php echo $current_path; ?>" alt="" class="responsive-img displayProfilePhoto" ></a> 
                   <p class="textCenterOfPhoto">Change Profile Picture</p>
               </div>    
         </div>
    </div>  
    <!-- Put an image for upload picture -->
</div>
<div  style = "margin-bottom:30em"></div>
<?php include('EditMyProfileForm.php') ?>
   
</div>        
</div>           
<!-- Edit  input fields End --> 
    </div>
</div>    
<!-- NavAccountInformationModal end -->  
<div class = "container">
    <div  style = "margin-bottom:5em"></div>
    <?php 
if(isset($_GET['myprojects'])){
  include('MyProjects.php');
}
if(isset($_GET['clientviewproject'])){
  include('ClientViewProject1.php');
}
 
if(isset($_GET['allportfolio'])){
  include('ClientAllPortfolio.php');
}
if(isset($_GET['clientviewportfolio'])){
  include('ClientViewPortfolio.php');
}
if(isset($_GET['logout'])){
  include('SignOutAdmin.php');
}
if(isset($_GET['messagepanel'])){
  include('DirectMessages.php');
}
?>

</div>


      <script src = "js/JQuery-1.8.0.js"></script>
     <script src = "js/jquery-1.11.3.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
     <script>
/*         
 
*/
$(document).ready(function(){
    
//Update profile picture thumbnails start
socket.on('set updateProfilePicture',function(data){
    $('#sidebarProfileThumb').attr('src',data.up_path);
    $('#UpperRightProfileThumb').attr('src',data.up_path);
    $('#DisplayEditProfileThumb').attr('src',data.up_path);
});
//Update profile picture thumbnails end    
$('.tooltipped').tooltip({delay: 50});
$('#test123').click(function(e){
    e.preventDefault();
    alert('Hello world');
});
$('#slide-out').show();
    
           //initialize sidenavbar
           $('.carousel.carousel-slider').carousel({fullWidth: true});
           $('.button-collapse').sideNav();
           $('.modal').modal();
           $('select').material_select();
});
        
     </script>
<?php

    }else{
        
    }
?>