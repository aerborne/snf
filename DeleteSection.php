<?php
    if(isset($_GET['DeleteSec'])){
      $category_id  = $_GET['DeleteSec'];
 
queryMysql("UPDATE section set available = 1  WHERE section_id = '$category_id'");
             echo "<script>alert('Successfully Deleted')</script>";
             echo "<script>window.open('index.php?AllSection ','_self')</script>";

}
?>
