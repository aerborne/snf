
<?php
if(isset($_GET['ppuj'])){
      $user_id = $_SESSION['user_id'];
      $projprog_id=$_GET['ppuj'];
      $project_name=queryMySql(" select * from project_progress where projprog_id='$projprog_id' ");
      $row=mysqli_fetch_array($project_name);
      $customer_id  = $row['customer_id'];
      $project_name  = $row['name'];

      $mobilenumber=queryMySql(" select mobilenumber from users where user_iid='$customer_id' ");
      $row2=mysqli_fetch_array($mobilenumber);
      $number = $row2['mobilenumber'];

     $select_pupdate_id = queryMySql("SELECT * FROM project_progress
right JOIN projectprog_update ON project_progress.projprog_id = projectprog_update.projprog_id   order by pupdate_id desc limit 1");
      $rows=mysqli_fetch_array($select_pupdate_id);
      $pupdate_id  = $rows['pupdate_id'];
      $rtpupdate_id =  $pupdate_id+1; //for realtime data
      $new_pupdate_id  = $pupdate_id; //for php non realtime data
     //echo $new_pupdate_id;
       //add 1 for realtime
       // static variable for non realtime(php)
    date_default_timezone_set('Asia/Manila');
    $data_directoryName = "uploads/"; //Date Directory Name
    $directoryName = "uploads/"; //Date Directory Name
?>
<div id = "pred_pupdate_id" style = "display:none"><?php echo $rtpupdate_id; ?></div>
<div id = "proj_prog_id" style = "display:none"><?php  echo $projprog_id; ?></div>
<div id = "proj_prog_user_id" style = "display:none"><?php  echo $_SESSION['user_id']; ?></div>
<div id = "directoryPath" style = "display:none"><?php  echo $data_directoryName; ?></div>
<?php
/*
if(isset($_POST['submit'])){


echo $number;
  $username = "rotalagjr@yahoo.com";
  	$hash = "6994a732636da1b05b825fdb4264fdb5c0c72e050bb8c251f735056a23f82526";


// $username = "ralph.talag@yahoo.com";
//$hash = "86c09a18f6d817cfe3157b4bd72101c914c1da533776f047146a6ce655ac525a";

//get form data


$sender = $_POST['from'];
$message = $_POST['message'];
$test = "0";
$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$number."&test=".$test;
//$vars = "https://api.txtlocal.com/send/?uname=".$username."&pword=".$password."message=".$message."from=".$from."&selectednums=".$number."&info=1&text=0";


if ($_POST['submitted']=="true")
  {
    $curl = curl_init('https://api.txtlocal.com/send/');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
  }

}
*/
  ?>

<div ></div>
<div class = "card-panel" style = "border:solid">
<div class = "row">
<div  class="col s12" style = "position:relative;">

<!-- Declare node.js client variables-->
    <div  id  = "user_id" style = "display:none"><?php echo $user_id; ?></div>
    <div  id = "customer_id" style = "display:none"><?php echo $customer_id; ?></div>
    <div  id = "project_name" style = "display:none"><?php echo $project_name; ?></div>
    <div id  = "pupdate_id" style = "display:none"><?php echo $pupdate_id; ?></div>


<div class = "center-align">
    <h4><p class="text-center text-uppercase">Project Name: <?php echo $row['name']?></p></h4>
</div>


<form  id = "myForm" action="" method = "POST" enctype="multipart/form-data">



        <div class="input-field col s12">
          <textarea id="project_update_description" name = "description" class="materialize-textarea"  required = "required"></textarea>
          <label for="description">Description</label>
        </div>







             <?php
                           /*
                           100 - 30  = 70
                            70 % 10  = 7
                           30  ctr = 7 increment 10
                           30 40 50 60 70 80 90 100

                            */

         $percent_all=queryMysql(" SELECT * FROM projectprog_update where projprog_id = '$projprog_id'  and available = '0' ORDER BY pupdate_id DESC LIMIT 1");
         $row = mysqli_fetch_array($percent_all);
         //PERCENT Function
         $input =  $row['percent_d'];
         $ans_sub = 0;
         $ans_division = 0;
         $ans_sub  = 100 - $input;
              //echo $ans_sub;
         $ans_division  = $ans_sub / 10;
              //echo $ans_division
            ?>

    <div class = "col s12">
        <label>Percent</label>
        <select id = 'percent' name='percent' class = "browser-default">
        <?php
        for ($i=0; $i < $ans_division  ; $i++){
           $values = $input +=10;
        ?>
       <option name ="value" value= "<?php echo $values; ?>"><?php echo $values . "%";?></option>

        <?php
        }
        ?>
        </select>

    </div>

      <div class="file-field input-field col s12">
                <div style = "margin-bottom:2em"></div>
      <div class="btn">
        <span>File</span>
        <input  id =  'upload'  name = 'upload[]' type="file" multiple = "multiple " accpet = "image/*" required = "required"/>
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate black-text" type="text" style = "display:none"placeholder="Upload one or more files">
      </div>
    </div>
   <div class = "clearfix"></div>
          <div  style = "margin-top:1em" id="selectedFiles"></div>
      <br><br><br><br><br><br>
     <div class = "clearfix"></div>




         <div>  <br><br>
      <br>"Note:If you click SUBMIT you will notify the client via SMS  about the new update"
         </div>
        <br>
        <form action="sms.php" method="POST">

         <input type="hidden" name="from" value="SEE N FEEL">

        <input type="hidden" name="message" value="Your Project have an update. Please check our website seeandfeel.com">
        <br>
        <br>
        <input type="hidden"name="submitted" value="true">
          <div class = "right-align">
         <input type="submit" style = "display:none" id =  "addProjectProgressBTN" name = "submit" class="btn btn-success" value="Submit">
         <a id = "triggerUploadButton" class="btn btn-success">Submit</a>
        </div>
        </form>
    </form>
    </div>
    </div>
</div>

<script>

       var storedFiles = [];
       var $user_id       = $('#user_id');
       var $customer_id   = $('#customer_id');
       var $project_name  = $('#project_name');
       var $percent       = $('#percent');
       var $pupdate_id    = $('#pupdate_id');
  ///     var $delPictureInformationList  = "delPictureInformationList";
      var delPictureInformationOBJlist = '{"delPictureInformationList":[]}';
       var btnCounterID = 0;
      delPicture_obj_ls = JSON.parse(delPictureInformationOBJlist);
      var  selDiv = $("#selectedFiles");
       $("#upload").on("change", handleFileSelect);
      function handleFileSelect(e) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f) {

            if(!f.type.match("image.*")) {
                return;
            }
            storedFiles.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
                filename =  f.name;
                delPicture_obj_ls.delPictureInformationList.push({"temp_id":btnCounterID,"filename":filename,"availability":"0"});
                selDiv.append("<div class = 'col s12 m4 l4 xl2 ' id = 'uploadPictureHolder"+btnCounterID+"' style = 'margin-bottom:1em'><div id = 'filename"+btnCounterID+"' style = 'display:none'>"+f.name+"</div><div class = 'uploadPhotoDivHolder'><div class = 'right'><a class='waves-effect deletePictureUploadBTN'  onclick ='triggerDeleteUploadPicture("+btnCounterID+")'>&times;</a></div><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='Click to remove'></div></div>");
                 btnCounterID++;
            }
            reader.readAsDataURL(f);

        });
    }
    function triggerDeleteUploadPicture(btnCounterID){
       delPicture_obj_ls.delPictureInformationList[btnCounterID].availability = 1;
       $("#uploadPictureHolder"+btnCounterID).hide();
    }

    //$('#addProjectProgressBTN').prop('disabled',true);
    $.getScript("js/form_validations.js",function(){

    });

    $("#triggerUploadButton").click(function(){
              if($('#project_update_description').val().length == 0||
                $('#upload').get(0).files.length === 0){
                  alert('Please Fill up the Fields and Choose a Picture to upload!  ');
              }else{
                  ///Check if there anything uploaded
                  //Create a counter for every 0 available counted
                  var ctrAvail = 0;
                  for (var i = 0; i <  delPicture_obj_ls.delPictureInformationList.length; i++) {
                       var  availability =  delPicture_obj_ls.delPictureInformationList[i].availability;
                         if(availability == 0){
                           ctrAvail++;
                         }else{

                         }
                  }
                  if(ctrAvail == 0){
                    alert('Please choose a picture to upload! ');
                     //var input = $("#upload");
                         $("#upload").val("");
                  }else{
                        socket.emit('get project_update_data',$('#proj_prog_id').html(),$('#project_update_description').val(),$('#percent').val(),$('#proj_prog_user_id').html(),function(projprog_id,descriptions,percent,user_id){});

                  }
              }
    });
    socket.on("delete selectedPictures",function(){
        // alert('delete pictures');
         for (var i = 0; i <  delPicture_obj_ls.delPictureInformationList.length; i++) {
             var  temp_id      =  delPicture_obj_ls.delPictureInformationList[i].temp_id;
             var  filename     =  delPicture_obj_ls.delPictureInformationList[i].filename;
             var  availability =  delPicture_obj_ls.delPictureInformationList[i].availability;
             socket.emit('get_delete_upload_pic',temp_id,filename,availability,$('#pred_pupdate_id').html(),$('#directoryPath').html(),function(temp_id,filename,availability,pred_pupdate_id,directoryPath){});
          }
    });
    socket.on('trigger deleteProjectPhoto',function(){
        $('#addProjectProgressBTN').trigger('click');
    });


 /*

      $('#myForm').submit(function(){

                   //var newProjectUpdateMessage = "Project "+$project_name.html()+" has been updated to  "+$percent.val()+"%";
                   //socket.emit('NewProject Notification',$user_id.html(),$customer_id.html(),newProjectUpdateMessage,'client.php?ProjectUpdateContent='+$pupdate_id.html(),'project_update',function(user_id,customer_id,newProjectMessage,key_id,notification_type){});


       });

   */



</script>
 <?php

 if(isset($_POST['submit']) && !empty($_POST['description'])){
    if (count($_FILES['upload']['name']) > 0) {
        $percent = ($_POST['percent']);
        $description = ($_POST['description']);
        $date = date('YYYY-MM-DD HH:mm');

       queryMysql("INSERT INTO projectprog_update(projprog_id,percent_d,descriptions,user_id,dated)VALUES('$projprog_id',
              '$percent',
              '$description',
              '$user_id',
              '$date')");


              $select_pup_id=queryMysql("selecT pupdate_id From projectprog_update where projprog_id = '$projprog_id' and dated = '$date' and descriptions = '$description'");
              $row = mysqli_fetch_array($select_pup_id);
              $id = $row['pupdate_id'];
              //Uploading  Single and Multiple Files
              //Loop through each file
              for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                  //Get the temp file path
                  $file_name = $_FILES['upload']['name'][$i];
                  $file_tmp = $_FILES['upload']['tmp_name'][$i];
                  $file_size = $_FILES['upload']['size'][$i];
                  $file_error = $_FILES['upload']['error'][$i];

                  $file_ext = explode('.', $file_name);
                  $file_ext = strtolower(end($file_ext));
                  // $allowed = array('jpg', 'jpeg', 'png', 'gif');
                  // if (in_array($file_ext, $allowed)) {
                  //     if ($file_error === 0) {
                          // if ($file_size <= 100097152) {
                              $file_name_new = uniqid('', true).
                              '.'.$file_ext;
                              $file_destination = 'uploads/'.$file_name_new;
                              if (move_uploaded_file($file_tmp, $file_destination)) {
                                  $file_destination;
                                  // :TODO save path to db
                                  queryMysql("insert into projectprog_image(name,pupdate_id,path) values('$file_destination','$id','$file_destination')");
                              }
                          // }
                  //     }else {
                  //         // :TODO error validation
                  //     }
                  // }
              }
          }
                  echo "<script>alert('Successfully Added')</script>";
                  echo "<script>window.location ='admin_meta_index.php?project-updates=$projprog_id','_self';</script>";

          }


}
?>
