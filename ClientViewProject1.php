<style>
.modal { width: 70% !important ; height: 70% !important ; }
.module { 
  height:15em!important;
  overflow-y: hidden!important;
  overflow-y: scroll!important;
  color:dimgray!important;
    font-size:10px!important; 
}
.comment{
  font-size:17px!important;        
}
.comment_dt{
  font-size:14px!important; 
  color:white!important;
}
.displayModalInfo{
  font-size:17px!important; 
  color:white!important;
}
 
</style> 
<?php  
 if(isset($_GET['clientviewproject'])){
         $projprog_id = $_GET['clientviewproject'];
  }   
 $current_user_id_login = $_SESSION['user_id'];


 //SELECT FEATURED PHOTOS START 
$select_row_featured_photos =  queryMysql("SELECT COUNT(*)  as row_count FROM project_progress left join projectprog_update on project_progress.projprog_id = projectprog_update.projprog_id left join projectprog_image on projectprog_update.pupdate_id = projectprog_image.pupdate_id where project_progress.projprog_id = '$projprog_id' and projectprog_image.featured = '1'");
     $run_row_featured_photos  =  mysqli_fetch_array($select_row_featured_photos);
     $row_featured_result   = $run_row_featured_photos['row_count'];
    if ($row_featured_result == 0){
         
    }else{
       $select_featured_photos = "SELECT * FROM project_progress left join projectprog_update on project_progress.projprog_id = projectprog_update.projprog_id left join projectprog_image on projectprog_update.pupdate_id = projectprog_image.pupdate_id where project_progress.projprog_id = '$projprog_id' and projectprog_image.featured = '1'"; 
       $run_featured_photos = queryMysql($select_featured_photos);
    }



  
//SELECT FEATURED PHOTOS START



//SELECT PERCENT ID START
    $select_percent_id = "SELECT * FROM projectprog_update  where projprog_id =' $projprog_id' and available = 0 order by  percent_d desc";
    $run_percent_id = queryMysql($select_percent_id);
//SELECT PERCENT ID END 

//SELECT PROJECT PROGRESS INFORMATION START
     $select_project = queryMysql("SELECT * FROM project_progress left join category on project_progress.category_id = category.category_id left join users on project_progress.user_iid = users.user_iid where projprog_id = '$projprog_id'");
     $row_select_project     =  mysqli_fetch_array($select_project);
      $category_name         = $row_select_project['category_name'];
      $project_name          = $row_select_project['name'];
      $project_description   = $row_select_project['description'];
      $publisher_lname       = $row_select_project['lname'];
      $publisher_fname       = $row_select_project['fname'];
      $registered_date       = $row_select_project['dated'];
  
 //SELECT PROJECT PROGRESS INFORMATION END 
     

?>
  


<div  id = "current_user_id_login" style = "display:none"><?php echo  $current_user_id_login;?></div>
  <div class ="card-panel white-text #d81b60 pink darken-1">

<div class = "row">

    <div class = "col s12"> 
         <div class="carousel carousel-slider center" data-indicators="true">
             
    <?php
     if($row_featured_result == 0){
          $featured_photo =  "../../no_feature_pictures.png";
     ?>
     <div class="carousel-item" href="#one!">
                   <img class=" carousel_dim responsive-img " src="<?php  echo $featured_photo; ?>" style = "width:100%;height:100%;">
    </div>         
   <?php
     }else{
         while($row_all_featured=mysqli_fetch_array($run_featured_photos)){
            $featured_photo =   $row_all_featured['path']; 
     
    
    ?>        
         <div class="carousel-item" href="#one!">
                   <img class=" carousel_dim responsive-img " src="<?php  echo $featured_photo; ?>">
         </div> 
             
    <?php             
     }
     }  
     ?> 
             
         
          </div>
        <br>
         <div style = "padding-left:1em">
              <!-- Dropdown Trigger -->
             
 
          <div class = "row">
              
                    <div class ="col s6">
                              <span class = "white-text"style = "font-weight:bold">Project Name:</span>  
                      <br><span  id  = "" class = "white-text"><?php echo $project_name; ?></span>
                    </div>
                   <div class ="col s6">
                        <span class = "white-text" style = "font-weight:bold">Registered Date:</span> 
                  
                      <br><span class = "white-text" id = "proj_prog_RD"><?php echo $registered_date; ?></span><br>
                    </div>
                     <div class ="col s6">
                        <span class = "white-text" style = "font-weight:bold">Published By:</span> 
                  
                      <br><span class = "white-text"><?php echo $publisher_fname." ".$publisher_lname; ?></span><br>
                    </div>
                    <div class ="col s6">
                        <span class = "white-text" style = "font-weight:bold">Category:</span> 
                  
                      <br><span class = "white-text"><?php echo $category_name; ?></span><br>
                    </div>
                
                 <div class ="col s12">
                
                       <span class = "white-text" style = "font-weight:bold">Description:</span>
                     <div class = "descriptionStyle">
                     <div id = "full_display_project_desc_id" class = "displayModalInfo" style = "display:none"><?php echo $project_description; ?></div>
                      <div id = "trunct_display_project_desc_id" class = "displayModalInfo" style = "display:none"><?php echo mb_strimwidth($project_description, 0, 320, "...");?></div>        
                     <span id = "display_project_desc_id" class = "displayModalInfo" ><?php echo mb_strimwidth($project_description, 0, 320, "...");?></span><a id = "readmore_proj_desc_id" style = "cursor:pointer"> Read More</a>
                    <a id = "undo_proj_desc_id" style = "cursor:pointer"> Undo</a>     
                         </div>

                </div>
                  <div class ="right">
                        <br>
                                 <a class='dropdown-button btn    #ec407a pink lighten-1' href='#' data-activates='dropdown1'>Percent<span id = "percentDisplayBTN"></span></a>

                          <!-- Dropdown Structure -->
                          <ul id='dropdown1' class='dropdown-content  white-text'>
                                <?php 
                                   while($row_all_percent_id=mysqli_fetch_array($run_percent_id)){
                                     $percent_id = $row_all_percent_id['pupdate_id'];   
                                     $percent = $row_all_percent_id['percent_d'];   
                                 ?>
                                <li class = " btn #ec407a pink lighten-1 white-text"> <a  class = "white-text" id  = "getPercent_ID" onclick="Materialize.fadeInImage('#percent_content');getPercent_ID('<?php  echo $percent_id;?>','<?php  echo $percent;?>');"><?php  echo $percent."%"; ?></a></li>
                                <?php        
                                  }
                                ?> 
                          </ul>
                    </div>
              <div class = "clearfix"></div>
            </div>     
          </div>
  
   
    </div>
    
 

</div>
</div>
<div  id = "percent_content">
 <div class = "card-panel  white-text #d81b60 pink darken-1">
       <div class = "col s12"> 
   
          <div class = "row"> 
          
              <div class = "col s12">
                    <div class = "card-panel #ff4081 pink accent-2"> 
                  <div   id  = "percentPictureGallery" class = "PictureGallery"  > 
                     <div class = "row"> 
<div id = "galleryHolder" ></div>  
  <!-- Modal Structure -->
  <div id="percent_picture" class="modal">
    <div class="modal-content #ec407a pink lighten-1">
        <div class = "row">
            <div class = "col s12">
             <div class = "#f06292 pink lighten-2" style = "box-shadow:0 0 10px #000;border:2px solid #000;">
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
            <div class = "clearfix"></div>
      <div class = "col s12">
             <div class="card blue-grey darken-1">
            <div class="card-content white-text #d81b60 pink darken-1">
              <span class="card-title">Description</span>
              <p style = "font-size:18px">
              
                 <span   id = "modalDescription" class = "displayModalInfo " ></span><a id = "readmore_modal_desc_id" style = "cursor:pointer"> Read More</a>
                    <a id = "undo_proj_modal_id" style = "cursor:pointer"> Undo</a>  
            </div>
            <div class="card-action #d81b60 pink darken-1">
             <div class   = "left">
                        <a href="#"  class = "white-text"><span  class = "displayModalInfo">Section:</span>  <span  class = 'displaycurrentSection displayModalInfo' ></span></a>
                     
             </div>
              <div class = "right">
                         <a href="#" class = "white-text"><span class="displayModalInfo" >Date:</span>  
                    <span  class  = "displayPercentDate displayModalInfo" style = "color:grey"></span></a>
                
              </div>
               <div class = "clearfix"></div>
            </div>
          </div>
      </div>          
      
        
            
            
            
           <br>
            <div class = "clearfix"></div>
          
            <div class="card blue-grey darken-1">
            <div class="card-content white-text #d81b60 pink darken-1">
              
                 <div id = "commentBox"></div>        
                  <div id = "SelectComments"></div>
                  <div class = "clearfix"></div>
        
                
                
                
            </div>
           
 </div>
 
            
            
            
            
       
        
    </div>
   
  </div>
                     </div>
                </div>
              </div>
               
             <div style = "padding-left:1em">
                  <div class = "row">

                       
                            <div class ="col s6">
                                      <span class="white-text" style = "font-weight:bold">ProjectName:</span>  
                              <br><span  id  = ""   class="white-text"><?php echo     $project_name ; ?></span>
                            </div>
                           <div class ="col s6">
                                <span class="white-text" style = "font-weight:bold">Updated Date:</span>
                               <br><span  class  = "displayPercentDate white-text" >Name</span>
                            </div>
                            <div class ="col s6">
                                <span class="white-text" style = "font-weight:bold">Percent:</span>
                               <br><span  id  = "displayPercent"   class="white-text">20%</span>
                            </div>
                            <div class ="col s6">
                                <span class="white-text" style = "font-weight:bold">Updated By:</span>
                               <br><span  id  = "displayUpdatedBy"   class="white-text">20%</span>
                            </div>
                            <div class = "col s12"> 
                  <div style ="padding-top:0.5em"></div>
                  <span class="white-text" style = "font-weight:bold">Description:</span><br>
                  
               <span id = "displayPercentDescription" class = "displayModalInfo white-text"></span>
                <a id = "readmore_percent_desc_id" style = "cursor:pointer"> Read More</a>
                    <a id = "undo_proj_percent_id" style = "cursor:pointer"> Undo</a>   
                                
              
               
              </div>
                       
                         <div class = "right">
                             <br>
                             <a class='dropdown-button  btn #d81b60 pink darken-1' href='#' data-activates='dropdown2'>SECTION:<span class = "displaycurrentSection">ALL</span></a>
                             <br>  
                             <ul id='dropdown2' class='dropdown-content'>
                                <div id = "all_section_value">
                                </div>
                                 <li><a  onclick = "selectSection('all')">All</a></li>
                             </ul>
                           
                         </div>
                         <div class = "clearfix"></div>
                          
                 </div>             
            </div>          
          </div> 
        
               
          </div>
    </div>
    </div>
</div>
    <div class="card blue-grey darken-1">
    <div class="card-content white-text #d81b60 pink darken-1">          
         <div id = "MaincommentBox"><div class="input-field col s12"><textarea id="MainCommentTextBox" style = "font-size:18px" class="materialize-textarea" placeholder = "Write a comment.."></textarea></div><div class ="right"><a id = "MainCommentBtn"class="waves-effect waves-light btn #f8bbd0 pink lighten-4">comment</a></div><div class = "clearfix"></div></div>  
        
      
        
         <div id = "MainSelectComments"></div>
         <div class = "clearfix"></div>
    </div>       
 </div>
    
</div>

    
    
 
    

<script> 
    
    
//////////////    

var percentPictureArr = [];
var store_percent_id = "";    
var none = "none"
var current_user_id_login =   $('#current_user_id_login').html();    
var comment_id_name =  "projectprog_img_comment_id";
var reference_id_name = "projprogimg_id";
var tablename = "projectprog_img_comments";  
    
    
    
    
    
    
    $('#undo_proj_desc_id').hide();
    $('#undo_proj_percent_id').hide();
    $('#undo_proj_modal_id').hide();
truncateDescription('readmore_proj_desc_id','undo_proj_desc_id','display_project_desc_id',$("#full_display_project_desc_id").html());               
    
    
$('#proj_prog_RD').html(convertDateTime($('#proj_prog_RD').html()));    
    
  socket.on('select all_section',function(data){
    if (data.section_id == null){
     
         $('#all_section_value').append('<li><a  onclick = "selectSection('+none+')">None</a></li>');
    }else{
        $('#all_section_value').append(' <li><a  onclick =  "selectSection('+data.section_id+')">'+data.section_name+'</a></li>   ');
    }      
});
socket.on('current section_name',function(data){
    $('.displaycurrentSection').html(data.section_name);
}); 
$('#percent_content').hide();          
function getPercent_ID(percent_id,percent){
      store_percent_id = percent_id;
    socket.emit("select update_percent_id",percent_id,function(percent_id){});
      $('#galleryHolder').empty(); 
      $('#percentDisplayBTN').html(": "+percent+"%");
      $('#all_section_value').empty();
      $('#SideModalGallery').empty();
      $('#DownModalGallery').empty(); 
       $.getScript("js/main_comment.js",function(){  
         //MainComment Module Script  Start
        submitComment('MainCommentBtn','MainCommentTextBox',$('#current_user_id_login').html(),percent_id,'projprog_update_comment_id','pupdate_id','projprog_update_comments',percent+"PPUP");    
         //MainComment Module Script  End
         $('#MainSelectComments').empty();
         $('#MainSelectComments').append('<div id = "MainDisplayComments"></div>');
         $('#MainSelectComments').append('<div class = "center-align"><div style = "cursor:pointer" id = "MainLoadMoreComments"><a id = "MainLoadMoreComments">Load More Comment/s</a></div></div>');   
        
     
          
     });
}
 function selectSection(section_id,section_name){
   $('#SideModalGallery').empty();
   $('#galleryHolder').empty(); 
   $('#DownModalGallery').empty(); 
    socket.emit('set picture_sections',section_id,store_percent_id,function(section_id,percent_id){});
}        
socket.on("set update_percent_id_info",function(data){   
    $('#percent_content').show(); truncateDescription('readmore_percent_desc_id','undo_proj_percent_id','displayPercentDescription',data.description);   
    $(window).scrollTop($('#percent_content').offset().top);
    
    $('.displayPercentDate').html( convertDateTime(data.project_update_date));
    $('#displayPercent').html(data.percent_value+"%"); 
    $('#displayUpdatedBy').html(data.publisher_fname+" "+data.publisher_lname); 
});  
socket.on('set percent_id_pictures',function(data){
     percentPictureArr[data.projprogimg_id] = data.path;
     $('#galleryHolder').append('<div id = "'+data.projprogimg_id+'" class = "col s6 m4 l4 " style = "padding:1em;width:13.5em;height:12em"><a  class="waves-effect waves-light  modal-trigger" href="#percent_picture" onclick = "updateModalPicture('+data.projprogimg_id+',percentPictureArr)"><img src="'+data.path+'" alt="" class="responsive-img "  style = "width:100%;height:100%;"></a></div>');     
     $('#SideModalGallery').append('<div class = "col m4  l12 sidemodalthumbnail" style = "padding:1em"><a  id = "sideModalPicture'+data.projprogimg_id+'" onclick = "updateModalPicture('+data.projprogimg_id+',percentPictureArr)" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt=""></a></div>');
     $('#DownModalGallery').append('<div class = "col s6 m4  l12 downmodalthumbnail" style = "padding:1em"><a  id = "downModalPicture'+data.projprogimg_id+'" onclick = "updateModalPicture('+data.projprogimg_id+',percentPictureArr)" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt=""></a></div>');  
});
socket.on('sum_count ofPercentPictures',function(data){
    //alert('pictures sum'+data.count_pictures);
     if( data.count_pictures  <= 3){
         $('#percentPictureGallery').removeClass('PictureGallery');
         $('#percentPictureGallery').addClass('LessThanFourPictureGallery'); 
         $('#DownModalGallery').removeClass('DownModalPictureGallery');
         $('#DownModalGallery').addClass('LessThanDownModalPictureGallery');
     }else{
         $('#percentPictureGallery').addClass('PictureGallery');
         $('#percentPictureGallery').removeClass('LessThanFourPictureGallery'); 
         $('#DownModalGallery').addClass('DownModalPictureGallery');
         $('#DownModalGallery').removeClass('LessThanDownModalPictureGallery');
     }
});       
function  updateModalPicture(variable_id,arrayName){
     for (var key in arrayName) {
            let value = arrayName[key];
                if(variable_id == key){
                    $('#modalPicture').empty();
                    $('#modalPicture').append('<img src="'+value+'" alt="" class="responsive-img "  width = "850"> ');             
                }          
          }
    socket.emit('get picture_description',variable_id,'PPUP',function(variable_id,cn_comment_cde){});
socket.on('Set picture_description',function(data){
        truncateDescription('readmore_modal_desc_id','undo_proj_modal_id','modalDescription',data.description);       
}); 
 var room_id = variable_id+"PPIC";
$('#SelectComments').empty();
$('#SelectComments').append('<div id = "displayComments'+variable_id+'"></div>');
$('#SelectComments').append('<div class = "center-align"><div style = "cursor:pointer" id = "loadMoreComments'+variable_id+'"><a id = "loadMoreComments'+variable_id+'">Load More Comment/s</a></div></div>');
$('#loadMoreComments'+variable_id).hide();
socket.emit("get commentRoomID",variable_id,room_id,comment_id_name,reference_id_name,tablename,"","",function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset,type){});
$('#commentBox').html(' <div class="input-field col s12"><textarea id="pictureCommentTextBox'+variable_id+'" style = "font-size:18px" class="materialize-textarea" placeholder = "Write a comment.."></textarea></div><div class ="right"><a id = "pictureCommentBtn'+variable_id+'"class="waves-effect waves-light btn #f8bbd0 pink lighten-4">comment</a></div><div class = "clearfix"></div>');
$('#pictureCommentBtn'+variable_id).click(function (){
    console.log('Commented a picture');
     if (($('#pictureCommentTextBox'+variable_id).val().trim() == '')){
         alert('Please fill up the comment field');
    }else{
        socket.emit('get picture_comment',$('#pictureCommentTextBox'+variable_id).val(),current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,0,variable_id+"PPIC","",function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id,type){});
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
LoadMoreComments('loadMoreComments','counted rows','get commentRoomID','PPIC',"standard");
LoadMoreComments('ShowMoreReplyComments','counted ReplyRows','get offsetReplyComment','PPIC',"reply");
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
    var replyExtension = '<div class = "row"><div class = "col s12"><div class = "left"><a class="waves-effect waves-light displayModalInfo" id = "openReplyForm'+comment_id+'" style = "cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;Reply</a><a class="waves-effect waves-light displayModalInfo" id ="closeReplyForm'+comment_id+'">&nbsp;&nbsp;&nbsp;&nbsp;Close</a></div><div class = "clearfix"></div><div id = "displayReplyCommentsForm'+comment_id+'"></div><div class = "clearfix"></div><div id = "rtReplyComment'+comment_id+'"></div><div class = "center"><a id = "ViewReplyComments'+comment_id+'" class = "displayModalInfo" style = "cursor:pointer;font-size:10px">View All Replies&#9660;</a></div><div class = "clearfix"></div><div class = "center"><a id = "HideReplyComments'+comment_id+'" style = "cursor:pointer;" class = "displayModalInfo">Hide All Replies&#9650;</a></div><div class = "clearfix"></div><div class = "clearfix"></div><div id = "displayReplyComments'+comment_id+'"></div><div class = "center"><a id = "ShowMoreReplyComments'+comment_id+'" style = "cursor:pointer">Show More Reply Comments</a></div><div class = "clearfix"></div></div></div>'; 
    
    var commentUI  =  '<div id = "modalCommentDiv'+comment_id+'"><div class ="col s3 m2 l1"><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10  l11"><span class = "displayModalInfo">'+fullname+' </span><div class = "right"><span class = "comment_dt">'+convertedDateTime +'</span></div><div class = "clearfix"></div><br><div id  = "commentDivHolder'+comment_id+'">'+currentCommentSpan+'</div></div></div>';
    var commentUIwithX  = '<div class = "right-align" id = "displayDeleteCommentModal'+comment_id+'" ><a id = "editCommentModal'+comment_id+'" class=" waves-effect waves-light "><i class="material-icons small white-text">create</i></a><a id = "deleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons  white-text small">close</i></a></div>'+commentUI;

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
            $('#'+displayComment_id).append('<div class = "right-align"><a class="waves-effect waves-light" id = "editCommentBTNcancel'+variable_id+'"><i class="material-icons small white-text">close</i></a></div><div class="input-field col s12"><textarea id="editCommentTXT'+variable_id+'" class="materialize-textarea comment">'+comment_value+'</textarea></div><div class ="right-align"><a class="waves-effect waves-light" id = "editCommentSaveBTN'+variable_id+'" ><i class="material-icons small white-text">save</i></a></div>');
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
           $('#'+displayReplyCommentForm_id).append('<div class ="col s3 m2 l2"><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10 l10"><div class="input-field col s12"><textarea id="pictureReplyCommentTextBox'+comment_id+'" class="materialize-textarea comment" placeholder = "Write a comment.."></textarea></div><div class ="right-align"><a id = "pictureReplyCommentBtn'+comment_id+'"class="waves-effect waves-light btn #f8bbd0 pink lighten-4">comment</a></div><br><br></div>');  
          $('#'+openReplyCommentBTN).hide();
          $('#'+closeReplyCommentBTN).show();
         
         
            $('#pictureReplyCommentBtn'+comment_id).click(function(){
                     if (($('#pictureReplyCommentTextBox'+comment_id).val().trim() == '')){
                         alert('Please fill up the comment field');
                    }else{
                        socket.emit('get picture_comment',$('#pictureReplyCommentTextBox'+comment_id).val(),current_user_id_login,variable_id,comment_id_name,reference_id_name,tablename,comment_id,variable_id+"PPIC ",function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id){});
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
    var commentUI  =  '<div id = "modalCommentDiv'+comment_id+'" style = "margin-left:2em"><div class ="col s3 m2 l1" ><div class = "commentDP"><img src="simages/deadpool.jpg" alt="" class="circle responsive-img"></div></div><div class ="col s9 m10  l11"><span class = "displayModalInfo">'+fullname+' </span><div class = "right"><span class = "comment_dt">'+convertedDateTime+'</span></div><div class = "clearfix"></div><br><div id  = "commentDivHolder'+comment_id+'">'+currentCommentSpan+'</div><div class = "clearfix"></div><br></div></div>';
    var commentUIwithX  = '<div class = "right-align" id = "displayDeleteCommentModal'+comment_id+'" ><a id = "editCommentModal'+comment_id+'" class=" waves-effect waves-light "><i class="material-icons small white-text">create</i></a><a id = "deleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons small white-text">close</i></a></div>'+commentUI;
    var commentUIwithXrm = '<div class = "right-align" id = "displayDeleteCommentModal'+comment_id+'" ><a id = "deleteCommentModal'+comment_id+'" class="waves-effect waves-light "><i class="material-icons small  white-text">close</i></a></div>'+commentUI; 
 
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
    
    
  
