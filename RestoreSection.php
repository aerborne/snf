<?php
    if(isset($_GET['RestoreSection'])){
      $category_id  = $_GET['RestoreSection'];
 
queryMysql("UPDATE section set available = 0  WHERE section_id = '$category_id'");
             echo "<script>alert('Successfully Restored')</script>";
             echo "<script>window.open('index.php?AllSection ','_self')</script>";

}
?>
