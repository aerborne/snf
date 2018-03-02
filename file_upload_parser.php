 
<?php

// echo "<script>alert('hello world')</script>";
 //$upload_user_id  = $_POST['set_user_id']; 
 $directoryName = "images/".date ('D, F d Y  h.i.s.'); //Date Directory Name
//if(isset($_POST['submit'])){
    if(!is_dir($directoryName)){ //Validate if there is no Existing Directory
      mkdir($directoryName,0755,true);
      if(count($_FILES['userImage']['name'])> 0){
        //Uploading  Single and Multiple Files
          //Loop through each file
          for($i=0; $i<count($_FILES['userImage']['name']); $i++) {
            //Get the temp file path
              $tmpFilePath = $_FILES['userImage']['tmp_name'][$i];

              //Make sure we have a filepath
              if($tmpFilePath != ""){
                  //save the filename
                  $shortname = $_FILES['userImage']['name'][$i];
                  //save the url and the file
                  $filePath = "$directoryName/". date ('D, F d Y  h.i.s.').'-'.$_FILES['userImage']['name'][$i];
                  //Upload the file into the temp dir
                   
                  if(move_uploaded_file($tmpFilePath, $filePath)) {

                  }
                 
                  
                }
          }
      }
    } 
?>
 
