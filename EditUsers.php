 
<?php
  if(isset($_GET['u_id'])){
    //$user_id = $_GET['u_id'];
      $edit_user_id = $_GET['u_id'];
    $edit_user = queryMysql("SELECT * FROM  users where user_iid = $edit_user_id ");
    $row = mysqli_fetch_array($edit_user);
  }
 
?> 

<div  id  = 'update_user_id' style = "display:none"><?php echo $row['user_iid']; ?></div>

        <div class="row">
              <div class="col s12 m12">
    <div class="card-panel">
    
<form  id = "myForm" action="" method = "POST" class  = "well">
    
        <div class = "center-align">
              <h3 >Edit Users</h3><br>
               <!-- Modal Trigger -->
                  <a class="waves-effect waves-light btn modal-trigger" href="#ResetPass">Reset Password</a>

                  <!-- Modal Structure -->
                  <div id="ResetPass" class="modal">
                    <div class="modal-content">
                      <?php  include ('EditUsersPassword.php');?>
                    </div>
                  </div>
        </div>
    <br>  <br>
      <br>    
      <div class = "row"> 
     <div class = "col s6">
            <label >Lastname</label>
            <input id = "Lname" name = "Lastname" type="text"  value = "<?php echo $row['lname'] ; ?> ">
            <p id = 'errorLname' class = "#ef5350 red lighten-1"></p>
     </div>
     <div class = "col s6">
          <label >Firstname</label>
          <input id = "Fname" name = "Firstname" type="text"  value = "<?php echo $row['fname'] ; ?> ">
          <p id = 'errorFname' class = "#ef5350 red lighten-1 "></p>
    </div>      
    <div class = "col s6">
           <label >Firstname</label>
          <input id = "Fname" name = "Firstname" type="text"  value = "<?php echo $row['fname'] ; ?> ">
          <p id = 'errorFname' class = "#ef5350 red lighten-1 "></p>
    </div>
    <div class = "col s6">
            <label>Middlename</label>
            <input id = "Mname" name = "Middlename" type="text"   value = "<?php echo $row['mname'] ; ?> ">
            <p id = 'errorMname' class = "#ef5350 red lighten-1 "></p>
    </div>
    <br>
          <div class = "col s12">
          
        <label>Level</label>
         <select name = 'category_id' id = "levels" >
        <option value="<?php echo $row['levels'];?>"><?php echo $row['levels'];?></option>     
                <?php 
                   if($row['levels'] == 'Admin'){
                ?>
                          <option value="Client">Client</option>
                          <option value="Interior Designer">Interior Designer</option>
                <?php        
                   }else if ($row['levels'] == 'Client'){
                  ?>
                          <option value="Admin">Admin</option>   
                           <option value="Interior Designer">Interior Designer</option>
                <?php
                   }else if ($row['levels'] == 'Interior Designer'){
                 ?>
                  <option value="Admin">Admin</option>  
                  <option value="Client">Client</option>
             <?php
                   }
                ?> 
         </select>
 </div>
 <div class = "col s6">
      <label>Birthdate:</label>
        <input  class = "datepicker " value =  "<?php echo $row['dateofbirth'] ; ?>" type="date" id = 'birthdate' style = 'width:23em' required>
 </div>
 <div class = "col s6"> 
         <label>Gender:</label>
         <select name='Gender' id = "Gender" >
            <option value="<?php echo $row['gender'] ; ?>"><?php echo $row['gender'] ; ?></option>
                <?php
                    $arrGender = array("Male", "Female", "Other");
                  foreach($arrGender as $GenderValue){
                        if($GenderValue == $row['gender']){
                        }else{
                 ?>
                    <option  value="<?php echo $GenderValue?> "><?php echo $GenderValue?> </option>  
               <?php
                    }
                  }     
               ?>
         </select>
  </div>               
          
   <div class = "col s12"> 
            <label>Mobile Number:</label>
    <div class="row">
               <div class = "col s3">             
                     <select name='indexMobile'  id = "index" >
                    <?php 
                           if ( substr($row['mobilenumber'],0,3) == "+63"){
                    ?>            
                    <option    value = "<?php echo substr($row['mobilenumber'],0,3) ; ?> "><?php echo substr($row['mobilenumber'],0,3) ; ?></option>    
                         <option  value="+82">+82</option>
                          <?php             
                           }else{
                             
                          ?>
                            <option  value="+63">+63</option>
                          <option    value = "<?php echo substr($row['mobilenumber'],0,3) ; ?> "><?php echo substr($row['mobilenumber'],0,3) ; ?></option>
                      <?php                
                           }
                         ?>             
                    </select>
                   </div>
                    <div class  = "col s9">
                     <input value = "<?php echo substr($row['mobilenumber'],4,12);?>" type="text"  id = "mobilenumber"  name = "mobilenumber" placeholder="Enter Mobile Number">
                          <p id  = 'errormobilenumber' class = "#ef5350 red lighten-1 "></p>
                    </div>      
    </div> 
 </div>
      <div class = "col s12">
             <label>Username</label>
                    <input type="text" id = "Addusername" name = "Username" class="validate" placeholder="Enter Username" value = "<?php echo $row['username'] ?>">
                 <p id = 'errorAddusername' class = "#ef5350 red lighten-1" style = "color:white"></p>
                    <p id = 'errorAddusername2' class = "#ef5350 red lighten-1" style = "color:white"></p>
      </div>    
        
 
    </div> 

    
     <div class="right-align"><input type="submit" name = "submit" class="btn btn-success main-color-bg" value="Save"></div>
    <br><br>
  </form>
            </div>
            </div></div> 
<br>
 
      <script src = "js/JQuery-1.8.0.js"></script>
   
            
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
       
<script>
   $(document).ready(function(){      
       var socket  = io.connect('http://localhost:3100');      
        $('select').material_select();
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears:200, // Creates a dropdown of 15 years to control year,
    max: [1990],  
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false,// Close upon selecting a date, 
    format: 'yyyy-mm-dd'
});  
           NamesValidation('Lname','Lastname must not be less than 2 characters!');
           NamesValidation('Fname','Firstname must not be less than 2 characters!');
           NamesValidation('Mname','Middlename must not be less than 2 characters!');
           referencesValidation('mobilenumber','Mobile Number must not be less than 10 digit/s!');
        function  NamesValidation(data,errorMessage){
                 jQuery('#'+data).on('input propertychange paste', function() {
                 if ($('#'+data).val().length < 2){
                      $('#error'+data).empty();
                     $('#error'+data).append(errorMessage);
                 }else{
                     $('#error'+data).empty();
                    
                 }
            });     
           }
       function  referencesValidation(data,errorMessage){
                 jQuery('#'+data).on('input propertychange paste', function() {
                  if ($('#'+data).val().length < 10){
                      $('#error'+data).empty();
                     $('#error'+data).append(errorMessage);
                 }else{
                     $('#error'+data).empty();
                    
                 }
            });     
      }
         
     $('#myForm').submit(function(e){           
        e.preventDefault();
          if($('#Lname').val().length == 0
             || $('#Fname').val().length == 0
             || $('#Mname').val().length == 0
             || $('#mobilenumber').val().length == 0){
                  alert('Please Fill up all fields!');     
          }else if ($('#Lname').val().length <  2
             || $('#Fname').val().length < 2 
             || $('#Mname').val().length < 2){
                      //  alert('HELLO');   
          }else if ($('#mobilenumber').val().length < 10){
                       //alert('Mobile # is less than 11')
          }else{
                      alert('Successfully Updated!!');
                          socket.emit('Update UsersSelf',$('#Lname').val(),$('#Fname').val(),$('#Mname').val(),$('#index').val()+$('#mobilenumber').val(),$("#Gender").val(),$('#birthdate').val(),$('#levels').val(),$('#update_user_id').html(),function(Lname,Fname,Mname,mobilenumber,gender,birthdate,levels,user_id){});    
              window.open('index.php?AllUsers=1&Category=','_self')
                        //socket.emit('UpdateChatList');
                        //socket.emit('UpdateAdminCounterList');
                        //window.open('signIN.php','_self');
                     
                 }
       
       
            });
         $(document).on('keypress', '#Lname', function (event) {
                var regex = new RegExp("^[a-zA-Z\b ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
         $(document).on('keypress', '#Fname', function (event) {
                var regex = new RegExp("^[a-zA-Z\b ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
         $(document).on('keypress', '#Mname', function (event) {
                var regex = new RegExp("^[a-zA-Z\b ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
   $(document).on('keypress', '#mobilenumber', function (event) {
                var regex = new RegExp("^[0-9\b ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
              $("#Lname").attr('maxlength','50');
              $("#Fname").attr('maxlength','50');
              $("#Mname").attr('maxlength','50');
              $("#mobilenumber").attr('maxlength','10');
        });
               
</script>
    


 

 