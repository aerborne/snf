<?php 
   date_default_timezone_set('Asia/Manila'); 
   
   $data_directoryName  = "../images/Portfolio/".$portfolio_id."/".date('D, F d Y')."/"; //Date Directory Name 
   $directoryName      = "../images/Portfolio/".$portfolio_id."/".date('D, F d Y')."/"; //Date Directory Name 
?>
<!-- Declare node.js client variables-->
    <div  id  = "portfolio_img_path" style = "display:none "><?php echo $data_directoryName; ?></div> 


<div class = "container">

<div class = "row">
        <form  id = "myForm" action="" method = "POST" enctype="multipart/form-data">
            <div class = "row">

 <div  class="right">
         <br><br>
         <input  id = "addPortfolioBTN" class="btn btn-success btn-lg  active main-color-bg" type="submit" name = "submit" class="btn btn-success" value="Submit" style = "display:none">
         <a id = "triggerUploadButton" class="btn #ec407a pink lighten-1 " >Upload</a>
             </div><br><br> 
   <div class = "clearfix"></div> 
                
                
  <div class="file-field input-field">
      <div class="btn #ec407a pink lighten-1 ">
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
   
    
            </div>
            </form> 
 
             <div class = "clearfix"></div>
             <div  style = "margin-top:1em" id="selectedFiles"></div>
       
</div>


</div>
<script>
    
// alert($('#portfolio_id').html());
  var storedFiles = [];  
   
  ///     var $delPictureInformationList  = "delPictureInformationList";
      var delPictureInformationOBJlist = '{"delPictureInformationList":[]}';
       var btnCounterID = 0;
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
                filename =  f.name;
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
              if($('#upload').get(0).files.length === 0){
                  alert('Please Fill up the Fields and Choose a Picture to upload!  ');
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
                     //var input = $("#upload");    
                         $("#upload").val("");
                  }else{
                        for (var key in delPicture_obj_ls.delPictureInformationList) {
                           delPicture_obj_ls.delPictureInformationList[key].temp_id;
                           var  temp_id      =  delPicture_obj_ls.delPictureInformationList[key].temp_id;
                           var  filename     =  delPicture_obj_ls.delPictureInformationList[key].filename;
                           var  availability =  delPicture_obj_ls.delPictureInformationList[key].availability; 
                        socket.emit('get_delete_upload_port_pic',temp_id,filename,availability,$('#portfolio_id').html(),$('#portfolio_img_path').html(),function(temp_id,filename,availability,pred_pupdate_id,directoryPath){});
                        

                    }
                         
                  }             
              }
    });
    socket.on('trigger deletePortPhoto',function(){
    $('#addPortfolioBTN').trigger('click'); });
    
    
</script>
 <?php 
          
 if(isset($_POST['submit'])){
   
//if(isset($_POST['submit'])){
    if(!is_dir($directoryName)){ //Validate if there is no Existing Directory
      mkdir($directoryName,0755,true);
      if(count($_FILES['upload']['name'])> 0){
        //Uploading  Single and Multiple Files
          //Loop through each file
          for($i=0; $i<count($_FILES['upload']['name']); $i++) {
            //Get the temp file path
              $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

              //Make sure we have a filepath
              if($tmpFilePath != ""){
                  //save the filename
                  $shortname = $_FILES['upload']['name'][$i];
                  //save the url and the file
                  $filePath = $directoryName.$_FILES['upload']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                  }
                }else{
                    $shortname = $_FILES['upload']['name'][$i];
                  //save the url and the file
                  $filePath = $directoryName.$_FILES['upload']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                  }
               }
          }
      }
    }else{
          if(count($_FILES['upload']['name'])> 0){
        //Uploading  Single and Multiple Files
          //Loop through each file
          for($i=0; $i<count($_FILES['upload']['name']); $i++) {
            //Get the temp file path
              $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

              //Make sure we have a filepath
              if($tmpFilePath != ""){
                  //save the filename
                  $shortname = $_FILES['upload']['name'][$i];
                  //save the url and the file
                  $filePath = $directoryName.$_FILES['upload']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                  }
                }else{
                    $shortname = $_FILES['upload']['name'][$i];
                  //save the url and the file
                  $filePath = $directoryName.$_FILES['upload']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                  }
               }
          }
      }
    }             
   echo "<script>alert('Successfully Added')</script>";
   echo "<script>window.open('index.php?Portfolio=$portfolio_id','_self')</script>";
 }        
 ?>  
        