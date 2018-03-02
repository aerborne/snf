<style>
.carousel_dim{
      width:40em!important;
      height:20em!important;
}
    .descriptionStyle{ 
      height:30em!important;
      overflow-y:hidden!important;
      overflow-y:scroll!important;
} 
</style>

<?php 
 

$url_ref = array ();
$filters = array (); 
$project_name = array ();
 
  if (isset($_GET['category']) && !empty($_GET['category'])) {
      $category_value = $_GET['category'];
      $filters['project_progress.category_id'] = $category_value;   
      $url_ref['category'] = $category_value;
  }else{
      $category_value = "";
  }
  if (isset($_GET['date']) && !empty($_GET['date'])) {
        $date_value = $_GET['date'];
        $filters['rdate'] = $date_value;
        $url_ref['date'] = $date_value; 
  }
  if (isset($_GET['name']) && !empty($_GET['name'])) {
        $name_value = $_GET['name'];
        $arr =  explode(" ", $name_value);
        $ctr = 0; 
        $project_nameEntered = "";
        foreach($arr as $v){
             $project_name['name'.$ctr] = $v;  
             $project_name['name'.$ctr] = $v;
        $ctr++;
           $project_nameEntered .= $v." ";
        }
        $name_value = str_replace(' ', '+', $name_value);
        $url_ref['name'] = $name_value;   
  }else{
      $category_nameEntered = "";
  } 
$arrNameSize  = sizeof($project_name); 
$arrFilterSize = sizeof($filters);
$url_refSize = sizeof($url_ref);
$filterCollection  = "";
$url_format_collection = collectionStructure($filterCollection,$url_ref,"=","&","","");
 
$multi_collections = "";
if ($url_refSize == 0 ){ 
   
}else if ($arrFilterSize != 0 && $arrNameSize != 0){
    $multi_collections = " AND ".collectionStructure($filterCollection,$filters,"= '"," AND ","' ","")."  AND (".collectionStructure($filterCollection,$project_name," LIKE  '"," OR ","%'","category_name").")" ;
}else if ($arrFilterSize == 0){
     $multi_collections =  "AND ".collectionStructure($filterCollection,$project_name," LIKE  '"," OR ","%'","category_name");
}else if ($arrNameSize == 0){
    $multi_collections =  "AND ".collectionStructure($filterCollection,$filters,"= '"," AND ","' ","");
}
if(isset($_GET['allprojectpage'])){
    $current_page=$_GET['allprojectpage'];

    }else{

      $current_page=1;
      }
  $previous_page=$current_page - 1;
  $next_page=$current_page + 1;
  $user_id   = $_SESSION['user_id'];
//Do a a where clause for categories create a new php script for selection
  $per_page=10;
  $start=($current_page - 1) * $per_page;
 if($start < 0){
     $start  = 0;
 }
 $select_all_content="select SQL_CALC_FOUND_ROWS  project_progress.projprog_id,project_progress.name,category.category_name,category.category_id,users.username,project_progress.dated,project_progress.available  FROM project_progress left join category on  project_progress.category_id = category.category_id left join users on project_progress.user_iid = users.user_iid WHERE project_progress.available = 0   $multi_collections order by projprog_id  DESC limit $start, $per_page  ";//sau sau sau
 //echo "per page".$per_page;
 //echo "start".$start;
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from project_progress  WHERE project_progress.available = 0 $multi_collections";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);

?> 

 <div id  = "levels_value" style = "display:none"><?php echo $category_value;?></div>

 <div class="row">
          <div class="col s12 m12" >
                   
            
             
 
        
        <!-- 

 CREATE A SELECT ON WHERE THE OPTION IS SELECTED
  -->
     <div class = "row">
        <div class = "col s3">
            <a class='dropdown-button btn #ec407a pink lighten-1 ' href='#' data-activates='dropdown1'>SELECT CATEGORY</a>
          <ul id='dropdown1' class='dropdown-content'>
               <li><a href="admin_meta_index.php?allprojectpage">All</a></li>
                <?php 
               $select_project_category = "SELECT * FROM category where available = 0 "; 
               $run_select_project_category = queryMysql($select_project_category); while($select_category=mysqli_fetch_array($run_select_project_category)){
                 $category_name = $select_category['category_name'];
                 $category_id   = $select_category['category_id']; 
              ?> 
            <li><a href="admin_meta_index.php?allprojectpage&category=<?php echo $category_id ?>"><?php echo strtolower($category_name); ?></a></li>
              <?php 
               } 
              ?> 
          </ul>  
          </div> 
           <div class = "col s9">
            <div class = "row">
                <div class = "col s10">
                    <input id = 'SearchKeyword'  type = "text" class = "form-control" value = "">
                    <p id = "SearchKeywordResult" style = "position:absolute"></p>
                </div>
                 <div class = "col s2">
                    <input id = "submit" type = "submit" class = "btn #ec407a pink lighten-1 " value =  "Search">
                </div>
            </div>  
         </div>
     </div>
              <div class = "row">
              <?php
    while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $projprog_id      = $row_all_content['projprog_id'];
                          $name             = $row_all_content['name'];
                          $post_date        = $row_all_content['dated'];
                          $category_name    = $row_all_content['category_name'];
                          $category_id      = $row_all_content['category_id'];
                          $username         = $row_all_content['username'];
                       
    ?>

<div class = "col  s12 m12 l6" id = "projectProgressDiv<?php echo $projprog_id; ?>" > 
<div class = "card-panel " >
           <div class = "right">
               <a class='dropdown-button  ' href='#' data-activates='asdasd<?php echo $projprog_id; ?>'><i class="material-icons">more_vert</i></a>

                  <!-- Dropdown Structure -->
                  <ul id='asdasd<?php echo $projprog_id; ?>' class='dropdown-content'>
                      <div class = "clearfix"></div>
                    <li><a href="admin_meta_index.php?project-updates=<?php echo $projprog_id;?>">Edit</a></li>
                    <li><a  onclick = "deleteProject('<?php echo $projprog_id; ?>','<?php echo $name; ?>')">Delete</a></li>
                  
                  </ul>
            </div>
            
     <div class = "clearfix"></div>
<div class = "row" >
    <div class = "col s12 projectProgressCard" >
     <!-- Image Carousel Start  -->
          
              <a  href = "admin_meta_index.php?clientviewproject=<?php echo $projprog_id;?>">View Project</a> 
         
         
        
    <br> 
           <div  class="carousel carousel-slider center" data-indicators="true">
        <?php 
            $select_count_ftPictures="SELECT COUNT(*) as num_row FROM  project_progress  left join projectprog_update  on project_progress.projprog_id = projectprog_update.projprog_id left join projectprog_image on projectprog_image.pupdate_id = projectprog_update.pupdate_id where project_progress.projprog_id  = $projprog_id  and projectprog_image.featured = 1";
            $run_count_ftPictures= queryMysql($select_count_ftPictures);
            $row_count_ftPictures=mysqli_fetch_array($run_count_ftPictures);
            $total_row_ftPictures=$row_count_ftPictures['num_row'];
           if ($total_row_ftPictures  == 0 ){
           ?>
           <div class="carousel-item" href="">
                   <img class=" carousel_dim responsive-img " src="no_feature_pictures.png">
            </div>    
        <?php
           }else{
         $select_all_feature_pictures  = "SELECT projectprog_update.pupdate_id,path,projprogimg_id FROM  project_progress  left join projectprog_update  on project_progress.projprog_id = projectprog_update.projprog_id left join projectprog_image on projectprog_image.pupdate_id = projectprog_update.pupdate_id where project_progress.projprog_id  = $projprog_id  and projectprog_image.featured = 1";
          $run_all_feature_pictures= queryMysql($select_all_feature_pictures);
          while($row_all_feature_pictures = mysqli_fetch_array($run_all_feature_pictures)){
                          $feature_path      = $row_all_feature_pictures ['path'];
                          $feature_id        = $row_all_feature_pictures ['projprogimg_id'];
             
         ?> 
           <div class="carousel-item" href="#<?php echo $feature_id; ?>">
                   <img class=" carousel_dim responsive-img " src="<?php echo $feature_path; ?>">
            </div>
             
        
        <?php 
           }
                 }
        ?> 
        
        
        
         
          
          </div>
        <!-- Image Carousel End  -->
        <br>
           <div style = "padding-left:1em">
          <div class = "row">
                    <div class ="col s6">
                              <span class="black-text" style = "font-weight:bold">ProjectName:</span>  
                      <br><span  id  = ""   style = "color:grey"><?php echo $name; ?></span>
                    </div>
                   <div class ="col s6">
                        <span class="black-text" style = "font-weight:bold">Registered Date:</span> 
                  
                      <br><span   class = "post_date" style = "color:grey"><?php echo convertDateTime($post_date) ; ?></span><br>
                       
                       
                        
                    </div>
                     <div class ="col s6">
                        <span class="black-text" style = "font-weight:bold">Published By:</span> 
                  
                      <br><span style = "color:grey"><?php echo $username; ?></span><br>
                    </div>
                    <div class ="col s6">
                        <span class="black-text" style = "font-weight:bold">Category:</span> 
                  
                      <br><span style = "color:grey"><?php echo $category_name; ?></span><br>
                    </div>
            </div>
                
               
                 
                   
          </div>
    </div>
    

</div>
    </div>
</div>
    
     <?php }?>
     </div>
    <script> 
        
 
        
        
        
 function deleteProject(projprog_id,project_name){
var answer = confirm('Are you sure you want to delete '+project_name+' ?');
if (answer)
{
      socket.emit('Delete Project',projprog_id,'project_progress','projprog_id',function(projprog_id,tablename,column_id_name){}); 
      $('#projectProgressDiv'+projprog_id).hide();
}
else
{
 
}
 }
  $(document).ready(function() {
      
      
    $('select').material_select();
          $.getScript("js/form_validations.js",function(){  
           Keypress_F('SearchKeyword','LettersOnly');
    });
     $(document).keypress(function (e) {
    if (e.which == 13) {
         if($('#url_format_collection').html() == ""){
                    var keywordEntered = $('#SearchKeyword').val() ;
                    keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                  window.location.replace('admin_meta_index.php?allprojectpage'+'&name='+keywordEntered); 
                }else{
                        var keywordEntered = $('#SearchKeyword').val() ;
                       keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                    window.location.replace('admin_meta_index.php?allprojectpage&category='+$('#levels_value').html()+'&name='+keywordEntered);
                }
    }});
      
              
               $('#submit').click(function(e){
                   // alert($('#url_format_collection').html());
                if($('#url_format_collection').html() == ""){
                    var keywordEntered = $('#SearchKeyword').val() ;
                    keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                  window.location.replace('admin_meta_index.php?allprojectpage'+'&name='+keywordEntered); 
                }else{
                        var keywordEntered = $('#SearchKeyword').val() ;
                       keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                    window.location.replace('admin_meta_index.php?allprojectpage&category='+$('#levels_value').html()+'&name='+keywordEntered);
                }
         
              });
      
  });
</script>             
              
              
<center>
 
  <ul class="pagination">
 
    <li><a href="admin_meta_index.php?allprojectpage=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='admin_meta_index.php?allprojectpage=$previous_page'&$url_format_collection aria-label='Previous'>
        <span aria-hidden='true'>&laquo;</span>
      </a>
    </li>";
     }
   ?>
     <?php
   //for($i=1; $i<=$last_page; $i++){
   for($i=$current_page -2; $i <=$current_page+2; $i++){//5sau
   if($i > 0 && $i <= $last_page){//5sau
     if($current_page != $i){// 4 sau
     echo "<li><a href='admin_meta_index.php?allprojectpage=$i'&$url_format_collection>$i</a></li>";
     }else{
     echo "<li><span class='active_page'>$i</span></li>";
     }
   }
 }
   ?>
      <?php
   if($current_page==$last_page){
    // echo "Next";
     }else{
     echo "  <li>
      <a href='admin_meta_index.php?allprojectpage=$next_page&$url_format_collection' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="admin_meta_index.php?allprojectpage=<?php echo $last_page; ?>">Last</a></li>
 
    
 
  </ul>
 
    
    </center>
    <br><br>              