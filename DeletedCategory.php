<!DOCTYPE html>
<!--- PHP  Pagination Script -->

<?php
if(isset($_GET['DeletedCategory'])){
    $current_page=$_GET['DeletedCategory'];

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
 //echo 'start'.$per_page;
  $select_all_content="select SQL_CALC_FOUND_ROWS  category_name,category_id,available from category where available = '1' order by category_id DESC  limit $start, $per_page  ";//sau sau sau

 //echo "per page".$per_page;
 //echo "<br>start".$start;
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from category  where available = 1";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);// di xuong duoi div id= page
  // het sau sau sauz
?>



                <div class="col-md-13 well" style = "position:relative;height:50em;width:50em;">
           
                
            <br>
            
            <div class = "form-group">
                    <input id = "submit" style = 'margin-left:49em;position:absolute'type = "submit" class = "btn" value =  "Search">
                    <input id = 'SearchKeyword' style = "width:49em"type = "text" class = "form-control">
                    <p id = "SearchKeywordResult" style = "position:absolute"></p>
                </div>
                     
                
              <br><br><br><br>
                 <table class="table table-striped table-hover table-bordered table-condensed">
                <tr><th>Category</th><th></th></tr>
                      <?php
                          while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $category_id      = $row_all_content['category_id'];
                          $category_name    = $row_all_content['category_name'];
                       ?>
                      <tr>
                          <td><?php  echo $category_name; ?></td>
                          <td> 
        <!--- Delete  Button--> 
        <input type="button" class = "btn " onclick="ConfirmDelete(<?php echo $category_id;?>,'<?php echo $category_name; ?>')" value="Restore">
        <script type="text/javascript">
         
             function ConfirmDelete(category_id,category_name){
                    if (confirm("Restore ? "+category_name)){
                        location.href='index.php?RestoreCategory='+category_id;
                   }else {

                   }
             }
         </script>
     
     </td>
                      </tr>
                      <?php }?>
                    </table>
      </div>
      <script src = "../js/JQuery-1.8.0.js"></script>
 
           
    <script src = "../js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
       
    <script>
          $(document).ready(function(){
        var socket  = io.connect('http://localhost:3100');
      socket.on('Searched Category',function(data){
            if( $('#SearchKeyword').val().trim() == '' ) {
                $('#SearchKeywordResult').empty();
            }else{
               $('#SearchKeywordResult').append('<a  href="index.php?cat_id='+data.category_id+'" class="list-group-item black-text" style = "background-color:white">'+data.category_name+'</a><br>');
         
            }       
    });
    $('#submit').click(function(e){
                $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordCategory',$('#SearchKeyword').val(),"1",function(keyword,available){});
        
        });
              jQuery('#SearchKeyword').on('input propertychange paste', function() {
                   $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordCategory',$('#SearchKeyword').val(),"1",function(keyword,available){});
            });
              
          
});
        




</script>
<br>
<center>
 
  <ul class="pagination">
 
    <li><a href="index.php?DeletedCategory=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='index.php?DeletedCategory=$previous_page' aria-label='Previous'>
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
     echo "<li><a href='index.php?DeletedCategory=$i'>$i</a></li>";
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
      <a href='index.php?DeletedCategory=$next_page' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="index.php?DeletedCategory=<?php echo $last_page; ?>">Last</a></li>
 
    
</ul>
 
 
    </center>
<br><br>