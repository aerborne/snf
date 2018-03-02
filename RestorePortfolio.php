<?php
    if(isset($_GET['RestorePortfolio'])){
      $proj_id  = $_GET['RestorePortfolio'];
 
queryMysql("UPDATE portfolio set available = 0  WHERE portfolio_id = '$proj_id'");
             echo "<script>alert('Successfully Restored')</script>";
             echo "<script>window.open('index.php?AllPortfolio ','_self')</script>";

}
?>
