<div class  = "right-align">
      <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
</div>
<div class="container">
   <div class="row">
      <div class="col s12 m12">
             <div class = "center-align">
                        <span class="card-title"><h3>Register Category</h3></span>
              </div>
            <form  id = "myFormCategory" action="" method = "POST" class = "well">
              <div class="modal-body">
                <div class="form-group">
                  <label>Category Name</label>
                  <input  id = "category_name" name = "category_name" type="text">
                </div>
                 <p id = "errorcategory_name"  class = "#ef5350 red lighten-1" style = "color:white;"></p>
                  <p id = "errorcategory_name2"  class = "#ef5350 red lighten-1" style = "color:white;"></p>
              </div>
                <br>
                <div class="right-align">
               <input type="submit" id = "btn_submit_addcategory" class="btn btn-success main-color-bg" value="Add">
                </div>
             </form>
          
      </div>
    </div>
</div>
<script src = "js/jquery-1.11.3.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js"></script>
<script> 
$(document).ready(function(){
     var socket  = io.connect('http://localhost:3100');
       $('#btn_submit_addcategory').prop('disabled', true);
     $('#myFormCategory').submit(function(e){
        e.preventDefault();
            
         
          if($('#category_name').val().length == 0){
               alert('Please Fill up the field!');   
          }else{
              socket.emit('Register Category',$('#category_name').val(),function(category_name){});
              alert('Successfully Added');
              $('#category_name').val('');
              $('#errorcategory_name2').empty();
              //$('#addCategory').modal('close');
          }
     });
    
     $(document).on('keypress', '#category_name', function (event){
                var regex = new RegExp("^[a-zA-Z\b ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
     });
      NamesValidation('category_name','Category name must not be less than  2 characters!!')
     function  NamesValidation(data,errorMessage){
                 jQuery('#'+data).on('input propertychange paste', function() {
                 if ($('#'+data).val().length < 2){
                      $('#error'+data).empty();
                      $('#error'+data).append(errorMessage);
                      $('#btn_submit_addcategory').prop('disabled', true);
                 }else{
                     $('#error'+data).empty();
                    
                 }
            });     
     } 
          jQuery('#category_name').on('input propertychange paste', function() {
                 
                    socket.emit('Check  category_name',$('#category_name').val(),function(category_name){});
          });
       socket.on('check category_name_result',function(data){
           // alert('value '+data.rows);
             $('#btn_submitaddcategory').prop('disabled', false);
                $('#errorcategory_name2').empty();
               if ($('#category_name').val().length < 2){
                       //alert('Username is less than  11');  
                }else{
                if (data.rows == 0 ){
                     //alert(data.rows);
                    $('#errorcategory_name2').append('Category Name is Available');
                     $("#errorcategory_name2").css("color", "white");
                     $('#btn_submit_addcategory').prop('disabled', false);
                    $("#errorcategory_name2" ).removeClass("#ef5350 red lighten-1" ).addClass( "#1de9b6 teal accent-3");
                }else{
                    //alert(data.rows);
                 $("#errorcategory_name2").css("color", "white");
                    $('#errorcategory_name2').append('Category Name is Unavailable');
                    $('#btn_submit_addcategory').prop('disabled', true);
                      $("#errorcategory_name2" ).removeClass("#1de9b6 teal accent-3" ).addClass( "#ef5350 red lighten-1");
                }
                }   
       });
     $("#category_name").attr('maxlength','15');
    
    
});
</script>

       
      
