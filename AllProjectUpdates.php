 <?php
      if(isset($_GET['Project/Updates'])){
            $projprog_id=$_GET['Project/Updates'];
            $percent_all=queryMysql(" SELECT * FROM projectprog_update where projprog_id = '$projprog_id' AND available = '0' ORDER BY pupdate_id DESC LIMIT 1");
            $row = mysqli_fetch_array($percent_all);
            $input =  $row['percent_d'];
           if ($input == 100){
              echo "<center><h3>Project Completed</h3></center>";
           }else{
?>
 <center><a   class=" btn btn-default" style = "text-decoration:none" href="index.php?ppuj=<?php  echo $projprog_id; ?>" >Add Project Update</a> </center> <br>
     <?php  
       }
            $check_updates =  queryMysql("SELECT COUNT(pupdate_id) as updates FROM projectprog_update where projprog_id = '$projprog_id' AND available = '0' ");
            $row = mysqli_fetch_array($check_updates);
            $updates = $row['updates'];

             if($updates == 0 ){
    echo "<h3></br></br><center>No  Project Update/s</center></h3>";
             }
               $project_name = queryMysql("SELECT name from project_progress where projprog_id = '$projprog_id' ");
               $select_name = mysqli_fetch_array($project_name);
               $pname  =   $select_name['name'];

?>
<?php
            $i=0;
            $selected_project = queryMysql("SELECT * FROM projectprog_update WHERE projprog_id = '$projprog_id' AND available = '0'  ");
            $ctrRep = 0;
            $ctrComment = 0;
            while($row=mysqli_fetch_array($selected_project)){
                $pupdate_id           =    $row['pupdate_id'];
                $description          =    $row['descriptions'];
                $percent              =    $row['percent_d'];
                $i++;
                $ctrComment++;
?>
<?php
$select_xmark=queryMySql(" SELECT * FROM projectprog_update where projprog_id = '$projprog_id' and available = '0' ORDER BY pupdate_id DESC LIMIT 1");
$row_select_xmark = mysqli_fetch_array($select_xmark);
  if($row_select_xmark['percent_d'] > $percent){

  }
  else{
  ?>      <!-- DELETE BUTTON -->
  <p class="text-right text-capitalize">
        <input type="button" class = "btn-danger" onclick="ConfirmDelete(<?php echo $pupdate_id;?>,<?php echo $projprog_id;?>)" value="&times;">
        </p>
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
 ?>
      <div class="panel panel-default ">
        <div class="panel-heading main-color-bg panel-fixed-top" >           
          <h3>Project: <small style = "color:white;"><?php echo $pname; ?></small></h3>
        </div>
        <div class="panel-body">           
        <!-- Define all of the tiles: -->
<div class="row">
<?php
$countPictures = queryMysql("SELECT COUNT(projprogimg_id) as pictures FROM projectprog_image where pupdate_id = '$pupdate_id'");
$obtainPictureNo = mysqli_fetch_array($countPictures);
$pictures = $obtainPictureNo['pictures'];
if ($pictures == "0"){
?>
                       
                    <div class = "row">
                    <div class="col-md-4 "></div>
                    <div class="col-md-4 ">
                    <div class="well dash-box">
                    <h4>No Pictures Available.</h4>
                    </div>
                    </div>
                    </div> 
                 
<?php
}else{
$selected_images = queryMysql("SELECT * FROM projectprog_image where pupdate_id = '$pupdate_id'");     
while($row_images=mysqli_fetch_array($selected_images)){
  $img           =    $row_images['path'];
  $i++;    
?>
    <div class="col-md-4 thumb ">
    <img class="thumbnail" src="<?php echo $img; ?>" height="100%" width = "100%";>    
    </div>
    
<?php 
    
 } 
}
 ?>

</div>
 <script src = 'js/JQuery-1.8.0.js'></script>
             
</div>

<div class = "well"   style = "background-color:white;">
<div class = "well" style = "background-color:white; border-color:white;">
        <dl>
        <div class="pull-right"><dt><strong>Percent:</strong> <?php echo $percent; ?>%</dt></div>
            <dt>Description:</dt>
        <a  class = " btn btn-default btn-xs"  href = 'index.php?dpj=<?php echo $projprog_id;?>&epju=<?php echo $pupdate_id;?>'><span>Edit Description</span></a>
          <dd><?php echo $description;?></dd>    
        </dl>
         <dd><strong>Published by:</strong></dd>
          <dd><strong>Date :</strong></dd>
</div>          
    <script src = "/js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3000/socket.io/socket.io.js"></script>
 

 <!-- Comment Section -->
<div class = well>

    <form  id  = "<?php echo $ctrComment; ?>commentForm">
        <div class = "row">
        <div class = 'col-md-1'>
        <?php
           $user_id = $_SESSION['user_id'];
           $select_username = queryMysql("SELECT username from users where user_iid = '$user_id' ");
           $selected_username = mysqli_fetch_array($select_username);
           $username = $selected_username['username'];
        ?> 
        <label id = "<?php echo $ctrComment; ?>username"><?php echo $username; ?></label>
        </div>
        <div class = "col-md-1"></div>
        <div class = "col-md-10">
        <textarea id = "<?php echo $ctrComment; ?>comment" class="form-control" rows="2"></textarea>
        </div>
        </div>
        <br>
        <p class ="text-right">
        <input  type = "submit"  value = "Comment">
        </p>
</form>
    <?php echo "CTR COMMENT ".$ctrComment; ?>
    
    <div id = "<?php echo $ctrComment; ?>ShowComments"></div>
<!-- Initializing Scripts -->  
<!-- SELECTING COMMENTS -->
<script>
   
    jQuery(function($){
 
         var socket          = io.connect('http://localhost:3000');
         var $commentForm    = $('#<?php echo $ctrComment; ?>commentForm');
         var $username       = $('#<?php echo $ctrComment; ?>username');
         var $comment        = $('#<?php echo $ctrComment; ?>comment');
         var $ShowComments   = $('#<?php echo $ctrComment; ?>ShowComments');
        
        $commentForm.submit(function(e){
            e.preventDefault();
              socket.emit('new user', $username.html(),function(data){
              });
            console.log('bullshit detected');        
            socket.emit('GetComment',$comment.var(),function(data,callback){
            $ShowComments.append('<span class = "error">'+ data + "</span><br/>");
                });
        
          
            
            $comment.val('');
        });
        
          socket.on('show comment',function(data){
                $ShowComments.append('<hr><span  style = "color:grey;">'+data.username+'</span><br><!-- Comment -->&nbsp;&nbsp;&nbsp;&nbsp;<span>'+data.comment+'</span><br>&nbsp;&nbsp;&nbsp;<a href = "">Reply</a> <br><hr>');
              });    
     
    }); 
    
</script>    
<hr>
<span  style = "color:grey;">Rajan Mate</span>
<br>
    <!-- Comment -->
    &nbsp;&nbsp;&nbsp;&nbsp;<span>Nice artwork!!!.</span>
     <br>
    &nbsp;&nbsp;&nbsp;<a href = "">Reply</a> 
<br>
<hr>
<span style = "color:grey;">Rajan Mate</span>
<br>
    <!-- Comment -->
    &nbsp;&nbsp;&nbsp;&nbsp;<span>Cool design eyy!!!</span>
    <br>
      &nbsp;&nbsp;&nbsp;<a href = "">Reply</a> 
</div>
<?php 
 
    $ctrRep++;
 echo $ctrRep;
?> 
<h3>Mouse Events</h3>
    <div id = "<?php echo $ctrRep?>SelectReply"></div>
		<a id="<?php echo $ctrRep;?>reply" class="btnClass" style = "cursor:pointer;">Reply</a>   
            
             <div id = "<?php echo $ctrRep;?>replyContent">
                <!-- FORM  SECTION --> 
              <form id = '<?php echo $ctrRep;?>send-reply'>
               <div   class = "row">
                <div class = 'col-md-1'><span><?php echo $username; ?></span></div> 
                  <div class = "col-md-1"></div>
                   <div class = "col-md-10">
                  <textarea  id = "<?php echo $ctrRep;?>replyMessage"class="form-control" rows="2"></textarea>
                   </div>
                </div>
                   <br>
                <p class ="text-right">
                <input type="submit" class="btn main-color-bg" value="Comment">
                </p>
              </form>
             <!-- FORM  SECTION -->
              </div>
    
<script>
     
$(document).ready(function(){
      $('#<?php echo $ctrRep;?>replyContent').hide();
$('#<?php echo $ctrRep;?>reply').on('click', function(){
				//$('.para1').hide();
				$('#<?php echo $ctrRep;?>replyContent').toggle();
			});
    
     jQuery(function($){
        var socket         =   io.connect();
        var $replyContent  =  $('#<?php echo $ctrRep?>SelectReply');
        var $sendReply     =  $('#<?php echo $ctrRep?>send-reply'); 
        var $replyMessage  =  $('#<?php echo $ctrRep;?>replyMessage');
         
        //Reply Message Form Client Functionality
        //Realtime  Reply message
    
        //Obtaining username 
        socket.emit('new user<?php echo $username; ?>',function(data){});
         
         //Comment function 
        $sendReply.submit(function(e){
           e.preventDefault();
              socket.emit('send message',$replyMessage.val(),function(data){
                 $replyContent.append('<span class = "msg"><b>'+
                data.nick + ': </b>'+data.msg + "</span><br>");
              });
           });
     });
});
</script>
<!-- Comment Section -->
 </div>
   </div>      
  <?php            
  }        
  }
?>
   
   
<script src="js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
  <script src = "js/updateDescription.js"></script>