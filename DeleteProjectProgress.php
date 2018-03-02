
<?php
    if(isset($_GET['DeletePPU'])&& isset($_GET['Proj']) ){
      $DeletePPU  = $_GET['DeletePPU'];
      $proj       = $_GET['Proj'];
             queryMysql("UPDATE projectprog_update set available = '1' WHERE pupdate_id = '$DeletePPU'");
             //query latest percent 
             //insert into  project_progress percent status 
            $select_count_proj_imp ="select * from projectprog_update where projprog_id =  ' $proj  ' and available = 0 order by pupdate_id DESC ";
            $run_count_proj_imp      = queryMysql($select_count_proj_imp);
            $row_count_proj_imp     = mysqli_fetch_array($run_count_proj_imp);
            $total_row_proj_imp     = $row_count_proj_imp['percent_d'];
            queryMysql("UPDATE project_progress set current_percent = '$total_row_proj_imp' WHERE projprog_id = '$proj  '");
             echo "<script>alert('Successfully Deleted')</script>";
             echo "<script>window.open('index.php?Project/Updates= $proj ','_self')</script>";
}
?>
