
 function Keypress_F(variable_id,KeyPType){
      if(KeyPType ==  "LettersOnly"){
         var  KeyMode =  "^[a-zA-Z\b ]+$";
      }else if(KeyPType == "NumbersAndLetters"){
         var  KeyMode  = "^[a-zA-Z0-9\b]+$";  
      }else if(KeyPType == "NumbersOnly"){
         var  KeyMode  =  "^[0-9\b ]+$";
      }           
$(document).on('keypress', '#'+variable_id, function (event) {
                var regex = new RegExp(KeyMode);
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
    });
}; 
 
 function MinLimit_F(variable_id,field,min_limit){
     var  errorMessage = field+" must not be less than "+min_limit+" character/s!";
            jQuery('#'+variable_id).on('input propertychange paste', function() {
                 if ($('#'+variable_id).val().length < min_limit){
                      displayMessageContrast("error"+variable_id,"error",errorMessage);
                 }else{
                     $('#error'+variable_id).empty();
                    
                 }
            }); 
 };
//Format function 
 //u_primary_id        = unique primary id 
// tblName             = table_name
// u_primary_id_col_n  = unique_primary_id_column_name
// variable_col_n      = variable_column_name 
//Check_username  = renamed to check uniqueness of the name


//Edit Error Message 

function check_username(variable_id,button_id,CheckType,u_primary_id,tblName,u_primary_id_col_n,variable_col_n,name_prompt){
     
        jQuery('#'+variable_id).on('input propertychange paste', function() {
       
             if (CheckType ==  2){
               
                    socket.emit('Check Username2',$('#'+variable_id).val(),u_primary_id,u_primary_id_col_n,variable_col_n,tblName,function(variable_value,u_primary_id,u_primary_id_col_n,variable_col_n,tblName){})             
             }else{
                //alert($('#'+variable_id).val());
                socket.emit('Check Username',$('#'+variable_id).val(),u_primary_id_col_n,variable_col_n,tblName,function(variable_value,u_primary_id_col_n,variable_col_n,tblName){});   
             }
                
            
            });
     
           socket.on('Username Error',function(data){
               $('#error'+variable_id+'2').empty();
             if ($('#'+variable_id).val().length < 11){ 
             }else{
                if (data.rows == 0 ){
                    $('#error'+variable_id+'2').append(name_prompt+' is Available');
                     $("#error"+variable_id+"2").css("color", "white");
                     $('#'+button_id).prop('disabled', false);
                     $("#error"+variable_id+"2" ).removeClass("#ef5350 red lighten-1" ).addClass( "#1de9b6 teal accent-3");
                }else{
                 $("#error"+variable_id+"2").css("color", "white");
                    $('#error'+variable_id+'2').append(name_prompt+' entered is Unavailable');
                    $('#'+button_id).prop('disabled', true);
                      $("#error"+variable_id+"2" ).removeClass("#1de9b6 teal accent-3" ).addClass( "#ef5350 red lighten-1");
                }
             }
            
           });
};
function check_password_again(password_id,password_again_id){
       jQuery('#'+password_again_id).on('input propertychange paste', function() {
                 if ($('#'+password_again_id).val() != $('#'+password_id).val()){
                      $('#error'+password_again_id).empty();
                     $('#error'+password_again_id).append('Password does not much matched!');
                   
                     // $('#btn_submit').prop('disabled', true);
                 }else{
                     $('#error'+password_again_id).empty();
                    // $('#btn_submit').prop('disabled', false);
                 }
            });
          
}
function compare_two_fields(variable_id,compare_to_id,variableDisplay,compareDisplay){
      jQuery('#'+variable_id).on('input propertychange paste', function() {
           if($('#'+variable_id).val().length < 14){
                $('#'+compare_to_id).prop('disabled',true); 
                $('#'+compare_to_id).val('');
           }else{
               $('#'+compare_to_id).prop('disabled',false);
                  jQuery('#'+compare_to_id).on('input propertychange paste', function() {
                       if ($('#'+compare_to_id).val() == $('#'+variable_id).val()){
                           var message = compareDisplay+" does match "+variableDisplay;
                         displayMessageContrast("error"+compare_to_id,"success",message);
                       }else{
                            
                           var message = compareDisplay+" does not match the "+variableDisplay;
                             displayMessageContrast("error"+compare_to_id,"error",message);
                       }
                  });
           }   
     
              
      });
}
function IFpasswordExist(variable_id,user_id,submitBTN_id){   
     var timer;
     $("#"+variable_id).on('keyup',function() {
        timer && clearTimeout(timer);
        timer = setTimeout(checkCurrentPass, 400)
    }); 
    function checkCurrentPass(){
            socket.emit('Check CurrentPassword',$('#'+variable_id).val(),$('#'+user_id).html(),function(currentPassword,user_id){});
     }
    socket.on('Password Results',function(data){
             if(data.result  === true ){
                 console.log('true match');
               displayMessageContrast('error'+variable_id,'success','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password entered is valid');         
                  $('#'+submitBTN_id).prop('disabled',false);
             }else{
                 console.log('false match');
                 displayMessageContrast('error'+variable_id,'error','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password entered is invalid');
                  $('#'+submitBTN_id).prop('disabled',true); 
             }
      });
}
function displayMessageContrast(variable_id,status,message){
      if(status == "error"){
         $('#'+variable_id).empty(); 
         $('#'+variable_id).append(message);
         $('#'+variable_id).removeClass('successMStyle');
         $('#'+variable_id).addClass('errorMStyle');
      }else{
         $('#'+variable_id).empty(); 
         $('#'+variable_id).append(message);  
         $('#'+variable_id).addClass('successMStyle');
         $('#'+variable_id).removeClass('errorMStyle')  
      }
    Materialize.fadeInImage('#'+variable_id);
};
function selectModalPicture(variable_id,click_id,arrayName,modal_picture_name){
         $('#'+click_id).click(function(){
          for (var key in arrayName) {
            let value = arrayName[key];
                if(variable_id == key){
                    $('#'+modal_picture_name).empty();
                    $('#'+modal_picture_name).append('<img src="'+value+'" alt="" class="responsive-img "  width = "850"> ');
                }          
          }
           //socket.emit('get picture_description',variable_id,function(variable_id){});
  
     });
 
};
function convertDateTime(variable_id){
     var month    = variable_id.substr(5,2);
     var day      = variable_id.substr(8,2);
     var year     = variable_id.substr(0,4);
     var time     = variable_id.substr(11,5);
     var endTime  = variable_id.substr(20,2);
     var time_convention  = variable_id.substr(11,2);
var NameOfMonths = [];
   NameOfMonths["01"]  = "Jan";
   NameOfMonths["02"]  = "Feb";
   NameOfMonths["03"]  = "Mar";
   NameOfMonths["04"]  = "Apr";
   NameOfMonths["05"]  = "May";
   NameOfMonths["06"]  = "Jun";
   NameOfMonths["07"]  = "July";
   NameOfMonths["08"]  = "Aug";
   NameOfMonths["09"]  = "Sept";
   NameOfMonths["10"]  = "Oct";
   NameOfMonths["11"]  = "Nov";
   NameOfMonths["12"]  = "Dec";   
for (var key in NameOfMonths) {
   let monthName = NameOfMonths[key];
    if(month == key){
        if(time_convention  > 12){
            time_convention  = time_convention - 12;
            time_convention  = time_convention+""+variable_id.substr(13,2);
            return  monthName+" "+day+", "+year+" at "+time_convention+" "+endTime+" PM";
        }else{
            return  monthName+" "+day+", "+year+" at "+time+" "+endTime+" AM";
        }
       
    }
 }
};
function delete_item(primary_id,primary_id_name,tablename,next_route){
     socket.emit('delete items',primary_id,primary_id_name,tablename,function(primary_id,primary_id_name,tablename){});
    window.open('admin_meta_index.php?'+next_route,'_self')
    
};
  
 