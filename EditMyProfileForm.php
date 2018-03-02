<?php 

  
 
     $mylname   = $row_select_current_profile_picture['lname'];
     $myfname   = $row_select_current_profile_picture['fname'];
     $mymname   = $row_select_current_profile_picture['mname'];
     $myusername  = $row_select_current_profile_picture['username'];
     $mylevels  = $row_select_current_profile_picture['levels'];
     $mymobilenumber  = $row_select_current_profile_picture['mobilenumber'];
     $mygender  = $row_select_current_profile_picture['gender'];
     $myemail  = $row_select_current_profile_picture['email'];
     $mydateofbirth  = $row_select_current_profile_picture['dateofbirth'];
 
?>

<div  id  = "myuser_id" style = "display:none"><?php echo $logged_user_id ?></div>
<div id = "editMyProfileInformationForm">
<div class =  "row">
 
<div class =  "col s12">
     <div class = "center">
           <div style = "margin-top:1em"></div>
         <a id = "changeMypasswordBTN"class="waves-effect waves-light btn">Change Password</a>
    </div>
    <div style = "margin-top:2em"></div>
</div>
   <div class = "col s12">
        <div class  = "row"> 
              <div class="input-field col s6">
                      <input placeholder="Placeholder" id="mylast_name" type="text" class="validate" value = "<?php echo $mylname; ?>">
                      <label for="last_name">Lastname</label>
                    <p id = 'errormylast_name' class = "#ef5350 red lighten-1"  style = "color:white"></p>
               </div>
               <div class="input-field col s6">
                      <input placeholder="Placeholder" id="myfirst_name" type="text" class="validate" value = "<?php echo $myfname; ?>">
                      <label for="first_name">Firstname</label>
                    <p id = 'errormyfirst_name' class = "#ef5350 red lighten-1"  style = "color:white"></p>
               </div>
         </div>
   </div>    
   <div class = "col s12">
       <div class = "row">
          <div class="input-field col s6">
                  <input placeholder="Placeholder" id="mymiddle_name" type="text" class="validate" value = "<?php echo $mymname; ?>">
                  <label for="middle_name">Middlename</label>
                   <p id = 'errormymiddle_name' class = "#ef5350 red lighten-1"  style = "color:white"></p>
           </div>
      
               <div  class = "col s6">
        <label>Gender:</label>
         <select name='Gender' id = "mygender" >
            <option value="<?php echo $mygender; ?>"><?php echo $mygender ; ?></option>
                <?php
                    $arrGender = array("Male", "Female", "Other");
                  foreach($arrGender as $GenderValue){
                        if($GenderValue == $mygender ){
                        }else{
                 ?>
                    <option  value="<?php echo $GenderValue?> "><?php echo $GenderValue?> </option>  
               <?php
                    }
                  }     
               ?>
         </select>
   </div>
               
               
               <div style = "display:none">
                     <input placeholder="Placeholder" id="mylevels" type="text" class="validate"  value = "<?php echo $mylevels; ?>" disabled>
                  <label for="levels">Levels</label>
               </div>
                
        
       </div>
   </div>
 
        <div class = "col s6">
            <label>Date of Birth:</label><br>
            <input onclick = "Materialize.toast('Scroll up to pick a date!', 4000)" class = "datepicker" value =  "<?php echo $mydateofbirth ; ?>" type="date" id = 'mybirthdate'  required> 
        </div>
         <div class = "col s6"> 
            <label>Mobile Number:</label>
    <div class="row">
               <div class = "col s4">             
                     <select name='indexMobile'  id = "my_index" >
                    <?php 
                           if ( substr($mymobilenumber,0,3) == "+63"){
                    ?>            
                    <option    value = "<?php echo substr($mymobilenumber,0,3) ; ?> "><?php echo substr($mymobilenumber,0,3) ; ?></option>    
                         <option  value="+82">+82</option>
                          <?php             
                           }else{
                             
                          ?>
                            <option  value="+63">+63</option>
                          <option    value = "<?php echo substr($mymobilenumber,0,3) ; ?> "><?php echo substr($mymobilenumber,0,3) ; ?></option>
                      <?php                
                           }
                         ?>             
                    </select>
                   </div>
                    <div class  = "col s8">
                     <input value = "<?php echo substr($mymobilenumber,4,12);?>" type="text"  id = "mymobilenumber"  name = "mobilenumber" placeholder="Enter Mobile Number">
                          <p id  = 'errormymobilenumber' class = "#ef5350 red lighten-1 "></p>
                    </div>      
    </div> 
 </div>
    
<div class = "col s12">
     <label>Username</label>
        <input type="text" id = "myusername" name = "Username" class="validate" placeholder="Enter Username" value = "<?php echo $myusername ?>">
                 <p id = 'errormyusername' class = "#ef5350 red lighten-1" style = "color:white"></p>
                    <p id = 'errormyusername2' class = "#ef5350 red lighten-1" style = "color:white"></p>
</div>

<div class  = "right">
        <div class="right-align"><input id = "updateMyProfileInformation" type="submit" name = "submit" class="btn btn-success main-color-bg" value="Save"></div>
</div>
</div>

</div>
<div id = "changePasswordForm">
    
     <div class ="left">
                   <a   id = "EditMyProfileBKbtn" class="left-align SpaceBetweenBTN waves-effect waves-light"> <i class="ion-arrow-left-c"></i></a>
     </div>
     <div class = "clearfix"></div>
     <div class = "row">
           <div class = "col s12">
                 <input type="password" id = "MyCurrentPassword" name = "Username" class="validate" placeholder="Enter Current Password" value = "">
                 <p id = 'errorMyCurrentPassword' style = "color:white"></p>
           </div>
           <div class = "col s12">
                  <input type="password"  id = "MyNewPassword" name = "Username" class="validate" placeholder="Enter New Password" value = "">
                 <p id = 'errorMyNewPassword' class = "#ef5350 red lighten-1" style = "color:white"></p>
           </div>
           <div class = "col s12">
                   <input type="password" id = "MyNewPasswordAgain" name = "Username" class="validate" placeholder="Enter New Password Again" value = "">
                 <p id = 'errorMyNewPasswordAgain' class = "#ef5350 red lighten-1" style = "color:white"></p>
           </div>
     </div>
     <div class =  "right">
         <div class="right-align"><input id ="saveNewPassword" type="submit" name = "submit" class="btn btn-success main-color-bg" value="Save"></div>
     </div>
     
</div>
<script> 
$(document).ready(function(){
$('#changePasswordForm').hide();
   $('#changeMypasswordBTN').click(function(e){
      $('#editMyProfileInformationForm').hide(); 
       $('#changePasswordForm').show();
   });
   $('#EditMyProfileBKbtn').click(function(e){
        $('#editMyProfileInformationForm').show(); 
       $('#changePasswordForm').hide();
   }); 
    $('#updateMyProfileInformation').click(function(e){           
        e.preventDefault();
          if($('#mylast_name').val().length == 0
             || $('#myfirst_name').val().length == 0
             || $('#mymiddle_name').val().length == 0
             || $('#mymobilenumber').val().length == 0){
                  alert('Please Fill up all fields!');     
          }else if ($('#mylast_name').val().length <  2
             || $('#myfirst_name').val().length < 2 
             || $('#mymiddle_name').val().length < 2){
                      //  alert('HELLO');   
          }else if ($('#mymobilenumber').val().length < 10){
                       //alert('Mobile # is less than 11')
          }else if ($('#myusername').val().length < 11){
              
          }else{
             alert('Successfully Updated!!');
                  socket.emit('Update Users',$('#mylast_name').val(),$('#myfirst_name').val(),$('#mymiddle_name').val(),$('#my_index').val()+$('#mymobilenumber').val(),$("#mygender").val(),$('#mybirthdate').val(),$('#mylevels').val(), $('#myusername').val(),$('#myuser_id').html(),function(Lname,Fname,Mname,mobilenumber,gender,birthdate,levels,username,user_id){}); 
    
                $('#errormyusername2').empty();
          
                 }
            }); 
    
    $('#saveNewPassword').click(function(e){
        e.preventDefault();
        if($('#MyCurrentPassword').val().length == 0
           || $('#MyNewPassword').val().length == 0
           || $('#MyNewPasswordAgain').val().length == 0){
            alert('Please fill up all fields!');
        }else if ($('#MyNewPassword').val().length < 11){
            
        }else if ($('#MyNewPasswordAgain').val() != $('#MyNewPassword').val()){
            
        }else{
            alert('Successfully Saved');
            
            socket.emit('Update NewUserPassword',$('#MyNewPassword').val(),$('#myuser_id').html(),function(new_password,user_id){});
            $('#MyNewPasswordAgain').val('');
            $('#MyNewPassword').val('');
            $('#MyCurrentPassword').val('');
            $('#errorMyCurrentPassword').empty();
            $('#editMyProfileInformationForm').show(); 
            $('#changePasswordForm').hide();
            $('#MyNewPasswordAgain').blur();
            $('#MyNewPassword').blur();
            $('#MyCurrentPassword').blur();
        }
    }); 
    var myFields = ["mylast_name","myfirst_name","mymiddle_name","myusername","mymobilenumber","mybirthdate"];
    $.getScript("../js/form_validations.js",function(){ 
   for ( var i = 0; i < 5 ; i++){
             if (i < 3 ){
                Keypress_F(myFields[i],'LettersOnly');
                $("#"+myFields[i]).attr('maxlength','20');
             }else if ( 2 < i &&  i < 4 ){
                  Keypress_F(myFields[i],"NumbersAndLetters");
                  $("#"+myFields[i]).attr('maxlength','16');
             }else if (i == 4){
                  Keypress_F(myFields[i],"NumbersOnly");
                  $('#'+myFields[i]).attr('maxlength','10');
             }
         }
          MinLimit_F('mylast_name','Lastname',2);
          MinLimit_F('myfirst_name','Firstname',2);
          MinLimit_F('mymiddle_name','Middlename',2);
          MinLimit_F('myusername','Username',11);
          MinLimit_F('mymobilenumber','Mobile Number',10);
          MinLimit_F('MyNewPassword','New Password',11);
          Keypress_F('MyNewPasswordAgain',"NumbersAndLetters");
          Keypress_F('MyNewPassword',"NumbersAndLetters");
          Keypress_F('MyCurrentPassword',"NumbersAndLetters");
          $('#MyNewPasswordAgain').attr('maxlength','16');
          $('#MyNewPassword').attr('maxlength','16');
          $('#MyCurrentPassword').attr('maxlength','16');
         
      check_username('myusername','updateMyProfileInformation','2',$('#myuser_id').html(),'users','user_iid','username','Username');  
        IFpasswordExist('MyCurrentPassword','myuser_id','saveNewPassword');
        check_password_again('MyNewPassword','MyNewPasswordAgain');
  });
      
      $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears:200, // Creates a dropdown of 15 years to control year,
    max: [1990],
    
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false,// Close upon selecting a date, 
    format: 'yyyy-mm-dd'
});
      });
</script>