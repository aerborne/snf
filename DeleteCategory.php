<?php
    if(isset($_GET['DeleteCat'])){
      $category_id  = $_GET['DeleteCat'];
 
queryMysql("UPDATE category set available = 1  WHERE category_id = '$category_id'");
             echo "<script>alert('Successfully Deleted')</script>";
             echo "<script>window.open('index.php?AllCategory ','_self')</script>";

}
?>
