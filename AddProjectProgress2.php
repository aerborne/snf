
<div class = "card-panel">
<div class = "center">
     <h4>Add Project </h4>
</div>
<br>
<div id  = "add_proj_user_id" style = "display:none"><?php echo $logged_user_id; ?></div>
<div class = "row">
   <div class="input-field col s6">
          <input id = "project_name" placeholder="Project Name" id="first_name" type="text" >
          <label for="first_name">Project Name</label>
           <p id = 'errorproject_name' class = "#ef5350 red lighten-1" style = "color:white"></p>
           <p id = 'errorproject_name2' class = "#ef5350 red lighten-1" style = "color:white"></p>
   </div>
     
         <div class="input-field col s6">
    <select id = "project_category_id_selected">
        <?php
       $select_all_category="SELECT * from category where available = '0'";
     echo  $select_all_category;
       $run_all_category= queryMysql($select_all_category);
       while($row_all_category=mysqli_fetch_array($run_all_category)){
                          $category_id      = $row_all_category['category_id'];
                          $category_name    = $row_all_category['category_name'];
        ?>
        <option value="<?php echo $category_id ?>"><?php echo $category_name; ?></option> 
      <?php
        }      
      ?>
    </select>
    <label>Category</label>
  </div>
    <div class="input-field col s12">
         <textarea id="project_description" class="materialize-textarea"></textarea>
         <label for="project_description">Description</label>
   </div>
       <div class = "col s12">
             <div class ="clearfix"></div>
             <div class = "right">
                 <a class="waves-effect waves-light btn modal-trigger" href="#chooseClientsModal">Choose Client</a>
           </div>
 
      <p style = "color:grey">The client of the Project:</p>  
    <div id = "displaySelectedClient"></div>       
      
           
           
           
           
   </div>
</div>
<br><br>
<div class = "right">
        <input  type = "submit"  id = "addProjectProgressBTN" value = "Add Project" class = "btn" >
</div>
<div class ="clearfix"></div>
</div>

<!---  Add Client Modal  Start ============================================== -->

<style>
 
</style>

  <!-- Modal Structure -->
  <div id="chooseClientsModal" class="modal">
    <div class="modal-content">
        <div class = "container"> 
        <div class = "row">
         <div class = "col s10">
                  <input placeholder="Search Name" id="filter_ClientName" type="text" class="validate">
         </div>
            <div class = "col s1">
         <a class="waves-effect waves-light btn" id = "clientSearchFilter"><i class="material-icons">search</i></a>    
     </div> 
  <div class="input-field col s12 left">
    <select  id = "selectionType">
      <option value="1">Latest</option>
      <option value="2">Oldest</option>
      <option value="3">A-Z Lastname</option>
      <option value="4">Z-A Lastname</option>
      <option value="5">A-Z Firstname</option>
      <option value="6">Z-A Firstname</option>
 
    </select>
    <label>Filter</label>
  </div>    
</div>        
       <div id = "clientInformationsList" class = "row" style = "margin-left:2em"></div>
    <hr>
    <div class="modal-footer">
      <a id = "SubmitClientInformationBTN" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
    </div>
      </div>
  </div>
</div>
          
<!---  Add Client Modal  End ============================================== -->



<script> 
     var client_information_arr = [];
    
    
    
    
    
   
$(document).ready(function(){
        //initialize variables  
        $('#filter_ClientName').prop('disabled',true);
        var order_by_value; 
        var column_name_arr =  ['lname','fname','rdate']; 
        var selected_client_id ;
        var clientInformatioOBJlist = '{"clientInformationList":[]}';
        client_obj_ls = JSON.parse(clientInformatioOBJlist);
        order_by_type($('#selectionType').val(),3,column_name_arr[0],""); //initialize default list
          $.getScript("../js/form_validations.js",function(){
              $("#project_name").attr('maxlength','25');
              Keypress_F("project_name","NumbersAndLetters");
              MinLimit_F('project_name','Project Name',6);
            check_username('project_name','addProjectProgressBTN','','','project_progress','projprog_id','name','Project Name'); 
          });
       
        $("#clientSearchFilter").click(function(){
           select_filter_condition();    
        });
        $('#SubmitClientInformationBTN').click(function(){
            $('#displaySelectedClient').empty();
                for (var i = 0; i <  client_obj_ls.clientInformationList.length; i++) {
                       if($('input[name="radioChoosenClient"]:checked').val() == client_obj_ls.clientInformationList[i].client_id){
                            $('#displaySelectedClient').append('<div class="chip"><img src="'+client_obj_ls.clientInformationList[i].path+'" alt="Contact Person">'+client_obj_ls.clientInformationList[i].fullname+'</div><div id = "clientSelectedID" style = "display:none">'+client_obj_ls.clientInformationList[i].client_id+'</div>'); 
                       }
               }
            
        });
       $('#addProjectProgressBTN').click(function(){
                        if($('#project_name').val().length == 0
                            || $('#project_description').val().length == 0){
                            alert('Please Fill up all fields!');     
                       }else if ($('#project_name').val().length <  6){
                       }else if ($('#displaySelectedClient').contents().length == 0){
                            alert("Please select a client! ");
                       }else{
                            socket.emit('insert projectProgress',$('#project_name').val().trim(),$('#project_description').val(),$('#project_category_id_selected').val(),$('#clientSelectedID').html(),$('#add_proj_user_id').html(),function(project_name,project_description,category_id,client_id,user_id){});
                            $('#project_name').val('');
                            $('#project_description').val('');
                            $('#displaySelectedClient').empty();
                            $('#project_name').blur();
                            $('#project_description').blur();
                            $('#errorproject_name2').hide();
                            $("input[name='radioChoosenClient']").attr("checked", false);
                            window.open('admin_meta_index.php?allprojectpage','_self');
                       }
                 
        });
     
socket.on('set ClientNames',function(data){
      var clientInformationsList  =  "clientInformationsList" //div id 
      if(data.path  === null){
          displayClientList(data.fullname,"simages/no_picture.png",data.user_id,clientInformationsList);
      }else{
          displayClientList(data.fullname,data.path,data.user_id,clientInformationsList);
      } 
});
 socket.emit('get AddClientsInformation',function(selectionType){});    
        $("#selectionType").change(function(){ 
          
           select_filter_condition();   
});
function select_filter_condition(){
     client_obj_ls.clientInformationList = [];
        $('#clientInformationsList').empty();
        var select_value =  $('#selectionType').val();  
        var filter_clientName  = $('#filter_ClientName').val().trim();
            if(select_value > 2 && 5 >  select_value){
               order_by_type(select_value,3,column_name_arr[0],filter_clientName);
               $('#filter_ClientName').prop('disabled',false);
            }else if (select_value > 4 && select_value < 7){ 
               order_by_type(select_value,5,column_name_arr[1],filter_clientName);
               $('#filter_ClientName').prop('disabled',false);
            }else if (select_value < 3 ){ 
               order_by_type(select_value,1,column_name_arr[2],filter_clientName);
               $('#filter_ClientName').prop('disabled',true);
               $('#clientSearchFilter').prop('disabled',true);
            }
}
function order_by_type(select_value,greater_than_value,column_name,filter_clientName){
    var  select_user_script   =  "select fname,lname,rdate,users.available as users_available,path,users.user_iid as client_id,users.levels,user_images.selected from users   left join  user_images on users.user_iid = user_images.user_iid where (user_images.selected = 0 or user_images.selected is null) and users.levels = 'Client' and users.available = 0 ";
    var  where_clause_script  =  " and "+column_name+" like '"+filter_clientName+"%' ";
    var  order_by_script; 
    var  final_script; 
       if(select_value > greater_than_value){       
             order_by_value  = "desc"                                   
       }else{
             order_by_value  = "asc"
       }
      order_by_script      =  " order by "+column_name+" "+order_by_value; 
      if(select_value > 2){
          if (filter_clientName == ''){
               final_script = select_user_script +order_by_script; 
          }else{
               final_script = select_user_script+where_clause_script+order_by_script;
          }
      }else{
          final_script = select_user_script +order_by_script; 
      }
        socket.emit('Get ClientsInformation',final_script,function(script_value){});                 
}
        
    });
 
function  displayClientList(fullname,path,client_id,variable_id){
    $('#'+variable_id).append('<div class  ="col s12 m6 l6" style = "padding:0.5em;"><div class = "clientInformationDiv"><input name = "radioChoosenClient" type="radio"   id="clientID'+client_id+'"    value = "'+client_id+'"/> <label class = "clientInformationCheckbox" for="clientID'+client_id+'" ></label><div  style = "width:3em;"><img class="responsive-img clientInformationImg" src = "'+path+'"> </div><span id= "clientNameLabel"  class  = "clientInformationNameField" >'+fullname+'</span></div> </div> ');
     client_obj_ls.clientInformationList.push({"fullname":fullname,"path":path,"client_id":client_id });
}  
    
   
 
</script>

