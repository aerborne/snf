<?php 
//if(isset($_GET['uadd'])){
    

?> 
 
 <section id="main">
      <div class="container">
        <div class="row">
   
 
            
          <div class="col s12 m12">
                
                    <div class = "center-align">
                        <span class="card-title "><h1>Register User</h1></span>
                   </div>
                      
            <form id="myForm" action="" method = "POST" class="well">
                 <div class="form-group">
                    <label>Lastname:</label>
                    <input type="text"  id =  "Lname" name = "Lastname" class="validate" placeholder="Lastname"> 
                    <p id = 'errorLname' class = "#ef5350 red lighten-1" style = "color:white"></p>
                </div>
                 <div class="form-group">
                    <label>Firstname:</label>
                    <input type="text" id  = "Fname" name = "Firstname" class="validate" placeholder="Enter Firstname">
                     <p id = 'errorFname' class = "#ef5350 red lighten-1" style = "color:white" ></p>
                </div>
                <div class="form-group">
                    <label>Middlename:</label>
                    <input type="text" id = "Mname" name = "Middlename" class="validate" placeholder="Enter Middlename">
                    <p id = 'errorMname' class = "#ef5350 red lighten-1" style = "color:white"></p>
                </div>
                <div class = "form-group">
                 <label>Birthdate:</label>
                <input  type="text" class = "datepicker" id = 'birthdate' style = 'width:23em' required>
                </div>
                <div class="form-group">
                    <label>Gender:</label>
                    <select name='Gender'  id = "Gender">
                        <option  value="Male">Male</option>
                        <option  value="Female">Female</option>
                        <option  value="Other">Other</option>
                    </select>
                </div>
                 <div class="row">
                    <div class = "col s2">   
                         <select name='indexMobile'  id = "index" >
                            <option  value="+63">+63</option>
                            <option  value="+82">+82</option>
                        </select>
                    </div>
                    <div class = "col s10">
                          <input type="text"  id = "mobilenumber" name = "mobilenumber" class="validate " placeholder="           Enter Mobile Number">
                    </div>
                  </div>
                 <p id  = 'errormobilenumber'  class = "#ef5350 red lighten-1" style = "color:white"></p>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id = "Addusername" name = "Username" class="validate" placeholder="Enter Username">
                 <p id = 'errorAddusername' class = "#ef5350 red lighten-1" style = "color:white"></p>
                    <p id = 'errorAddusername2' class = "#ef5350 red lighten-1" style = "color:white"></p>
                  </div>    
                  <div class="form-group">
                    <label >Password</label>
                    <input type="password" id = "password" name = "Password" class="form-control " placeholder="Password">
                    <p  id = 'errorpassword' class = "#ef5350 red lighten-1" style = "color:white"></p>
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" id = "password_again" name = "Password_Again" placeholder="Password Again">
                    <p id = 'errorpassword_again'class = "#ef5350 red lighten-1" style = "color:white"></p>
                  </div>
                 <div class="form-group">
           <label>Level</label>
 <select  name = 'category_id' id = "levels" class ='form-control'>
      <option value="Admin">Admin</option> 
      <option value="Interior Designer">Interior Designer</option> 
      <option value="Client">Client</option>     
</select>
     </div>
                  <div class="right-align">
                 <input  type = "submit"  id = "btn_submit" value = "Register" class = "btn" >
                      </div>
                <br>
              </form> 
            
          </div>
  
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>                
    <script> 
$(document).ready(function(){
    var socket  = io.connect('http://localhost:3100');
    var fields  = ["Lname","Fname","Mname","Addusername","password","password_again","mobilenumber","birthdate"];
      $('#myForm').submit(function(e){           
        e.preventDefault();
          if($('#Lname').val().length == 0
             || $('#Fname').val().length == 0
             || $('#Mname').val().length == 0
             || $('#Addusername').val().length == 0
             || $('#password').val().length == 0
             || $('#password_again').val().length == 0
             || $('#mobilenumber').val().length == 0){

                  alert('Please Fill up all fields!');     
          }else if ($('#Lname').val().length <  2
             || $('#Fname').val().length < 2 
             || $('#Mname').val().length < 2){
                      //  alert('HELLO');   
          }else if ($('#mobilenumber').val().length < 10){
                       //alert('Mobile # is less than 11')
          }else if ($('#Addusername').val().length < 11){
                       //alert('Username is less than  11');  
          }else if ($('#password').val().length < 11){
          }else if ($('#password_again').val() != $('#password').val()){
                       //alert('Password is less than  11');
          }else{
                      //alert('Insert Uqery!!');
                      
                          socket.emit('Register  User2',$('#Lname').val(),$('#Fname').val(),$('#Mname').val(),$('#Addusername').val(),$('#password').val(),$('#index').val()+$('#mobilenumber').val(),$("#Gender").val(),$('#birthdate').val(),$('#levels').val(),function(Lname,Fname,Mname,username,password,mobilenumber,gender,birthdate,levels){
                         });    
                        socket.emit('UpdateChatList');
                        socket.emit('UpdateAdminCounterList');
                        socket.emit('Update ClientChatList');
                        alert('Successfully Registered');
                 for ( var i = 0; i < 8 ; i++){
                      $('#'+fields[i]).val('');
                      $('#'+fields[i]).blur();
                }
                $('#errorAddusername2').empty();
                       // window.open('signIN.php','_self');
                 }
          socket.emit('UpdateChatList');
          socket.emit('UpdateAdminCounterList');
          socket.emit('Update ClientChatList');
                 
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
           
    $.getScript("js/form_validations.js",function(){    
        //Keypress Validation 
         for ( var i = 0; i < 8 ; i++){
             if (i < 3 ){
                  Keypress_F(fields[i],'LettersOnly');
                  $("#"+fields[i]).attr('maxlength','10');
             }else if( 2 < i && i < 6 ){
                  Keypress_F(fields[i],"NumbersAndLetters");
                  $("#"+fields[i]).attr('maxlength','16');
             }else{
                  Keypress_F(fields[i],"NumbersOnly");
                  $('#'+fields[i]).attr('maxlength','10');
             }         
         }     
          MinLimit_F('Lname','Lastname',2);
          MinLimit_F('Fname','Firstname',2);
          MinLimit_F('Mname','Middlename',2);
          MinLimit_F('Addusername','Username',11);
          MinLimit_F('password','Password',11);
          MinLimit_F('mobilenumber','Mobile Number',10); 
          check_username('Addusername','btn_submit','','','users','user_iid','username','Username');    
          check_password_again('password','password_again');
    });
              $('select').material_select();

       });
            
    </script>             
        </div>
      </div>
    </section>


  <?php         
// }
  ?>
       <br><br>   <br><br>



