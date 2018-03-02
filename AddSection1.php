 <div class="container"> 
    <div class="row">
      <div class="col s12 m12">
         
             <div class = "center-align">
                        <span class="card-title"><h3>Register Section</h3></span>
                   </div>
            <form  id = "myFormSection" action="" method = "POST" class = "well">
              <div class="modal-body">
                <div class="form-group">
                  <label>Section Name</label>
                  <input id = "section_name" name = "section_name" type="text" >
                </div>
                 <p id = "errorsection_name"  class = "#ef5350 red lighten-1" style = "color:white;"></p>
                  <p id = "errorsection_name2"  class = "#ef5350 red lighten-1" style = "color:white;"></p><br>
              </div>
                <div class="right-align">
                    
               <input type="submit" id = "btn_submitaddsection" name = "submit" class="btn btn-success main-color-bg" value="Submit">

                </div>
               
             </form>
        
      </div>
    </div>
</div>
<script src = "js/jquery-1.11.3.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js">
</script>
<script> 
  $(document).ready(function(){
       var socket  = io.connect('http://localhost:3100');
     $('#btn_submitaddsection').prop('disabled', true);
     $('#myFormSection').submit(function(e){
          e.preventDefault();
           if($('#section_name').val().length == 0 ){
              alert('Please Fill up the field!');
          }else{
              socket.emit('Register Section',$('#section_name').val(),function(section_name){});
              alert('Successfully Added');
              $('#section_name').val('');
              $('#errorsection_name2').empty();
          }
     });
       $(document).on('keypress', '#section_name', function (event){
                var regex = new RegExp("^[a-zA-Z\b ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
     });
          NamesValidation('section_name','Section name must not be less than  2 characters!!')
     function  NamesValidation(data,errorMessage){
                 jQuery('#'+data).on('input propertychange paste', function() {
                 if ($('#'+data).val().length < 2){
                      $('#error'+data).empty();
                      $('#error'+data).append(errorMessage);
                      $('#btn_submitaddsection').prop('disabled', true);
                 }else{
                     $('#error'+data).empty();
                    
                 }
            });     
     }
       jQuery('#section_name').on('input propertychange paste', function() {
                 
                    socket.emit('Check  section_name',$('#section_name').val(),function(section_name){});
       });
socket.on('check section_name_result',function(data){
          //  alert('Hello');
             $('#btn_submitaddsection').prop('disabled', false);
                $('#errorsection_name2').empty();
               if ($('#section_name').val().length < 2){
                       //alert('Username is less than  11');  
                }else{
                if (data.rows == 0 ){
                     //alert(data.rows);
                    $('#errorsection_name2').append('Category Name is Available');
                     $("#errorsection_name2").css("color", "white");
                     $('#btn_submitaddsection').prop('disabled', false);
               $("#errorsection_name2" ).removeClass("#ef5350 red lighten-1" ).addClass( "#1de9b6 teal accent-3");
                }else{
                    //alert(data.rows);
                 $("#errorsection_name2").css("color", "white");
                    $('#errorsection_name2').append('Category Name is Unavailable');
                    $('#btn_submitaddsection').prop('disabled', true);
                    $("#errorsection_name2" ).removeClass("#1de9b6 teal accent-3" ).addClass( "#ef5350 red lighten-1");
                }
                }   
});
      
    $("#section_name").attr('maxlength','15');
    
     
  });
</script>
