
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
    if($availability_result  == "Client" || $availability_result == "Interior Designer" || $availability_result   == "Owner"){

    }else{

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
///Setting Current Profile Picture
?>



<div id = "user_id" style = "display:none"><?php  echo  $logged_user_id ; ?></div>
<div id = "user_id" style = "display:none"><?php  echo  $logged_in_user_level ; ?></div>
<div id = "username" style = "display:none"><?php  echo  $select_username_result ; ?></div>

<!DOCTYPE html>
  <html>
    <head>
        <link type="text/css" rel="stylesheet" href="css/AddProjectProgress.css"  media="screen,projection"/>
  <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
   <link type="text/css" rel="stylesheet" href="css/ionicons/css/ionicons.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
#img {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 700px;
}

     .yourdiv
{
    display: inline;
     margin-top: 100px;
    margin-bottom: 100px;
    margin-right: 150px;
     margin-left: 450px;
}


.HeaderDiv {
height : 350px;
background-image : url("img/bg.jpg");
background-size: cover;
background-position: center;
margin-bottom : 0px;
    margin: auto;
}

.HeaderColor {
height : 100px;
background-color : black;
opacity: 0.5;
}
.HeaderNav {
height : 75px;
width : 45%
right: 0;

position : fixed;
padding-top : 40px;

}

.HeaderButtons {
right: 15;
margin-top : 5px;
margin-right : 30px;
color: white;
text-decoration: none;
border-style: solid;
border-radius : 25px;
padding-left : 15px;
padding-right : 15px;
padding-top : 7px;
padding-bottom : 7px;
margin-left : 10px;
font-weight: bold;
font-family : "Lucida Console";
text-shadow: 1px 1px black;
right: 0;

position : fixed;

}

.HeaderPhrase {
font-family : "Verdana";
font-weight: bold;
width : 60%;
margin-top : 30px;
padding-top : 0;

}

.HeaderFont {
color : white;
font-size : 70px;
text-shadow: 2px 2px black;
margin: auto;

}

.HeaderFont2 {
color : white;
font-size : 20px;
margin: auto;

}

    .footerwrap {
height : 250px;
background-color : #f06292;

}
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
    </head>
    <body>


<script src = "http://localhost:3100/socket.io/socket.io.js"></script>
<script>
    var socket  = io.connect('http://localhost:3100');


        socket.on('connect', function() {
            socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),' ',' ',' ',' ',' ');
        });
        socket.on('countMessagesValuesClient',function(countMessagesValues){
           $('#messageCounterAdmin').empty();
           $.each(countMessagesValues,function(key,value){
               $('#messageCounterAdmin').prepend('<div>'+value+'</div>');
        });
                $('#MessageClick').click(function(){
         socket.emit('Seen Messsages Client');
});
        });





</script>
        <ul id="slide-out" class="side-nav  #f3e5f5 purple lighten-3 white-text">
              <a  href = "">
            <li>
    <div class="col s5 m8 offset-m2 l4 offset-l3">
        <div class="card-panel #f3e5f5 purple lighten-5 z-depth-1" style  = "height:4em">
          <div class="row valign-wrapper">
            <div class="col s4">
            <!-- sidebar profilepicture thumbnail -->
                      <img id = "sidebarProfileThumb" src="<?php echo $current_path; ?>" alt="" class=" responsive-img">

            </div>
            <div class="col s10">
              <span class = "white-text">
            <?php  echo   $select_username_result ;?>
              </span>
            </div>
          </div>
        </div>
      </div>

          </li>
                   </a>
        <li>
           <div class = "divider">
           </div>
        </li>
          <li>
              <a class = "white-text" href="admin_meta_index.php?dashboard">Dashboard</a>
          </li>

         <li>
           <a class = "white-text" href = "index.php">Home</a>
         </li>
          <li>
            <a class = "white-text" href="#">Contact</a>
          </li>
     <li class="  #f3e5f5 purple lighten-3 ">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header #f3e5f5 purple lighten-3 white-text">Manage Content<i class="mdi-navigation-arrow-drop-down"></i></a>
            <div class="collapsible-body #f3e5f5 purple lighten-3">
              <ul>
               <li><a class = "white-text" style = "background-color:" href="#">Manage Homepage</a></li>
               <li><a class = "white-text" style = "background-color:" href="#">Manage Gallery</a></li>
               <li><a class = "white-text" href  = "admin_meta_index.php?allusers">Manage Users</a></li>
               <li><a class = "white-text" href  = "admin_meta_index.php?allportfolio">Manage Portfolios</a></li>
               <li><a class = "white-text"  href = "admin_meta_index.php?allcategory">Manage Category</a> </li>
               <li><a class = "white-text" href  = "admin_meta_index.php?allprojectpage">Manage Projects</a></li>
             <li><a class = "white-text" href  = "admin_meta_index.php?allsection">Manage Section</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
       <li class="  #f3e5f5 purple lighten-3 ">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header #f3e5f5 purple lighten-3 white-text">Add Content<i class="mdi-navigation-arrow-drop-down"></i></a>
            <div class="collapsible-body #f3e5f5 purple lighten-3">
              <ul>
               <li><a class = "white-text" href  = "admin_meta_index.php?uadd">Add Users</a></li>
               <li><a class = "white-text" href  = "admin_meta_index.php?AddPortfolio">Add Portfolios</a></li>
               <li><a class = "white-text"  href = "admin_meta_index.php?cadd">Add Category</a> </li>
               <li><a class = "white-text" href  = "admin_meta_index.php?padd">Add Projects</a></li>
                <li><a class = "white-text" href  = "admin_meta_index.php?sadd">Add Section</a></li>
             </ul>
            </div>
          </li>
        </ul>
      </li>
          <li>
            <div  class="divider"></div>
          </li>
          <li>
            <a id = "logout" class = "white-text" class="waves-effect modal-trigger" href="admin_meta_index.php?logout">Sign Out</a>
          </li>
        </ul>



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
<div class=" #e040fb purple accent-2 navbar-fixed" style = "position:relative;width:100%;height:2.5em">
          <a href="" data-activates="slide-out" class="button-collapse" ><i class="small material-icons white-text">menu</i></a>
          <span  class = "NavAccountProfileImage">
                <a  class="waves-effect waves-light modal-trigger" href="#NavAccountInformationModal">

                    <img id =  "UpperRightProfileThumb" src="<?php echo $current_path; ?>" alt="" class="circle responsive-img" style = "height:2em" >
              </a>
          </span>

  <!-- Modal Structure -->




          <span class = "MyAccountIcons">
               <a id = "MessageClick" href = "admin_meta_index.php?messagepanel" class = "iconHoverColor" style = "cursor:pointer">
                     <span style = "position:relative"><i class="small material-icons  white-text">mail_outline</i><span class = "NavAccountNotifCounterBox" id = "messageCounterAdmin">10</span></span>
              </a>
             <a class = "iconHoverColor" style = "cursor:pointer">
            <span style = "position:relative"><i class="small material-icons  white-text">language</i><span class = "NavAccountNotifCounterBox" id = "notification_value">0</span></span>
             </a>
          </span>
    </div>








<!-- Add Portfolio  modal start -->
        <div id="signInModal" class="modal">
          <div class="modal-content">
            <div class="card-panel violet">
             <span>
               <div class = "form-group">
                  <label>Portfolio Name:</label>
                    <input name = "portfolio_name" id = "portfolio_name" type="text" class="form-control" placeholder="Portfolio Name">
                </div>
             <div class="input-field col s12">
                  <textarea  name = "description" id="description" class="materialize-textarea"></textarea>
                  <label for="textarea1">Description</label>
              </div>
                 <label>Category</label>
                      <div class = "form-group">
                      <?php
                      $result = queryMysql("selecT * From category");
                      echo "<select id = 'category_id' name='category_id' class ='browser-default'>";
                            while ($row = $result->fetch_assoc()){
                            unset($id, $name);
                            $id = $row['category_id'];
                            $name = $row['category_name'];
                            echo '<option name ="ucat" value="'.$id.'">'.$name.'</option>';
                           }
                           echo '</select>';
                      ?>
                      </div>
             </span><br><br>
                  <div class = "center-align">
                        <a class= "waves-effect modal-trigger modal-close btn" id = "AddPortfolioBtn" href="#uploadOption">Add</a>
                  </div>
            </div>
          </div>
        </div>
  <!-- Add Portfolio Modal End -->
        <!--

         <a href="" class="btn tooltipped" data-position="top" data-tooltip="I am tooltip">Hover Me</a>
        -->
        <div id="uploadOption" class="modal">
          <div class="modal-content">
            <div class="card-panel violet">
             <span>
             </span>
                <h4>Choose where to get photos</h4>
<?php
  $select_portfolio_id        = queryMysql("SELECT  * from  portfolio  order by portfolio_id desc limit 1 ");
  $row_select_portfolio_id    = mysqli_fetch_array($select_portfolio_id);
  $select_portfolio_id_result =  $row_select_portfolio_id['portfolio_id'] + 1;
?>
                  <div class = "row">
                      <div class = "center-align">
                      <div class  = "col s3">
                          <a class="waves-effect modal-trigger modal-close btn tooltipped" href="index.php?GalleryPortfolioP" data-position="top" data-tooltip="Select photos from the website gallery.">Gallery</a>
                      </div>
                      <div class = "col s3">
                         <a class="waves-effect modal-trigger modal-close btn tooltipped" position="top" data-tooltip="Upload photos from your computer" href="index.php?UploadPortfolioP=<?php echo $select_portfolio_id_result; ?> ">Upload</a>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
<!-- SignIn  modal end -->

               <div class="headerDiv">

		<div class="HeaderLogo">
            <br>

		</div>

		<center>
            <div class="container">
		<div class="HeaderPhrase">

	<h2 class="center-align" style="color : white;
font-size : 50px;
text-shadow: 2px 2px black; font-weight: 900;">See and Feel Interior Design</h2>
			<h3 class="center-align" style="color : white;
font-size : 15px;
margin: auto; font-weight: bold;">Everything is possible if we try</h3>

		</div>

                </div>
		</center>


</div>
<br><br>

<?php


if(isset($_GET['importproject'])){
  include('ImportProject.php');
}
if(isset($_GET['NotificationPage'])){
  include('NotificationPage.php');
}
if(isset($_GET['allprojectpage'])){
  include('AllProjectProgress2.php');
}
if(isset($_GET['allsection'])){
  include('AllSection.php');
}

if(isset($_GET['allportfolio'])){
  include('AllPortfolioList.php');
}
if(isset($_GET['portfolio'])){
  include('PortfolioGallery.php');
}
if(isset($_GET['padd'])){
 // include('AddProjectProgress.php');
  include('AddProjectProgress2.php');
}
if(isset($_GET['DeletedPortfolio'])){
  include('DeletedPortfolio.php');
}
if(isset($_GET['DeletedProject'])){
  include('DeletedProject.php');
}
if(isset($_GET['DeletedCategory'])){
  include('DeletedCategory.php');
}
if(isset($_GET['deleted-section'])){
  include('DeletedSection.php');
}

if(isset($_GET['RestorePortfolio'])){
  include('RestorePortfolio.php');
}
if(isset($_GET['RestoreUser'])){
    include('RestoreUsers.php');
}
if(isset($_GET['DeletedUsers'])){
    include('DeletedUsers.php');
}
if(isset($_GET['RestoreProjectProg'])){
    include('RestoreProjectProg.php');
}
if(isset($_GET['RestoreCategory'])){
    include('RestoreCategory.php');
}
if(isset($_GET['RestoreSection'])){
    include('RestoreSection.php');
}

if(isset($_GET['EditProject'])){
    include('EditProjectProgress.php');
                         //exit();
}
if(isset($_GET['allcategory'])){
    include('AllCategory.php');
}
if(isset($_GET['allusers'])){
    include('AllUser3.php');
}
if(isset($_GET['AllMessages'])){
    include('1DirectMessages.php');
}
if(isset($_GET['uadd'])){
    include('AddUsers.php');
}
if(isset($_GET['cadd'])){
    include('AddCategory.php');
}
if(isset($_GET['sadd'])){
    include('AddSection.php');
}
if(isset($_GET['AddPortfolio'])){
    include('AddPortfolio.php');
}
if(isset($_GET['cat_id'])){
    include('EditCategory.php');
}
if(isset($_GET['project-updates'])){
                        //include('includes/AllProjectUpdates.php');
    include ('TentativeDesign.php');
}
if(isset($_GET['ppuj'])){
    include('AddProjectProgressUpdates.php');
}
if(isset($_GET['ppup']) && isset($_GET['pdd']) ){
    include('EditProjectProgressUpdate.php');
}
if(isset($_GET['deleteppu'])&& isset($_GET['Proj'])){
    include('DeleteProjectProgress.php');
}
if(isset($_GET['DeletePro'])){
    include('DeleteProject.php');
}
if(isset($_GET['DeleteCat'])){
   include('DeleteCategory.php');
}
if(isset($_GET['DeleteUser'])){
    include('DeleteUsers.php');
}
if(isset($_GET['DeletePortfolio'])){
    include('DeletePortfolio.php');
}
if(isset($_GET['deletesection'])){
    include('DeleteSection.php');
}
if(isset($_GET['sec_id'])){
    include('EditSection.php');
}
if(isset($_GET['EditHeading'])){
    include('EditHeading.php');
}
if(isset($_GET['dpj'])&& isset($_GET['epju']) ){
    include('EditProjectProgressUpdate.php');
}
if(isset($_GET['u_id'])){
    include('EditUsers.php');
}
if(isset($_GET['ResetPass'])){
    include('EditUsersPassword.php');
}
if(isset($_GET['ResetUsername'])){
    include('EditUserUsername.php');
}

if(isset($_GET['AddProClient'])){
   include('AddProjectClient.php');
}
if(isset($_GET['selectup'])){
   include('SelectedUpdate.php');
}
if(isset($_GET['logout'])){
   include('signOutAdmin.php');
}
if(isset($_GET['Homepage'])){
  include('EditHeading.php');
}
if(isset($_GET['EditAccount'])){
  include('EditAccount.php');
}
if(isset($_GET['EditHomeHeading'])){
 include('EditHomeHeading.php');
}
if(isset($_GET['EditAboutUs'])){
 include('EditHomeAboutUs.php');
}
if(isset($_GET['EditContactUs'])){
 include('EditContactUs.php');
}
if(isset($_GET['dashboard'])){
  include('Dashboard1.php');
}
if(isset($_GET['Gallery'])){
  include('Gallery.php');
}
if(isset($_GET['AssignProjectUpSection'])){
  include('AssignProjectUpSection.php');
}
if(isset($_GET['clientviewproject'])){
  include('ClientViewProject1.php');
}
if(isset($_GET['SelectProjUpPicSec'])){
  include('SelectProjectUpdatePictureSec.php');
}
if(isset($_GET['clientviewportfolio'])){
  include('ClientViewPortfolio.php');
}
if(isset($_GET['testdesign'])){
  include('testDesign.php');
}
if(isset($_GET['messagepanel'])){
  include('1DirectMessages.php');
}

?>

      <!--Import jQuery before materialize.js-->

     <script src = "js/jquery-1.11.3.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
     <script>

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
$('#AddPortfolioBtn').click(function(e){
     socket.emit('Add Portfolio',$('#portfolio_name').val(),$('#description').val(),$('#category_id').val(),$('#user_id').html(),function(portfolio_name,description,category_id,user_id){});
     alert('Successfully Addedsssasds');
});

           //initialize sidenavbar
           $('.carousel.carousel-slider').carousel({fullWidth: true});
           $('.button-collapse').sideNav();
           $('.modal').modal();
           $('select').material_select();
});
         $('#logout').click(function(){
             socket.emit('disconnect', function(){});
         });



     </script>

    </body>
  </html>
<?php
    }
        ?>


<!--FOOTER CODES -->

<div class="footerwrap">
<img src="img/LogoFooter.png" width=250 class="footerlogo">
<div class="footerright">
<ul class="footerlistul"><li class="footerlistli"><b class="footerhead">DIRECTORY</b></li>
<li class="footerlistli"><a href="" class="footerlinks">Careers</a></li>
    <li class="footerlistli"><a href="" class="footerlinks">Contact Us</a></li></ul></div>
</div>
