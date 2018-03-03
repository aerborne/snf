 <?php
if(isset($_GET['AddPortfolio'])){
      $user_id = $_SESSION['user_id'];
    $select_pupdate_id = queryMySql("SELECT * from portfolio where available = 0 order by portfolio_id    desc limit 1 ");
      $rows=mysqli_fetch_array($select_pupdate_id);
      $pupdate_id  = $rows['portfolio_id'];
      $rtpupdate_id =  $pupdate_id+1; //for realtime data
      $new_pupdate_id  = $pupdate_id; //for php non realtime data

     //echo $new_pupdate_id;
       //add 1 for realtime
       // static variable for non realtime(php)
     date_default_timezone_set('Asia/Manila');
     $data_directoryName = "images/portfolio/".$rtpupdate_id."/".date('D, F d Y')."/";
     $directoryName      = "images/portfolio/".$pupdate_id."/".date('D, F d Y')."/"; //Date Directory Name

?>
<!-- Declare node.js client variables-->
    <div  id  = "user_id" style = "display:none"><?php echo $user_id; ?></div>
    <div  id  = "pred_portfolio_id" style = "display:none"><?php echo $rtpupdate_id; ?></div>
    <div  id  = "portfolio_user_id" style = "display:none"><?php echo $_SESSION['user_id']; ?></div>
    <div  id  = "portfolio_img_path" style = "display:none "><?php echo $data_directoryName; ?></div>


        <div class="row">


              <div class="col s12 m12">
       <div class="card-panel #9c27b0 white">
               <div class = "center-align">
                        <span class="card-title black"><h1>Register Portfolio</h1></span>
                   </div>
<form  id = "myForm" action="" method = "POST" enctype="multipart/form-data" class = "well">
<div class="input-field col s12">
                    <label class = "black-text">Portfolio Name:</label>
                      <input  id = "port_name" name = "project_name" type="text" class="validate  black-text" placeholder="Portfolio Name">
                       <p id = 'errorport_name' class = "#ef5350 red lighten-1" style = "color:white"></p>
                    <p id = 'errorport_name2' class = "#ef5350 red lighten-1" style = "color:white"></p>
    </div>
<div class="input-field col s12">
          <textarea  id = "port_description" name = "description" id="description" class="materialize-textarea black-text"></textarea>
         <p id = 'errorport_description' class = "#ef5350 red lighten-1 white-text"></p>
          <label for="textarea1" class = "black-text">Description:</label>
</div>
        <input type="text" class="datepicker" name = "datePortfolio" id = "datePortfolio" data-value =  "now"  style = "display:none">


                    <label>Category</label>
                      <div class = "form-group">
                      <?php
                      $result = queryMysql("selecT * From category where available = 0 ");
                      echo "<select name='category_id' id = 'portfolio_category_id' class ='browser-default'>";
                            while ($row = $result->fetch_assoc()){
                            unset($id, $name);
                            $id = $row['category_id'];
                            $name = $row['category_name'];
                            echo '<option name ="ucat" value="'.$id.'">'.$name.'</option>';
                           }
                           echo '</select>';
                      ?>
                      </div>
        <br>
 <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input id='upload' name="upload[]" type="file" multiple="multiple"  accept="image/*" class="btn  white  " role = "button" required="required">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate  black-text" type="text" placeholder="Upload one or more files">
      </div>
</div>
   <div class = "clearfix"></div>
          <div  style = "margin-top:1em" id="selectedFiles"></div>
      <br><br><br><br><br><br>
     <div class = "clearfix"></div>
     <div  class="right-align">
         <br><br>
         <input  id = "addPortfolioBTN" class="btn btn-success btn-lg  active main-color-bg" type="submit" name = "submit" class="btn btn-success" value="Submit" style = "display:none">
         <a id = "triggerUploadButton" class="btn btn-success" >Submit</a>
             </div><br><br>
</form>
            </div>
                </div>

     </div>
 <?php

 if(isset($_POST['submit'])){
     $project_name = $_POST['project_name'];
     $desc = $_POST['description'];
     $cat = $_POST['category_id'];
     $uid = $_SESSION['user_id'];

      if(count($_FILES['upload']['name'])> 0){
          queryMySql("INSERT INTO portfolio(name,description,category_id,dated,user_iid) VALUES('$project_name','$desc','$cat',NOW(),'$uid')");
          $pfid = queryMysql("SELECT portfolio_id FROM portfolio WHERE name = '$project_name' and description = '$desc'");
          $row = mysqli_fetch_array($pfid);
          $id = $row['portfolio_id'];
        //Uploading  Single and Multiple Files
          //Loop through each file
          for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
              //Get the temp file path
              $file_name = $_FILES['upload']['name'][$i];
              $file_tmp = $_FILES['upload']['tmp_name'][$i];
              $file_size = $_FILES['upload']['size'][$i];
              $file_error = $_FILES['upload']['error'][$i];

              $file_ext = explode('.', $file_name);
              $file_ext = strtolower(end($file_ext));
              // $allowed = array('jpg', 'jpeg', 'png', 'gif');
              // if (in_array($file_ext, $allowed)) {
              //     if ($file_error === 0) {
                      // if ($file_size <= 100097152) {
                          $file_name_new = uniqid('', true).
                          '.'.$file_ext;
                          $file_destination = 'uploads/'.$file_name_new;
                          if (move_uploaded_file($file_tmp, $file_destination)) {
                              $file_destination;
                              // :TODO save path to db
                              queryMysql("INSERT INTO portfolio_images(name,portfolio_id,path,available,upload_datetime) VALUES('$file_destination','$id','$file_destination','0',NOW())");
                          }
                      // }
              //     }else {
              //         // :TODO error validation
              //     }
              // }
          }
      }
   echo "<script>alert('Successfully Added')</script>";
   echo "<script>window.open('admin_meta_index.php?allportfolio','_self')</script>";
 }

 ?>



<script src = "http://localhost:3100/socket.io/socket.io.js"></script>
<script>
       var delPictureInformationOBJlist = '{"delPictureInformationList":[]}';
       var btnCounterID = 0;
    var storedFiles = [];
      delPicture_obj_ls = JSON.parse(delPictureInformationOBJlist);
      var  selDiv = $("#selectedFiles");
       $("#upload").on("change", handleFileSelect);
      function handleFileSelect(e) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f) {

            if(!f.type.match("image.*")) {
                return;
            }
            storedFiles.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
                 delPicture_obj_ls.delPictureInformationList.push({"temp_id":btnCounterID,"filename":f.name,"availability":"0"});
                selDiv.append("<div class = 'col s12 m4 l4 xl2 ' id = 'uploadPictureHolder"+btnCounterID+"' style = 'margin-bottom:1em'><div id = 'filename"+btnCounterID+"' style = 'display:none'>"+f.name+"</div><div class = 'uploadPhotoDivHolder'><div class = 'right'><a class='waves-effect deletePictureUploadBTN'  onclick ='triggerDeleteUploadPicture("+btnCounterID+")'>&times;</a></div><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='Click to remove'></div></div>");
                 btnCounterID++;
            }
            reader.readAsDataURL(f);

        });
    }
function triggerDeleteUploadPicture(btnCounterID){
   delPicture_obj_ls.delPictureInformationList[btnCounterID].availability = 1;
   $("#uploadPictureHolder"+btnCounterID).hide();
}
  $("#triggerUploadButton").click(function(){

              if($('#port_description').val().length == 0||
                $('#port_name').val().length == 0 ||
                $('#upload').get(0).files.length === 0){
                  alert('Please Fill up the Fields and Choose a Picture to upload!  ');
              }else if($('#port_name').val().length < 6){
              }else if($('#port_description').val().length < 6 ){
              }else{
                  ///Check if there anything uploaded
                  //Create a counter for every 0 available counted
                  var ctrAvail = 0;
                  for (var i = 0; i <  delPicture_obj_ls.delPictureInformationList.length; i++) {
                       var  availability =  delPicture_obj_ls.delPictureInformationList[i].availability;
                         if(availability == 0){
                           ctrAvail++;
                         }else{
                         }
                  }
                  if(ctrAvail == 0){
                    alert('Please choose a picture to upload! ');
                         $("#upload").val("");
                  }else{
                      socket.emit('get_portoflio_data',$('#port_name').val(),$('#port_description').val(),$('#portfolio_category_id').val(),$('#portfolio_user_id').html(),function(name,descriptions,category_id,user_id){});
                    }
              }
    });
socket.on("delete selectedPortPictures",function(){
         for (var i = 0; i <  delPicture_obj_ls.delPictureInformationList.length; i++) {
             var  temp_id      =  delPicture_obj_ls.delPictureInformationList[i].temp_id;
             var  filename     =  delPicture_obj_ls.delPictureInformationList[i].filename;
             var  availability =  delPicture_obj_ls.delPictureInformationList[i].availability;
             socket.emit('get_delete_upload_port_pic',temp_id,filename,availability,$('#pred_portfolio_id').html(),$('#portfolio_img_path').html(),function(temp_id,filename,availability,pred_pupdate_id,directoryPath){});
          }

});
socket.on('trigger deletePortPhoto',function(){
    $('#addPortfolioBTN').trigger('click');
});
$.getScript("js/form_validations.js",function(){
  check_username('port_name','addPortfolioBTN','','','portfolio','portfolio_id','name','Portfolio Name');
  MinLimit_F('port_name','Portfolio Name',6);
  MinLimit_F('port_description','Description',6);
  $('#port_name').attr('maxlength','50');
       Keypress_F("port_name","NumbersAndLetters");
});
   // alert('HELLO word');



</script>
<?php
    }

?>
