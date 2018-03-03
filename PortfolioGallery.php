

<?php
if(isset($_GET['portfolio'])){

      $portfolio_id = $_GET['portfolio'];
      $user_id  = $_SESSION['user_id'];
      $select_username  = queryMysql("SELECT  *  from users where user_iid = '$user_id'");
      $row_select  = mysqli_fetch_array($select_username);
      $username    =  $row_select['username'];
      $user_level  =  $row_select['levels'];

      $select_portfolio_name  = queryMysql("SELECT *  FROM portfolio left join category  on portfolio.category_id  = category.category_id where portfolio_id = '$portfolio_id'");
      $row_portfolio_name  = mysqli_fetch_array($select_portfolio_name);
      $portfolio_name      = $row_portfolio_name['name'];
      $description         = $row_portfolio_name['description'];
      $category_id         = $row_portfolio_name['category_id'];
      $category_name       = $row_portfolio_name['category_name'];



?>

<div id =  "portfolio_id" style = "display:none"><?php echo $portfolio_id ;?></div>
          <div id = "user_id" style = "display:none;"><?php echo $user_id; ?></div>
 <div id = "username" style = "display:none;"><?php echo $username; ?></div>
          <div id = "user_level" style = "display:none;"><?php echo $user_level;?></div>
          <div id = "tableName" style = "display:none">portfolio_update_comments</div>
          <div id = "comment_id_name" style = "display:none">portfolio_update_comment_id</div>
          <div id  = "reference_id_name" style = "display:none">portfolio_id</div>
<div class = "col s12 m6">
 <div class = "card">
   <div class="card-content  #c2185b pink darken-2 white-text" >
    <div class = "right">
        <a class="waves-effect waves-light modal-trigger" style = "color:white;background-color:#ff5252 red accent-2" href="#projectPhotoUpload"> <i class="material-icons  small">file_upload</i></a>
        <a href = "#EditProjectModal" class="waves-effect waves-light  modal-trigger tooltipped" data-position="top" data-tooltip="Edit Portfolio  Name and Description"  style = "color:white;background-color:#ff5252 red accent-2;"><i class="material-icons  small">create</i></a>

    </div>
    <div class = "clearfix"></div>

 <div class = "center">
 <h3 id = "displayPname" style = "font-size:30px">Project Name: <?php echo $portfolio_name;  ?></h3>

</div>

     <div class = "right">
         <span id = "displayCategoryName" style = "font-size:18px">Category: <?php echo $category_name; ?></span>
     </div>
      <p id = "displayDescription" class = "flow-text" style = "word-wrap:break-word;font-size:18px ">Description:<br>&nbsp;&nbsp;&nbsp;<?php echo $description; ?></p>




<!-- Edit Project  Information Modal  Start-->
  <div id="EditProjectModal" class="modal" >
    <div class="modal-content" style = "height:20em">
       <br><br>
      <div class = "row">

        <div class="input-field col s12">
          <input  id="project_name" type="text" class="validate black-text" value = "<?php  echo $portfolio_name; ?>">
             <p id  = 'errorproject_name<?php echo $portfolio_id; ?>' class = "#ef5350 red lighten-1 white-text"></p>
              <p id  = 'errorproject_name<?php echo $portfolio_id;?>2' class = "#ef5350 red lighten-1 white-text"></p>
          <label for="port_name">Portfolio Name</label>
        </div>
          <div class="input-field col s12">
          <textarea id="EditPdescription" class="materialize-textarea black-text">  <?php  echo $description; ?></textarea>
          <label for="EditPdescription">Description</label>
        </div>
            <div class="input-field col s12">
                <select id = "project_category_id" class = "black-text">
                  <option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
                       <?php
                              //Category Choices
                              $select_category_choices  = queryMysql("SELECT * from category where category_id != '$category_id'");
                             while($row_category_choices=mysqli_fetch_array($select_category_choices)){
                                    $category_id_choices   =  $row_category_choices['category_id'];
                                    $category_name_choices =  $row_category_choices['category_name'];
                        ?>
                     <option value="<?php echo $category_id_choices ; ?>"><?php echo  $category_name_choices; ?></option>
                        <?php
                             }
                        ?>
                </select>
                <label>Category</label>
              </div>
          <div class = "clearfix"></div>
            <br><br>
         <div class = "right">
              <input id = "EditProject" type="button" class = "  btn #ec407a pink lighten-1  "  value="Save">

        </div>
          <div class = "clearfix"></div>
        <br><br>
      </div>
    </div>
  </div>
<!-- Edit Project  Information Modal  End -->
<!-- Upload Project  Image Modal -->
  <div id="projectPhotoUpload" class="modal">
    <div class="modal-content">
         <?php  include('UploadPortfolioGallery.php')?>
    </div>
  </div>
<!-- Upload Project  Image Modal -->
     </div>





<div class="row">
    <div class = "col s11">
         <div class = "center-align">
            <p class = "flow-text">Please Check the Photos that you want to be featured</p>
        </div>
         <div  id  = "EditPortfolioImages" style =  "overflow-y:scroll; height:30em;margin-left:4em"></div>
        <br><br>
             <div class = "container">

    <div class="input-field col s10">
    <select id = "selectSection_id">
    <?php
     $select_all_content="SELECT * FROM section where available  = 0 ";//sau sau sau


  $run_all_content= queryMysql($select_all_content);
         while($row_all_content=mysqli_fetch_array($run_all_content)){
                          $category_id      = $row_all_content['section_id'];
                          $category_name    = $row_all_content['section_name'];
    ?>
      <option value="<?php  echo $category_id; ?>"><?php echo $category_name; ?></option>
<?php
         }
?>
    </select>
    <label>Choose section for check items</label>
  </div><br>
    <!--   save  section -->
  <div class = "col s2">
        <a  id = "BTNsubmitSection"class="waves-effect waves-light btn #ec407a pink lighten-1">Save</a>
  </div>
                 <br><br>
                 <p id = 'errorSelectSection' class = "#ef5350 red lighten-1 white-text"></p>
            </div>

    </div>

    </div>

 <br><br>  <br><br>
     <!--
     <div class = "container">
     <div class = "row">
    <div class = "right-align">
      <button  id  = "btnSave"class="btn btn-large purple lighten-2">Save Images Descriptions</button>
    </div>
         </div>
    </div>
     -->
     <!-- Save Button -->
    <br><br><br>
  </div>
</div>


<script src = "../js/JQuery-1.8.0.js"></script>
<script src = "../js/jquery-1.11.3.min.js"></script>
<script src = "http://localhost:3100/socket.io/socket.io.js"></script>



<script>


     //Create an update information function
      $('#EditProject').click(function(){

         var category_id            =  $('#project_category_id').val();
         var project_id             =  $('#portfolio_id').html();


            if($('#EditPdescription').val().length == 0  ||
               $('#project_name').val().length == 0 ){
               alert('Please Fill up all fields!  ');
            }else if ($('#project_name').val().length < 6){

            }else{
               var project_name           =  $('#project_name').val().trim();
               var description            =  $('#EditPdescription').val().trim();

                 socket.emit('update portfolioInformation',project_id,project_name,description,category_id,function(project_id,project_name,description,category_id){});
                  //Update display information
                  $('#displayPname').html('Project Name: '+project_name);
                  $('#displayCategoryName').html('Project Name: '+$('#project_category_id :selected').text());
                  $('#displayDescription').html('Description:<br>&nbsp;&nbsp;&nbsp; '+description)


                  alert('Successfully Saved! ');
                 $('#EditProjectModal').modal('close');
            }


      });



       socket.emit('Get PortfolioIDfImage',$('#portfolio_id').html(),function(portfolio_id){});

       //  var filter_clientName  = $('#filter_ClientName').val().trim();
       $.getScript("../js/form_validations.js",function(){


        MinLimit_F('project_name','Project Name',6);

        $('#project_name').attr('maxlength','20');
        check_username('project_name','EditProject','2',$('#portfolio_id').html(),'portfolio','portfolio_id','name','Portfolio Name');

       });










        // var checkPortfolioImage_id  = [] ;


       ////asdddddddddddddddddddddd
       socket.on('SetPortfolioImages',function(data){

             //alert('portfolio_id '+data.portfolio_id);
             //alert('path'+data.path);
       var portfolioImages_id = [];
       var portfolioImages_Description =  [];
       var portfolioImageSection =   [];


        portfolioImages_id.push("portIMG"+data.portimg_id);
        portfolioImages_Description.push("imgDescription"+data.portimg_id);

        if(data.featured  ==  0){
                   $('#EditPortfolioImages').append('<div id = "ImageCont'+data.portimg_id+'"><div id  = "portIMG'+data.portimg_id+'" style = "display:none" >'+data.portimg_id+'</div><div class="col s12 m6 l4"><div class="card white"><div class="card-content black-text"><div class = "right-align" > <button id = "DeleteProjProgImage'+data.portimg_id+'"class="btn btn-small red darken-3 white-text">&times</button></div><div class ="left-align"><p><input type="checkbox"  id="check'+data.portimg_id+'" /><label for="check'+data.portimg_id+'">Feature Photo</label></p><p><input type="checkbox"  id="checkSection'+data.portimg_id+'" /><label for="checkSection'+data.portimg_id+'"><span id = "sectionName'+data.portimg_id+'">Section: '+data.section_name+'</span></label></p></div><br><a class = "modal-trigger" href = "#"><img style = " width:270px;height:180px;overflow:hidden;" src="'+data.path+'" alt="" class="responsive-img " alt=""></a><div class="row"><div class="input-field col s12"><textarea id  = "imgDescription'+data.portimg_id+'" class="" style = "overflow-y:scroll;height:9em"> '+data.description+'</textarea></div></div></div></div></div></div><div id="modal'+data.portimg_id+'" class="modal"><div class="modal-content" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt="">   <span class="card-title"><h3>Picture Name</h3></span><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta ratione, aliquid minima autem tempora, dolor impedit quidem tempore dolorem magnam deserunt, illo. Perspiciatis, quia praesentium nihil illo asperiores dolor modi.</p><br><div class = "right-align"><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star_border</i><p class="truncate">Average Rating: 4</p> </div><form id  = "commentForm"><div class="input-field"><input type="text" id=""><label class="active" for="comment">Write a Comment</label></div><div class    = "right-align"><input id = "btnSubmit" type = "submit"  value = "Comment" class = "main-color-bg" ></div> </form><div id = "ShowComments" style = " white-space: initial;"></div></p>  <div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text" style = "margin-left:1em"><span style = "color:blue">Raine Drop</span> Yeah Dawg!!!</p><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div></div>  <div class="chip"><img src="images/yuna.jpg" alt="Contact Person">Jane Doe</div></div><div class="modal-footer"></div></div>');
          $('#check'+data.portimg_id).click(function(){
             if(this.checked){
                  //alert('HELLO');
                  //alert(data.portimg_id);
                  socket.emit('Select FeaturePortfolioImages','portfolio_images','portimg_id',$('#portIMG'+data.portimg_id).html(),"1",function(tablename,column_id_name,portimg_id,featured){});
             }else{
                    socket.emit('Select FeaturePortfolioImages','portfolio_images','portimg_id',$('#portIMG'+data.portimg_id).html(),"0",function(talename,column_id_name,portimg_id,featured){});
             }
         });

            // Put Select section value
    $('#checkSection'+data.portimg_id).click(function(){
             if(this.checked){
                  portfolioImageSection.push(data.portimg_id);
                //alert('HELLO'+data.projprogimg_id);
                //selectSection_id
                //Create Socket.emit to update projectprog image
                 }else{

                 }
            });
$('#BTNsubmitSection').click(function(e){


     for (var i in  portfolioImageSection){
            // alert($('#selectSection_id').val());
             //alert(projprogImageSection[i]);
         $('#sectionName'+ portfolioImageSection[i]).html('Section: '+$( "#selectSection_id option:selected" ).text());
         $("#checkSection"+ portfolioImageSection[i]).attr('checked',false);
         socket.emit('Assign Section','portfolio_images','portimg_id',$('#selectSection_id').val(), portfolioImageSection[i],function(tablename,column_id_name,section_id,projprogimg_id){});
    }
             portfolioImageSection = [];
});


        }else{
                $('#EditPortfolioImages').append('<div id = "ImageCont'+data.portimg_id+'"><div id  = "portIMG'+data.portimg_id+'" style = "display:none" >'+data.portimg_id+'</div><div class="col s12 m6 l4"><div class="card white"><div class="card-content black-text"><div class = "right-align" > <button id = "DeleteProjProgImage'+data.portimg_id+'"class="btn btn-small red darken-3 white-text">&times</button></div><div class ="left-align"><p><input type="checkbox"   checked = "checked"   id="check'+data.portimg_id+'" /><label for="check'+data.portimg_id+'">Feature Photo</label></p><p><input type="checkbox"  id="checkSection'+data.portimg_id+'" /><label for="checkSection'+data.portimg_id+'"><span id = "sectionName'+data.portimg_id+'">Section: '+data.section_name+'</span></label></p></div><br><a class = "modal-trigger" href = "#"><img style = " width:270px;height:180px;overflow:hidden;" src="'+data.path+'" alt="" class="responsive-img " alt=""></a><div class="row"><div class="input-field col s12"><textarea id  = "imgDescription'+data.portimg_id+'" class="" style = "overflow-y:scroll;height:9em"> '+data.description+'</textarea></div></div></div></div></div></div><div id="modal'+data.portimg_id+'" class="modal"><div class="modal-content" ><img src="'+data.path+'" alt="" class="responsive-img " width = "850"  alt="">   <span class="card-title"><h3>Picture Name</h3></span><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta ratione, aliquid minima autem tempora, dolor impedit quidem tempore dolorem magnam deserunt, illo. Perspiciatis, quia praesentium nihil illo asperiores dolor modi.</p><br><div class = "right-align"><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star</i><i class="material-icons" style = "color:yellow;">star_border</i><p class="truncate">Average Rating: 4</p> </div><form id  = "commentForm"><div class="input-field"><input type="text" id=""><label class="active" for="comment">Write a Comment</label></div><div class    = "right-align"><input id = "btnSubmit" type = "submit"  value = "Comment" class = "main-color-bg" ></div> </form><div id = "ShowComments" style = " white-space: initial;"></div></p>  <div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text" style = "margin-left:1em"><span style = "color:blue">Raine Drop</span> Yeah Dawg!!!</p><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div><p  class = "flow-text"><span style = "color:blue">Raine Drop</span> This Design is cool man!!!</p><div class = "center-align"><button class="btn btn-small purple lighten-2">Reply</button> </div></div>  <div class="chip"><img src="images/yuna.jpg" alt="Contact Person">Jane Doe</div></div><div class="modal-footer"></div></div>');
          $('#check'+data.portimg_id).click(function(){
             if($('#check'+data.portimg_id)){
                   socket.emit('Select FeaturePortfolioImages',$('#portIMG'+data.portimg_id).html(),"1",function(portimg_id,featured){});
             }else{
               // alert('HELLO');
                  //alert(data.portimg_id);
                  socket.emit('Select FeaturePortfolioImages',$('#portIMG'+data.portimg_id).html(),"0",function(portimg_id,featured){});
             }
         });

             $('#checkSection'+data.portimg_id).click(function(){
             if(this.checked){
                  portfolioImageSection.push(data.portimg_id);
                //alert('HELLO'+data.projprogimg_id);
                //selectSection_id
                //Create Socket.emit to update projectprog image
                 }else{

                 }
            });

$('#BTNsubmitSection').click(function(e){


for (var i in  portfolioImageSection){
            // alert($('#selectSection_id').val());
             //alert(projprogImageSection[i]);
         $('#sectionName'+ portfolioImageSection[i]).html('Section: '+$( "#selectSection_id option:selected" ).text());
         $("#checkSection"+ portfolioImageSection[i]).attr('checked',false);

         socket.emit('Assign Section','portfolio_images','portimg_id',$('#selectSection_id').val(), portfolioImageSection[i],function(tablename,column_id_name,section_id,projprogimg_id){});
          }
             portfolioImageSection = [];
      });


}



         //$('#EditPortfolioImages').append('<div id  = "portIMG'+data.portimg_id+'" style = "display:none" >'+data.portimg_id+'</div><div class="col s12 m6 l4"><div class="card white"><div class="card-content black-text"><img src="'+data.path+'" alt="" class="responsive-img" alt=""><div class="row"><div class="input-field col s12"><textarea id  = "imgDescription'+data.portimg_id+'" class="materialize-textarea"> '+data.description+'</textarea></div></div></div></div></div>');
$("#DeleteProjProgImage"+data.portimg_id).click(function(e){
           //  alert(data.projprogimg_id);
             socket.emit('Get DeletePortfolioImage',data.portimg_id,function(projprogimg_id){});
             $('#ImageCont'+data.portimg_id).hide();
        });

/*
    $('#btnSave').click(function(e){

        for (var i in portfolioImages_Description){
           for (var s in portfolioImages_id){

                      alert(portfolioImages_id[s]);
                      alert(portfolioImages_Description[i]);
              //Create Socket.emit for insert image description
socket.emit('InsertPortfolioImageDescription',$('#'+portfolioImages_id[s]).html(),$("#"+portfolioImages_Description).val(),function(portimg_id,image_description){

         }); console.log('portfolioID'+portfolioImages_id[s]+'portfolioImage_Description'+portfolioImages_Description[i]);
           }
       }
    });

  */
 jQuery('#imgDescription'+data.portimg_id).on('input propertychange paste', function() {

        for (var i in portfolioImages_Description){
           for (var s in portfolioImages_id){

                     // alert(portfolioImages_id[s]);
                    //  alert(portfolioImages_Description[i]);
              //Create Socket.emit for insert image description
socket.emit('InsertPortfolioImageDescription',$('#'+portfolioImages_id[s]).html(),$("#"+portfolioImages_Description).val(),function(portimg_id,image_description){

         }); console.log('portfolioID'+portfolioImages_id[s]+'portfolioImage_Description'+portfolioImages_Description[i]);
           }
       }
});




});







                 $('select').material_select();



</script>
<?php
}
?>
