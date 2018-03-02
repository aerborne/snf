<?php 
  
   if(isset($_GET['ResetUsername'])){
       $user_id_reset    = $_GET ['ResetUsername'];
       $edit_user  =  queryMysql("SELECT * FROM users where user_iid ='$user_id_reset'");
       $row              = mysqli_fetch_array($edit_user);
       $salt1            = "qm&h*";
       $salt2            = "pg!@";
       $oldUsername      = $row['username'];
   }
?> 
<div id = "user_id_reset" style = "display:none"><?php echo  $user_id_reset;?> </div>
<!-- Change  Username Form -->
<div class="container">
        <div class="row">
              <div class="col s12 ">
                  
    <div class="card-panel #9c27b0 purple"> 
        
         <div class = "center-align">
              <h3 class = "white-text">Edit Username</h3>
        </div>
<form id  = "myForm" action = "" method = "POST" class = "well"> 
   
           <div class="col s12">
                    <label class = "white-text">Username</label>
                    <input value = "<?php echo $row['username']; ?>" type="text" id = "EditUsername" name = "Username" class="white-text" placeholder="Enter Username">
                 <p id = 'errorEditUsername' class = " white-text background-color:#ef5350 red lighten-1;"></p>
                 <p id = 'errorEditUsername2'  class = " white-text" style = 'background-color:#ef5350 red lighten-1;'></p>
                
               <br><br>
                  </div> 
    <div class="right-align"><input id = "btn_submit" type="submit" name = "Resetsubmit" class="btn btn-success main-color-bg" value="Save"></div>
<br><br>
</form>
            </div>
            </div></div></div>
 
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
<script>
$(document).ready(function(){
    var socket  = io.connect('http://localhost:3100');
    
    $('#myForm').submit(function(e){           
        e.preventDefault();
         if($('#EditUsername').val() == 0){
             alert('Please Fill up all the field/s');
         }else if ($('#EditUsername').val().length < 11){
             
         }else{
              alert('Successfully Saved');
             socket.emit('Update Username',$('#EditUsername').val(),$('#user_id_reset').html(),function(username,user_id){});
             socket.emit('UpdateChatList');
             socket.emit('UpdateAdminCounterList');
         }
         

    });
    
socket.on('Username Error',function(data){
     $('#errorEditUsername2').empty();
     if ($('#EditUsername').val().length < 11){
                       //alert('Username is less than  11');  
      }else{
          if(data.rows == 0){
               $('#errorEditUsername2').append('Username is Available');
               $("#errorEditUsername2").css("background-color", "green");
                 $('#btn_submit').prop('disabled', false);
          }else{
              $("#errorEditUsername2").css("background-color", "red");
              $('#errorEditUsername2').append('Username is Unavailable');
              $('#btn_submit').prop('disabled', true);
          
          }    
                    
      }    
});    
 jQuery('#EditUsername').on('input propertychange paste', function() {
                 socket.emit('Check Username2',$('#EditUsername').val(),$('#user_id').html(),function(username,user_id){}); 
            });
    
 referencesValidation('EditUsername','Username must not be less than 11 characters!!');
  function  referencesValidation(data,errorMessage){
                 jQuery('#'+data).on('input propertychange paste', function() {
                  if ($('#'+data).val().length < 11){
                      $('#error'+data).empty();
                     $('#error'+data).append(errorMessage);
                 }else{
                     $('#error'+data).empty();
                    
                 }
            });     
    } 
     $("#EditUsername").attr('maxlength','16');
       
    
});
</script>


 
