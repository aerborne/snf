    <a href = "#changeProfileP<?php  echo  $account_user_id;  ?>" class = "modal-trigger" onclick = "upload_user_modal(document.getElementById('<?php  echo  $account_user_id;  ?>upload_user_id').innerHTML)"> <i class="material-icons white-text" style = "background-color:black;opacity:0.5;position:absolute">edit</i></a>
 
        <div class = "container">
            <div style = "overflow-y:hidden; overflow-y:scroll; height:20em;">
                
<form action="#">
     <div class  = "col s4" style = "margin-bottom:0.5em">
         <div id = "test1_img" ><img class="responsive-img" src="simages/deadpool.jpg"></div>
             
                 <input class="with-gap" name="group1" type="radio" id="test1"  />
                <label for="test1" ></label>
                 
                
     </div>
    <div class  = "col s4" style = "margin-bottom:0.5em">
         <div class = "left-align">
             <div id = "test2_img" ><img class="responsive-img" src="simages/deadpool.jpg"></div>
                 <input class="with-gap" name="group1" type="radio" id="test2"  />
                <label for="test2"></label>
        </div>  
                 
                
     </div>   
  </form>      
          </div>
        </div>
<style>
    .forceDisplay{ 
      margin-bottom: 20em;
       border-style: dotted;
    }
</style>
 <script src = "js/JQuery-1.8.0.js"></script>     
    <script src = "js/jquery-1.11.3.min.js"></script>
<script>
  $("label[for=test1],#test1").hide();
  $("label[for=test2],#test2").hide();
$('#test1_img').click(function() {

       $('#test1_img').addClass('forceDisplay');                     
        $('#test2_img').removeClass('forceDisplay'); 
        $("#test1").prop("checked", true)
      
   if($('#test1').is(':checked')) { 
       
   }
    
});
$('#test2_img').click(function(){

       $('#test2_img').addClass('forceDisplay');                     
        $('#test1_img').removeClass('forceDisplay'); 
        $("#test2").prop("checked", true)
     /*
   if($('#test1').is(':checked')) { 
         $('#test1_img').addClass('forceDisplay');                     
        $('#test2_img').removeClass('forceDisplay');  
   }
   */
});
 
</script>     