<?php  
if(isset($_GET['ClientViewProject'])){
         $projprog_id = $_GET['ClientViewProject'];
         $select_pupdates  = queryMysql("SELECT  *  from projectprog_update where  projprog_id = '$projprog_id'  and available = 0 order by pupdate_id desc");
           $project_details        = queryMysql("SELECT  * from project_progress where projprog_id = '$projprog_id'");
           $row_project_details    = mysqli_fetch_array($project_details);
           $project_name           =  $row_project_details['name'];
           $project_description    =  $row_project_details['description'];
          $select_username  = queryMysql("SELECT  *  from users where user_iid = '$user_id'");
          $row_select  = mysqli_fetch_array($select_username);
          $username    =  $row_select['username'];
          $user_level  =  $row_select['levels'];
         
    //Create update
         $update_id   =  $_GET['updates'];
         $select_percentage = queryMysql("SELECT * FROM  projectprog_update   where pupdate_id = '$update_id'");
         $row_select_percentage =  mysqli_fetch_array($select_percentage);
         $update_percent   = $row_select_percentage['percent_d'];
        
    //echo $update_percent;
 
?>
<!-- Initialize Add user parameter values-->
          <div id  =  "update_id" style = "display:none;"><?php echo $update_id;?></div>
          <div id  =  "update_percent" style  = "display:none;"><?php echo $update_percent;  ?> </div>
          <div id = "user_id" style = "display:none;"><?php echo $user_id; ?></div>
          <div id = "username" style = "display:none;"><?php echo $username; ?></div>
          <div id = "user_level" style = "display:none;"><?php echo $user_level;?></div>
          <div id = "tableName" style = "display:none">projprog_update_comments</div>
          <div id = "comment_id_name" style = "display:none">projprog_update_comment_id</div>
          <div id  = "reference_id_name" style = "display:none">pupdate_id</div>
 
<!-- Initialize Add user parameter values--> 
 
<div id = "projprog_id" style = "display:none"><?php echo $projprog_id?></div>
<div class  = "card">
<div class = "card-content">
<div class  ="row">
  
     <span class="card-title" style = "margin-left:1em  "><?php echo $project_name; ?></span>
    
<div  id  style =  "overflow-y:scroll; height:30em; margin-top:0.5em">
   <div id  = "featImage"></div>
</div>
 
    <br><br>
<ul class="collapsible" id = "collapsDescription" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><p class = " truncate" style = "word-wrap: break-word;"><?php echo $project_description;?></p></div>
      <div class="collapsible-body"><span><p  style = "word-wrap: break-word;"><?php echo $project_description;?></p></span></div>
    </li>
</ul>
        
 
   
      <div class="input-field col s12">
    <select id = "selectupdatePercentID">
<?php
         while($row_all_content=mysqli_fetch_array($select_pupdates)){
         $pupdate_id    = $row_all_content['pupdate_id'];
         $percent       = $row_all_content['percent_d'];
         echo $pupdate_id; 
         echo $percent;
 
?> 
      <option  class = "center-align" value="<?php echo $pupdate_id; ?>"><?php  echo  $percent; ?> %</option>
<?php 
}
?>
    </select>
    <label>Select Project Percentage</label>
  </div>
 
</div>
   
        
  <ul class="collapsible popout" id  = "section_names" data-collapsible="accordion">
    
      
      <li><div class="collapsible-header active">All</div><div class="collapsible-body"><div class="row"><div id = "AllPictureszz" style =  "overflow-y:scroll; height:50em;margin-left:4em" ></div></div><span></span></div></li>
       <li><div class="collapsible-header">No Section</div><div class="collapsible-body"><div class="row"><div id = "NoSection" style =  "overflow-y:scroll; height:50em;margin-left:4em" ></div></div><span></span></div></li>
 
  </ul>
    </div>
</div>
<div class = "card">
  <div class = "card content">
      <div class = "row">
          <div class = "col s12">

        <form  id  = "commentForm">
               <br><br>
               <div class="input-field col s12">
                    <label for="comment" id = "username"><?php echo $username; ?></label>
            <textarea id = "Newcomment" class="materialize-textarea" rows="2"></textarea>
            </div>

            <br>
            <div  class ="right-align">
            <input id = "btnSubmit" type = "submit"  value = "Comment" class = "main-color-bg btn" >
            </div>
       </form>
        <br><br>
          <div id = "ShowComments" style = " white-space: initial;"></div>
      <div id = "Show" style = " white-space: initial;"></div>
    <div id = "replyContent"></div>         

    </div> 
    </div>
</div>

</div>


         <script src = "js/JQuery-1.8.0.js"></script>
<script src = "js/jquery-1.11.3.min.js"></script>
      
   <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
  
     
<script>


  $(document).ready(function(){
          var socket  = io.connect('http://localhost:3100');
          var  $username            =   $('#username');
          var  $comment             =   $('#Newcomment');
          var  $ShowComments        =   $('#ShowComments')
          var  $ReplyComments       =   $('#replyContent');
          var  $user_id             =   $('#user_id');
          var  $user_level          =   $('#user_level');
          var  $tableName           =   $('#tableName');
          var  $comment_id_name     =   $('#comment_id_name');
          var  $reference_id_name   =   $('#reference_id_name');
     $('.collapsible').collapsible();
     $('select').material_select();
      
    // alert($('#selectSectionID').val());
      
      
       
    
jQuery("#selectupdatePercentID").change(function(){    
      //alert($('#selectupdatePercentID').val());
  //$("#selectupdatePercentID option:selected" ).text('Hawss');
    $('#section_names').empty();
    $('#section_names').append('<li><div class="collapsible-header active">All</div><div class="collapsible-body"><div class="row"><div id = "AllPictureszz" style =  "overflow-y:scroll; height:50em;margin-left:4em" ></div></div><span></span></div></li><li><div class="collapsible-header">No Section</div><div class="collapsible-body"><div class="row"><div id = "NoSection" style =  "overflow-y:scroll; height:50em;margin-left:4em" ></div></div><span></span></div></li>');
   
alert('Hello');    

    
    /*
    if ($(this).val() === '12'){
        alert('Top Projects');
     }else{
             //socket.emit('Select Category',$('#SelectPortfolioCategory').val(),function(category_id){});
     }
     
  
socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),$('#selectupdatePercentID').val(),'ppg',$('#tableName').html(),$('#comment_id_name').html(),$('#reference_id_name').html(),function(user_id,username,user_level,pupdate_id,cn_comment_code,tableName,comment_id_name,reference_id_name){});
 */     
    socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),$('#selectupdatePercentID').val(),'ppg',$('#tableName').html(),$('#comment_id_name').html(),$('#reference_id_name').html());  
socket.emit('Get pupdate_ID',$('#selectupdatePercentID').val(),function(projprog_id){
    
});

    $('.collapsible').collapsible(); 
      $ShowComments.empty();
   // $('#selectupdatePercentID').val() = " ";
    
});
//Comment  module start  =====>>>>>>>>>>>>>>>>>>>>>>>>> 
 /*
socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),$('#selectupdatePercentID').val(),'ppg',$('#tableName').html(),$('#comment_id_name').html(),$('#reference_id_name').html());
*/  
      
//Comment module start ===========================> >>
             
  $('#commentForm').submit( function(e){ 
        e.preventDefault();
        if (($('#Newcomment').val().trim() == '')){
              alert('Please fill up the comment field');
        }else{
            alert('comment value'+$comment.val());
            
        socket.emit('GetComment',$comment.val(),function(data){
                    });      
        var newCommentMessage = " commented: "+$comment.val();
          socket.emit('NewComment Notification',$('#user_id').html(),$user_level.html(),newCommentMessage,'client.php?ProjectUpdateContent='+ $('#Project').html(),'comment',$('#Project').html(),function(user_id,user_level,newCommentMessage,key_id,notification_type,pupdate_id){
              });    
              $comment.val('');
        
        
        }  
});   
        
        socket.on('countMessagesValuesClient',function(countMessagesValues){
        //alert('Connection is alright');
        $('#messageCounterAdmin').empty();
           $.each(countMessagesValues,function(key,value){
             // alert('countMessages Triggered');
               $('#messageCounterAdmin').prepend('<div>'+value+'</div>');
           });
    });
        
        socket.on('show comment',function(data){

         // alert('Show Comment');
            console.log('show comment is detected');
            if($user_id.html() == data.user_id){
            //Comment Function    
             commentOutput('current'+data.comment_id,data.comment_id,"YES",data.username,data.comment,'currentButton'+data.comment_id,"Delete Comment",'Current'); 
            
            //Reply Function 
                console.log('comment_id for reply'+data.comment_id);  
                replyOutput('ReplyButton'+data.comment_id,'ReplyFormDiv'+data.comment_id,'ReplyMainDiv'+data.comment_id,$username.html(),'ReplyComment'+data.comment_id,'ReplySubmitnhjButton'+data.comment_id,'ReplySubMainDiv'+data.comment_id,'ReplyDeleteButton'+data.comment_id,'ShowReplys'+data.comment_id,data.comment_id,data.user_id);
                  
            }else{
                commentOutput('current'+data.comment_id,data.comment_id,"NO",data.username,data.comment,' ',' ','Current');
                replyOutput('ReplyButton'+data.comment_id,'ReplyFormDiv'+data.comment_id,'ReplyMainDiv'+data.comment_id,$username.html(),'ReplyComment'+data.comment_id,'ReplySubmitButton'+data.comment_id,'ReplySubMainDiv'+data.comment_id,'ReplyDeleteButton'+data.comment_id,'ShowReplys'+data.comment_id,data.comment_id,data.user_id); 
            }     
        });
       socket.on('deleted comment',function(data){
                 console.log("delete comment id detected = :"+data.comment_id);
                 $("#current"+data.comment_id).hide();
       }); 
       socket.on('Comment History',function(data){
        
           console.log('Comment History is tracked');
           
              if($user_id.html() == data.user_id){ 
                 commentOutput('History'+data.comment_id,data.comment_id,"YES",data.username,data.comment,'HistoryButton'+data.comment_id,"Delete History Comment",'History');
                  replyOutput('ReplyButton'+data.comment_id,'ReplyFormDiv'+data.comment_id,'ReplyMainDiv'+data.comment_id,$username.html(),'ReplyComment'+data.comment_id,'ReplySubmitButton'+data.comment_id,'ReplySubMainDiv'+data.comment_id,'ReplyDeleteButton'+data.comment_id,'ShowReplys'+data.comment_id,data.comment_id,data.user_id);
                   
              }else{  
                  commentOutput('History'+data.comment_id,data.comment_id,"NO",data.username,data.comment,'',"",'History'); 
                  replyOutput('ReplyButton'+data.comment_id,'ReplyFormDiv'+data.comment_id,'ReplyMainDiv'+data.comment_id,$username.html(),'ReplyComment'+data.comment_id,'ReplySubmitButton'+data.comment_id,'ReplySubMainDiv'+data.comment_id,'ReplyDeleteButton'+data.comment_id,'ShowReplys'+data.comment_id,data.comment_id,data.user_id);         
              }
            
      });
      socket.on('Deleted History Comment',function(data){
                 console.log("delete comment id detected = :"+data.comment_id)
                 $("#History"+data.comment_id).hide();
      });

             function commentOutput(MainDiv,comment_id,DeleteID,userName,comment,DeleteButton,DeleteFunction,time){
                 
               $('.modal').modal(); 
              if(time == "Current"){
                if(DeleteID == "YES"){
                   $ShowComments.prepend('<div id = "'+MainDiv+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="'+DeleteButton+'">&times;</button></div><p class="flow-text " style  = "word-wrap: break-word"><label  id = "commentUsername"><span style = "color:grey;">'+userName+'</span></label><br><span id = "displayComment'+comment_id+'">'+comment+'</span><a id = "EditCommentModalTrigger'+comment_id+'" href = "#editComment'+comment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p><button class = "btn main-color-bg  btn-small" id = "ReplyButton'+comment_id+'">Reply</button><div id = "ReplyMainDiv'+comment_id+'"></div><label id = "parent_key'+comment_id+'">'+comment_id+'</label><div id = "ShowReplyComments'+comment_id+'"></div></div> <div id="editComment'+comment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label for="editComment">Comment</label><input  id="Comment'+comment_id+'" type="text" class="validate" value = "'+comment+'"><div class = "right-align"><a id = "editCommentModal'+comment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
                     $('#'+DeleteButton).click(function(){
                             socket.emit(DeleteFunction,comment_id,function(data){});
                           });
                    $('#EditCommentModalTrigger'+comment_id).click(function(){
                           $('#editComment'+comment_id).modal();
                           $('#editComment'+comment_id).modal('open');      
                    });
                     $('#editCommentModal'+comment_id).click(function(e){
                      socket.emit('Edit Comment',comment_id,$('#Comment'+comment_id).val(),function(comment_id,comment){});
                      //$('#displayComment'+comment_id).empty();
                      //$('#displayComment'+comment_id).html($('#Comment'+comment_id).val());
                    });
                    /*
                  
                */
                }else{
                     $ShowComments.prepend('<div id = "'+MainDiv+'"><hr><p class="flow-text " style = "word-wrap:break-word"><label  id = "commentUsername"><span style = "color:grey;">'+userName+'</span></label><br><span id = "displayComment'+comment_id+'">'+comment+'</span></p><button  class = "main-color-bg btn" id = "ReplyButton'+comment_id+'">Reply</button><div id = "ReplyMainDiv'+comment_id+'"></div><label id = "parent_key'+comment_id+'">'+comment_id+'</label><div id = "ShowReplyComments'+comment_id+'"></div></div>');
                  
                  
                }
              }else{  
                  //Create a modal function 
                if(DeleteID == "YES"){
                     $ShowComments.append('<div id = "'+MainDiv+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="'+DeleteButton+'">&times;</button></div><p class="flow-text " style  = "word-wrap: break-word"><label  id = "commentUsername"><span style = "color:grey;">'+userName+'</span></label><br><span id = "displayComment'+comment_id+'">'+comment+'</span><a href = "#editComment'+comment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p><button class = "btn main-color-bg  btn-small" id = "ReplyButton'+comment_id+'">Reply</button><div id = "ReplyMainDiv'+comment_id+'"></div><label id = "parent_key'+comment_id+'">'+comment_id+'</label><div id = "ShowReplyComments'+comment_id+'"></div></div> <div id="editComment'+comment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label for="editComment">Comment</label><input  id="Comment'+comment_id+'" type="text" class="validate" value = "'+comment+'"><div class = "right-align"><a id = "editCommentModal'+comment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
                     $('#'+DeleteButton).click(function(){
                             socket.emit(DeleteFunction,comment_id,function(data){});
                     });  
                 $('#editCommentModal'+comment_id).click(function(e){
                      socket.emit('Edit Comment',comment_id,$('#Comment'+comment_id).val(),function(comment_id,comment){});
                      //$('#displayComment'+comment_id).empty();
                     // $('#displayComment'+comment_id).html($('#Comment'+comment_id).val());
                 });
              
                
                }else{
                     $ShowComments.append('<div id = "'+MainDiv+'"><hr><p class="flow-text"><label  id = "commentUsername"><span style = "color:grey;">'+userName+'</span></label><br><span id = "displayComment'+comment_id+'">'+comment+'</span></p><button class = " btn main-color-bg btn-small" id = "ReplyButton'+comment_id+'">Reply</button><div id = "ReplyMainDiv'+comment_id+'"></div><label id = "parent_key'+comment_id+'">'+comment_id+'</label><div id = "ShowReplyComments'+comment_id+'"></div></div>');
                    $('#EditCommentModalTrigger'+comment_id).click(function(){
                           $('#editComment'+comment_id).modal();
                           $('#editComment'+comment_id).modal('open');      
                    });
                    
                    
                    
                }
            }
                         $('#parent_key'+comment_id).hide();
        }
//Reply Function ======================================================================== Start //////
        function replyOutput(ReplyButton,ReplyFormDiv,ReplyMainDiv,userName,ReplyComment,ReplySubmitButton,ReplySubMainDiv,ReplyDeleteButton,ShowReplyComments,comment_id,user_id){
                 console.log('data.comment_id'+comment_id);
                 console.log('username'+userName);
                 console.log('ReplyComment'+ReplyComment);
                 console.log('ReplyMainDiv'+ReplyMainDiv);
                 console.log('ReplySubmitButton'+ReplySubmitButton);
                 var ReplyComment_ID = comment_id;
                        $('#'+ReplyMainDiv).html('<div class = "row"><div class = "col-md-1"><label id = "username">'+userName+'</label></div><div class = "col-md-1"></div><div class = "col-md-10"><textarea id = "'+ReplyComment+'" class="form-control" rows="2"></textarea></div></div><br><p class ="text-right"><button  id s= "'+ReplySubmitButton+'" class = "main-color-bg btn">Reply</button></p>');
                        console.log('Comment Id'+comment_id);
                   console.log("PARENT ID 1"+$('#parent_key'+comment_id).html());
            
    
$('#'+ReplySubmitButton).prop('disabled',true);
    jQuery('#'+ReplyComment).on('input propertychange paste', function() {
                      var str = $("#"+ReplyComment).val();
        if( $('#'+ReplyComment).val().trim() == '' ) {
          $('#'+ReplySubmitButton).prop('disabled',true);     
      }else{
        $('#'+ReplySubmitButton).prop('disabled', false); 
      }
    }); 
            
            
                       $('#'+ReplyMainDiv).hide();
                        $('#'+ReplyButton).click(function(e){
                            e.preventDefault();
                            
                      
                               console.log("PARENT ID 1"+$('#parent_key'+comment_id).html());
                            $('#ParentComment_ID'+comment_id).hide();
                            $('#'+ReplyMainDiv).toggle();
                            $('#ParentComment_ID'+comment_id).hide();
                       
                        $('#'+ReplySubmitButton).click(function(e){
                            e.preventDefault(); 
                            
                              if( $('#'+ReplyComment).val().trim() == '' ) {
                              
                              }else{
                                   alert('Reply comment value '+ $('#'+ReplyComment).val());
                                socket.emit('GetReplyComment',$('#'+ReplyComment).val(),$('#parent_key'+comment_id).html(),function(data,Parent_id){ 
                            });       
                            var newCommentMessage = " comment replied "+$('#'+ReplyComment).val();
                             socket.emit('NewComment Notification',$('#user_id').html(),$user_level.html(),newCommentMessage,'client.php?ProjectUpdateContent='+ $('#Project').html(),'comment',$('#Project').html(),function(user_id,user_level,newCommentMessage,key_id,notification_type,pupdate_id){
                             });   
                     
                            
                            $('#'+ReplyComment).val(' ');
                            $('#'+ReplySubmitButton).prop('disabled',true);
 
                        }
                         
                          
                     });   
                                
            });     
          
              socket.on('show ReplyComment'+comment_id,function(data){

                    if($user_id.html() == user_id){
                         if($user_id.html() == data.user_id){
                                $('#ShowReplyComments'+comment_id).prepend('<div id= "ReplyCurrentCommentDiv'+data.replyComment_id+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="ReplyCurrentDeleteButton'+data.replyComment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span><br></label><span id = "displayComment'+data.replyComment_id+'">'+data.ReplyComment+'</span><a id = "EditCommentModalTrigger'+data.replyComment_id+'" href = "#editComment'+data.replyComment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p></div> <div id="editComment'+data.replyComment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label for="editComment">Comment</label><input  id="Comment'+data.replyComment_id+'" type="text" class="validate" value = "'+data.ReplyComment   +'"><div class = "right-align"><a id = "editCommentModal'+data.replyComment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
                             $('#EditCommentModalTrigger'+data.replyComment_id).click(function(){
                                    $('#editComment'+data.replyComment_id).modal();
                                    $('#editComment'+data.replyComment_id).modal('open');      
                            });
                            $('#editCommentModal'+data.replyComment_id).click(function(e){
                                socket.emit('Edit Comment',data.replyComment_id,$('#Comment'+data.replyComment_id).val(),function(comment_id,comment){});
                       
                           });
                               $('#ReplyCurrentDeleteButton'+data.replyComment_id).click(function(){         
                              socket.emit('Delete ReplyComment',data.replyComment_id,function(data){});
                      });
                             
                         }else{
                               $('#ShowReplyComments'+comment_id).prepend('<div id= "ReplyCurrentCommentDiv'+data.replyComment_id+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="ReplyCurrentDeleteButton'+data.replyComment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span><br></label><span id = "displayComment'+data.replyComment_id+'">'+data.ReplyComment+'</span></p></div>');
                         }
                        
                        
 
                      $('#ReplyCurrentDeleteButton'+data.replyComment_id).click(function(){         
                              socket.emit('Delete ReplyComment',data.replyComment_id,function(data){});
                      });
                        
                     }else{
                         if($user_id.html() == data.user_id){
                              $('#ShowReplyComments'+comment_id).prepend('<div id= "ReplyCurrentCommentDiv'+data.replyComment_id+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="ReplyCurrentDeleteButton'+data.replyComment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word;margin-left:2em;"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span></label><br><span id = "displayComment'+data.replyComment_id+'">'+data.ReplyComment+'</span><a id = "EditCommentModalTrigger'+data.replyComment_id+'" href = "#editComment'+data.replyComment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p></div><div id="editComment'+data.replyComment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label for="editComment">Comment</label><input  id="Comment'+data.replyComment_id+'" type="text" class="validate" value = "'+data.ReplyComment   +'"><div class = "right-align"><a id = "editCommentModal'+data.replyComment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
                      
                      $('#ReplyCurrentDeleteButton'+data.replyComment_id).click(function(){         
                              socket.emit('Delete ReplyComment',data.replyComment_id,function(data){});
                      });
                         $('#EditCommentModalTrigger'+data.replyComment_id).click(function(){
                                    $('#editComment'+data.replyComment_id).modal();
                                    $('#editComment'+data.replyComment_id).modal('open');      
                            });
                            $('#editCommentModal'+data.replyComment_id).click(function(e){
                                socket.emit('Edit Comment',data.replyComment_id,$('#Comment'+data.replyComment_id).val(),function(comment_id,comment){});
                       
                           });
                         }else{
                            $('#ShowReplyComments'+comment_id).prepend('<div id= "ReplyCurrentCommentDiv'+data.replyComment_id+'"><hr><div class="pull-right"></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em;"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span></label><br><span  id = "displayComment'+data.replyComment_id+'">'+data.ReplyComment+'</span></p></div>');
                         }
                     } 
                  });
            
             socket.on('Show ReplyCommentHistory',function(data){
                   if(comment_id == data.parent_comment_id){
                     if($user_id.html() == user_id){
                         /*
                           console.log('orignal comment id ='+data.comment_id);
                          $('#ShowReplyComments'+comment_id).append('<hr><div id = "ReplyCommentDiv'+data.comment_id+'"><div class="right-align" style = "margin-right:3em"><button class = "btn-danger btn red darken-3" id="ReplyDeleteButton'+data.comment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em;"><label  id = "commentUsername"></label><span style = "color:grey;">'+data.username+'</span><br><span>'+data.comment+'</span></p></div>');        
                          
                          $('#ReplyDeleteButton'+data.comment_id).click(function(){
                              socket.emit('Delete ReplyHistoryComment',data.comment_id,function(data){});
                          });
                          */
                        if($user_id.html() == data.user_id){
                             $('#ShowReplyComments'+comment_id).append('<div id = "ReplyCommentDiv'+data.comment_id+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="ReplyDeleteButton'+data.comment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span></label><br><span id = "displayComment'+data.comment_id+'">'+data.comment+'</span><a id = "EditCommentModalTrigger'+data.comment_id+'" href = "#editComment'+data.comment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p></div><div id="editComment'+data.comment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label for="editComment">Comment</label><input  id="Comment'+data.comment_id+'" type="text" class="validate" value = "'+data.comment+'"><div class = "right-align"><a id = "editCommentModal'+data.comment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');   
                             $('#EditCommentModalTrigger'+data.comment_id).click(function(){
                                    $('#editComment'+data.comment_id).modal();
                                    $('#editComment'+data.comment_id).modal('open');      
                            });
                            $('#editCommentModal'+data.comment_id).click(function(e){
                                socket.emit('Edit Comment',data.comment_id,$('#Comment'+data.comment_id).val(),function(comment_id,comment){});
                       
                           });
                             $('#ReplyDeleteButton'+data.comment_id).click(function(){
                              socket.emit('Delete ReplyHistoryComment',data.comment_id,function(data){});
                          });
                        }else{
                              console.log('orignal comment id ='+data.comment_id);
                          $('#ShowReplyComments'+comment_id).append('<div id = "ReplyCommentDiv'+data.comment_id+'"><hr><div class="right-align" ><button class = "btn-danger btn red darken-3" id="ReplyDeleteButton'+data.comment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em;"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span></label><br><span id = "displayComment'+data.comment_id+'">'+data.comment+'</span></p></div>');        
                          
                          $('#ReplyDeleteButton'+data.comment_id).click(function(){
                              socket.emit('Delete ReplyHistoryComment',data.comment_id,function(data){});
                          });
                          
                        }
                     }else{
                         if($user_id.html() == data.user_id){
                               $('#ShowReplyComments'+comment_id).append('<div id = "ReplyCommentDiv'+data.comment_id+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="ReplyDeleteButton'+data.comment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span></label><br><span id = "displayComment'+data.comment_id+'">'+data.comment+'</span><a href = "#editComment'+comment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p></div>');        
                          
                               $('#ReplyDeleteButton'+data.comment_id).click(function(){
                                socket.emit('Delete ReplyHistoryComment',data.comment_id,function(data){});
                               });
                         }else{
                             $('#ShowReplyComments'+comment_id).append('<div id = "ReplyCommentDiv'+data.comment_id+'"><hr><div class="pull-right"></div><p class="flow-text"  style  = "word-wrap: break-word;margin-left:2em"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span></label><br><span id = "displayComment'+data.comment_id+'">'+data.comment+'</span></p></div>');
                         }
                     } 
                   }
             });
            socket.on('Delete ReplyHistory Comment',function(data){
                 console.log("delete comment id detected = :"+data.comment_id)
                 $("#ReplyCommentDiv"+data.comment_id).hide();
                });           
               socket.on('Deleted ReplyComment',function(data){
                 console.log("delete comment id detected = :"+data.comment_id)
                 $("#ReplyCurrentCommentDiv"+data.comment_id).hide();
             });
              
         }      
      
      
      
//Comment module end =============================>>>>     
 socket.emit('Get pupdate_ID',$('#selectupdatePercentID').val(),function(projprog_id){});

 socket.emit('Get FeaturePhotosProjProgID',$('#projprog_id').html(),function(projprog_id){  
});

 socket.on('Set FeaturePictures',function(data){
     
       $('#featImage').append('<img class="activator" src="'+data.path+'" style = "width:64.5em;height:30em;overflow:hidden;"> '); 
      
 
 });
 
      
       socket.on('Set Section',function(data){
          //alert('pupdate_id'+data.pupdate_id);
          $('#section_names').append('<li id = "selectPictures'+data.section_id+'"><div class="collapsible-header">'+data.section_name+'</div><div class="collapsible-body"><div class="row"><div id = "SelectPictureBody'+data.section_id+'" style =  "overflow-y:scroll; height:50em;margin-left:4em" ></div></div><span></span></div></li>');
          
          $('#selectPictures'+data.section_id).click(function(e){
                $('#SelectPictureBody'+data.section_id).empty();
                socket.emit('Display SectionPictures',data.pupdate_id,data.section_id,function(pupdate_id,section_id){});
            
          });
      });
       socket.on('Set DisplaySectionPictures',function(data){ thumbnailFormats('#SelectPictureBody'+data.section_id,data.path,data.projprogimg_id);
       });
     socket.on('Set AllSectionPictures',function(data){
         thumbnailFormats('#AllPictureszz',data.path,data.projprogimg_id);
     });
     socket.on('Set NoneSectionPictures',function(data){
         thumbnailFormats('#NoSection',data.path,+data.projprogimg_id);
     });
    function thumbnailFormats(divisionID,path,img_refer_id){
        $(divisionID).append('<a href = "index.php?SelectProjUpPicSec='+img_refer_id+'"><div class="col s12 m5 l4"><div class="card-panel "><img style = " width:270px;height:180px;overflow:hidden;" src="'+path+'" alt="" class="responsive-img " alt=""></div></div></a>');
    } 
  
});
</script>
<?php
}
?> 
