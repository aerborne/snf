 <style>
     .portfolioGalleryThumb{
         height:12em;
         width:5em;
     }
      .portfolioGalleryThumb img {
         height:100%;
         width:100%;
     }
    
     .ratingStars i{
         cursor:pointer;
     } 
     .ratingStars i:hover{
         color:yellow;
     } 


</style>




<?php  
if(isset($_GET['ClientViewPortfolio'])){
    
     $projprog_id = $_GET['ClientViewPortfolio'];
 
           $project_details        = queryMysql("select * from portfolio left join portfolio_images on portfolio.portfolio_id = portfolio_images.portfolio_id where portfolio_images.featured = 1 and portfolio.portfolio_id = $projprog_id");
                
               $select_project = queryMysql("SELECT * FROM  portfolio  right join category on portfolio.category_id = category.category_id left join users  on portfolio.user_iid = users.user_iid   where portfolio_id  = $projprog_id");
               $row_select_project =  mysqli_fetch_array($select_project);
               $category_name   = $row_select_project['category_name'];
               $project_name   = $row_select_project['name'];
               $project_description   = $row_select_project['description'];
               $publisher_lname  = $row_select_project['lname'];
               $publisher_fname  = $row_select_project['fname'];
               $publisher_date   = $row_select_project['dated'];
               $publisher_fullname = $publisher_fname." ".$publisher_lname
    
?> 
<div id = "client_view_portfolio_id" style = "display:none"><?php echo $projprog_id; ?></div>
<div id  = "current_user_id_login" style = "display:none"><?php echo $_SESSION['user_id'];?></div>

 


 
 <div class = "card-panel  white-text #d81b60 pink darken-1">
       <div class = "col s12"> 
   
          <div class = "row"> 
          
              <div class = "col s12">
                    <div class = "card-panel card-panel #ff4081 pink accent-2"> 
                  <div   id  = "percentPictureGallery" class = "PictureGallery"  > 
                     <div class = "row"> 
<div id = "galleryHolder" ></div>  
  <!-- Modal Structure -->
  <div id="percent_picture" class="modal">
    <div class="modal-content #ec407a pink lighten-1">
        <div class = "row">
            <div class = "col s12">
             <div  class = "#f06292 pink lighten-2" style = "box-shadow:0 0 10px #000;border:2px solid #000;">
                 <div class = "row">
            <div class  ="col s12 m12 l9 " >
                 <div id  = "modalPicture" class = "modalPicture" style = "padding:1em"></div>    
                       <div id = "DownModalGallery" class = "show-on-medium-and-down hide-on-large-only DownModalPictureGallery">                  
                     </div>
            </div>
            <div style = "padding-top:0.1em"></div>
            <div class ="col m12 l3" >          
             <div id = "SideModalGallery"  class = "hide-on-med-and-down" style = "height:30em; overflow-y:hidden;overflow-y:scroll;"> </div>
            
                        
            </div>
                </div>
        </div>
        </div>
            
            
            
            <div class = "col s12">
                <br><br>
                <div class = "row">

                <div class ="col s6">
                    <span class="white-text" style = "font-weight:bold">Section:</span>  
                    <br><span  class = 'displaycurrentSection displayModalInfo white-text' ></span>
                </div>
                <div class ="col s6">
                    <span class="white-text" style = "font-weight:bold">Date:</span>  
                    <br><span  class  = "displayPercentDate displayModalInfo white-text" ></span>
                </div>
                <div class = "col s12">
                      <span class="white-text" style = "font-weight:bold">Description:<span id = "modalDescription"></span></span> 
                  <br>
                    
                    <!--
                 <span   id = "modalDescription" class = "displayModalInfo" ></span><a id = "readmore_modal_desc_id" style = "cursor:pointer"> Read More</a>
                    <a id = "undo_proj_modal_id" style = "cursor:pointer"> Undo</a>  
                    -->
                </div>     
                </div>
                  <div id = "RatingPortfolioImagesDiv"></div>
   
            </div>
            
            
            
           <!-- code design -->
            
           <br>
            <div class ="col s12">
              <div class = "divider"></div><br>
                <div class = "row">
                     
                    <div class ="col s3 m2 l2">
                         <div class = "commentDP">
                           <img src="simages/deadpool.jpg" alt="" class="circle responsive-img">
                        </div>
                    </div>
                  <div id = "commentBox"></div>
                  <div id = "SelectComments"></div>
            </div>
                 
         </div>
        
    </div>
       
  </div>
                     </div>
                </div>
              </div>
               
             <div style = "padding-left:1em">
                  <div class = "row">
                         <div class = "col s12">
                             <br>
                             <a class='dropdown-button btn #d81b60 pink darken-1' href='#' data-activates='dropdown2'>SECTION:<span class = "displaycurrentSection">ALL</span></a>
                             <br>  
                             <ul id='dropdown2' class='dropdown-content'>
                                <div id = "all_section_value">
                                </div>
                                 <li><a  onclick = "selectSection('all')">All</a>
                                  <li><a  onclick = "selectSection('none')">None</a></li>
                             </ul>
                           
                         </div>
                          
                 </div>             
            </div>          
          </div> 
        
               
          </div>
    </div>
           
          <div class = "row">
              
                    <div class ="col s6">
                              <span class="white-text" style = "font-weight:bold">ProjectName:</span>  
                      <br><span  id  = ""  class = "white-text"><?php echo $project_name; ?></span>
                    </div>
                 
                     <div class ="col s6">
                        <span class="white-text" style = "font-weight:bold">Published By:</span> 
                  
                      <br><span class = "white-text"><?php echo $publisher_fullname ; ?></span><br>
                    </div>
                     
                
                 <div class ="col s12">
                
                       <span class="white-text" style = "font-weight:bold">Description:</span>
                     <div class = "descriptionStyle">
                     <div id = "full_display_project_desc_id" style = "display:none"><?php echo $project_description; ?></div>
                         

                         
                      <div id = "trunct_display_project_desc_id" style = "display:none"><?php echo mb_strimwidth($project_description, 0, 320, "...");?></div>        
                     <span id = "display_project_desc_id" ><?php echo mb_strimwidth($project_description, 0, 320, "...");?></span><a id = "readmore_proj_desc_id" style = "cursor:pointer"> Read More</a>
                    <a id = "undo_proj_desc_id" style = "cursor:pointer"> Undo</a>     
                         </div>

                </div>
              
              
               
            </div> 
    </div>
        <div class="card-action #d81b60 pink darken-1">
             <div class   = "left">
                        <a href="#"  class = "white-text"><span  class = "displayModalInfo">Category:</span>  <span  class = 'displaycurrentSection displayModalInfo' ><?php echo $category_name; ?></span></a><br>
                             <a href="#" class = "white-text"><span class="displayModalInfo" >Date:</span>  
                    <span  class  = "displayPercentDate displayModalInfo white-text" ><?php echo   $publisher_date; ?></span></a>
                   
                     
             </div>
              <div class = "right">
                    
    <a id = "value_1" 
    onclick = "ratingPortfolio('1','<?php echo $projprog_id; ?>','<?php echo $_SESSION['user_id']; ?>')" class = "white-text ratingStars"><i class="material-icons">star</i></a>
     <a id = "value_2" 
    onclick = "ratingPortfolio('2','<?php echo $projprog_id; ?>','<?php echo $_SESSION['user_id']; ?>')" class = "white-text ratingStars"><i class="material-icons">star</i></a>
     <a id = "value_3" 
    onclick = "ratingPortfolio('3','<?php echo $projprog_id; ?>','<?php echo $_SESSION['user_id']; ?>')" class = "white-text ratingStars"><i class="material-icons">star</i></a>
    <a id = "value_4" 
    onclick = "ratingPortfolio('4','<?php echo $projprog_id; ?>','<?php echo $_SESSION['user_id']; ?>')" class = "white-text ratingStars"><i class="material-icons">star</i></a>
     <a id = "value_5" 
    onclick = "ratingPortfolio('5','<?php echo $projprog_id; ?>','<?php echo $_SESSION['user_id']; ?>')" class = "white-text ratingStars"><i class="material-icons">star</i></a>
                  
                
              
              </div>
               <div class = "clearfix"></div>
               <div class = "right">
                   Rating Average: <span id = "portfolio_average" class = "white-text">0</span>
               </div>
                <div class = "clearfix"></div>
            </div>
     
</div> 
  <div class="card blue-grey darken-1">
    <div class="card-content white-text #d81b60 pink darken-1">          
         <div id = "MaincommentBox"><div class="input-field col s12"><textarea id="MainCommentTextBox" style = "font-size:18px" class="materialize-textarea" placeholder = "Write a comment.."></textarea></div><div class ="right"><a id = "MainCommentBtn"class="waves-effect waves-light btn #f8bbd0 pink lighten-4">comment</a></div><div class = "clearfix"></div></div>  
        
      
        
         <div id = "MainSelectComments"></div>
         <div class = "clearfix"></div>
    </div>       
 </div>
<?php
}
?>


 
<script>
 
///rating portfolio 
    ///socket.emit('Rate Portfolio',function())
    
///Realtime Main Portfolio Rating Start 
    function ratingPortfolio(rating_value,portfolio_id,logged_user_id){
     
        socket.emit('Rate Portfolio',rating_value,portfolio_id,logged_user_id,"MRP"+portfolio_id,function(rating_value,portfolio_id,logged_user_id,room_id){});
    }
    socket.on('portfolio_average',function(data){
          
       
        $('#portfolio_average').html('0');
        $('#portfolio_average').html(data.portfolio_ave);
    });
   
    socket.emit('Retrieved PortfolioHistoryAverage',$('#client_view_portfolio_id').html(),"MRP"+$('#client_view_portfolio_id').html(),function(portfolio_id,room_id){});

///Realtime Main Portfolio Rating End    
 
//Realtime Portfolio Rating Image Start 
  socket.on('portfolioImage_average',function(data){
          $('#portfolioPicture_average'+data.portfolio_id).html('0');
          $('#portfolioPicture_average'+data.portfolio_id).html(data.portfolio_ave);
    }); 
    function ratingPortfolioPictures(rating_value,portfolio_id,logged_user_id){ 
     socket.emit('Rate PortfolioImages',rating_value,portfolio_id,logged_user_id,"MRPI"+portfolio_id,function(rating_value,portfolio_id,logged_user_id,room_id){});  
}   
//Realtime Portfolio Rating Image End    
var percentPictureArr = [];
var store_percent_id = "";    
var none = "none"
var current_user_id_login =   $('#current_user_id_login').html();    
var comment_id_name =  "portfolio_image_comment_id";
var reference_id_name = "portimg_id";
var tablename = "portfolio_images_comment";  
var PictureInformatioOBJlist = '{"PictureInformationList":[]}';
picture_obj_ls = JSON.parse(PictureInformatioOBJlist);
    

truncateDescription('readmore_proj_desc_id','undo_proj_desc_id','display_project_desc_id',$("#full_display_project_desc_id").html());     
function truncateDescription(readMore_id,undo_id,display_id,originalDisplay){
        $('#'+readMore_id).show();
        $('#'+undo_id).hide();
     if(originalDisplay.length < 320){
        $('#'+display_id).html(originalDisplay);
        $('#'+readMore_id).hide(); 
        $('#'+undo_id).hide();
     }else{
       var truncateDescirption = originalDisplay.substring(0,320)+"...";
        $('#'+display_id).html(truncateDescirption);
        $('#'+readMore_id).click(function(){
             $('#'+display_id).html(originalDisplay);
             $('#'+undo_id).show();
             $('#'+readMore_id).hide(); 
        });
        $('#'+undo_id).click(function(){
              $('#'+display_id).html(truncateDescirption);
             $('#'+readMore_id).show();
             $('#'+undo_id).hide(); 
        }); 
     }    
}
    
socket.on('populate_section_btn',function(data){
    console.log(data.section_id+" "+data.section_name);
    $('#all_section_value').append(' <li><a  onclick = "selectSection('+data.section_id+')">'+data.section_name+'</a></li>');
});
    selectSection('all');
function  selectSection(section_id){
      $('#galleryHolder').empty(); //clear  section gallery 
       socket.emit('selected_portfolio_section',section_id,$('#client_view_portfolio_id').html(),function(section_id,portfolio_id){});
}
    socket.on('set PortPictureGallery',function(data){
 
      picture_obj_ls.PictureInformationList.push({"portimg_id":data.portimg_id,"image_description":data.image_description,"path":data.path,"section_name":data.section_name,"date":data.date});
        
         percentPictureArr[data.portimg_id] = data.path;
        $('#galleryHolder').append('<div id = "'+data.portimg_id+'" class = "col s6 m4 l4 " style = "padding:1em;width:13.5em;height:12em"><a  class="waves-effect waves-light  modal-trigger" href="#percent_picture" onclick = "updateModalPicture('+data.portimg_id+',percentPictureArr)"><img src="'+data.path+'" alt="" class="responsive-img "  style = "width:100%;height:100%;"></a></div>');
        $('#modalDescription').html("hello world");
                     //$('.displaycurrentSection').html(picture_obj_ls.PictureInformationList[i].section_name);
                     //$('.displayPercentDate').html(picture_obj_ls.PictureInformationList[i].date);
        
        
        
        
         $('#SideModalGallery').append('<div class = "col m4  l12 sidemodalthumbnail" style = "padding:1em"><a  id = "sideModalPicture'+data.portimg_id+'" onclick = "updateModalPicture('+data.portimg_id+',percentPictureArr)" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt=""></a></div>');
     $('#DownModalGallery').append('<div class = "col s6 m4  l12 downmodalthumbnail" style = "padding:1em"><a  id = "downModalPicture'+data.portimg_id+'" onclick = "updateModalPicture('+data.portimg_id+',percentPictureArr)" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt=""></a></div>');
     
    });
   
       
                  
   
 
function updateModalPicture(variable_id){
        for (var i = 0; i <  picture_obj_ls.PictureInformationList.length; i++) {
             if(variable_id == picture_obj_ls.PictureInformationList[i].portimg_id){
                     $('#modalPicture').empty();
                     $('#modalPicture').append('<img src="'+picture_obj_ls.PictureInformationList[i].path+'" alt="" class="responsive-img "  width = "850"> '); 
                     
                 
                     $('#modalDescription').html(picture_obj_ls.PictureInformationList[i].image_description);
                     $('.displaycurrentSection').html(picture_obj_ls.PictureInformationList[i].section_name);
                     $('.displayPercentDate').html(picture_obj_ls.PictureInformationList[i].date);
                    var portimg_id  = picture_obj_ls.PictureInformationList[i].portimg_id;
                //  alert('portimg_id: '+variable_id);   
                 
              
   

                 $("#RatingPortfolioImagesDiv").html('<div class = "right"><a id = "value_1" onclick = "ratingPortfolioPictures(1,'+variable_id+','+$('#current_user_id_login').html()+')" class = "white-text ratingStars"><i class="material-icons">star</i></a><a id = "value_2" onclick = "ratingPortfolioPictures(2,'+variable_id+','+$('#current_user_id_login').html()+')" class = "white-text ratingStars"><i class="material-icons">star</i></a><a id = "value_3" onclick = "ratingPortfolioPictures(3,'+variable_id+','+$('#current_user_id_login').html()+')" class = "white-text ratingStars"><i class="material-icons">star</i></a><a id = "value_4" onclick = "ratingPortfolioPictures(4,'+variable_id+','+$('#current_user_id_login').html()+')" class = "white-text ratingStars"><i class="material-icons">star</i></a><a id = "value_5" onclick = "ratingPortfolioPictures(5,'+variable_id+','+$('#current_user_id_login').html()+')" class = "white-text ratingStars"><i class="material-icons">star</i></a></div><div class = "clearfix"></div><div class = "right">Rating Average: <span id = "portfolioPicture_average'+variable_id+'" class = "white-text"></span></div><div class = "clearfix"></div>');
                   socket.emit('Retrieved PortfolioImageHistoryAverage',variable_id,"MRPI"+variable_id,function(portfolio_id,room_id){});
  
                   
             }
                   
        }
    //Comment Module 
 var room_id = variable_id+"POPIC";
$('#SelectComments').empty();
$('#SelectComments').append('<div id = "displayComments'+variable_id+'"></div>');
$('#SelectComments').append('<div class = "center-align"><div style = "cursor:pointer" id = "loadMoreComments'+variable_id+'"><a id = "loadMoreComments'+variable_id+'">Load More Comment/s</a></div></div>');
$('#loadMoreComments'+variable_id).hide();
socket.emit("get commentRoomID",variable_id,room_id,comment_id_name,reference_id_name,tablename,"",function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset){});
$('#commentBox').html('<div class ="col s9 m10 l10"><div class="input-field col s12"><textarea id="pictureCommentTextBox'+variable_id+'" class="materialize-textarea" placeholder = "Write a comment.."></textarea></div><div class ="right-align"><a id = "pictureCommentBtn'+variable_id+'"class="waves-effect waves-light btn">comment</a></div><br><br></div>');
$('#pictureCommentBtn'+variable_id).click(function (){
    console.log('Commented a picture');
     if (($('#pictureCommentTextBox'+variable_id).val().trim() == '')){
         alert('Please fill up the comment field');
    }else{
        socket.emit('get picture_comment',$('#pictureCommentTextBox'+variable_id).val(),current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,0,variable_id+"POPIC",function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id){});
        $('#pictureCommentTextBox'+variable_id).val('');    
    } 
       
});
 
             
}

socket.on('set commentDisplay',function(data){    
   if(data.parent_comment_id == 0){
     commentDisplays(data.fullname,data.comment_dt,data.comment_value,data.variable_id,data.time,'displayComments'+data.variable_id,data.user_id,current_user_id_login,data.comment_id);  
      
   }else{
       displayReplyComments(data.fullname,data.comment_dt,data.comment_value,data.time,'displayReplyComments'+data.parent_comment_id,'rtReplyComment'+data.parent_comment_id,data.user_id,current_user_id_login,data.comment_id,data.parent_comment_id,'ViewReplyComments'+data.parent_comment_id,'HideReplyComments'+data.parent_comment_id,'ShowMoreReplyComments'+data.parent_comment_id);
   } 
    
    
});
socket.on('set ReplyCommentDisplays',function(data){
  displayReplyComments(data.fullname,data.comment_dt,data.comment_value,data.time,'displayReplyComments'+data.parent_comment_id,"",data.user_id,current_user_id_login,data.comment_id,data.parent_comment_id,'ViewReplyComments'+data.parent_comment_id,'HideReplyComments'+data.parent_comment_id,'ShowMoreReplyComments'+data.parent_comment_id,data.comment_owner_id);
  
});
//LoadMoreFunctions 
LoadMoreComments('loadMoreComments','counted rows','get commentRoomID','POPIC',"standard");
LoadMoreComments('ShowMoreReplyComments','counted ReplyRows','get offsetReplyComment','POPIC',"reply");
socket.on('deactivate commment',function(data){
     var currentCommentSpan = '<span class = "comment">'+data.comment+'</span>'; 
    if(data.mode == "delete"){
        $('#modalCommentDiv'+data.comment_id).hide(); 
        $('#displayDeleteCommentModal'+data.comment_id).hide();
    }else if(data.mode == "edit"){
          $('#commentDivHolder'+data.comment_id).empty();     $('#commentDivHolder'+data.comment_id).append(currentCommentSpan);
    }
});
function convertDateTime(variable_id){
     var month    = variable_id.substr(5,2);
     var day      = variable_id.substr(8,2);
     var year     = variable_id.substr(0,4);
     var time     = variable_id.substr(11,5);
     var endTime  = variable_id.substr(20,2);
var NameOfMonths = [];
   NameOfMonths["01"]  = "January";
   NameOfMonths["02"]  = "Febuary";
   NameOfMonths["03"]  = "March";
   NameOfMonths["04"]  = "April";
   NameOfMonths["05"]  = "May";
   NameOfMonths["06"]  = "June";
   NameOfMonths["07"]  = "July";
   NameOfMonths["08"]  = "August";
   NameOfMonths["09"]  = "September";
   NameOfMonths["10"] = "October";
   NameOfMonths["11"] = "November";
   NameOfMonths["12"] = "December";   
for (var key in NameOfMonths) {
   let monthName = NameOfMonths[key];
    if(month == key){
       return  monthName+" "+day+", "+year+" at "+time+" "+endTime;
    }
 }
}     
function commentDisplays(fullname,datetime,comment_value,variable_id,time,displayComment_ID,user_id,current_user_id_login,comment_id){
    var displayComment;
  //  alert(datetime);
    var convertedDateTime = convertDateTime(datetime);
    var currentCommentSpan = '<span class = "comment">'+comment_value+'</span>'; 
    var replyExtension = '<br><div class = "col s12"><div class = "row"><div class = "col s1"></div><div class = "col s11"><a class="waves-effect waves-light" id = "openReplyForm'+comment_id+'" style = "cursor:pointer;font-size:10px">Reply</a><a class="waves-effect waves-light" id = "closeReplyForm'+comment_id+'">Close</a><div id = "displayReplyCommentsForm'+comment_id+'"></div><br><div id = "rtReplyComment'+comment_id+'"></div><a id = "ViewReplyComments'+comment_id+'" style = "cursor:pointer;font-size:10px">View All Replies&#9660;</a><a id = "HideReplyComments'+comment_id+'" style = "cursor:pointer;font-size:10px">Hide All Replies&#9650;</a><div id = "displayReplyComments'+comment_id+'"></div><a id = "ShowMoreReplyComments'+comment_id+'" style = "cursor:pointer">Show More Reply Comments</a></div></div></div>';    
    var commentUI  =  '<div id = "modalCommentDiv'+comment_id+'"><div class ="col s3 m2 l1" "><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10  l11"><span>'+fullname+' </span><span class = "comment_dt">'+convertedDateTime +'</span><br><div id  = "commentDivHolder'+comment_id+'">'+currentCommentSpan+'</div><br> <br><div class = "divider"></div><br> </div></div>';
    var commentUIwithX  = '<div class = "right-align" id = "displayDeleteCommentModal'+comment_id+'" ><a id = "editCommentModal'+comment_id+'" class=" waves-effect waves-light "><i class="material-icons Tiny">create</i></a><a id = "deleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons Tiny">delete_forever</i></a></div>'+commentUI;

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
    $("#ShowMoreReplyComments"+comment_id).hide();
    $('#displayReplyComments'+comment_id).hide(); 
    $('#HideReplyComments'+comment_id).hide();
    $('#ViewReplyComments'+comment_id).hide();
    socket.on('counted ReplyRows',function(data){
       if(data.counted_rows == 0){
       }else{
          $('#ViewReplyComments'+data.variable_id).show();
       }
       
   });
        $('#closeReplyForm'+comment_id).hide();
 replyCommentForm(comment_id,'openReplyForm'+comment_id,'displayReplyCommentsForm'+comment_id,'closeReplyForm'+comment_id,current_user_id_login,variable_id); 
    
    
    
    deleteComment(comment_id,"deleteCommentModal"+comment_id);
    editComment(comment_id,"editCommentModal"+comment_id,'commentDivHolder'+comment_id,currentCommentSpan,comment_value);
   
}

function truncateDescription(readMore_id,undo_id,display_id,originalDisplay){
        $('#'+readMore_id).show();
        $('#'+undo_id).hide();
     if(originalDisplay.length < 320){
        $('#'+display_id).html(originalDisplay);
        $('#'+readMore_id).hide(); 
        $('#'+undo_id).hide();
     }else{
       var truncateDescirption = originalDisplay.substring(0,320)+"...";
        $('#'+display_id).html(truncateDescirption);
        $('#'+readMore_id).click(function(){
             $('#'+display_id).html(originalDisplay);
             $('#'+undo_id).show();
             $('#'+readMore_id).hide(); 
        });
        $('#'+undo_id).click(function(){
              $('#'+display_id).html(truncateDescirption);
             $('#'+readMore_id).show();
             $('#'+undo_id).hide(); 
        }); 
     }    
}
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
function editComment(variable_id,editCommentBTN,displayComment_id,currentCommentSpan,comment_value){
    $('#'+editCommentBTN).click(function(){
            $('#'+displayComment_id).empty();
            $('#'+displayComment_id).append('<div class = "right-align"><a class="waves-effect waves-light" id = "editCommentBTNcancel'+variable_id+'"><i class="material-icons">close</i></a></div><div class="input-field col s12"><textarea id="editCommentTXT'+variable_id+'" class="materialize-textarea comment">'+comment_value+'</textarea></div><div class ="right-align"><a class="waves-effect waves-light" id = "editCommentSaveBTN'+variable_id+'" ><i class="material-icons">save</i></a></div>');
            $('#editCommentBTNcancel'+variable_id).click(function(){
                 $('#'+displayComment_id).empty();
                 $('#'+displayComment_id).append(currentCommentSpan);
               
            });
            $('#editCommentSaveBTN'+variable_id).click(function(){
                  
                     if (($('#editCommentTXT'+variable_id).val().trim() == '')){
                         alert('Please fill up the comment field');
                     }else{
                          socket.emit('trigger deactivate_comment',variable_id,"comment",$('#editCommentTXT'+variable_id).val(),"edit",function(variable_id,filter_name,filter_value,mode){});
    
                     }
                 
               });
          
    });  
 
}
function replyCommentForm(comment_id,openReplyCommentBTN,displayReplyCommentForm_id,closeReplyCommentBTN,current_user_id_login,variable_id){
     $('#'+openReplyCommentBTN).click(function(){
              $('#'+displayReplyCommentForm_id).empty();
           $('#'+displayReplyCommentForm_id).show();
           $('#'+displayReplyCommentForm_id).append('<div class ="col s3 m2 l2"><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10 l10"><div class="input-field col s12"><textarea id="pictureReplyCommentTextBox'+comment_id+'" class="materialize-textarea comment" placeholder = "Write a comment.."></textarea></div><div class ="right-align"><a id = "pictureReplyCommentBtn'+comment_id+'"class="waves-effect waves-light btn">comment</a></div><br><br></div>');  
          $('#'+openReplyCommentBTN).hide();
          $('#'+closeReplyCommentBTN).show();
         
         
            $('#pictureReplyCommentBtn'+comment_id).click(function(){
                     if (($('#pictureReplyCommentTextBox'+comment_id).val().trim() == '')){
                         alert('Please fill up the comment field');
                    }else{
                        socket.emit('get picture_comment',$('#pictureReplyCommentTextBox'+comment_id).val(),current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,comment_id,variable_id+"POPIC ",function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id){});
                        $('#pictureReplyCommentTextBox'+comment_id).val(''); 
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
function  LoadMoreComments(LoadMoreCommentsID,socketOnFuncName,socketEmitFuncName,roomKeyword,type){
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
                          if(increment_counter == total_incrementation){
                              $('#'+LoadMoreCommentsID+data.variable_id).hide();
                              var room_id = data.variable_id+roomKeyword;
                               socket.emit(socketEmitFuncName,data.variable_id,room_id,comment_id_name,reference_id_name,tablename,' OFFSET '+offset_value,function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset){});
                          }else{
                            var room_id = data.variable_id+roomKeyword;
                            socket.emit(socketEmitFuncName,data.variable_id,room_id,comment_id_name,reference_id_name,tablename,' OFFSET '+offset_value,function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset){});
                          }
                           increment_counter++;
                           offset_value += 10;
                      });
                   }
             });
         
}
 
function displayReplyComments(fullname,datetime,comment_value,time,displayComment_ID,displayCurrentCommentID,user_id,current_user_id_login,comment_id,principal_comment_id,ViewReplyCommentsID,HideReplyCommentsID,ShowMoreReplyCommentsID,comment_owner_id){ 
    var displayComment;
    var convertedDateTime =convertDateTime(datetime); 
    var currentCommentSpan = '<span class = "comment">'+comment_value+'</span>';
    var commentUI  =  '<div id = "modalCommentDiv'+comment_id+'"><div class ="col s3 m3 l2" "><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m9  l10"><span>'+fullname+' </span><span class = "comment_dt">'+convertedDateTime+'</span><br><div id  = "commentDivHolder'+comment_id+'">'+currentCommentSpan+'</div><br> <br><div class = "divider"></div><br> </div></div>';
    var commentUIwithX  = '<div class = "right-align" id = "displayDeleteCommentModal'+comment_id+'" ><a id = "editCommentModal'+comment_id+'" class=" waves-effect waves-light "><i class="material-icons Tiny">create</i></a><a id = "deleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons Tiny">delete_forever</i></a></div>'+commentUI;
    var commentUIwithXrm = '<div class = "right-align" id = "displayDeleteCommentModal'+comment_id+'" ><a id = "deleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons Tiny">delete_forever</i></a></div>'+commentUI; 
 
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
      
    deleteComment(comment_id,"deleteCommentModal"+comment_id);
    editComment(comment_id,"editCommentModal"+comment_id,'commentDivHolder'+comment_id,currentCommentSpan,comment_value);
}
 
</script>
 
