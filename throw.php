<?php
 
 date_default_timezone_set('Asia/Manila');
$standard_date_format = date('Y-m-d H:i:s');
$directoryName = "../images/ProjectProgUpdates/".$standard_date_format; //Date Directory Name

 
              if(!is_dir($directoryName)){ //Validate if there is no Existing Directory
      mkdir($directoryName,0755,true);
      if(count($_FILES['files']['name'])> 0){
        //Uploading  Single and Multiple Files
          //Loop through each file
          for($i=0; $i<count($_FILES['files']['name']); $i++) {
            //Get the temp file path
              $tmpFilePath = $_FILES['files']['tmp_name'][$i];

              //Make sure we have a filepath
              if($tmpFilePath != ""){
                  //save the filename
                  $shortname = $_FILES['files']['name'][$i];
                  //save the url and the file
                  $filePath = "$directoryName/".$standard_date_format.'-'.$_FILES['files']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                    
                          
                             
                  }
                }
          }
      }
                  
    }
 
 
?>