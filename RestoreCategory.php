<?php
    if(isset($_GET['RestoreCategory'])){
      $category_id  = $_GET['RestoreCategory'];
 
queryMysql("UPDATE category set available = 0  WHERE category_id = '$category_id'");
             echo "<script>alert('Successfully Restored')</script>";
             echo "<script>window.open('index.php?AllCategory ','_self')</script>";

}
?>
