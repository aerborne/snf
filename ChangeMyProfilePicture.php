 
<div id = "logged_user_id" style = "display:none"><?php echo $logged_user_id; ?> </div>
<div id = "UploadNewProfPic">
    <div class="row">
      <div class="col s12  ">
        <div class="card " style = "height:38em" >
            <div class = "card-content">
     
             <div class ="left">
                   <a id = "EditMyProfileInfo" href = "#NavAccountInformationModal"  class="left-align SpaceBetweenBTN waves-effect waves-light modal-trigger modal-close"> <i class="ion-arrow-left-c"></i></a>
             </div>
            <form id="uploadProfilePictureForm"
        action="" method = "POST" enctype="multipart/form-data">
             <div class = "right">
                <input id="uploadProfPic" name = "userPhoto[]" type="file" style = "display:none"  onchange="loadFile(event)">
                <a id= "uploadProfPicLink" class=" tooltipped SpaceBetweenBTN waves-effect waves-light " data-position="bottom" data-delay="50" data-tooltip="Upload photo from PC"><i class="ion-monitor"></i></a>
                <a id = "SelectFromProfGalleryBTN" class="tooltipped SpaceBetweenBTN waves-effect waves-light" data-position="bottom" data-delay="50" data-tooltip="Select photo from previous uploads"><i class="ion-images"></i></a>  
             </div>
                <div class ="clearfix"></div>
                <div class = "center-align">
                        <input class = "SaveProfilePhotoBTN btn"  type="submit" value="Save" name="UploadProfilePicture">
                </div>
<div id = "current_path" style = display:none>
                  <?php echo   $current_path; ?></div>
              <div id ="displayCurrentPhotoUpload" class = "displaySelectedPhoto">
                 
                      <img id = "PrevProfilePicUpload" src="<?php echo   $current_path; ?>" alt="" class="responsive-img displayProfilePhoto">
                     
                   
              </div>
           
              
             
         </form>
    
          </div>
 
        </div>
      </div>
    </div>
</div>
 
<div id = "SelectProfPic">
   <div class = "card" style = "height:38em">
 <div class="card-content " >
     <div class ="left">
                   <a  id = "BackToUploadProfPic" class="left-align SpaceBetweenBTN waves-effect waves-light"> <i class="ion-arrow-left-c"></i></a>
     </div>     
     
     
     
    <div class = "displaySelectedPhoto">
         <div class = "textCenterOfPhotoBG">
             <div id = "DisplaySelectedProfilePic">
                   <div  id = "user_image_id" style = "display:none"><?php echo $current_user_images_id; ?></div>
                   <a id = "SelectPictureFromGalleryBTN"><img src="<?php echo $current_path; ?>" alt="" class="responsive-img displayProfilePhoto" ></a> 
                   <p class="textCenterOfPhoto">Select from Gallery </p>
               </div>    
         </div>
    </div><div class = "clearfix"></div>
<div class = "center-align"><a id = "updateProfilePictureBTN"class="waves-effect waves-light btn SaveProfilePhotoBTN ">Save</a></div>  
</div></div>    
</div>
<div id = "GalleryOFprofilePic">
    <div class = "card" style = "height:38em">
 <div class="card-content " >
    <div class  = "left"> 
         <a  id = "BackToCurrentSelectedPhoto" class="left-align SpaceBetweenBTN waves-effect waves-light"> <i class="ion-arrow-left-c"></i></a>
    </div>
  <div>
    <div class  = "ProfPicGalleryThumbnail"> 
    <div class = "row">
          <div class =  "col s12">
              <div  id = "PPThumbnails">
               </div>   
          </div>
     </div>
    </div> 
  </div>
</div></div>
</div>
     
<script src = "js/jquery-1.11.3.min.js"></script>
<script>
var $logged_user_id  = $('#logged_user_id').html();
var $current_path   = $('#current_path').html();
var ProfilePictureArr = [];
socket.emit('Select ProfilePictures',$logged_user_id,function(user_id){});
socket.on('set ProfilePictureGallery',function(data){
     ProfilePictureArr[data.user_images_id] = data.path;
     $('#PPThumbnails').append('<div id = "'+data.user_images_id+'"  class = "col s12 m4 l3"><a  onclick="updateDisplayProfPic('+data.user_images_id+',ProfilePictureArr)" style = "cursor:pointer"><img src="'+data.path+'"  class="responsive-img profilepicPhoto" width = "100%"></a> </div>');
});
    

socket.on('set CurrentPhotoSelected',function(data){ 
$('#BackToUploadProfPic').click(function(){
   $('#UploadNewProfPic').show();
   $('#SelectProfPic').hide();
   $('#DisplaySelectedProfilePic').empty();
  $('#DisplaySelectedProfilePic').append('<div  id = "user_image_id"    style = "display:none">'+data.curr_user_images_id+'</div><a id = "SelectPictureFromGalleryBTN"><img src="'+data.curr_path+'" alt="" class="responsive-img displayProfilePhoto" ></a> <p class="textCenterOfPhoto">Select from Gallery </p>');    
    $('#SelectPictureFromGalleryBTN').click(function(){
                        $('#GalleryOFprofilePic').show();
                        $('#SelectProfPic').hide();
    });   

}); 
});   
    function  updateDisplayProfPic(variable_id,arrayName){
         for (var key in arrayName) {
            let value = arrayName[key];
                if(variable_id == key){
                   $('#DisplaySelectedProfilePic').empty();
                   $('#DisplaySelectedProfilePic').append('<div  id = "user_image_id" style = "display:none">'+key+'</div><a id = "SelectPictureFromGalleryBTN"><img src="'+value+'" alt="" class="responsive-img displayProfilePhoto" ></a> <p class="textCenterOfPhoto">Select from Gallery </p>');
                   $('#GalleryOFprofilePic').hide();
                   $('#SelectProfPic').show();
                   $('#SelectPictureFromGalleryBTN').click(function(){
                        $('#GalleryOFprofilePic').show();
                        $('#SelectProfPic').hide();
                   });
                    
                }          
          }
    }
$('#updateProfilePictureBTN').click(function(){
    //alert('user_image_id '+$('#user_image_id').html());
    socket.emit('Update ProfilePicture',$('#user_image_id').html(),function(new_user_images_id){});
    $('#MyProfileInfoPanelPicUploadB').modal('close');  
});
    $('#BackToUploadProfPic').click(function(){
   $('#UploadNewProfPic').show();
   $('#SelectProfPic').hide();
    });
$('#BackToUploadProfPic').hide();
$('#SelectProfPic').hide();
$('#GalleryOFprofilePic').hide();
$('#SelectFromProfGalleryBTN').click(function(){
   $('#UploadNewProfPic').hide();
   $('#SelectProfPic').show();
   $('#BackToUploadProfPic').show()    
}); 

$('#SelectPictureFromGalleryBTN').click(function(){
    $('#GalleryOFprofilePic').show();
    $('#SelectProfPic').hide();
});
$('#EditMyProfileInfo').click(function(){
  
    $('#displayCurrentPhotoUpload').empty();
    $('#displayCurrentPhotoUpload').append('<img id = "PrevProfilePicUpload" src="'+$current_path+'" alt="" class="responsive-img displayProfilePhoto">');
});        
$("#uploadProfPicLink").on('click', function(e){
        e.preventDefault();
       //alert('Hello world ');
       $("#uploadProfPic:hidden").trigger('click');
});
$('#BackToCurrentSelectedPhoto').click(function(){
     $('#GalleryOFprofilePic').hide();
     $('#SelectProfPic').show();
});    
var loadFile = function(event) {
    var output = document.getElementById('PrevProfilePicUpload');
    output.src = URL.createObjectURL(event.target.files[0]);
  };    
     
</script>
<?php

date_default_timezone_set('Asia/Manila');
$standard_date_format = date('Y-m-d H:i:s');
$directoryName = "images/ProfilePics/".$logged_user_id."/".$standard_date_format; //Date Directory Name

    if(isset($_POST['UploadProfilePicture'])){
              if(!is_dir($directoryName)){ //Validate if there is no Existing Directory
      mkdir($directoryName,0755,true);
      if(count($_FILES['userPhoto']['name'])> 0){
        //Uploading  Single and Multiple Files
          //Loop through each file
          for($i=0; $i<count($_FILES['userPhoto']['name']); $i++) {
            //Get the temp file path
              $tmpFilePath = $_FILES['userPhoto']['tmp_name'][$i];

              //Make sure we have a filepath
              if($tmpFilePath != ""){
                  //save the filename
                  $shortname = $_FILES['userPhoto']['name'][$i];
                  //save the url and the file
                  $filePath = "$directoryName/".$standard_date_format.'-'.$_FILES['userPhoto']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                      queryMysql("insert into user_images(name,user_iid,path,image_upload_date) values('$shortname','$logged_user_id','$filePath','$standard_date_format')");
                      queryMysql("UPDATE user_images set selected = 1 where user_images_id = ' $current_user_images_id'");
                          
                            echo "<script>location.reload();</script>"; 
                  }
                }
          }
      }
                  
    }
   
    }
?>
