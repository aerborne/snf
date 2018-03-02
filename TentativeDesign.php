<?php
if(isset($_GET['project-updates'])){
     
            $projprog_id=$_GET['project-updates'];
    $user_id = $_SESSION['user_id'];
    $select_userInformation  = queryMysql("SELECT * from users where user_iid='$user_id'");
    $row_users   = mysqli_fetch_array($select_userInformation);
    $username    = $row_users['username'];
    $user_level  = $row_users['levels']; 
    
  
    $restriction_result  = queryMysql("SELECT COUNT(projprog_id) as rows_results FROM project_progress where projprog_id = '$projprog_id'  and available = 0  and user_iid = '$user_id'");
    $restriction_result_fetch  =   mysqli_fetch_array($restriction_result);
   $restriction_row_result    =  $restriction_result_fetch['rows_results']; 
    
?>
<div id = "user_id"  style = "display:none"><?php echo $user_id; ?></div>
<div  id  = "project_id" style = "display:none"><?php echo $projprog_id; ?></div>
 <div id = "username" style = "display:none;"><?php echo $username; ?></div>
          <div id = "user_level" style = "display:none;"><?php echo $user_level;?></div>
          <div id = "tableName" style = "display:none">projprog_update_comments</div>
          <div id = "comment_id_name" style = "display:none">projprog_update_comment_id</div>
          <div id  = "reference_id_name" style = "display:none">pupdate_id</div>

<div class="jumbotron text-center">
      <div class="container">
    <?php 
      //Selecting Project Name 
      $project_name = queryMysql("SELECT   project_progress.category_id,name,description,category_name from project_progress left join category on project_progress.category_id = category.category_id   where projprog_id = '$projprog_id' ");
      $select_name = mysqli_fetch_array($project_name);
      $pname  =   $select_name['name'];
      $description = $select_name['description'];
      $current_category_name   = $select_name['category_name'];
      $current_category_id   = $select_name['category_id'];
      $availability_result = queryMysql("SELECT COUNT(projprog_id) as rows   FROM project_progress where projprog_id =  '$projprog_id' and available = 0 ");
      $row_availability = mysqli_fetch_array($availability_result);
      $availability_result = $row_availability['rows'];
    
if ($availability_result == 0){
    
}else{    
    ?> 
     
          
  
  
          
          
          
    <div class="row">
        <div class="col s12 m10">
          <div class="card white darken-1">
            <div class="card-content  #ff5252 red accent-2 white-text">
                <div class = "right-align">
                 <a href = "#EditProjectModal" class="waves-effect waves-light  modal-trigger" style = "color:white;background-color:#ff5252 red accent-2"><i class="material-icons">create</i></a> 
                </div>
                <div class = "row">
                     <div class = "col s6">
                            Project Name:<span id = "displayProjectName" class="card-title"><?php  echo $pname?></span>
                     </div>
                     <div class = "col s6">
                            Category:<span  id = "displayCategoryName" class="card-title"><?php  echo   $current_category_name;?></span>
                     </div>
                    <div class = "col s12">
                       <div class = "left">
                        <span style = "font-size:20px">Description:</span>
                        </div>
                        <div class = "clearfix"></div>
                       <p style = "margin-left:4em;word-wrap: break-word;font-size:15px" id = "displayDescription" class = "flow-text"> <?php echo $description; ?></p>
                    </div>
                </div>
                      
            
            </div>
              
              <!-- Modal Structure -->
  <div id="EditProjectModal" class="modal" >
    <div class="modal-content" style = "height:20em">
       
  
        <div class="input-field col s12">
          <input  id="project_name" type="text" class="validate" value = "<?php  echo $pname; ?>">
          <label for="project_name">Project Name</label>
        </div>
          <div class="input-field col s12">
          <textarea id="EditPdescription" class="materialize-textarea"><?php  echo $description; ?></textarea>
          <label for="EditPdescription">Description</label>
        </div>
             <div class="input-field col s12">
                <select id  = "category_selection">
                    <option value="<?php echo $current_category_id; ?>"><?php echo $current_category_name; ?></option>
                  <?php 
    
                      $select_all_category = "SELECT * FROM `category` WHERE category_id != '$current_category_id'"; 
                      $run_select_all_category = queryMysql($select_all_category);
                      while($select_category = mysqli_fetch_array($run_select_all_category)){
                           $category_name =  $select_category['category_name'];
                           $category_id = $select_category['category_id'];
                  ?>
                    <option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
                  <?php
                      }
                  ?> 
                </select>
                <label>Category</label>
            </div>
        
         <div class = "right-align">
            <a  id = "EditProject"class="waves-effect waves-light btn modal-close">Save</a>
          </div>
    </div>
   <br><br><br><br><br><br>
  </div>
            <div class="card-action">
       <?php 
           //Checking if the project is completed
            $percent_all=queryMysql(" SELECT * FROM projectprog_update where projprog_id = '$projprog_id' AND available = '0'  ORDER BY pupdate_id DESC LIMIT 1");
            $row = mysqli_fetch_array($percent_all);
            $input =  $row['percent_d'];
           if ($input == 100){
              echo "<center style = 'color:green;'><h3>Project Completed</h3></center>";
             $import_status = queryMysql("SELECT COUNT(*) as import_status_result FROM project_progress  where projprog_id = '$projprog_id'  and imported = 0  limit 1");
             $row_import_status = mysqli_fetch_array($import_status);
             $import_status_result =  $row_import_status['import_status_result'];
               if($import_status_result == 0){
                    echo "<div class  = 'center-align'><a href = 'admin_meta_index.php?importproject=$projprog_id' class='waves-effect waves-light btn disabled'>Imported to Portfolio</a></div><br>";
               }else{
                    echo "<div class  = 'center-align'><a href = 'admin_meta_index.php?importproject=$projprog_id' class='waves-effect waves-light btn'>Import to Portfolio</a></div><br>";
               }
               
               
           }else{
        ?>
<?php
     if($restriction_row_result  == 0){
         
     }else{     
?> 
   
            <div class = "form-group">
                <a href="admin_meta_index.php?ppuj=<?php echo $projprog_id; ?>" class="btn main-color-bg  btn-block">Add Project Update</a>
          
             </div>
                
 
                
<?php
     }          
?>          
          <br>
          <div class = "row">
        <?php 
        } 
            //Check if there are any updates 
            $check_updates =  queryMysql("SELECT COUNT(pupdate_id) as updates FROM projectprog_update where projprog_id = '$projprog_id' AND available = '0' ");
            $row = mysqli_fetch_array($check_updates);
            $updates = $row['updates'];
            if($updates == 0 ){
               echo "<h3></br></br><center>No  Project Update/s</center></h3>";
             }else{
            
             // echo $projprog_id;
                //Create query for the latest updates
                
            $latest_updates =  queryMysql("SELECT   *  FROM projectprog_update  where projprog_id = '$projprog_id' AND available = '0'  order by pupdate_id desc limit 1");
            $row_latest_updates = mysqli_fetch_array($latest_updates);
            $update_id = $row_latest_updates['pupdate_id'];
            
                
             ?>
              
             
              <div class = "center-align">
              <form name = "PercentForm">
                  
                       <?php
                        $i=0;
                        $selected_project = queryMysql("SELECT * FROM projectprog_update WHERE projprog_id = '$projprog_id' AND available = '0'  ");
                        $ctrRep = 0;
                        $ctrComment = 0;
                        while($row=mysqli_fetch_array($selected_project)){
                            $pupdate_id           =    $row['pupdate_id'];
                            $percent              =    $row['percent_d'];
                       ?>
                   
                
     <div class = "row">
         <div class = "col s6  ">
        <a href="index.php?SelectUp=<?php echo $pupdate_id; ?>" class="collection-item"><div class = "center-align"><span style = "font-size:2em;color:purple"><?php echo $percent; ?>%</span></div></a>
             
        </div>
              
                       <?php
                            $select_xmark=queryMySql(" SELECT * FROM projectprog_update where projprog_id = '$projprog_id' and available = '0' ORDER BY pupdate_id DESC LIMIT 1");
                            $row_select_xmark = mysqli_fetch_array($select_xmark);
                            ?>
                               
                             <?php
                              if($row_select_xmark['percent_d'] > $percent){
                               ?>
                                 <div class = "col s3">
                                   <div class = "right-align">
                                   
                                    <p class="text-left text-capitalize">
                                   <input type="button" class = "btn   red " disabled="disabled" style = "background-color:grey; cursor:not-allowed;" onclick="ConfirmDelete(<?php echo $pupdate_id;?>,<?php echo $projprog_id;?>)" value="Delete">
                                    </p>
                                   </div>   
                                 </div> 
                                  
                                <?php
                              }else if($row_select_xmark['percent_d'] == "100"){
                                ?>
                                  <input type="button" class = "btn   red " disabled="disabled" style = "background-color:grey; cursor:not-allowed;" onclick="ConfirmDelete(<?php echo $pupdate_id;?>,<?php echo $projprog_id;?>)" value="Delete">
                            <?php 
                                  
                              }else{
                                  
                                   if($restriction_row_result  == 0){
                                   }else{ 
                              ?>      <!-- DELETE BUTTON -->
                                <div class = "col s3">
                                    <div class = "right-align">
                                    
                                    <p class="text-left text-capitalize">
                                   <input type="button" class = "btn  red" onclick="ConfirmDelete(<?php echo $pupdate_id;?>,<?php echo $projprog_id;?>)" value="Delete">
                                    </p>
                                        </div>
                                 </div> 
                                 
                                    <script type="text/javascript">

                                         function ConfirmDelete(deleteupdate,project_id){
                                                if (confirm("Delete?")){
                                                    location.href='index.php?DeletePPU='+deleteupdate+'&Proj='+project_id;
                                               }else {

                                               }
                                         }
                                     </script>
                            <?php
                                   }
                            }
                             ?>
                        </div> 
                  
                        <?php 
                        }
                       ?>
             
                
          
              </form>
                </div>
          </div>   
               </div>
          </div>
        </div>
      </div>
          
      </div>
    </div>
<?php
                    
}
 }
}
?>
 
<script src = "http://localhost:3100/socket.io/socket.io.js"></script> 
<script>
   $(document).ready(function(){
          var socket = io.connect('http://localhost:3100'); 
       socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),$('#project_id').html(),'projprog',$('#tableName').html(),$('#comment_id_name').html(),$('#reference_id_name').html());
       
      $('#EditProject').click(function(){
             //alert("The selected category "+$('#category_selection').val());
            socket.emit('Get EditedDescriptions',$('#project_id').html(),$('#EditPdescription').val(),"project_progress","projprog_id",$('#project_name').val(),$('#category_selection').val(),function(portfolio_id,description,tablename,columnIdName,projectName,category_id){});
       
       }); 
       socket.on('Set EditedDescriptions',function(data){
               $('#displayProjectname').html(data.projectName);
               $('#displayDescription').html(data.description); 
               $('#displayCategoryName').html(data.category_name);        
       }); 
       
   });
</script>

