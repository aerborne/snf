 <?php
if(isset($_GET['cadd'])){

?>


 <div class="container">
        
            
             
                    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel #9c27b0 purple">
             <div class = "center-align">
                        <span class="card-title white-text"><h1>Register Category</h1></span>
                   </div>
            <form  id = "myForm" action="" method = "POST" class = "well">
              <div class="modal-body">
                <div class="form-group">
                  <label class = "white-text">Category Name</label>
                  <input name = "category_name" type="text" class="white-text">
                </div>
              </div>
                <div class="right-align">
               <input type="submit" name = "submit" class="btn btn-success main-color-bg" value="Submit">

                </div>
               
             </form>
        </div>
      </div>
    </div>

 
 
</div>
  <?php
    $errorHandler = new ErrorHandler;

    //PHP Dynamic Validations
    if(!empty($_POST))
    {

       $validator = new Validator($errorHandler);
       $validation = $validator->check($_POST,[

      'category_name' =>[
         'required'   => true,
         'maxlength'  => 25
      ]
       ]);
       if($validation->fails())
       {
         echo '<pre>'.print_r($validation->errors()->first('category_name')),'</pre>';
       }
       else
       {
         //SQL functions
         if(isset($_POST['submit'])
         && !empty($_POST['category_name']))
         {
           $category_name = sanitizeString($_POST['category_name']);

           queryMysql("INSERT INTO category (category_name) VALUES ('$category_name')");
           echo "<script>window.open('admin_meta_index.php?allcategory','_self')</script>";
           echo "<script>alert('Successfully Added')</script>";

         }
         else
         {
               echo "<script>alert('Failed --Please Contact the Developer')</script>";

         }

       }

    }
  }
  ?>
     <script src = "../js/JQuery-1.8.0.js"></script>
   
    <script src = "../js/jquery-1.11.3.min.js"></script>


