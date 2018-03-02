<?php 
if(isset($_GET['UploadPortfolioP'])){    
 $portfolio_id  = $_GET['UploadPortfolioP'];
?>
<form  id = "myForm" action="" method = "POST" enctype="multipart/form-data">
<div class = "col s6">
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input id='upload' name="upload[]" type="file" multiple="multiple"  accept="image/*" class="btn btn-default " role = "button" required="required"/>
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload one or more files">
      </div>
    </div>
    </div>        
    <div class = "col s3 right-align"  style = "margin-top:1em">
          <input type="submit" name = "submit" class="btn btn-success" value="Upload">      
    </div>
</form>
<?php
    if(isset($_POST['submit'])){
$directoryName = "../images/".date ('D, F d Y  h.i.s.'); //Date Directory Name
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
                  $filePath = "$directoryName/". date ('D, F d Y  h.i.s.').'-'.$_FILES['upload']['name'][$i];
                  //Upload the file into the temp dir
                  if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $files[] = $shortname;
                      queryMysql("insert into portfolio_images(name,portfolio_id,path) values('$shortname','$portfolio_id ','$filePath')");

                  }
                }
          }
      }
    } 
}
}
?> 