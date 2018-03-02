 <?php 
if(isset($_GET['SelectUp'])){
      $pupdate_id = $_GET['SelectUp'];
      $user_id  = $_SESSION['user_id'];
      $select_username  = queryMysql("SELECT  *  from users where user_iid = '$user_id'");
      $row_select  = mysqli_fetch_array($select_username);
      $username    =  $row_select['username'];
      $user_level  =  $row_select['levels'];
    
      $select_pupdate_name  = queryMysql("SELECT  project_progress.name as project_name,projectprog_update.descriptions as ppup_desc,category_name,percent_d,projectprog_update.dated as ppup_date,lname,fname FROM projectprog_update left join project_progress  on  projectprog_update.projprog_id = project_progress.projprog_id left join category on category.category_id = project_progress.category_id left join  users on  projectprog_update.user_id = users.user_iid where pupdate_id = '$pupdate_id'");
      $row_pupdate_name  = mysqli_fetch_array($select_pupdate_name);
      $project_name      = $row_pupdate_name['project_name'];  
      $descriptions      = $row_pupdate_name['ppup_desc'];
      $category_name     = $row_pupdate_name['category_name'];
      $ppup_date         = $row_pupdate_name['ppup_date'];
      $percent           = $row_pupdate_name['percent_d'];
      $fullname          = $row_pupdate_name['fname']." ".$row_pupdate_name['lname'];   
?>

<div class = "col s12 m6">
    
 <div class = "card">
      <div class="card-content  #c2185b pink darken-2 white-text" >
            <div class = "right">
                <a href = "#EditProjectModal" class="waves-effect waves-light  modal-trigger tooltipped" data-position="top" data-tooltip="Edit Project Update Description"  style = "color:white;background-color:#ff5252 red accent-2"><i class="material-icons">create</i></a>
                <a class="waves-effect waves-light modal-trigger" style = "color:white;background-color:#ff5252 red accent-2" href="#projectPhotoUpload"> <i class="material-icons  small">file_upload</i></a> 
        </div>
         <div class = "clearfix"></div>     
 <div class = "center-align">
 <h3><?php echo $project_name;  ?></h3>
</div> 
    <div class = "left">
          <span  style = "font-size:18px">Category: <?php echo $category_name; ?></span><br>
           <span  style = "font-size:18px">Percent: <?php echo $percent; ?>%</span>
     </div>          
    <div class = "right">
            <span  style = "font-size:18px">Date Published: <?php echo convertDateTime($ppup_date); ?></span><br>
            <span  style = "font-size:18px">Published By: <?php echo $fullname; ?></span> 
     </div>
           
     <div class = "clearfix"></div>
          <br>
            <p id = "displayDescription" class = "flow-text" style = "word-wrap: break-word;font-size:15px "><?php echo $descriptions; ?></p>
 
        
        
          
      <!-- Modal Structure -->
  <div id="EditProjectModal" class="modal" >
    <div class="modal-content" style = "height:20em">
          <div class="input-field col s12">
          <textarea id="EditPdescriptions" class=" black-text materialize-textarea"><?php  echo $descriptions; ?></textarea>
          <label for="EditPdescriptions">Description</label>
        </div>
         <div class = "right-align">
            <a  id = "EditProject"class="waves-effect waves-light btn modal-close">Save</a>
          </div>
    </div>
  </div>
     <div id="projectPhotoUpload" class="modal">
    <div class="modal-content">         
         <?php  include('UploadProjectUpdateGallery.php')?>    
    </div>
  </div>    
          
          
 
         
     </div>
         
<div id =  "pupdate_id" style = "display:none"><?php echo $pupdate_id ;?></div>
          <div id = "user_id" style = "display:none;"><?php echo $user_id; ?></div>
 <div id = "username" style = "display:none;"><?php echo $username; ?></div>
          <div id = "user_level" style = "display:none;"><?php echo $user_level;?></div>
          <div id = "tableName" style = "display:none">projprog_update_comments</div>
          <div id = "comment_id_name" style = "display:none">projprog_update_comment_id</div>
          <div id  = "reference_id_name" style = "display:none">pupdate_id</div>
 
     <div class = "row">
     

     
     
     </div>
 

 
<br>
 
<div class="row">
    <div class = "col s11">
      <div  id  = "EditPortfolioImages" style =  "overflow-y:scroll; height:30em;margin-left:4em"></div>
        <br><br>
        <div class = "container">
            
    <div class="input-field col s10">
    <select id = "selectSection_id">
    <?php    
     $select_all_content="SELECT * FROM section where available  = 0 ";//sau sau sau

 
  $run_all_content= queryMysql($select_all_content);
         while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $category_id      = $row_all_content['section_id'];
                          $category_name    = $row_all_content['section_name'];
    ?>
      <option value="<?php  echo $category_id; ?>"><?php echo $category_name; ?></option>
<?php
         }
?>
    </select>
    <label>Choose section for check items</label>
  </div><br>
    <!--   save  section -->
  <div class = "col s2">
        <a  id = "BTNsubmitSection"class="waves-effect waves-light btn">Save</a>
  </div><br><br>
               <p id = 'errorSelectSection' class = "#ef5350 red lighten-1 white-text"></p>
            </div>
    </div> 
    <br><br>
    </div>
 
<br>
<!--
<div class = "container" >
    <div class = "right-align">
    <button  id  = "btnSave"class="btn btn-large purple lighten-2"  onclick="Materialize.toast('Gallery Alteration Saved', 4000)">SAVE</button>
    </div>
</div>    
-->    
   
   
    
    
    
    

     <br><br><br><br><br><br>
</div></div><br><br> 

    <!-- Hold Html Comments -->
<div class = "container">

<div class = "row">
<div class = "col s12">
   
   
    <br><br>
      <div id = "ShowComments" style = " white-space: initial;"></div>
  <div id = "Show" style = " white-space: initial;"></div>
<div id = "replyContent"></div>         

</div>    
</div>        
</div>  
 
<script>
    
          var  $username            =   $('#username');
              var  $comment             =   $('#Newcomment');
              var  $ShowComments        =   $('#ShowComments')
              var  $ReplyComments       =   $('#replyContent');
              var  $user_id             =   $('#user_id');
              var  $user_level          =   $('#user_level');
              var  $tableName           =   $('#tableName');
              var  $comment_id_name     =   $('#comment_id_name');
              var  $reference_id_name   =   $('#reference_id_name');

           
    socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),$('#pupdate_id').html(),'ppg',$('#tableName').html(),$('#comment_id_name').html(),$('#reference_id_name').html());
       socket.emit('Get ProjProgIDfImage',$('#pupdate_id').html(),function(projprog_id){});
       
    $('#assignSectionBTN').click(function(e){
              window.open('index.php?AssignProjectUpSection='+$('#pupdate_id').html(),'_self');
         
    }); 
              
  
        
  
       
       
//Edit  User Comments ========================================================>
socket.on('Set EditedComment',function(data){
    //alert('Set EditedComment has been triggered');
     $('#displayComment'+data.comment_id).empty();
     $('#displayComment'+data.comment_id).html(data.comment); 
});
       

       
       
       
//// Edit Project Details Start ==============================>       
    $('#EditProject').click(function(e){
         socket.emit('Get EditedProjectDescriptions',$('#pupdate_id').html(),$('#EditPdescriptions').val(),"projectprog_update","pupdate_id",function(portfolio_id,description,tablename,columnIdName){});
    });
    socket.on('Set EditedProjectDescriptions',function(data){
         $('#displayDescription').empty();
         $('#displayDescription').html(data.description);
    });
       
       
        socket.on('SetProjProgImg',function(data){
        
        //alert("HELLO"); 
       var projprogImages_id = [];
       var projprogImages_Description =  [];  
       var projprogImageSection = [];
            
        projprogImages_id.push("projprogIMG"+data.projprogimg_id);
        projprogImages_Description.push("projprogimgDescription"+data.projprogimg_id);
            
       
   if(data.featured == 0){
       // alert('HELLO');
           $('#EditPortfolioImages').append('<div id = "ImageCont'+data.projprogimg_id+'"><div id  = "projprogIMG'+data.projprogimg_id+'" style = "display:none" >'+data.projprogimg_id+'</div><div class="col s12 m6 l4"><div class="card white"><div class="card-content black-text"><div class = "right-align" > <button id = "DeleteProjProgImage'+data.projprogimg_id+'"class="btn btn-small red darken-3 white-text">&times</button></div><div class ="left-align"><p><input type="checkbox"  id="check'+data.projprogimg_id+'" /><label for="check'+data.projprogimg_id+'">Feature Photo</label></p><p><input type="checkbox"  id="checkSection'+data.projprogimg_id+'" /><label for="checkSection'+data.projprogimg_id+'"><span id = "sectionName'+data.projprogimg_id+'">Section: '+data.section_name+'</span></label></p></div><br><a class = "modal-trigger" href = "index.php?SelectProjectUpdatePicture='+data.projprogimg_id+'"><img style = " width:270px;height:180px;overflow:hidden;" src="'+data.path+'" alt="" class="responsive-img " alt=""></a><div class="row"><div class="input-field col s12"><textarea id  = "projprogimgDescription'+data.projprogimg_id+'" class="" style = "overflow-y:scroll;height:9em"> '+data.description+'</textarea></div></div></div></div></div></div><div id="modal'+data.projprogimg_id+'" class="modal"><div class="modal-content" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt="">   <span class="card-title"><h3>Picture Name</h3></span><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta ratione, aliquid minima autem tempora, dolor impedit quidem tempore dolorem magnam deserunt, illo. Perspiciatis, quia praesentium nihil illo asperiores dolor modi.</p><br><div class = "right-align"><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star_border</i><p class="truncate">Average Rating: 4</p> </div><form id  = "commentForm"><div class="input-field"><input type="text" id=""><label class="active" for="comment">Write a Comment</label></div><div class    = "right-align"><input id = "btnSubmit" type = "submit"  value = "Comment" class = "main-color-bg" ></div> </form><div id = "ShowComments" style = " white-space: initial;"></div></p>  <div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text" style = "margin-left:1em"><span style = "color:blue">Raine Drop</span> Yeah Dawg!!!</p><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div></div>  <div class="chip"><img src="images/yuna.jpg" alt="Contact Person">Jane Doe</div></div><div class="modal-footer"></div></div>');
            
        $('.modal').modal();   
        $("#DeleteProjProgImage"+data.projprogimg_id).click(function(e){
           //  alert(data.projprogimg_id);
             socket.emit('Get DeleteProjProgImage',data.projprogimg_id,function(projprogimg_id){}); 
             $('#ImageCont'+data.projprogimg_id).hide();
        });    
  
$('#check'+data.projprogimg_id).click(function(){
             if(this.checked){
                   socket.emit('Select FeaturePortfolioImages','projectprog_image','projprogimg_id',data.projprogimg_id,"1",function(tablename,column_id_name,portimg_id,featured){});     
             }else{
               // alert('HELLO');
                  //alert(data.portimg_id);
                  socket.emit('Select FeaturePortfolioImages','projectprog_image','projprogimg_id',data.projprogimg_id,"0",function(tablename,column_id_name,portimg_id,featured){}); 
             } 
});            
$('#checkSection'+data.projprogimg_id).click(function(){
             if(this.checked){
             
                  projprogImageSection.push(data.projprogimg_id); 
                //alert('HELLO'+data.projprogimg_id);
                //selectSection_id
                //Create Socket.emit to update projectprog image 
             }else{
                 
             }
    
    
});
$('#BTNsubmitSection').click(function(e){
if (projprogImageSection.length === 0) {
      $('#errorSelectSection').empty();
     $('#errorSelectSection').append('No picture has been checked!');
      // alert('No Selection Has been selected!');
}else{
     $('#errorSelectSection').empty();
}
          for (var i in projprogImageSection){ 
            // alert($('#selectSection_id').val());
             //alert(projprogImageSection[i]);
         $('#sectionName'+projprogImageSection[i]).html('Section: '+$( "#selectSection_id option:selected" ).text());
         $("#checkSection"+projprogImageSection[i]).attr('checked',false);
         socket.emit('Assign Section','projectprog_image','projprogimg_id',$('#selectSection_id').val(),projprogImageSection[i],function(tablename,column_id_name,section_id,projprogimg_id){});     
          }
   projprogImageSection = [];           
});

       
   }else{
          $('#EditPortfolioImages').append('<div id = "ImageCont'+data.projprogimg_id+'"><div id  = "projprogIMG'+data.projprogimg_id+'" style = "display:none" >'+data.projprogimg_id+'</div><div class="col s12 m6 l4"><div class="card white"><div class="card-content black-text"><div class = "right-align" > <button id = "DeleteProjProgImage'+data.projprogimg_id+'"class="btn btn-small red darken-3 white-text">&times</button></div><div class ="left-align"><p><input type="checkbox"   checked = "checked"   id="check'+data.projprogimg_id+'" /><label for="check'+data.projprogimg_id+'">Feature Photo</label></p><p><input type="checkbox"  id="checkSection'+data.projprogimg_id+'" /><label for="checkSection'+data.projprogimg_id+'"><span id = "sectionName'+data.projprogimg_id+'">Section: '+data.section_name+'</span></label></p></div><br><a class = "modal-trigger" href = "index.php?SelectProjectUpdatePicture='+data.projprogimg_id+'"><img style = " width:270px;height:180px;overflow:hidden;" src="'+data.path+'" alt="" class="responsive-img " alt=""></a><div class="row"><div class="input-field col s12"><textarea id  = "projprogimgDescription'+data.projprogimg_id+'" class="" style = "overflow-y:scroll;height:9em"> '+data.description+'</textarea></div></div></div></div></div></div><div id="modal'+data.projprogimg_id+'" class="modal"><div class="modal-content" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt="">   <span class="card-title"><h3>Picture Name</h3></span><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta ratione, aliquid minima autem tempora, dolor impedit quidem tempore dolorem magnam deserunt, illo. Perspiciatis, quia praesentium nihil illo asperiores dolor modi.</p><br><div class = "right-align"><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star_border</i><p class="truncate">Average Rating: 4</p> </div><form id  = "commentForm"><div class="input-field"><input type="text" id=""><label class="active" for="comment">Write a Comment</label></div><div class    = "right-align"><input id = "btnSubmit" type = "submit"  value = "Comment" class = "main-color-bg" ></div> </form><div id = "ShowComments" style = " white-space: initial;"></div></p>  <div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text" style = "margin-left:1em"><span style = "color:blue">Raine Drop</span> Yeah Dawg!!!</p><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div></div>  <div class="chip"><img src="images/yuna.jpg" alt="Contact Person">Jane Doe</div></div><div class="modal-footer"></div></div>');
            
        $('.modal').modal();   
        $("#DeleteProjProgImage"+data.projprogimg_id).click(function(e){
           //  alert(data.projprogimg_id);
             socket.emit('Get DeleteProjProgImage',data.projprogimg_id,function(projprogimg_id){}); 
             $('#ImageCont'+data.projprogimg_id).hide();
        });    
  
$('#check'+data.projprogimg_id).click(function(){
             if(this.checked){
                       socket.emit('Select FeaturePortfolioImages','projectprog_image','projprogimg_id',data.projprogimg_id,"1",function(tablename,column_id_name,portimg_id,featured){});
             }else{
               // alert('HELLO');
                  //alert(data.portimg_id);
                  socket.emit('Select FeaturePortfolioImages','projectprog_image','projprogimg_id',data.projprogimg_id,"0",function(tablename,column_id_name,portimg_id,featured){});
             } 
});
$('#checkSection'+data.projprogimg_id).click(function(){
             if(this.checked){
             
                  projprogImageSection.push(data.projprogimg_id); 
                //alert('HELLO'+data.projprogimg_id);
                //selectSection_id
                //Create Socket.emit to update projectprog image 
             }else{
                 
             }
    
    
});
$('#BTNsubmitSection').click(function(e){
if (projprogImageSection.length === 0) {
      $('#errorSelectSection').empty();
     $('#errorSelectSection').append('No picture has been checked!');
      // alert('No Selection Has been selected!');
}else{
     $('#errorSelectSection').empty();
}
          for (var i in projprogImageSection){ 
            // alert($('#selectSection_id').val());
             //alert(projprogImageSection[i]);
         $('#sectionName'+projprogImageSection[i]).html('Section: '+$( "#selectSection_id option:selected" ).text());
         $("#checkSection"+projprogImageSection[i]).attr('checked',false);
         socket.emit('Assign Section','projectprog_image','projprogimg_id',$('#selectSection_id').val(),projprogImageSection[i],function(tablename,column_id_name,section_id,projprogimg_id){});     
          }
   projprogImageSection = [];           
});

       
   }            
            
            //<img class="materialboxed" data-caption="A picture of a way with a group of trees in a park" width="250" src="https://lorempixel.com/800/400/nature/4">
            
         
     
      
    jQuery('#projprogimgDescription'+data.projprogimg_id).on('input propertychange paste', function() {
    
        for (var i in projprogImages_Description){  
           for (var s in projprogImages_id){    
              //Create Socket.emit for insert image description
socket.emit('InsertProjProgImageDescription',$('#'+projprogImages_id[s]).html(),$("#"+projprogImages_Description).val(),function(projprogimg_id,image_description){
        
         }); console.log('portfolioID'+projprogImages_id[s]+'portfolioImage_Description'+projprogImages_Description[i]);
           }
        
       }    
        
        
    });        
            

/*  //Back up button for button save 
        $('#btnSave').click(function(e){
       
        for (var i in projprogImages_Description){  
           for (var s in projprogImages_id){    
              //Create Socket.emit for insert image description
socket.emit('InsertProjProgImageDescription',$('#'+projprogImages_id[s]).html(),$("#"+projprogImages_Description).val(),function(projprogimg_id,image_description){
        
         }); console.log('portfolioID'+projprogImages_id[s]+'portfolioImage_Description'+projprogImages_Description[i]);
           }
        
       }
           
    });
            */
      
             $('select').material_select();
 
   });
 

    
</script>
<?php 
}
?> 



