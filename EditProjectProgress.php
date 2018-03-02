
      <script src = "js/JQuery-1.8.0.js"></script>
   
    <script src = "js/jquery-1.11.3.min.js"></script> 

<?php
if(isset($_GET['EditProject'])&& isset($_GET['pcat'])){
      $projprog_id=$_GET['EditProject'];
      $category_id =$_GET['pcat'];
      $edit_projprog=queryMySql( " select * from project_progress where projprog_id='$projprog_id' ");
      $row=mysqli_fetch_array($edit_projprog);    



   $availability_result = queryMysql("SELECT COUNT(projprog_id) as rows   FROM  project_progress where projprog_id =  '$projprog_id' and available = 0 ");
      $row_availability = mysqli_fetch_array($availability_result);
      $availability_result = $row_availability['rows'];
?>



<?php
             $user_id = $_SESSION['user_id'];
             $select_user = queryMysql("SELECT * FROM users where user_iid = '$user_id'");
             $select_user_row = mysqli_fetch_array($select_user);
             $username      = $select_user_row['username'];
             $user_level   = $select_user_row['levels'];
    ?>
            <div  id  = "user_id" style  = "display:none"><?php echo $user_id; ?></div>
            <div id = "username" style  = "display:none"><?php  echo $username; ?></div>
            <div id = "user_level" style = "display:none"><?php echo $user_level; ?></div> <html>
 
<?php
                
   if($availability_result  == 0){
       
   }else{              
?> 
 <div class="container">
        <div class="row">
              <div class="col s12 m12">
  <div class="card-panel #9c27b0 purple"> 
        
<form  id = "myForm" action="" method = "POST" class = "well">
  <div class="modal-header">
      
   
        <div class="right-align">
     <input type="button" class = "btn #e57373 red lighten-2" onclick="ConfirmDelete(<?php echo $projprog_id;?>,'<?php echo $row['name'];?>')" value="&times">
      </div>
        <script type="text/javascript">
             function ConfirmDelete(project_id,projectname){
                    if (confirm("Delete ? "+projectname)){
                        location.href='index.php?DeletePro='+project_id;
                   }else {
                   }
             }
         </script>   
  </div>
     <div class = "center-align">
              <h3 class = "white-text">Edit Project</h3>
        </div>
  <div class="modal-body">
    <div class="input-field col s12">
      <label class = "white-text">Project Title</label>
      <input name = "project_name" type="text" class="white-text"  value  = "<?php echo $row['name']; ?>"placeholder="Project Title">
    </div>
      <div class="input-field col s12">
          <textarea id="description" name = "description" class="materialize-textarea white-text"><?php echo $row['description'];?></textarea>
          <label for="textarea1" class = "white-text">Description</label>
    </div>
  
   <br>
    <div class = "form-group">
     <?php include'ProjectProgressEditCategoryDropDown.php';?>
    </div>
  </div>
    <br>
 <div class = "form-group">  
    <div class="right-align">
    <input type="submit" style = "margin-right:1em"name = "submit" class="btn btn-success main-color-bg" value="Save">
       
    </div>
     </div> <br><br>   
</form>
            </div>
            </div></div></div>

 
<?php
    $errorHandler = new ErrorHandler;
    //PHP Dynamic Validiations
     if(!empty($_POST)){
       $validator = new Validator($errorHandler);
       $validation = $validator->check($_POST,[
        'project_name' => [
          'required'      => true,
          'minlength'     => 3,
          'maxlength'     => 25,
        ],
        'description'=>[
           'required'     =>true,
           'maxlength'    =>255,
          ]
       ]);
         if($validation->fails()){
              echo '<pre>',print_r($validation->errors()->first('project_name')),'</pre>';
              echo '<pre>',print_r($validation->errors()->first('description')),'</pre>';
            //  echo '<pre>',print_r($validation->errors()->all('description')),'</pre>';
           }
           else{
            //SQL functions
           if(isset($_POST['submit'])
           && !empty($_POST['project_name'])
           && !empty($_POST['description'])
           && !empty($_POST['category_id'])){
                $date            =  date ('D, F d Y  h.i.s.');
                $pname           = sanitizeString($_POST['project_name']);
                $description     = sanitizeString($_POST['description']);
                $category        = sanitizeString($_POST['category_id']); 
               queryMysql("UPDATE project_progress set name = '$pname',description  = '$description', category_id = '$category', dated = '$date' where projprog_id = '$projprog_id'"); 
                   echo "<script>alert('Successfully Updated')</script>";
                   echo "<script>window.open('index.php?AllProject','_self')</script>";
                   
           }
           else{
                echo "<script>alert('Failed --Please Contact the Developer')</script>";
           }
           }
     }
}
     }
  ?>
       
   

       
  
