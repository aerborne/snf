
<!-- Change Password Form -->
<div class="container">
        <div class="row">
              <div class="col s12 m12">
    <div class="card-panel">              
<form id  = "editUserPasswordForm" action = "" method = "POST" class = "well"> 
    <div class ="center-align">
    
    <h5>Reset Password 
      </h5>  
    <h8 style = "display:none">Username: <?php  echo $row['username'];  ?></h8>
        </div>
    <br>
      <label for = "CurrentPassword" > Current Password</label>
    <div class="input-field col s12">
        
       <input id  =  "CurrentPassword" name = "Password" data-length="14">
         <p id = 'errorCurrentPassword'></p>
    </div>
    <br>
       <label for = "NewPassword">New Password</label>
    <div class="input-field col s12">
       <input id = "NewPassword" name = "Password" data-length="14"  >
          <p id = 'errorNewPassword'></p>
    </div> 
    <br>   
       <label>Re-Type New Password</label>
    <div class = "col s12">  
       <input id  = "NewPassword_Again" name = "Password_Again">
       <p id = 'errorNewPassword_Again'></p> 
    <br><br>
    </div>
    
    <div class="right-align"><input id = "btnResetPasswordBtn" type="submit" name = "Resetsubmit" class="btn btn-success main-color-bg" value="Save"></div>
    <br><br>
</form>
            </div>
            </div></div></div>
  
<script src = "../js/jquery-1.11.3.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
<script>
 $(document).ready(function(){
     var fields = ["CurrentPassword","NewPassword","NewPassword_Again"];
     
     $('input#NewPassword,input#CurrentPassword,input#NewPassword_Again').characterCounter();
           var socket  = io.connect('http://localhost:3100');
      $('#btnResetPasswordBtn').prop('disabled',true);
      $('#NewPassword_Again').prop('disabled',true);
       $('#btnResetPasswordBtn').click(function(e){
                 e.preventDefault(); 
         if($('#CurrentPassword').val().length == 0 || 
            $('#NewPassword').val().length == 0  ||   
                  $('#NewPassword_Again').val().length == 0){
                   alert('Please fill up all the fields !');
         }else if ($('#NewPassword').val().length < 14 || 
                   $('#NewPassword_Again').val().length  < 14){
         }else{
                if ($('#NewPassword_Again').val() != $('#NewPassword').val()){ 
                     alert('not matching');
                 }else{
                    alert('Successfully Saved');
                    socket.emit('Update UserPassword',$('#NewPassword').val(),$('#update_user_id').html(),function(NewPassword,user_id){});
                          for ( var i = 0; i < 3 ; i++){
                              $('#'+fields[i]).val('');
                              $('#'+fields[i]).blur();
                              $('#error'+fields[i]).empty();
                        }
                       
                         $('#ResetPass').modal('close'); 
                 }  
         }
           
       });
$.getScript("../js/form_validations.js",function(){ 
    //Compare Password and confirm passowrd
  compare_two_fields('NewPassword','NewPassword_Again',' New Password','Password Again');
    //Minimum Charters 
    MinLimit_F('NewPassword','New Password',14);
    //Check if password exists
    IFpasswordExist('CurrentPassword','update_user_id','btnResetPasswordBtn');
    //Keypress and maxlength
     for ( var i = 0; i < 3 ; i++){
        Keypress_F(fields[i],"NumbersAndLetters");
        $('#'+fields[i]).attr('maxlength','14');      
     }
    
});   
 });
   
</script>       



  