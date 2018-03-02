<?php 

if(isset($_GET['importproject'])){
   $project_id  = $_GET['importproject'];
  $user_id = $_SESSION['user_id']; 
  $select_username  = queryMysql("SELECT  username,levels from users where user_iid = '$user_id'");
  $row_select_username  = mysqli_fetch_array($select_username);
  $username =  $row_select_username['username'];
  $user_level    = $row_select_username['levels'];
   
  $select_project  = queryMysql("SELECT  * FROM project_progress left join category on project_progress.category_id = category.category_id  where  projprog_id = '$project_id'");
  $row_project     =  mysqli_fetch_array($select_project);
  $project_name    =  $row_project['name'];
  $project_description  = $row_project['description'];
  $category_name   = $row_project['category_name'];
  $category_id     = $row_project['category_id'];

?>
 <div class = "card-panel">
<div class = "row">
    <div class="input-field col s12">
                    <label>Portfolio Name</label>
                      <input name = "project_name" id = "portname" type="text" class="form-control flow-text" placeholder="Portfolio Name" value = "<?php echo $project_name; ?>">
    </div>

<div class="input-field col s12">
          <textarea  name = "description" id="portdescription" class="materialize-textarea flow text">
    <?php echo $project_description; ?></textarea>
          <label for="textarea1">Description</label>
</div>


<div class = "input-field col s12">
<label>Category</label>
<p class="flow-text"><?php echo $category_name; ?></p>
<div class = "category_id" style = "display:none"><?php echo $category_id;?></div>
</div>
        <br>    
    
     <div  class="right-align">
         <br><br>
    
             </div> 
 </div>
</div>
    <div class = "row" style = "height:50em;overflow-y:scroll">
       <div id = "EditPortfolioImages"></div>
    </div>

  <br><br>
<div class = "right-align">
<a class="waves-effect waves-light btn" id = "btnSubmitPictures">Submit</a>
</div>
<br><br><br><br><br><br>

<div  id  = "project_id" style = "display:none"><?php echo $project_id; ?></div>
<div id =  "pupdate_id" style = "display:none"><?php echo $pupdate_id ;?></div>
          <div id = "user_id" style = "display:none;"><?php echo $user_id; ?></div>
 <div id = "username" style = "display:none;"><?php echo $username; ?></div>
          <div id = "user_level" style = "display:none;"><?php echo $user_level;?></div>
          <div id = "tableName" style = "display:none">projprog_update_comments</div>
          <div id = "comment_id_name" style = "display:none">projprog_update_comment_id</div>
          <div id  = "reference_id_name" style = "display:none">pupdate_id</div>




 

<?php
}
?>
 
<script>
   
        var selectedPictures = [];
        var picturePath      = [];
        var pictureName      = [];  
       
       
       
       socket.emit('Get GalleryProjProgId',$('#project_id').html(),function(projprog_id){});
       socket.on('Set SelectGalleryProjProgImages',function(data){
         //  console.log('Set SelectGalleryProjProgImages ================================');
    //       console.log('projprogimg_id '+data.projprogimg_id);
            $('#EditPortfolioImages').append('<div id = "ImageCont'+data.projprogimg_id+'"><div id  = "projprogIMG'+data.projprogimg_id+'" style = "display:none" >'+data.projprogimg_id+'</div><div class="col s12 m6 l4"><div class="card white"><div class="card-content black-text"><div class = "row"><div class ="right-align"><p><input type="checkbox" id="check'+data.projprogimg_id+'" /><label for="check'+data.projprogimg_id+'"></label></p></div></div><br><div style = "height:15em;width:15em;"><img src="'+data.path+'" alt="" class="responsive-img" style = "width:100%;height:100%" alt=""></div><div class="row"><div class="input-field col s12"></div></div></div></div></div></div>');
       
     
         $('#check'+data.projprogimg_id).click(function(){
             if(this.checked){
        
                 //selectedPictures.push(data.projprogimg_id);
                 picturePath.push(data.path);
                 pictureName.push(data.name);
             } 
         });
       });
        $('#btnSubmitPictures').click(function(){
           
                //alert($('#portname').val());
            //    alert($('#portdescription').val());
              //  alert($('#category_id').val());
         
               socket.emit('Add Portfolio',$('#portname').val(),$('#portdescription').val(),$('#category_id').val(),$('#user_id').html(),$('#project_id').html(),function(portfolio_name,description,category_id,user_id,project_id){
                 
               });
             
            
        var ctr  = 0;
         for (var a  in picturePath){
                console.log("picture name: "+pictureName[a]);
                console.log("picture path: "+picturePath[a])              
           
                socket.emit('Relate PicturesPortfolioToProject',pictureName[a],picturePath[a],function(name,path){});
                   
        
              }            
              window.open('admin_meta_index.php?allportfolio','_self');
           });
 
</script>