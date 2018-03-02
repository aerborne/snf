<?php 
if(isset($_GET['SelectPortfolioPicture'])){
      $portimg_id = $_GET['SelectPortfolioPicture'];


$user_id           =  $_SESSION['user_id'];
$select_username   =  queryMysql("SELECT  *  from users where user_iid = '$user_id'");
$row_select        =  mysqli_fetch_array($select_username);
$username          =  $row_select['username'];
$user_level        =  $row_select['levels'];
    
$select_image_info  = queryMysql("SELECT  portfolio_images.name as img_name,portfolio.name as portfolio_name,portfolio_images.image_description,portfolio_images.path,portfolio_images.available  FROM  portfolio_images  left join portfolio  on portfolio_images.portfolio_id = portfolio.portfolio_id where  portimg_id = '$portimg_id' and portfolio_images.available = 0");
    
      $row_image_info        = mysqli_fetch_array($select_image_info);
      $img_name              =  $row_image_info['img_name'];
      $project_name          =  $row_image_info['portfolio_name'];
      $image_description     =  $row_image_info['image_description'];
      $path                  =  $row_image_info['path'];  
    
    $select_portfolio_id      = queryMysql("SELECT * FROM portfolio_images where portimg_id = '$portimg_id'");
    $row_select_portfolio_id  = mysqli_fetch_array($select_portfolio_id);
    $portfolio_id             = $row_select_portfolio_id['portfolio_id'];

    $select_images    = queryMysql("SELECT * FROM portfolio_images where portfolio_id ='$portfolio_id'");
    
?>

 
<div class  = "row">
    <div class = "col s9">
        <div class="card"> 
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" style = "width:50em;height:30em;overflow:hidden;" src="<?php  echo $path;  ?>">
        </div>
        <div class="card-content">
          <span class="card-title activator grey-text text-darken-4"><?php echo $project_name; ?><i class="material-icons right">more_vert</i></span>
         <div class = "right-align">
                <div id="rooms"></div><br>
                <div id = "AverageRating">Average Rate:</div>
                <div id = "ratingStars"></div>        
         </div>
        </div>
        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4"><?php  echo $project_name; ?><i class="material-icons right">close</i></span>
          <p><?php echo $image_description; ?></p>
        </div>   
</div>
    </div>
      <div class = "col s3">
           <div  style =  "overflow-y:scroll; height:41em; margin-top:0.5em">
                 <div id = "importPortfolioPictures"> 
                  </div>
        
          </div>
        </div>
    </div>

     
    
     
    
    
    
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
      <div id = "ShowComments" style = " white-space: initial;"></div>
  <div id = "Show" style = " white-space: initial;"></div>
<div id = "replyContent"></div>         

</div>    
</div>        
    
<!-- Start  Initialize columns -->
<div id  = "portfolio_id" style = "display:none"><?php echo $portfolio_id; ?></div>
<div id =  "pupdate_id" style = "display:none;" ><?php echo $portimg_id ;?></div>
<div id = "user_id" style = "display:none;"><?php echo $user_id; ?></div>
<div id = "username" style = "display:none;"><?php echo $username; ?></div>
<div id = "user_level" style = "display:none;"><?php echo $user_level;?></div>
<div id = "tableName" style = "display:none">portfolio_images_comment</div>
<div id = "comment_id_name" style = "display:none">portfolio_image_comment_id</div>
<div id  = "reference_id_name" style = "display:none">portimg_id</div>
  


<!-- End  Initialize column -->



 <script src = "../js/JQuery-1.8.0.js"></script>     
<script src = "../js/jquery-1.11.3.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js"></script>       
 <script> 
      $(document).ready(function(){
                     var  socket = io.connect('http://localhost:3100'); 
              var  $username             =   $('#username');
              var  $comment              =   $('#Newcomment');
              var  $ShowComments         =   $('#ShowComments')
              var  $ReplyComments        =   $('#replyContent');
              var  $user_id              =   $('#user_id');
              var  $user_level           =   $('#user_level');
              var  $tableName            =   $('#tableName');
              var  $comment_id_name      =   $('#comment_id_name');
              var  $reference_id_name    =   $('#reference_id_name');
              var  $ratingChoices        = [1, 2, 3, 4, 5];

     
 socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),$('#pupdate_id').html(),'pimg',$('#tableName').html(),$('#comment_id_name').html(),$('#reference_id_name').html());                    
          
          
    socket.emit('Set RatingTable','rating_portfolio_image','rating_portfolio_image_id','portimg_id',function(tablename,column_id_name,reference_id_name){});
    
    socket.emit('Set PortfolioThumbnail',$('#portfolio_id').html(),function(portfolio_id){        
    });
           
    socket.on('Setted  PortfolioThumbnail',function(data){
         //alert(data.path);
       
        $('#importPortfolioPictures').append('<div><a href = "index.php?SelectPortfolioPicture='+data.portimg_id+'"><img style = "width:250px;height:120px;overflow:hidden;" src="'+data.featpath+'" alt="" class="responsive-img " alt=""></a></div><br><br>') 
    });
        
          
var arrayLength = $ratingChoices.length;
for (var i = 0; i < arrayLength; i++) {
    
      // alert($ratingChoices[i]);
      $('#rooms').append('<button class = "btn-danger  #f44336 red" id="'+$ratingChoices[i]+'">'+$ratingChoices[i]+'</button>');
    
     ratings($ratingChoices[i],$ratingChoices[i], $('#pupdate_id').html(),$('#user_id').html());
    
}
        
        function ratings(buttonName,value,pupdate_id,user_id){
              $('#'+buttonName).click(function(){
              //  alert("RATING VALUE"+value);
                     socket.emit('ratePortfolio',value,pupdate_id,user_id);
                     socket.emit('updatePortfolioAve',pupdate_id);
        });  
}             
//Comment Form            
          
           $('#commentForm').submit( function(e){ 
        e.preventDefault();
        if (($('#Newcomment').val().trim() == '')){
              alert('Please fill up the comment field');
        }else{
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
            console.log('show comment is detected');
            if($user_id.html() == data.user_id){
            //Comment Function    
             commentOutput('current'+data.comment_id,data.comment_id,"YES",data.username,data.comment,'currentButton'+data.comment_id,"Delete Comment",'Current'); 
            
            //Reply Function 
                console.log('comment_id for reply'+data.comment_id);  
                replyOutput('ReplyButton'+data.comment_id,'ReplyFormDiv'+data.comment_id,'ReplyMainDiv'+data.comment_id,$username.html(),'ReplyComment'+data.comment_id,'ReplySubmitButton'+data.comment_id,'ReplySubMainDiv'+data.comment_id,'ReplyDeleteButton'+data.comment_id,'ShowReplys'+data.comment_id,data.comment_id,data.user_id);
                  
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
     $('.modal').modal(); 
             function commentOutput(MainDiv,comment_id,DeleteID,userName,comment,DeleteButton,DeleteFunction,time){
                 
          
              if(time == "Current"){
                if(DeleteID == "YES"){
                   $ShowComments.prepend('<div id = "'+MainDiv+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="'+DeleteButton+'">&times;</button></div><p class="flow-text " style  = "word-wrap: break-word"><label  id = "commentUsername"><span style = "color:grey;">'+userName+'</span></label><br><span id = "displayComment'+comment_id+'">'+comment+'</span><a id = "EditCommentModalTrigger'+comment_id+'" href = "#editComment'+comment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p><button class = "btn main-color-bg  btn-small" id = "ReplyButton'+comment_id+'">Reply</button><div id = "ReplyMainDiv'+comment_id+'"></div><label id = "parent_key'+comment_id+'">'+comment_id+'</label><div id = "ShowReplyComments'+comment_id+'"></div></div> <div id="editComment'+comment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label>Comment</label><br><input  id="Comment'+comment_id+'" type="text" class="validate" value = "'+comment+'"><div class = "right-align"><a id = "editCommentModal'+comment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
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
                     $ShowComments.append('<div id = "'+MainDiv+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="'+DeleteButton+'">&times;</button></div><p class="flow-text " style  = "word-wrap: break-word"><label  id = "commentUsername"><span style = "color:grey;">'+userName+'</span></label><br><span id = "displayComment'+comment_id+'">'+comment+'</span><a id = "EditCommentModalTrigger'+comment_id+'" href = "#editComment'+comment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p><button class = "btn main-color-bg  btn-small" id = "ReplyButton'+comment_id+'">Reply</button><div id = "ReplyMainDiv'+comment_id+'"></div><label id = "parent_key'+comment_id+'">'+comment_id+'</label><div id = "ShowReplyComments'+comment_id+'"></div></div> <div id="editComment'+comment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label>Comment</label><br><input  id="Comment'+comment_id+'" type="text" class="validate" value = "'+comment+'"><div class = "right-align"><a id = "editCommentModal'+comment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
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
                        $('#'+ReplyMainDiv).html('<div class = "row"><div class = "col-md-1"><label id = "username">'+userName+'</label></div><div class = "col-md-1"></div><div class = "col-md-10"><textarea id = "'+ReplyComment+'" class="form-control" rows="2"></textarea></div></div><br><p class ="text-right"><button  id = "'+ReplySubmitButton+'" class = "main-color-bg btn">Reply</button></p>');
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
                                $('#ShowReplyComments'+comment_id).prepend('<div id= "ReplyCurrentCommentDiv'+data.replyComment_id+'"><hr><div class="right-align"><button class = "btn-danger btn red darken-3" id="ReplyCurrentDeleteButton'+data.replyComment_id+'">&times;</button></div><p class="flow-text"  style  = "word-wrap: break-word; margin-left:2em"><label  id = "commentUsername"><span style = "color:grey;">'+data.username+'</span><br></label><span id = "displayComment'+data.replyComment_id+'">'+data.ReplyComment+'</span><a id = "EditCommentModalTrigger'+data.replyComment_id+'" href = "#editComment'+data.replyComment_id+'" class = "modal-trigger "><i class="material-icons" style = "color:#42a5f5 blue lighten-1;background-color:white">create</i></a></p></div> <div id="editComment'+data.replyComment_id+'" class="modal"><div class="modal-content"><div class="input-field col s12"><label>Comment</label><br><input  id="Comment'+data.replyComment_id+'" type="text" class="validate" value = "'+data.ReplyComment   +'"><div class = "right-align"><a id = "editCommentModal'+data.replyComment_id+'" class="waves-effect waves-light btn modal-close">Save</a></div><br><br></div></div></div>');
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
          socket.on('Set EditedComment',function(data){
    //alert('Set EditedComment has been triggered');
     $('#displayComment'+data.comment_id).empty();
     $('#displayComment'+data.comment_id).html(data.comment); 
});
       

/// Reply Function End ================================================================================> 
$emptyStars  =  '<i class="material-icons" style = "color:yellow;">star_border</i>';
$Stars       =  '<i class="material-icons" style = "color:yellow;">star</i>';
        function countingStars(ctr,Star,emptyStars){
                     $ctrStars = "";
                    var difference =  5 - ctr;
              
                    for (var i = 0; i < ctr; i++) {
                        $ctrStars += Star;
                    }
                    for (var s = 0; s < difference;s++){
                        $ctrStars += emptyStars;
                    }
              }         
        
        
 
    socket.on('AverageRate Value',function(data){
           $('#AverageRating').empty();   
           $('#ratingStars').empty();
         //alert('AverageRate Value has been triggered');

        if(data.AverageRate  ==  5){
                countingStars(5,$Stars,$emptyStars);
           }else if(data.AverageRate == 4){
                 countingStars(4,$Stars,$emptyStars);
           }else if(data.AverageRate == 3 ){
                 countingStars(3,$Stars,$emptyStars);
           }else if(data.AverageRate == 2){
                 countingStars(2,$Stars,$emptyStars);    
           }else if(data.AverageRate == 1){
                  countingStars(1,$Stars,$emptyStars);
           }else if(data.AverageRate == 0){
                  countingStars(0,$Stars,$emptyStars);
           }
                $('#AverageRating').empty();
        if (data.AverageRate == null){
              countingStars(0,$Stars,$emptyStars);
            $('#AverageRating').append("Rating Average: 0");
        }else{
        $('#AverageRating').append('Rating Average: '+data.AverageRate);   
        $('#ratingStars').append($ctrStars);
        }  
    });   

          
          
                     
          
});


</script>
    
    
    
<?php
}
?>
 
