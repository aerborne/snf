<?php
    if(isset($_GET['DeletePortfolio'])){
      $proj_id  = $_GET['DeletePortfolio'];
 
queryMysql("UPDATE portfolio set available = 1  WHERE portfolio_id = '$proj_id'");
             echo "<script>alert('Successfully Deleted')</script>";
             echo "<script>window.open('index.php?AllPortfolio ','_self')</script>";

}
?>
