 <?php
if(isset($_GET['padd'])){
    $customer_id   = sanitizeString($_GET['padd']);
    $user_id         = $_SESSION['user_id'];
 
?>
  <div  id  = "user_id" style = "display:none"><?php echo $user_id; ?></div>
  <div  id = "customer_id" style = "display:none"><?php echo $customer_id; ?></div>
 

<!-- 
    <script src = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
-->
   

 <div class="container">
        <div class="row">
             <div class="col s12 m12">
       <div class="card-panel #9c27b0 purple">  
           <div class = "center-align">
                        <span class="card-title white-text"><h1>Register Project</h1></span>
                   </div>
        <form  id = "myForm" action="" method = "POST" class = "well">
        <div class="input-field col s12">
              <label for  = "project_name" class = "white-text">Project Title</label>
              <input id = "project_name" name = "project_name" type="text" class="validate white-text" placeholder="Project Title">
            <p id = 'errorproj_name' class = "#ef5350 red lighten-1 white-text"></p>
        </div>
        <div class="input-field col s12">
          <textarea name = "description" id="proj_description" class="materialize-textarea white-text" placeholder = "Description"  ></textarea>
          <label for="description" class = "white-text">Description</label>
             <p id = 'errorproj_description' class = "#ef5350 red lighten-1 white-text"></p>
        </div>
            <!-- Get Date --> 
            <input type="text" class="datepicker" name = "dateProject" id = "dateProject" data-value = "now" style = "display:none">
         
           <br>
            <label class = "white-text">Category</label>
        <br> <br>
    <select name='category_id' class = "browser-default">
            <?php
       $select_all_category="SELECT * from category where available = '0'";
     echo  $select_all_category;
       $run_all_category= queryMysql($select_all_category);
       while($row_all_category=mysqli_fetch_array($run_all_category)){
                          $category_id      = $row_all_category['category_id'];
                          $category_name    = $row_all_category['category_name'];
        ?>
           <option value="<?php echo $category_id ?>"><?php echo $category_name; ?></option> 
        <?php
       }      
    
            ?>
    </select>
                       <br><br>
            <div  class="right-align">
            <input  id = "btnSubmit"type="submit" name = "submit" class="btn btn-success btn-lg  active main-color-bg" value="Add">
            </div>
                        <br><br>
        </form>
  
            </div>
     </div>
          
     </div>
</div>
 <script src = "../js/JQuery-1.8.0.js"></script>
<script src = "../js/jquery-1.11.3.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js"></script>

<script> 
  $(document).ready(function(){
      var  socket         = io.connect('http://localhost:3100');
      var  $user_id       = $('#user_id');
      var  $customer_id   = $('#customer_id');
      var  $project_name  = $('#project_name');
      var  $description   = $('#description');
      
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    format: 'yyyy-mm-dd', 
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false // Close upon selecting a date,
  });
    
        
   jQuery('#project_name').on('input propertychange paste', function(){
           if ($('#project_name').val().length < 5){
                    $('#errorproj_name').empty();
                    $('#errorproj_name').append('Portfolio must not be less than 5 character/s !');    
                    $('#btnSubmit').prop('disabled',true);
          }else if ($('#proj_description').val().length == 0) {
                    $('#errorproj_name').empty();
                    $('#btnSubmit').prop('disabled',true);
           }else{
                    $('#errorproj_name').empty();
                    $('#btnSubmit').prop('disabled', false);
           }          
   });
    
  jQuery('#proj_description').on('input propertychange paste', function(){
     
       
           if ($('#proj_description').val().length < 10){
                      $('#errorproj_description').empty();
                      $('#errorproj_description').append('Description must not be less than 10 character/s !');    
                      $('#btnSubmit').prop('disabled',true);
           }else if ($('#project_name').val().length == 0) {
                      $('#errorproj_description').empty();
                      $('#btnSubmit').prop('disabled',true);
           }else{
                      $('#errorproj_description').empty();
                      $('#btnSubmit').prop('disabled', false);
           }
        
               
   });      
     $("#project_name").attr('maxlength','50');
    
      
    $('select').material_select();
    $("#myForm").submit(function(){    
         var newProjectMessage = "Project "+$project_name.val()+" has been added on your hangar";
        socket.emit('NewProject Notification',$user_id.html(),$customer_id.html(),newProjectMessage,'client.php?ClientProjectList','project',function(user_id,customer_id,newProjectMessage,key_id,notification_type){});          
    }); 
      
  });
</script>
 
 
 