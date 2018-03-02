<!DOCTYPE html>
<!--- PHP  Pagination Script -->

<?php
if(isset($_GET['AllProjectpage'])){
    $current_page=$_GET['AllProjectpage'];

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
//echo 'startssss'. $start;
  $select_all_content="select SQL_CALC_FOUND_ROWS  project_progress.projprog_id, project_progress.name,category.category_name,category.category_id,users.username,project_progress.dated,project_progress.available  FROM project_progress left join category on  project_progress.category_id = category.category_id left join users on project_progress.user_iid = users.user_iid  where project_progress.available = '0'  order by projprog_id  DESC limit $start, $per_page  ";//sau sau sau
   
 //echo "per page".$per_page;
 //echo "start".$start;
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from project_progress  where available = 0";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);// di xuong duoi div id= page
  // het sau sau sauz
?>


<div class = "row">

 
 <div class=" col s12">
      <div class="card-panel #9c27b0 purple">
     
       <a href="index.php?DeletedProject" class="btn main-color-bg  btn-block">Deleted Items</a>
            <br>
         
            <div class = "row">
                <div class = "col s8 m9 l10">
                    <input id = 'SearchKeyword' type = "text" class = "white-text">
                    <p  style = "position:absolute" id = "SearchKeywordResult"></p>
                </div>
                    
                <div class = "col s2 m3 l2">
                        <input id = "submit" type = "submit" class = "btn" value =  "Search">
                </div>
                </div>
                     
                
              
                 <table class="bordered white-text">
                <tr><th>Project</th><th>Category</th><th>Published By:</th> <th>Options</th></tr>
                      <?php
                          while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $projprog_id      = $row_all_content['projprog_id'];
                          $name             = $row_all_content['name'];
                          $post_date        = $row_all_content['dated'];
                          $category_name    = $row_all_content['category_name'];
                          $category_id      = $row_all_content['category_id'];
                          $username         = $row_all_content['username'];
                           
                       ?>
                      <tr>
                          <td> <a class = "white-text" href="index.php?Project/Updates=<?php echo $projprog_id;?>"><?php echo $name; ?></a></td>
                          <td><?php  echo $category_name; ?></td>
                          <td><?php echo $username ?></td>
                        
                          <td>
             <?php
                          $select_count="select COUNT(*) as num_row from project_progress  where projprog_id = '$projprog_id' and user_iid = '$user_id'";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);                            
$total_row=$row_count['num_row'];                     
if($total_row == 1){
                          ?>                           
                 <a class="btn btn-default" href="index.php?EditProject=<?php echo $projprog_id;?>&pcat=<?php echo $category_id;?>"><i class='large material-icons'>border_color</i></a> 
                    <!--- Delete  Button--> 
        <input type="button" class = " btn #e57373 red lighten-2 " onclick="ConfirmDelete(<?php echo $projprog_id;?>,'<?php echo $name;?>')" value="&times">
        <script type="text/javascript">
             function ConfirmDelete(project_id,projectname){
                    if (confirm("Delete ? "+projectname)){
                        location.href='index.php?DeletePro='+project_id;
                   }else {
                       
                       
                       
                   }
             }
         </script>  
             <?php
               }else{
    ?>
                              <a class="btn btn-default disabled"  style="cursor:not-allowed" href="index.php?EditProject=<?php echo $projprog_id;?>&pcat=<?php echo $category_id;?>">Edit</a> 
                              <input type="button" class = "btn #e57373 red lighten-2  disabled"    style = "cursor:not-allowed"  value="Delete">
<?php
    
}                     
              ?>

                              
                              
                 </td>
                      </tr>
                      <?php }?>
                    </table>
    
     
           

  

<script src = "../js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
       
    <script>
          $(document).ready(function(){
        var socket  = io.connect('http://localhost:3100');
    socket.on('Searched Project',function(data){
            if( $('#SearchKeyword').val().trim() == '' ) {
                $('#SearchKeywordResult').empty();
            }else{
               $('#SearchKeywordResult').append('<a  href="index.php?Project/Updates='+data.projprog_id+'" class="list-group-item black-text" style = "background-color:white">'+data.name+'</a><br>');
         
            }       
    });
    $('#submit').click(function(e){
                $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordProject',$('#SearchKeyword').val(),"0",function(keyword,available){});
        
        });
              jQuery('#SearchKeyword').on('input propertychange paste', function() {
                   $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordProject',$('#SearchKeyword').val(),"0",function(keyword,available){});
            });
              
          
});
        




</script>


    </div>

  </div>
    </div>

<br>
     
<center>
 
  <ul class="pagination">
 
    <li><a href="index.php?AllProjectpage=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='index.php?AllProjectpage=$previous_page' aria-label='Previous'>
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
     echo "<li><a href='index.php?AllProjectpage=$i'>$i</a></li>";
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
      <a href='index.php?AllProjectpage=$next_page' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="index.php?AllProjectpage=<?php echo $last_page; ?>">Last</a></li>
 
    
 
  </ul>
 
    
    </center>
    <br><br>