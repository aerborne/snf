 
    
<br><br>
<!DOCTYPE html>
<!--- PHP  Pagination Script -->

<?php
$url_ref = array ();
$filters = array (); 
$name = array ();
 
  if (isset($_GET['category']) && !empty($_GET['category'])) {
      $levels_value = $_GET['category'];
       if($_GET['category'] == "interior_designer"){
         $levels_value =  "interior designer";
       }
       //convert interior designer 
      $filters['levels'] = $levels_value;   
      $url_ref['category'] = $levels_value;
  }else{
      $levels_value = "";
  }
  if (isset($_GET['date']) && !empty($_GET['date'])) {
        $date_value = $_GET['date'];
        $filters['rdate'] = $date_value;
        $url_ref['date'] = $date_value; 
  }
 
  if (isset($_GET['name']) && !empty($_GET['name'])) {
        $name_value = $_GET['name'];
        $arr =  explode(" ", $name_value);
        $ctr = 0; 
        $nameEntered = "";
        foreach($arr as $v){
             $name['lname'.$ctr] = $v;  
             $name['fname'.$ctr] = $v;
        $ctr++;
           $nameEntered .= $v." ";
        }
      //echo $nameEntered;
        
        $name_value = str_replace(' ', '+', $name_value);
        $url_ref['name'] = $name_value;      
  }else{
      $nameEntered = "";
  }
$arrNameSize  = sizeof($name); 
$arrFilterSize = sizeof($filters);
$url_refSize = sizeof($url_ref);
$filterCollection  = "";
 
$url_format_collection = collectionStructure($filterCollection,$url_ref,"=","&","","");
$multi_collections = "";
if ($url_refSize == 0 ){ 
   
}else if ($arrFilterSize != 0 && $arrNameSize != 0){
    $multi_collections = "WHERE ".collectionStructure($filterCollection,$filters,"= '"," AND ","' ","")."  AND (".collectionStructure($filterCollection,$name," LIKE  '"," OR ","%'","name").")" ;
}else if ($arrFilterSize == 0){
     $multi_collections = "WHERE ".collectionStructure($filterCollection,$name," LIKE  '"," OR ","%'","name");
}else if ($arrNameSize == 0){
    $multi_collections = "WHERE ".collectionStructure($filterCollection,$filters,"= '"," AND ","' ","");
}
 

if(isset($_GET['allusers'])){
    $current_page=$_GET['allusers'];

    }else{

      $current_page=1;
      }
  $previous_page=$current_page - 1;
  $next_page=$current_page + 1;
  $user_id   = $_SESSION['user_id'];
//Do a a where clause for categories create a new php script for selection
  $per_page=10;
  $start=($current_page - 1) * $per_page;
 if($start < 0){
     $start  = 0;
 }


 

    //echo 'start'.$per_page;
  $select_all_content="select SQL_CALC_FOUND_ROWS       lname,fname,available,mname,gender,levels,users.user_iid,mobilenumber,username,rdate,dateofbirth,available  from users $multi_collections order by user_iid DESC  limit $start, $per_page  ";//sau sau sau

 //echo "per page".$per_page;
 //echo "<br>start".$start;
  $run_all_content= queryMysql($select_all_content);
  $select_count="select COUNT(*) as num_row from users $multi_collections";
  $run_count= queryMysql($select_count);
  $row_count=mysqli_fetch_array($run_count);
  $total_row=$row_count['num_row'];
  $last_page=ceil($total_row / $per_page);// di xuong duoi div id= page
  // het sau sau sauz
?>
 <div id  = "levels_value" style = "display:none"><?php echo $levels_value;?></div>
   <div class="row">
          <div class="col s12 m12" >
                   
            
       
             
 
        
        <!-- 

 CREATE A SELECT ON WHERE THE OPTION IS SELECTED
  -->
     <div class = "row">
        <div class = "col s3">
            <select id  = "userCategory">
             <?php 
               $select_options = '<option value="" disabled selected>Choose your option</option>';
               $all =   '<option value="admin_meta_index.php?allusers">All</option>';
               $Admin = '<option value="admin_meta_index.php?allusers&category=admin">Admin</option>';
               $Interior_Designer = '<option value="admin_meta_index.php?allusers&category=interior_designer">Interior Designer</option>';
               $Client = '<option value="admin_meta_index.php?allusers&category=client">Client</option>';
                  
           
                if($_GET['category']== ""){
                   echo $select_options;
                   echo $all; 
                   echo $Admin; 
                   echo $Interior_Designer;
                   echo $Client;
                }else if ($_GET['category']== "admin"){
                    echo $select_options;
                   echo $Admin;     
                   echo $all; 
                   echo $Interior_Designer;
                   echo $Client;
                }else if ($_GET['category'] == "client"){
                    echo $select_options;
                   echo $Client;
                   echo $Admin;     
                   echo $all; 
                   echo $Interior_Designer;
                }else if ($_GET['category'] == "interior_designer"){
                    echo $select_options;
                    echo $Interior_Designer;    
                   echo $Client;
                   echo $Admin;     
                   echo $all;        
                }
            
              ?> 
           
        </select>
        <label>Category Select</label>

          </div> 
           <div class = "col s9">
            <div class = "row">
                <div class = "col s10">
                    <input id = 'SearchKeyword'  type = "text" class = "form-control" value = "<?php echo $nameEntered; ?>">
                    <p id = "SearchKeywordResult" style = "position:absolute"></p>
                </div>
                 <div class = "col s2">
                    <input id = "submit" type = "submit" class = "btn" value =  "Search">
                </div>
            </div>  
         </div>
     </div>
      
     <div class = "left-align">
          <?php
              if($levels_value == ""){
          ?>
          <?php
            if($nameEntered == ""){
                
            }else{
          ?>
           <span style = "color:#757575">Name Entered : <?php echo $nameEntered; ?></span> 
         <br>
         <?php
            }
         ?>  
         <?php 
              }else{
                  
                 if ($levels_value == "interior_designer"){
                    $levels_value ="Interior Designer";  
                 }
                 
         ?>  
            <span style = "color:#757575">Option Selected : <?php echo $levels_value; ?></span> 
         <br>
         <?php
            if($nameEntered == ""){
                
            }else{
        ?>
           <span style = "color:#757575">Name Entered : <?php echo $nameEntered; ?></span> 
         <br>
         <?php
            }
         ?>
       
            <span style = "color:#757575">Results Found : <?php echo  $total_row; ?></span> 
         <?php 
              }
             
          ?>   
    </div><br>
        
     
        
 
    <script>
    document.getElementById("userCategory").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>
      
                    
                      <?php
                          while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $account_user_username     = $row_all_content['username'];
                          $account_user_id      = $row_all_content['user_iid'];
                          $lname        = $row_all_content['lname'];
                          $mname        = $row_all_content['mname'];
                          $fname        = $row_all_content['fname'];
                          $mobileNo     = $row_all_content['mobilenumber'];
                          $account_user_levels       = $row_all_content['levels'];
                          $gender       = $row_all_content['gender'];
                          $rdate        = $row_all_content['rdate'];
                          $bdate        = $row_all_content['dateofbirth'];
                          $available    = $row_all_content['available'];
                         
                       ?>
                       
 <div class="col s12">
        <div class="card-panel ">
       <div class = "row">   
           <div class = "col m12 l3">
            
           
               <div id = "s<?php echo $account_user_id;?>">
            <?php 
              $picture_count="SELECT count(*) as num_row FROM user_images WHERE user_iid = '$account_user_id' and selected = 0";
              $picture_run_count= queryMysql($picture_count);
              $picture_row_count=mysqli_fetch_array($picture_run_count);
              $picture_total_row=$picture_row_count['num_row'];                  
                    
                    //echo "row count".$picture_total_row;
            if ($picture_total_row == "0"){
            ?>
                     <img  class="responsive-img" src="simages/no_picture.png" style  ="width:300em; length:250em">
            <?php 
            }else{
                 $select_profile_picture="SELECT * FROM user_images WHERE user_iid ='$account_user_id' and selected = 0 "; 
                  $run_profile_picture= queryMysql($select_profile_picture);
                while($row_all_picture=mysqli_fetch_array($run_profile_picture)){
                                     $path    = $row_all_picture['path'];
                                  // echo $path;
            ?>
              <img  class="responsive-img" src="<?php echo $path; ?>" style  ="width:300em; length:250em">     
            <?php 
                    }  
            }         
              
            ?> 
          </div> 
        
            
    
 
                 <div style = "padding-left:1em">
                     <span class="black-text" style = "font-weight:bold">Username:</span>  
                      <br><span  id  = "displayUsername<?php echo  $account_user_id; ?>"   style = "color:grey"><?php echo $account_user_username; ?></span><br>
                    <span class="black-text" style = "font-weight:bold">Registered Date:</span> 
                  
                      <br><span style = "color:grey"><?php echo substr($rdate,0,16); ?></span><br>
                </div>
             <br><br>
           </div>
        <div class = "col s12 m12 l3">
             <div class = "col s6 m6 l12">
                    <span class="black-text" style = "font-weight:bold">Date Of Birth:</span> 
                      <br><span id = "displayBirthdate<?php echo  $account_user_id; ?>" style = "color:grey"><?php echo $bdate; ?></span>
               </div>
                   <div class = "col s6 m6  l12">
                         <span class="black-text" style = "font-weight:bold">Last Name:</span> 
                              <br><span  id  = "displayLname<?php echo  $account_user_id; ?>" style = "color:grey"><?php echo $lname; ?></span>
                 </div>
                <div class = "col s6 m6  l12">
                     <span class="black-text" style = "font-weight:bold">First Name:</span> 
                          <br><span id = "displayFname<?php echo  $account_user_id; ?>" style = "color:grey"><?php echo $fname; ?></span>
                 </div>
                 <div class = "col s6 m6 l12">
                     <span class="black-text" style = "font-weight:bold">Middle Name:</span> 
                          <br><span id = "displayMname<?php echo  $account_user_id; ?>" style = "color:grey"><?php echo $mname; ?></span>
                 </div>
           
        </div>
         <div class = "col s12 m12 l3"> 
                <div class = "col s6 m6 l12">
                 <span class="black-text" style = "font-weight:bold">Contact #:</span> 
                      <br><span id = "displayMobileNo<?php echo  $account_user_id; ?>" style = "color:grey"><?php echo   $mobileNo; ?> </span>
                </div>
                <div class = "col s6 m6 l12">
                 <span class="black-text" style = "font-weight:bold">Email:</span> 
                      <br><span id = "displayEmail<?php echo  $account_user_id; ?>" style = "color:grey;  word-wrap: break-word;">deadpool@gmail.com</span>
            </div>
              <div class = "col s6  m6 l12">
                     <span class="black-text"  style = "font-weight:bold">Gender:</span> 
                          <br><span  id = "displayGender<?php echo  $account_user_id; ?>" style = "color:grey"><?php echo  $gender; ?></span>
              </div>
               <div class = "col s6  m6 l12">
                     <span class="black-text"  style = "font-weight:bold">Level:</span> 
                          <br><span id = "displayLevels<?php echo  $account_user_id; ?>" style = "color:grey"><?php 
                          echo  str_replace('_',' ',$account_user_levels);?></span>
              </div>
         </div>
         <div class = "col s12 m12 l3"> 
             <br><br>
             
<div class = "right-align">
    <span class="black-text"  style = "font-weight:bold" >Availability</span>
<?php
    if($available == 1){
?>
  <div class="switch">
    <label>
      Off
      <input  id = "availableButton<?php echo $account_user_id; ?>" type="checkbox">
      <span class="lever"></span>
      On
    </label>            
 </div>  
<?php         
    }else{
?>
  <div class="switch">
    <label>
      Off
      <input id = "availableButton<?php echo $account_user_id; ?>"  type="checkbox"  checked >
      <span class="lever"></span>
      On
    </label>
 </div>     
<?php     
    }
?>
      <script src = "js/JQuery-1.8.0.js"></script>     
    <script src = "js/jquery-1.11.3.min.js"></script>
  
<script>
  
             $('#availableButton<?php echo $account_user_id; ?>').click(function(){
         if(this.checked){
               socket.emit('Update user_availability',<?php echo $account_user_id; ?>,0,function(user_id,available){}); 
         }else{
       
                socket.emit('Update user_availability',<?php echo $account_user_id; ?>,1,function(user_id,available){});
         }
    });
 
    
 
 
</script>
  
    
    <br>
        <!--- Delete  Button--> 
    
          <a class="waves-effect waves-light btn modal-trigger" href="#edituser_<?php echo $account_user_id;?>" onclick="get_edit_user_id('<?php  echo  $account_user_id; ?>')"><i class='large material-icons'>border_color</i></a><br>
                <!-- 
                    <a class="waves-effect waves-light" style = "padding:1em">Priveleges</a>
                -->
             </div>
<div id="edituser_<?php echo  $account_user_id; ?>" class="modal">
    <div class="modal-content">
          <div id  ="<?php  echo  $account_user_id;  ?>edit_user_id" style = "display:none"><?php  echo  $account_user_id;  ?></div>
 <!-- Edit  input fields Start -->
<div class ="container">

<div class="row">
 <div class =  "col s12">
   <div class = "row">
     <div class = "col s6">
        <label>Lastname</label>
        <input id = "Lname<?php echo $account_user_id; ?>" name = "Lastname" type="text" class="validate" value = "<?php echo $lname  ?>">
         <p id = 'errorLname<?php echo $account_user_id; ?>' class = "#ef5350 red lighten-1" style = "color:white"></p>    
      </div>
      <div class = "col s6">
         <label>Firstname</label>
         <input type="text" id  = "Fname<?php echo $account_user_id; ?>" name = "Firstname" class="validate" value = "<?php  echo $fname; ?>" >
         <p id = 'errorFname<?php echo $account_user_id; ?>' class = "#ef5350 red lighten-1" style = "color:white" ></p>
      </div>  
      <div class = "col s6">   
          <label>Middlename</label>
         <input type="text" id = "Mname<?php echo $account_user_id; ?>" name = "Middlename" class="validate"  value = "<?php  echo $mname; ?>">
         <p id = 'errorMname<?php echo $account_user_id; ?>' class = "#ef5350 red lighten-1" style = "color:white"></p>
      </div> 
      <div class = "col s6">
            <label>Birthdate:</label>
         <input  type="text" class = "datepicker" id = 'birthdate<?php echo $account_user_id; ?>'   required  value = "<?php echo $bdate; ?>"><br>
      </div>
    </div>

      <label>Gender:</label>
        <select name='Gender'  id = "Gender<?php echo $account_user_id; ?>"> 
           <?php  if ($gender == "Male"){
           ?>
               <option  value="Male">Male</option>
               <option  value="Female">Female</option>
               <option  value="Other">Other</option>
           <?php          
                  }else if($gender == "Female"){
           ?>
              <option  value="Female">Female</option>
              <option  value="Male">Male</option>
              <option  value="Other">Other</option>
            <?php
                  }else{               
            ?>
             <option  value="Other">Other</option>
              <option  value="Male">Male</option>
              <option  value="Female">Female</option>
             
            <?php                
                } 
            ?>
                      
        </select> 
         <div class="row">
                     <div class = "col s3">
                 
                     <select name='indexMobile'  id = "index<?php echo $account_user_id; ?>"  >
                    <?php 
                           if ( substr($mobileNo,0,3) == "+63"){
                    ?>            
                    <option    value = "<?php echo substr($mobileNo,0,3) ; ?> "><?php echo substr($mobileNo,0,3) ; ?></option>    
                         <option  value="+82">+82</option>
                         
                     <?php             
                           }else{
                             
                          ?>
                            <option  value="+63">+63</option>
                          <option    value = "<?php echo substr($mobileNo,0,3) ; ?> "><?php echo substr($mobileNo,0,3) ; ?></option>
                      <?php                
                           }
                         ?> 
                
                        
                    </select>
                   </div>
                    <div class  = "col s9">
                     <input value = "<?php echo substr($mobileNo,4,12);?>" type="text"  id = "mobilenumber<?php echo $account_user_id; ?>"  name = "mobilenumber"   placeholder="Enter Mobile Number">
                          <p id  = 'errormobilenumber<?php echo $account_user_id; ?>' class = "#ef5350 red lighten-1 white-text"></p>
                    </div>
                  
         </div><br>
      <div class = "row">
        <div class = "col s6">
           <label>Username</label>
             <input type="text" id = "Addusername<?php echo $account_user_id; ?>" name = "Username" class="validate" placeholder="Enter Username" value = "<?php echo $account_user_username;?>">
             <p id = 'errorAddusername<?php echo $account_user_id;?>' class = "#ef5350 red lighten-1" style = "color:white"></p>
             <p id = 'errorAddusername<?php echo $account_user_id; ?>2' class = "#ef5350 red lighten-1" style = "color:white"></p> 
        </div>
        <div class = "col s6"> 
            <label>Level</label>
           
             <select name = 'category_id' id = "levels<?php echo $account_user_id; ?>" >
            <option value="<?php echo $account_user_levels;?>"><?php echo str_replace('_',' ',$account_user_levels);?></option>     
                    <?php 
                       if($account_user_levels== 'Admin'){
                    ?>
                              <option value="Client">Client</option>
                              <option value="Interior Designer">Interior Designer</option>
                    <?php        
                       }else if ($account_user_levels == 'Client'){
                      ?>
                              <option value="Admin">Admin</option>   
                               <option value="Interior Designer">Interior Designer</option>
                    <?php
                       }else if ($account_user_levels == 'Interior_Designer'){
                     ?>
                      <option value="Admin">Admin</option>  
                      <option value="Client">Client</option>
                 <?php
                       }
                    ?> 
            </select>
        </div>     
</div>
     <div class = "right-align">
         
             <input id = "update_user<?php echo $account_user_id; ?>" type="button" class = "  btn #e57373 green lighten-2"  value="Save">
     </div>
   
</div>     
</div>        
</div>       
        
        
 
 
    
        

        
        
        
<!-- Edit  input fields End -->      
       
    </div>
    <div class="modal-footer">
     
    </div>
         
<script>
 
   
function  get_edit_user_id(user_id){
 
    var fields  = ["Lname"+user_id,"Fname"+user_id,"Mname"+user_id,"Addusername"+user_id,"mobilenumber"+user_id,"birthdate"+user_id];
         
   
 
    $('#update_user'+user_id).click(function(){
                if($('#Lname'+user_id).val().length == 0
             || $('#Fname'+user_id).val().length == 0
             || $('#Mname'+user_id).val().length == 0
             || $('#Addusername'+user_id).val().length == 0
             || $('#mobilenumber'+user_id).val().length == 0){
            

                alert('Please Fill up all fields!');     
          }else if ($('#Lname'+user_id).val().length <  2
             || $('#Fname'+user_id).val().length < 2 
             || $('#Mname'+user_id).val().length < 2){
                      //  alert('HELLO');   
          }else if ($('#mobilenumber'+user_id).val().length < 10){
                    
          }else if ($('#Addusername'+user_id).val().length < 11){
        
                   
          }else{
            
               
                socket.emit('Update Users',$('#Lname'+user_id).val(),$('#Fname'+user_id).val(),$('#Mname'+user_id).val(),$('#index'+user_id).val()+$('#mobilenumber'+user_id).val(),$("#Gender"+user_id).val(),$('#birthdate'+user_id).val(),$('#levels'+user_id).val(), $('#Addusername'+user_id).val(),user_id,function(Lname,Fname,Mname,mobilenumber,gender,birthdate,levels,username,user_id){});   
               for ( var i = 0; i < 7 ; i++){
                      $('#'+fields[i]).blur();
               }       
    $('#displayUsername'+user_id).html($('#Addusername'+user_id).val());
    $('#displayBirthdate'+user_id).html($('#birthdate'+user_id).val());
    $('#displayLname'+user_id).html($('#Lname'+user_id).val());
    $('#displayFname'+user_id).html($('#Fname'+user_id).val());
    $('#displayMname'+user_id).html($('#Mname'+user_id).val());
$('#displayMobileNo'+user_id).html($('#index'+user_id).val()+$('#mobilenumber'+user_id).val());         
//email
$('#displayGender'+user_id).html($('#Gender'+user_id).val());
$('#displayLevels'+user_id).html($('#levels'+user_id).val());
                $('#errorAddusername2'+user_id).empty();
            
                $('#edituser_'+user_id).modal('close');
          
          }
        
        
    });
 
 
    $.getScript("js/form_validations.js",function(){    
        //Keypress Validation 
          for ( var i = 0; i < 5 ; i++){
             if (i < 3 ){
                Keypress_F(fields[i],'LettersOnly');
                $("#"+fields[i]).attr('maxlength','20');
             }else if ( 2 < i &&  i < 4 ){
                  Keypress_F(fields[i],"NumbersAndLetters");
                  $("#"+fields[i]).attr('maxlength','16');
             }else if (i == 4){
                  Keypress_F(fields[i],"NumbersOnly");
                  $('#'+fields[i]).attr('maxlength','10');
             }
         }
        //Minimum Error Restrictions  
          MinLimit_F('Lname'+user_id,'Lastname',2);
          MinLimit_F('Fname'+user_id,'Firstname',2);
          MinLimit_F('Mname'+user_id,'Middlename',2);
          MinLimit_F('Addusername'+user_id,'Username',11);
          MinLimit_F('mobilenumber'+user_id,'Mobile Number',10);
             Keypress_F('SearchKeyword','LettersOnly');
     check_username('Addusername'+user_id,'update_user'+user_id,'2',user_id,'users','user_iid','username','Username');  
          check_password_again();
    });
     
 
    
} 
 
       
     
 
       
 
</script>
  </div>

               
 
             
             
         </div>
      </div> 
        </div>
</div>                                          
                      <?php }?>
                    </div>
               </div>



 
          
 
  
 
<center>   
    <script src = "js/JQuery-1.8.0.js"></script>       
      
    <script>
   
          $(document).ready(function(){
          $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears:200, // Creates a dropdown of 15 years to control year,
    max: [1990],
    
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false,// Close upon selecting a date, 
    format: 'yyyy-mm-dd'
});
 
      $(document).keypress(function (e) {
    if (e.which == 13) {
     
                  if($('#url_format_collection').html() == ""){
                    var keywordEntered = $('#SearchKeyword').val() ;
                    keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                  window.location.replace('admin_meta_index.php?allusers'+'&name='+keywordEntered); 
                }else{
                        var keywordEntered = $('#SearchKeyword').val() ;
                       keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                    window.location.replace('admin_meta_index.php?allusers&category='+$('#levels_value').html()+'&name='+keywordEntered);
                }
      }});
               $('#submit').click(function(e){
                   // alert($('#url_format_collection').html());
                if($('#url_format_collection').html() == ""){
                    var keywordEntered = $('#SearchKeyword').val() ;
                    keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                  window.location.replace('admin_meta_index.php?allusers'+'&name='+keywordEntered); 
                }else{
                        var keywordEntered = $('#SearchKeyword').val() ;
                       keywordEntered = keywordEntered.replace(/\s/g, "+");
                   //alert(keywordEntered);
                    window.location.replace('admin_meta_index.php?allusers&category='+$('#levels_value').html()+'&name='+keywordEntered);
                }
         
              });
            
             
           
          });
    </script>
 <br><br><br> <br><br><br><br><br>
  <ul class="pagination">
 
    <li><a href="admin_meta_index.php?allusers=1">First</a></li>
     <?php
   if($current_page==1){
    // echo "Previous";
     }else{
     echo "<li>
      <a href='admin_meta_index.php?allusers=$previous_page&$url_format_collection' aria-label='Previous'>
        <span aria-hidden='true'>&laquo;</span>
      </a>
    </li>";
     }
   ?>
     <?php
   //for($i=1; $i<=$last_page; $i++){
   for($i=$current_page -2; $i <=$current_page+2; $i++){//5sau
   if($i > 0 && $i <= $last_page){//5sau
     if($current_page != $i){// 4 sau
     echo "<li><a href='admin_meta_index.php?allusers=$i&$url_format_collection'>$i</a></li>";
     }else{
     echo "<li><span class='active_page'>$i</span></li>";
     }
   }
 }
   ?>
      <?php
   if($current_page==$last_page){
    // echo "Next";
     }else{
     echo "  <li>
      <a href='admin_meta_index.php?allusers=$next_page&$url_format_collection' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
      </a>
    </li>";
     }
   ?>
    
             <li><a href="admin_meta_index.php?allusers=<?php echo $last_page; ?>">Last</a></li>
 
    
 
  </ul>
 
    </center>
