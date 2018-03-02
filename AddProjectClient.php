
        <?php
if(isset($_GET['AddProClient'])){
    $current_page=$_GET['AddProClient'];

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
  $select_all_content="select SQL_CALC_FOUND_ROWS  lname,fname,available,mname,gender,levels,user_iid,mobilenumber,username  from users where available = '0' and levels = 'Client' order by user_iid DESC  limit $start, $per_page  ";//sau sau sau

 //echo "per page".$per_page;
 //echo "<br>start".$start;
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from users  where available = 0  and levels = 'Client' ";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);// di xuong duoi div id= page
  // het sau sau sauz
?> 
            
    <div  class = "row">
            <div class="col-md-15 well"  style = "position:relative;height:50em;width:55em;">
                
                 <div class = "form-group">
                    <input  id = "submit" style = 'margin-left:46em;position:absolute'type = "submit" class = "btn" value =  "Search">
                    <input id = 'SearchKeyword'type = "text" class = "form-control" style = 'width:46em'>
                    <p id = "SearchKeywordResult" style = "position:absolute"></p>
                </div>
                  
       
                
                
                <br><br>                 <br><br> 
        
   <table class="table table-striped table-hover table-bordered table-condensed">
                     <tr><th>Username</th><th>Lastname</th><th>Firstname</th><th>Middlename</th><th>Mobile No</th><th>Level</th> <th></th></tr>
                      <?php
                          while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $username     = $row_all_content['username'];
                          $user_id      = $row_all_content['user_iid'];
                          $lname        = $row_all_content['lname'];
                          $mname        = $row_all_content['mname'];
                          $fname        = $row_all_content['fname'];
                          $mobileNo     = $row_all_content['mobilenumber'];
                          $levels       = $row_all_content['levels'];
                          $gender       = $row_all_content['gender'];
                            
                       ?>
                      <tr>
                          <td><a  href="index.php?padd=<?php echo  $user_id;?>"><?php  echo $username; ?></a></td>    
                          <td><?php  echo $lname; ?></td>
                          <td><?php  echo $mname; ?></td>
                          <td><?php  echo $fname; ?></td>
                          <td><?php  echo $mobileNo; ?></td>
                         <td><?php  echo $levels; ?></td>
              
                                          
                          <td><a class="btn btn-default" href="index.php?u_id=<?php echo  $user_id;?>">Edit</a>
        <!--- Delete  Button--> 
        <input type="button" class = "btn " onclick="ConfirmDelete(<?php echo  $user_id ;?>,'<?php echo    $username; ?>')" value="Delete">
        <script type="text/javascript">
         
             function ConfirmDelete(user_id,username){
                
                    if (confirm("Delete ? "+username)){
                        location.href='index.php?DeleteUser='+user_id;
                   }else {

                   }
             }
         </script>
     
     </td>          </tr>
                      <?php }?>
                    </table>                
                
                
                
                
                
                
                
                
                
      </div>
</div>
<script src = ".js/jquery-1.8.0.js"></script>
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>     <script>
    $(document).ready(function(){
           var socket  = io.connect('http://localhost:3100'); 
           var OffsetCounter = 0;
        //alert('Add Project  Client');
          socket.on('Selected Clients',function(data){
         
          $('#Clients').append('<a  href="index.php?padd='+data.user_id+'" class="list-group-item">'+data.lname+' '+data.fname+'</a>');
          });
          
         socket.on('Searched Clients',function(data){
                
            if( $('#SearchKeyword').val().trim() == '' ) {
                $('#SearchKeywordResult').empty();
            }else{
               $('#SearchKeywordResult').append('<a  href="index.php?padd='+data.user_id+'" class="list-group-item black-text" style = "background-color:white">'+data.lname+' '+data.fname+'</a><br>');
         
            }       
         });
          
        $('#submit').click(function(e){
           $('#SearchKeywordResult').empty();
                  socket.emit('Search Keyword',$('#SearchKeyword').val(),function(keyword){});
        
        });
             jQuery('#SearchKeyword').on('input propertychange paste', function() {
                   $('#SearchKeywordResult').empty();
                  socket.emit('Search Keyword',$('#SearchKeyword').val(),function(keyword){});
            });
        
          $('#btnPrevious').click(function(e){
              e.preventDefault();
              if (OffsetCounter < 0 ){
                  OffsetCounter = 0;
              }
               OffsetCounter -= 10; 
            $('#Clients').empty();
              socket.emit('Client Pagination',OffsetCounter,function(OffsetCounter){});
              
              
          });
          $('#btnNext').click(function(e){
              e.preventDefault();
              OffsetCounter += 10;
            $('#Clients').empty();
              socket.emit('Client Pagination',OffsetCounter,function(OffsetCounter){});
              
                 
          });
    });

    </script>       
    
<center>
       
 
  <ul class="pagination">
  
    <li><a href="index.php?AddProClient=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='index.php?AddProClient=$previous_page' aria-label='Previous'>
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
     echo "<li><a href='index.php?AddProClient=$i'>$i</a></li>";
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
      <a href='index.php?AddProClient=$next_page' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="index.php?AddProClient=<?php echo $last_page; ?>">Last</a></li>
 
    
</ul>
 
 
    </center>
       <br><br>
 