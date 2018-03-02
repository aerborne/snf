 
<?php
  if(isset($_GET['cat_id'])){
    $category_id = $_GET['cat_id'];
    $edit_category = queryMysql("SELECT * FROM category where category_id = '$category_id'");
    $row = mysqli_fetch_array($edit_category);
  }


      $availability_result = queryMysql("SELECT COUNT(category_id) as rows   FROM  category where category_id =  '$category_id' and available = 0 ");
      $row_availability = mysqli_fetch_array($availability_result);
      $availability_result = $row_availability['rows'];


if( $availability_result == 0){
    
}else{
    
 
?>
 
 <div class="container">
        <div class="row">
              <div class="col s12 m12 ">
   <div class="card-panel #9c27b0 purple"> 
        
         <div class = "center-align">
              <h3 class = "white-text">Edit Category</h3>
        </div>
<form  id = "myForm" action="" method = "POST" class = "well">
  <div class="modal-body">
          <div class="right-align">
         <!--- Delete  Button--> 
        <input type="button" class="btn btn-danger #e57373 red lighten-2 " onclick="ConfirmDelete(<?php echo $category_id;?>,'<?php echo $row['category_name'] ;?>')" value="&times">
        <script type="text/javascript">
         
             function ConfirmDelete(category_id,category_name){
                    if (confirm("Delete ? "+category_name)){
                          $.getScript("js/form_validations.js",function(){  
                          delete_item(category_id,'category_id','category','allcategory');
                           });
                   }else {

                   }
             }
         </script>
      </div>
    <div class="form-group">
        
      <label class = "white-text">Category Name</label>
        <br>    <br>
      <input name = "category_name" type="text" class="white-text" placeholder="Category Name" value = "<?php echo $row['category_name'] ; ?>">
    </div>
  </div>
    <br><br>
    <div class="right-align">
      
   <input  style = "margin-right:1em"type="submit" name = "submit" class="btn btn-success main-color-bg" value="Save">
    </div>
    <br><br>
  </form>
            </div>
            </div>
     </div>
</div>
  <?php
     $errorHandler = new ErrorHandler;

     if(!empty($_POST))
     {
       $validator = new Validator($errorHandler);
       $validation = $validator->check($_POST,[

          'category_name'   =>[
              'required'    =>true,
              'maxlength'   =>25
          ]
       ]);

       if($validation->fails())
       {
         echo '<pre>',print_r($validation->errors()->all()),'</pre>';
       }
       else
       {

         //SQL functions
         if(isset($_POST['submit'])
            &&!empty($_POST['category_name']))
            {
              $category_name = sanitizeString($_POST['category_name']);

              queryMysql("UPDATE category set category_name = '$category_name' WHERE category_id = '$category_id'");
             echo "<script>window.open('admin_meta_index.php?allcategory','_self')</script>";
             			echo "<script>alert('Successfully Updated')</script>";
              

            }
            else
            {
              	echo "<script>alert('Failed --Please Contact the Developer')</script>";
            }

       }


     }
}
   ?>

 