<?php 
  if(isset($_SESSION['user_id'])&&isset($_SESSION['user_level'])){
    
      if($_SESSION['user_level']== "Client"){
   ///echo "<script>window.open('signin.php','_self')</script>";
           destroySession();
          echo "<script>window.open('index.php','_self')</script>";          
      }else{
           destroySession();
            echo "<script>window.open('index.php','_self')</script>";  
          
       
      }
       
  }

?>