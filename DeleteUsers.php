<?php
    if(isset($_GET['DeleteUser'])){
      $user_id  = $_GET['DeleteUser'];
 
queryMysql("UPDATE users set available = 1  WHERE user_iid = '$user_id'");
             echo "<script>alert('Successfully Deleted')</script>";
             echo "<script>window.open('index.php?AllUsers ','_self')</script>";

}
?>
 