
function  submitComment(submitBtnID,commentTextBoxID,current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,room_id){
   $('#'+submitBtnID).click(function (){
    console.log('Commented a picture');
    console.log('variable id value '+variable_id);
    console.log('commentTextBox value '+$('#'+commentTextBoxID).val())
     if (($('#'+commentTextBoxID).val().trim() == '')){
         alert('Please fill up the comment field');
    }else{
        socket.emit('get picture_comment',$('#'+commentTextBoxID).val(),current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,0,room_id,"1",function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id,type){});
        $('#'+commentTextBoxID).val('');    
    } 
 
       
});   

function McommentDisplays(fullname,datetime,comment_value,variable_id,time,displayComment_ID,user_id,current_user_id_login,comment_id){
    var displayComment;
  //  alert(datetime);
    var convertedDateTime = convertDateTime(datetime);
    var currentCommentSpan = '<span class = "comment">'+comment_value+'</span>'; 
    var replyExtension = "";// '<div class = "row"><div class = "col s12"><div class = "left"><a class="waves-effect waves-light displayModalInfo" id = "MainOpenReplyForm'+comment_id+'" style = "cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;Reply</a><a class="waves-effect waves-light displayModalInfo" id ="MainCloseReplyForm'+comment_id+'">&nbsp;&nbsp;&nbsp;&nbsp;Close</a></div><div class = "clearfix"></div><div id = "MainDisplayReplyCommentsForm'+comment_id+'"></div><div class = "clearfix"></div><div id = "MainrtReplyComment'+comment_id+'"></div><div class = "center"><a id = "MainViewReplyComments'+comment_id+'" class = "displayModalInfo" style = "cursor:pointer;font-size:10px">View All Replies&#9660;</a></div><div class = "clearfix"></div><div class = "center"><a id = "MainHideReplyComments'+comment_id+'" style = "cursor:pointer;" class = "displayModalInfo">Hide All Replies&#9650;</a></div><div class = "clearfix"></div><div class = "clearfix"></div><div id = "MainDisplayReplyComments'+comment_id+'"></div><div class = "center"><a id = "MainShowMoreReplyComments'+comment_id+'" style = "cursor:pointer">Show More Reply Comments</a></div><div class = "clearfix"></div></div></div>'; 
    
    var commentUI  =  '<div id = "MainModalCommentDiv'+comment_id+'"><div class = "row"><div class ="col s3 m2 l1"><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10  l11"><span class = "displayModalInfo">'+fullname+' </span><div class = "right"><span class = "comment_dt">'+convertedDateTime +'</span></div><div class = "clearfix"></div><br><div id  = "MainCommentDivHolder'+comment_id+'">'+currentCommentSpan+'</div></div></div></div>';
    var commentUIwithX  = '<div class = "right-align" id = "MainDisplayDeleteCommentModal'+comment_id+'" ><a id = "MainEditCommentModal'+comment_id+'" class=" waves-effect waves-light "><i class="material-icons small white-text">create</i></a><a id = "MainDeleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons  white-text small">close</i></a></div>'+commentUI;

    if(user_id != current_user_id_login){
          displayComment = commentUI;
    }else{
          displayComment = commentUIwithX; 
    }
     displayComment  = displayComment+replyExtension;
    if (time == "history"){
         Materialize.fadeInImage('#'+displayComment_ID);
         $('#'+displayComment_ID).append(displayComment);     
    }else{
         Materialize.fadeInImage('#'+displayComment_ID);
        $('#'+displayComment_ID).prepend(displayComment); 
    } 
    $("#MainShowMoreReplyComments"+comment_id).hide();
    $('#MainDisplayReplyComments'+comment_id).hide(); 
    $('#MainHideReplyComments'+comment_id).hide();
    $('#MainViewReplyComments'+comment_id).hide();
    socket.on('counted ReplyRows',function(data){
       if(data.counted_rows == 0){
       }else{
          $('#MainViewReplyComments'+data.variable_id).show();
       }
       
   });
        $('#MainCloseReplyForm'+comment_id).hide();
     var room_id =  room_id;
    socket.emit("get commentRoomID",variable_id,room_id,comment_id_name,reference_id_name,tablename,"",function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset){});
      deleteComment(comment_id,"MainDeleteCommentModal"+comment_id);
    
editComment(comment_id,"MainEditCommentModal"+comment_id,'MainCommentDivHolder'+comment_id,currentCommentSpan,comment_value);    
     replyCommentForm(comment_id,'MainOpenReplyForm'+comment_id,'MainDisplayReplyCommentsForm'+comment_id,'MainCloseReplyForm'+comment_id,current_user_id_login,variable_id); 
    
    
    
  
   
   
}
       
 socket.on('set MainCommentDisplay',function(data){ 
   if(data.parent_comment_id == 0){
     McommentDisplays(data.fullname,data.comment_dt,data.comment_value,data.variable_id,data.time,'MainDisplayComments',data.user_id,current_user_id_login,data.comment_id);  
      
   }else{
       MdisplayReplyComments(data.fullname,data.comment_dt,data.comment_value,data.time,'MainDisplayReplyComments'+data.parent_comment_id,'MainrtReplyComment'+data.parent_comment_id,data.user_ida,current_user_id_login,data.comment_id,data.parent_comment_id,'MainViewReplyComments'+data.parent_comment_id,'MainHideReplyComments'+data.parent_comment_id,'MainShowMoreReplyComments'+data.parent_comment_id);
   } 
    
    
}); 
//MLoadMoreComments('MainLoadMoreComments','counted rows','get commentRoomID','PPUP',"standard");
socket.on('set MainReplyCommentDisplays',function(data){
  MdisplayReplyComments(data.fullname,data.comment_dt,data.comment_value,data.time,'MainDisplayReplyComments'+data.parent_comment_id,"",data.user_id,current_user_id_login,data.comment_id,data.parent_comment_id,'MainViewReplyComments'+data.parent_comment_id,'MainHideReplyComments'+data.parent_comment_id,'MainShowMoreReplyComments'+data.parent_comment_id,data.comment_owner_id);
  
});

 
socket.emit("get commentRoomID",variable_id,room_id,comment_id_name,reference_id_name,tablename,"","1",function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset,type){});    
   
function deleteComment(variable_id,deleteCommentBTN){
    
      $('#'+deleteCommentBTN).click(function(){
           if (confirm('Do you want to delete the item?')) {
                   //alert('Item has been deleted');
                   socket.emit('trigger deactivate_comment',variable_id,"available",1,"delete",function(variable_id,filter_name,filter_value,mode){});
            } else {
                 //alert('Item has been restored');
                // Do nothing!
            }

      });
}
socket.on('deactivate commment',function(data){
     var currentCommentSpan = '<span class = "comment">'+data.comment+'</span>'; 
    if(data.mode == "delete"){
        $('#MainModalCommentDiv'+data.comment_id).hide(); 
        $('#MainDisplayDeleteCommentModal'+data.comment_id).hide();
        $('#MainOpenReplyForm'+data.comment_id).hide();
    }else if(data.mode == "edit"){
          $('#MainCommentDivHolder'+data.comment_id).empty();     $('#MainCommentDivHolder'+data.comment_id).append(currentCommentSpan);
    }
});
function editComment(variable_id,editCommentBTN,displayComment_id,currentCommentSpan,comment_value){
    $('#'+editCommentBTN).click(function(){
    
            $('#'+displayComment_id).empty();
            $('#'+displayComment_id).append('<div class = "right-align"><a class="waves-effect waves-light" id = "editCommentBTNcancel'+variable_id+'"><i class="material-icons small white-text">close</i></a></div><div class="input-field col s12"><textarea id="MainEditCommentTXT'+variable_id+'" class="materialize-textarea comment">'+comment_value+'</textarea></div><div class ="right-align"><a class="waves-effect waves-light" id = "editCommentSaveBTN'+variable_id+'" ><i class="material-icons small white-text">save</i></a></div>');
            $('#editCommentBTNcancel'+variable_id).click(function(){
                 $('#'+displayComment_id).empty();
                 $('#'+displayComment_id).append(currentCommentSpan);
               
            });
            $('#editCommentSaveBTN'+variable_id).click(function(){
                  
                     if (($('#MainEditCommentTXT'+variable_id).val().trim() == '')){
                         alert('Please fill up the comment field');
                     }else{
                          socket.emit('trigger deactivate_comment',variable_id,"comment",$('#MainEditCommentTXT'+variable_id).val(),"edit",function(variable_id,filter_name,filter_value,mode){});
    
                     }
                 
               });
          
    });  
 
}
function replyCommentForm(comment_id,openReplyCommentBTN,displayReplyCommentForm_id,closeReplyCommentBTN,current_user_id_login,variable_id){
     $('#'+openReplyCommentBTN).click(function(){
              $('#'+displayReplyCommentForm_id).empty();
           $('#'+displayReplyCommentForm_id).show();
           $('#'+displayReplyCommentForm_id).append('<div class ="col s3 m2 l2"><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10 l10"><div class="input-field col s12"><textarea id="MainPictureReplyCommentTextBox'+comment_id+'" class="materialize-textarea comment" placeholder = "Write a comment.."></textarea></div><div class ="right-align"><a id = "pictureMainReplyCommentBtn'+comment_id+'"class="waves-effect waves-light btn #f8bbd0 pink lighten-4">comment</a></div><br><br></div>');  
          $('#'+openReplyCommentBTN).hide();
          $('#'+closeReplyCommentBTN).show();
         
         
            $('#pictureMainReplyCommentBtn'+comment_id).click(function(){
                     if (($('#MainPictureReplyCommentTextBox'+comment_id).val().trim() == '')){
                         alert('Please fill up the comment field');
                    }else{
                        socket.emit('get picture_comment',$('#MainPictureReplyCommentTextBox'+comment_id).val(),current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,comment_id,room_id,"1",function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id,type){});
                        $('#MainPictureReplyCommentTextBox'+comment_id).val(''); 
                             $('#'+displayReplyCommentForm_id).empty();
                    } 
            });
    });
     $('#'+closeReplyCommentBTN).click(function(){
              $('#'+displayReplyCommentForm_id).empty();
          $('#'+displayReplyCommentForm_id).hide();
          $('#'+openReplyCommentBTN).show();
          $('#'+closeReplyCommentBTN).hide();
     });
   
}
function MdisplayReplyComments(fullname,datetime,comment_value,time,displayComment_ID,displayCurrentCommentID,user_id,current_user_id_login,comment_id,principal_comment_id,ViewReplyCommentsID,HideReplyCommentsID,ShowMoreReplyCommentsID,comment_owner_id){ 
    var displayComment;
    var convertedDateTime =convertDateTime(datetime); 
    var currentCommentSpan = '<span class = "comment">'+comment_value+'</span>';
    var commentUI  =  '<div id = "MainModalCommentDiv'+comment_id+'" style = "margin-left:2em"><div class ="col s3 m2 l1" ><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10  l11"><span class = "displayModalInfo">'+fullname+' </span><div class = "right"><span class = "comment_dt">'+convertedDateTime+'</span></div><div class = "clearfix"></div><br><div id  = "MainCommentDivHolder'+comment_id+'">'+currentCommentSpan+'</div><div class = "clearfix"></div><br></div></div>';
    var commentUIwithX  = '<div class = "right-align" id = "MainDisplayDeleteCommentModal'+comment_id+'" ><a id = "MainEditCommentModal'+comment_id+'" class=" waves-effect waves-light "><i class="material-icons small white-text">create</i></a><a id = "MainDeleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons small white-text">close</i></a></div>'+commentUI;
    var commentUIwithXrm = '<div class = "right-align" id = "MainDisplayDeleteCommentModal'+comment_id+'" ><a id = "MainDeleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons small  white-text">close</i></a></div>'+commentUI; 
 
     if(user_id != current_user_id_login){
         if(comment_owner_id  == current_user_id_login){
               displayComment = commentUIwithXrm; 
         }else{
              displayComment = commentUI;
         }
     }else{
          displayComment = commentUIwithX; 
     }
     displayComment  = displayComment;
    if (time == "history"){
         Materialize.fadeInImage('#'+displayComment_ID);
         $('#'+displayComment_ID).append(displayComment);     
    }else{
         Materialize.fadeInImage('#'+displayComment_ID);
         //create a Current Reply History current 
         // rtReplyComment'+comment_id+
         $('#'+displayCurrentCommentID).append(displayComment);
         $('#'+displayComment_ID).prepend(displayComment); 
    } 
   $('#'+ViewReplyCommentsID).click(function(){
        $('#'+displayComment_ID).show();
        $('#'+ViewReplyCommentsID).hide();
        $('#'+HideReplyCommentsID).show();
          $('#'+displayCurrentCommentID).html('');
       socket.on('counted ReplyRows',function(data){
       if(data.counted_rows < 10){
       }else{
            $('#'+ShowMoreReplyCommentsID).show(); 
       }
       });
       
   });

   $('#'+HideReplyCommentsID).click(function(){
       
        $('#'+ShowMoreReplyCommentsID).hide(); 
       $('#'+displayComment_ID).hide();
       $('#'+ViewReplyCommentsID).show();
       $('#'+HideReplyCommentsID).hide();
   });
      
    deleteComment(comment_id,"MainDeleteCommentModal"+comment_id);
    editComment(comment_id,"MainEditCommentModal"+comment_id,'MainCommentDivHolder'+comment_id,currentCommentSpan,comment_value);
}
    
    function  MLoadMoreComments(LoadMoreCommentsID,socketOnFuncName,socketEmitFuncName,roomKeyword,type){
             socket.on(socketOnFuncName,function(data){
                   if(data.counted_rows < 10){
                   }else{ 
                    if(type == "reply"){
                        $('#'+LoadMoreCommentsID+data.variable_id).hide();
                    }else{ 
                        $('#'+LoadMoreCommentsID+data.variable_id).show();
                    }
                      var increment_counter = 1; 
                      var total_incrementation =  Math.ceil(data.counted_rows/10) - 1;
                      var offset_value = 10;
                      $('#'+LoadMoreCommentsID+data.variable_id).click(function(){ 
                          alert("HELLO WORLD");
                          if(increment_counter == total_incrementation){
                              $('#'+LoadMoreCommentsID+data.variable_id).hide();
                              var room_id = data.variable_id+roomKeyword;
                               
                             alert("1"); socket.emit(socketEmitFuncName,data.variable_id,room_id,comment_id_name,reference_id_name,tablename,' OFFSET '+offset_value,"1",function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset,type){});
                          }else{
                            var room_id = data.variable_id+roomKeyword;
                           alert("2"); socket.emit(socketEmitFuncName,data.variable_id,room_id,comment_id_name,reference_id_name,tablename,' OFFSET '+offset_value,"1",function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset,type){});
                          }
                           increment_counter++;
                           offset_value += 10;
                      });
                   }
             });
         
}
};

