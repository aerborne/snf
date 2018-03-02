<!DOCTYPE html>
<!--- PHP  Pagination Script -->

<?php
if(isset($_GET['DeletedPortfolio'])){
    $current_page=$_GET['DeletedPortfolio'];


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
 //echo
  $select_all_content="select SQL_CALC_FOUND_ROWS  portfolio.portfolio_id,users.username,portfolio.name,category.category_name,category.category_id,portfolio.dated,portfolio.available  FROM portfolio left join category on  portfolio.category_id = category.category_id left join users on portfolio.user_iid = users.user_iid  where portfolio.available = '1'    order by portfolio.portfolio_id DESC LIMIT $start,$per_page ";//sau sau sau
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from portfolio left join users on portfolio.user_iid = users.user_iid where portfolio.available = 1  ";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);// di xuong duoi div id= page
  // het sau sau sau
?>

<div class = "row">


 <div class="col s12 well" style = "position:relative;height:50em;width:50em;">
           
            <br>
 
            <div class = "form-group">
                    <input id = "submit" style = 'margin-left:49em; position:absolute'type = "submit" class = "btn" value =  "Search">
                    <input id = 'SearchKeyword' style = "width:49em"type = "text" class = "form-control">
                    <p id = "SearchKeywordResult" style = "position:absolute"></p>
                </div>
                 <table class="table table-striped table-hover table-bordered table-condensed">
                 <tr><th>Project</th><th>Category</th><th>Published By:</th><th></th></tr>
                      <?php
                          while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $projprog_id        = $row_all_content['portfolio_id'];
                          $name               = $row_all_content['name'];
                          $post_date          = $row_all_content['dated'];
                          $category_name      = $row_all_content['category_name'];
                          $category_id        = $row_all_content['category_id'];
                          $username_p         = $row_all_content['username'];
                           
                       ?>
                      <tr>
                          <td><?php echo $name; ?></td>
                          <td><?php  echo $category_name; ?></td>
                          <td><?php echo $username_p ?></td>
                         
                          <td> 
    <?php
                          $select_count="select COUNT(*) as num_row from portfolio  where portfolio_id = '$projprog_id' and user_iid = '$user_id'";
                          $run_count= queryMysql($select_count);
                          $row_count=mysqli_fetch_array($run_count);                            
                          $total_row=$row_count['num_row'];                     
                          if($total_row == 1){      
                          ?>                              
                              
                    <!--- Delete  Button--> 
        <input type="button" class = "btn-danger" onclick="ConfirmDelete(<?php echo $projprog_id;?>,'<?php echo $name;?>')" value="Restore">
        <script type="text/javascript">
             function ConfirmDelete(project_id,projectname){
                    if (confirm("Restore ? "+projectname)){
                        location.href='index.php?RestorePortfolio='+project_id;
                   }else {
                   }
             }
         </script> 
             <?php
          }else{
    ?>
                              
            <input type="button" class = "btn-danger disabled"  style = "cursor:not-allowed" value="Restore">                  
        <?php
}
?> 
                 </td>
                      </tr>
                      <?php }?>
                    </table>
  
      
      

      <script src = "js/JQuery-1.8.0.js"></script>
   
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
       
    <script>
          $(document).ready(function(){
        var socket  = io.connect('http://localhost:3100');
         socket.on('Searched Portfolio',function(data){
              alert('HELLOOO');
            if( $('#SearchKeyword').val().trim() == '' ) {
                $('#SearchKeywordResult').empty();
            }else{
               $('#SearchKeywordResult').append('<a  href="index.php?Portfolio='+data.portfolio_id+'" class="list-group-item">'+data.name+'</a>');
         
            }       
    });
    $('#submit').click(function(e){
                $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordPortfolio',$('#SearchKeyword').val(),"1",function(keyword,available){});
        
        });
              jQuery('#SearchKeyword').on('input propertychange paste', function() {
                   $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordPortfolio',$('#SearchKeyword').val(),"1",function(keyword,available){});
            });
              
          
});
        

</script>




<br>
         </div>
    </div>
<center >
 
  <ul class="pagination">
 
    <li><a href="index.php?DeletedPortfolio=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='index.php?DeletedPortfolio=$previous_page' aria-label='Previous'>
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
     echo "<li><a href='index.php?DeletedPortfolio=$i'>$i</a></li>";
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
      <a href='index.php?DeletedPortfolio=$next_page' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="index.php?DeletedPortfolio=<?php echo $last_page; ?>">Last</a></li>
 
    
</ul>   
 
    </center>
      <br><br>   