<style>
    .summaryAll{
       font-size:25px;
       
    }

</style> 
<?php 
         //select all users 
            $select_count_users="SELECT COUNT(*) as num_row from users where available = 0";
            $run_count_users      = queryMysql($select_count_users);
            $row_count_users = mysqli_fetch_array($run_count_users);
            $total_row_users = $row_count_users['num_row'];
        //select all projects 
            $select_count_project="SELECT COUNT(*) as num_row from project_progress where available = 0";
            $run_count_project      = queryMysql($select_count_project);
            $row_count_project = mysqli_fetch_array($run_count_project);
            $total_row_project = $row_count_project['num_row'];
      //select all portfolios
            $select_count_portfolio ="SELECT COUNT(*) as num_row from portfolio  where available = 0";
            $run_count_portfolio      = queryMysql($select_count_portfolio);
            $row_count_portfolio     = mysqli_fetch_array($run_count_portfolio);
            $total_row_portfolio     = $row_count_portfolio['num_row'];
      //complete projects
             $select_count_proj_comp ="select count(*) as num_row from project_progress left join projectprog_update  on project_progress.projprog_id = projectprog_update.projprog_id where projectprog_update.available = 0 and projectprog_update.percent_d = 100";
            $run_count_proj_comp      = queryMysql($select_count_proj_comp);
            $row_count_proj_comp     = mysqli_fetch_array($run_count_proj_comp);
            $total_row_proj_comp     = $row_count_proj_comp['num_row'];
     //incomplete projects 
           $select_count_proj_incomp ="select count(*) as num_row from project_progress left join projectprog_update  on project_progress.projprog_id = projectprog_update.projprog_id where projectprog_update.available = 0 and projectprog_update.percent_d != 100";
            $run_count_proj_incomp      = queryMysql($select_count_proj_incomp);
            $row_count_proj_incomp     = mysqli_fetch_array($run_count_proj_incomp);
            $total_row_proj_incomp     = $row_count_proj_incomp['num_row'];
      //imported projects 
           $select_count_proj_imp ="select count(*) as num_row from project_progress where imported = 1 ";
            $run_count_proj_imp      = queryMysql($select_count_proj_imp);
            $row_count_proj_imp     = mysqli_fetch_array($run_count_proj_imp);
            $total_row_proj_imp     = $row_count_proj_imp['num_row'];

/*
$select_all_category="SELECT project_progress.name,category.category_name,users.lname,users.fname,project_progress.dated  from project_progress left join projectprog_update on  projectprog_update.projprog_id  = project_progress.projprog_id left join category on project_progress.category_id = category.category_id left join users on project_progress.user_iid = users.user_iid";
                       $run_all_category= queryMysql($select_all_category);
                       while($row_all_category=mysqli_fetch_array($run_all_category)){

  */     
   
?> 
<div class = "card-panel  white-text #d81b60 pink darken-1"> 
    
    
    
    
     <div class  = "row">
            <div class = "center">
                <div class="col s4">
                     <i class="large material-icons">account_circle</i><br>
                      <span class = "summaryAll">Users: </span><span class = "summaryAll"><?php echo $total_row_users; ?></span>
                    <!-- Promo Content 1 goes here -->
                  </div>
                  <div class="col s4">
                      <i class="large material-icons">folder</i><br>   
                      <span class = "summaryAll">Project: </span><span class = "summaryAll"><?php echo $total_row_project; ?></span>
                    <!-- Promo Content 2 goes here -->
                  </div>
                  <div class="col s4">
                      <i class="large material-icons">image</i><br>
                      <span class = "summaryAll">Portfolio: </span><span class = "summaryAll"><?php  echo  $total_row_portfolio; ?></span>
                    <!-- Promo Content 3 goes here -->
                  </div>
            </div>
     </div>
     
          <div class="card #ff4081 pink accent-2">
            <div class="card-content white-text">
              <span class="card-title center"><h4>Project</h4></span>
                <div class = "row">
                     <div class="input-field col s3">
                    <select id = "p_year_dd">
                         
                        <?php             
            $select_count_year_published ="SELECT COUNT(DISTINCT(YEAR(dated)))  as  num_rows   FROM project_progress where available = 0";
            $run_count_year_published      = queryMysql($select_count_year_published);
            $row_count_year_published     = mysqli_fetch_array($run_count_year_published);
            $total_row_year_published     = $row_count_year_published['num_rows'];
               if($total_row_year_published == 0 ){
             ?>
                         <option value="no_projects" disabled selected>No Project Published</option>
            <?php
               }else{
                ?> 
                   <option value="">All</option>
              <?php            
                       $select_year_published ="SELECT DISTINCT(YEAR(dated)) as year_published   FROM project_progress where available = 0";
                       $run_year_published= queryMysql($select_year_published);
                       while($row_year_published=mysqli_fetch_array($run_year_published)){
                         $year_published     = $row_year_published['year_published'];  
                ?>
                        <option value=" AND  YEAR(project_progress.dated) = '<?php echo  $year_published;  ?>' "><?php echo  $year_published;  ?></option>
                <?php 
                       }
               }

                        //count  if there project posted or not 
                        
                        
                          //SELECT DISTINCT(YEAR(dated)) as year_published   FROM project_progress where available = 0
                        
                        // query all date 
                      
                        ?>
                    </select>
                    <label class = "white-text">Select Year</label>
                  </div>
                  <div class="input-field col s3">
                    <select  id = "project_status_dd">
                      <option value= " AND project_progress.current_percent != ' ' ">All</option>
                      <option value= " AND project_progress.current_percent != '100' ">Incomplete</option>
                      <option value=" AND project_progress.current_percent = '100' ">Completed</option>
                      <option value=" AND project_progress.imported = '1' ">Imported</option>
                    </select>
                    <label class = "white-text">Select Project status</label>
                  </div>
                   <div class="input-field col s3">
                    <select id = "p_category_dd">
                      <option value=" project_progress.category_id != ' ' ">All</option>
                          <?php
                       $select_all_category="SELECT * from category ";
                       $run_all_category= queryMysql($select_all_category);
                       while($row_all_category=mysqli_fetch_array($run_all_category)){
                                          $category_id      = $row_all_category['category_id'];
                                          $category_name    = $row_all_category['category_name'];
                        ?>
                        <option value=" project_progress.category_id = '<?php echo $category_id ?>' "><?php echo $category_name; ?></option> 
                      <?php
                        }      
                      ?>
                    </select>
                    <label class = "white-text">Category</label>
                  </div>
                   <div class="input-field col s3" id = "proj_percentage_div">
                    <select id = "proj_percentage_dd">
                      <option value="" disabled selected>Choose your option</option>
                      <option value=" AND project_progress.current_percent != ' ' ">All</option>
                      <option value=" AND project_progress.current_percent = '10' ">10</option>
                      <option value=" AND project_progress.current_percent = '20' ">20</option>
                      <option value=" AND project_progress.current_percent = '30' ">30</option>
                      <option value=" AND project_progress.current_percent = '40' ">40</option>
                      <option value=" AND project_progress.current_percent = '50' ">50</option>
                      <option value=" AND project_progress.current_percent = '60' ">60</option>
                      <option value=" AND project_progress.current_percent = '70' ">70</option>
                      <option value=" AND project_progress.current_percent = '80' ">80</option>
                      <option value=" AND project_progress.current_percent = '90' ">90</option>
                    </select>
                    <label class = "white-text">Select percentage</label>
                  </div>
                </div>
                
     <table  class = "responsive-table white-text">
        <thead>
          <tr>
              <th>Project Name</th>
              <th>Customer Name</th>
           
              <th>Category</th>
              <th>Published Date</th>
              <th>Current Percent</th>
          </tr>
        </thead>

        <tbody  id = "setqueryReport">
        </tbody>
      </table>
            
                
                
                <!-- 
                <div class = "row center">
                    <div class = "col s4">
                          <span class = "summaryAll">Completed: </span><span class = "summaryAll"><?php echo $total_row_proj_comp; ?> </span>
                    </div>
                    <div class = "col s4">
                        <span class = "summaryAll">Incomplete: </span><span class = "summaryAll"><?php echo $total_row_proj_incomp; ?></span>
                    </div>
                    <div class = "col s4">
                        <span class = "summaryAll">Imported: </span><span class = "summaryAll"><?php echo  $total_row_proj_imp; ?> </span>
                    </div>
                </div>
                --><br><br>
                <div class = "right">
                    <a id = "queryProReports" class="waves-effect waves-light btn #f8bbd0 pink lighten-4">Submit</a>
                 </div>
                <div class = "clearfix">
                </div>

            </div>
          </div>
    
    
    
         <div class="card #ff4081 pink accent-2" style = "height:30em;overflow-y:hidden;overflow-y:scroll">
            <div class="card-content white-text">
              <span class="card-title center"><h4>Select Featured Portfolios</h4></span>
               <div class = "row">
            <?php
                 $select_all_content="select * from portfolio left join category on portfolio.category_id = category.category_id left join users on  portfolio.user_iid = users.user_iid   where  portfolio.available = 0 ";//sau sau sau
                 $run_all_content= queryMysql($select_all_content);
                  while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $projprog_id      = $row_all_content['portfolio_id'];
                          $name             = $row_all_content['name'];
                          $post_date        = $row_all_content['dated'];
                          $category_name    = $row_all_content['category_name'];
                          $category_id      = $row_all_content['category_id'];
                          $username         = $row_all_content['username'];
                          $featured         = $row_all_content['featured'];
               
                     if($featured  == 0){
                        $check_status  = "";
                     }else{
                        $check_status = "checked";
                     }
            ?>
                
                <div class = "col  s6" id = "projectProgressDiv<?php echo $projprog_id; ?>" >
<div class = "card-panel "  >
 <?php
          if($logged_in_user_level == "Client"){
              
          }else{
 ?> 
     <div class = "right">
         
                  <input <?php  echo $check_status; ?> class = "featuredProject"  value = "<?php echo $projprog_id; ?>" type="checkbox" id="Project<?php echo $projprog_id; ?>" />
                  <label for="Project<?php echo $projprog_id; ?>"></label>
                 <a class='dropdown-button  ' href='#' data-activates='allport<?php echo $projprog_id;?>'><i class="material-icons">more_vert</i></a>

                  <!-- Dropdown Structure -->
                  <ul id='allport<?php echo $projprog_id;?>' class='dropdown-content'>
                      <div class = "clearfix"></div>
                    <li><a href="index.php?Portfolio=<?php echo $projprog_id;?> ">Edit</a></li>
                    <li><a  onclick = "deleteProject('<?php echo $projprog_id; ?>','<?php echo $name; ?>')">Delete</a></li>
                  
                  </ul>
                
            </div>
    
<?php   
          }
         ?> 
    

          
            
     <div class = "clearfix"></div>
<div class = "row" >
    <div class = "col s12 projectProgressCard"  >
     <!-- Image Carousel Start  -->
          
         <?php 
             if($logged_in_user_level == "Client"){
         ?>
         <a  href = "ClientMainPage.php?ClientViewPortfolio=<?php echo $projprog_id;?>">View Project</a> 
        <?php
             }else{
        ?>
          <a  href = "index.php?ClientViewPortfolio=<?php echo $projprog_id;?>">View Project</a> 
        <?php 
             }
          ?> 
            
         
         
        
    <br> 
           <div  class="carousel carousel-slider center" data-indicators="true" >
        <?php 
            $select_count_ftPictures="SELECT COUNT(*) as num_row from portfolio left join portfolio_images  on portfolio_images.portfolio_id = portfolio.portfolio_id where portfolio_images.featured = 1 and portfolio.portfolio_id = $projprog_id";
            $run_count_ftPictures= queryMysql($select_count_ftPictures);
            $row_count_ftPictures=mysqli_fetch_array($run_count_ftPictures);
            $total_row_ftPictures=$row_count_ftPictures['num_row'];
           if ($total_row_ftPictures  == 0 ){
               echo $total_row_ftPictures;
           ?>
           <div    class="carousel-item" href="">
                   <img  style = "height:100%;width:100%;" class=" carousel_dim responsive-img " src="no_feature_pictures.png">
            </div>    
        <?php
           }else{
               echo $total_row_ftPictures;
         $select_all_feature_pictures  = "SELECT * from portfolio left join portfolio_images  on portfolio_images.portfolio_id = portfolio.portfolio_id where portfolio_images.featured = 1 and portfolio.portfolio_id = $projprog_id";
          $run_all_feature_pictures= queryMysql($select_all_feature_pictures);
          while($row_all_feature_pictures = mysqli_fetch_array($run_all_feature_pictures)){
                          $feature_path      = $row_all_feature_pictures ['path'];
                          $feature_id        = $row_all_feature_pictures ['portimg_id'];
             
         ?> 
           <div class="carousel-item" href="#<?php echo $feature_id; ?>"  >
                   <img class=" carousel_dim responsive-img "   src="<?php echo $feature_path; ?>">
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
                  
                      <br><span style = "color:grey"><?php echo $post_date; ?></span><br>
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
            <?php       
                }
            ?>
             </div>
            </div>        
          </div>
<div class = "right">
    <a id = "submitBTN"class="waves-effect waves-light btn #f8bbd0 pink lighten-4">Submit</a>
</div><div class = "clearfix"></div>

</div>
 
<script>
$('#submitBTN').click(function(){
      $('input.featuredProject:checkbox:checked').each(function () {
            var sThisVal = $(this).val();
           socket.emit('update featuredProject',sThisVal,1,function(project_id,featured_status){});
     });
    $('input.featuredProject:checkbox:not(:checked)').each(function () {
            var sThisVal = $(this).val();
          socket.emit('update featuredProject',sThisVal,0,function(project_id,featured_status){});

     });
});
//Query Project Reports
  socket.emit('query  allProjectReports');
    /*
  socket.emit('get allProjectReports',{name:name,category_name:category_name,publisher:publisher,dated:dated,projprog_id,customer:customer}); 
    */
  socket.on('get allProjectReports',function(data){
         $.getScript("js/form_validations.js",function(){  
            var convertedDate =  convertDateTime(data.dated);
        
          $('#setqueryReport').append('<tr><td ><a class = "white-text" href = "index.php?ClientViewProject='+data.projprog_id+'">'+data.name+'</a></td><td>'+data.customer+'</td><td>'+data.category_name+'</td><td>'+convertedDate+'</td><td>'+data.current_percent+' %</td><</tr>');
         });
  });
  $('#queryProReports').click(function(){
           $('#setqueryReport').empty(); 
       var  fullquery;
        if($("#project_status_dd :selected").val() == "" &&
            $("#proj_percentage_dd :selected").val() == "" &&
            $("#p_year_dd :selected").val() == "" &&
             $("#p_category_dd  :selected").val() == ""
            ){
             
           }else{
                if($("#project_status_dd :selected").text() == "Completed"||
                $("#project_status_dd :selected").text() == "Imported"  ){
                      fullquery  = "WHERE  "+$("#p_category_dd :selected").val()+$("#p_year_dd :selected").val()+$("#project_status_dd  :selected").val()+" AND project_progress.available = 0";
                      socket.emit('query wProjFilter',fullquery,function(fullquery){ });                 
                }else{
                    fullquery  = "WHERE  "+$("#p_category_dd :selected").val()+$("#project_status_dd :selected").val()+$("#p_year_dd :selected").val()+$("#proj_percentage_dd  :selected").val()+" AND project_progress.available = 0";
                      socket.emit('query wProjFilter',fullquery,function(fullquery){ });
                  
                    
                }
             //open where clause 
          
           }
        
  });
    
   
$(document).ready(function(){
        $("#project_status_dd").change(function(){
    
         
           if($("#project_status_dd :selected").text() == "Completed"||
              $("#project_status_dd :selected").text() == "Imported"  ){
              $('#proj_percentage_div').hide();
        
           }else{
              $('#proj_percentage_div').show();
         }
     });
});

  
 

</script>