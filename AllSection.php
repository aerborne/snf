<!DOCTYPE html>
<!--- PHP  Pagination Script -->

<?php
if(isset($_GET['allsection'])){
    $current_page=$_GET['allsection'];

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
  $select_all_content="select SQL_CALC_FOUND_ROWS  section_name,section_id,available from section where available = '0' order by section_id DESC  limit $start, $per_page  ";//sau sau sau

 //echo "per page".$per_page;
 //echo "<br>start".$start;
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from section where available = 0";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);// di xuong duoi div id= page
  // het sau sau sauz
?>



                <div class="col s12 ">
            <div class="card-panel #9c27b0 purple">
                <!-- 
                 <a href="admin_meta_index.php?deleted-section" class="btn main-color-bg  btn-block">Deleted Items</a>
                -->
            <br>
            
             <div class = "row">
                <div class ="col s8 m10">   
                    <input id = 'SearchKeyword' type = "text" class = "white-text">
                    <p id = "SearchKeywordResult" style = "position:absolute"></p>
                </div> 
                <div class = "col s2 m2">
                <input id = "submit" type = "submit" class = "btn" value =  "Search">
                    </div>
                </div>
                     
                     
                
               
                 <table class="white-text bordered">
                <tr><th>Section</th><th></th></tr>
                      <?php
                          while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $category_id      = $row_all_content['section_id'];
                          $category_name    = $row_all_content['section_name'];
                       ?>
                      <tr>
                          <td><?php  echo $category_name; ?></td>
                          <td><a class="btn btn-default" href="admin_meta_index.php?sec_id=<?php echo $category_id;?>"><i class='large material-icons'>border_color</i></a>
      
      
        <!--- Delete  Button--> 
        <input type="button" class = "btn #e57373 red lighten-2" onclick="ConfirmDelete(<?php echo $category_id;?>,'<?php echo $category_name; ?>')" value="&times">
        <script type="text/javascript">
         
            
         </script>
     
     </td>
                      </tr>
                      <?php }?>
                    </table>
</div>
      </div>
      <script src = "js/JQuery-1.8.0.js"></script>
 
 
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>            
       
    <script>
         function ConfirmDelete(category_id,category_name){
                    if (confirm("Delete ? "+category_name)){
                           $.getScript("js/form_validations.js",function(){  
                          delete_item(category_id,'section_id','section','allsection');
                           });
                   }else {

                   }
          }
          $(document).ready(function(){
                   $('.button-collapse').sideNav();       
        var socket  = io.connect('http://localhost:3100');
         
    socket.on('Searched Section',function(data){
            if( $('#SearchKeyword').val().trim() == '' ) {
                $('#SearchKeywordResult').empty();
            }else{
               $('#SearchKeywordResult').append('<a  href="index.php?sec_id='+data.category_id+'" class="list-group-item black-text" style = "background-color:white">'+data.category_name+'</a><br>');
         
            }       
    });
    $('#submit').click(function(e){
                $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordCategory',$('#SearchKeyword').val(),"0",function(keyword,available){});
        
        });
              jQuery('#SearchKeyword').on('input propertychange paste', function() {
                  
                   $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordSection',$('#SearchKeyword').val(),"0",function(keyword,available){});
            });
    
          
});
        




</script>
<br>
<center>
 
  <ul class="pagination">
 
    <li><a href="admin_meta_index.php?allsection=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='admin_meta_index.php?allsection=$previous_page' aria-label='Previous'>
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
     echo "<li><a href='admin_meta_index.php?allsection=$i'>$i</a></li>";
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
      <a href='admin_meta_index.php?allsection=$next_page' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="admin_meta_index.php?allsection=<?php echo $last_page; ?>">Last</a></li>
 
    
</ul>
 
 
    </center>
<br><br>