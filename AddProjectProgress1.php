
<div class = "row">
  
 
     <div class = "container"> 
          <div class = "right-align">
            <a class="waves-effect waves-light modal-trigger" href="#selectUsers"><i class="material-icons right">person_add</i></a>
          </div>
            <br>
            <div class = "divider"> 
            </div><br>
          
              <div class="chip">
                <img src="images/yuna.jpg" alt="Contact Person">
                Jane Doe
              </div>
                            <div class="chip">
                <img src="images/yuna.jpg" alt="Contact Person">
                Jane Doe
              </div>
                 <div class="chip">
                <img src="images/yuna.jpg" alt="Contact Person">
                Jane Doe
              </div>
                            <div class="chip">
                <img src="images/yuna.jpg" alt="Contact Person">
                Jane Doe
              </div>
                 <div class="chip">
                <img src="images/yuna.jpg" alt="Contact Person">
                Jane Doe
              </div>
                            <div class="chip">
                <img src="images/yuna.jpg" alt="Contact Person">
                Jane Doe
              </div>
          <br><br>
          <div class="row">
                <div class="input-field col s12">
                  <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                  <label for="first_name">Project Name</label>
                </div>
                <div class="input-field col s12">
                  <textarea id="textarea1" class="materialize-textarea"></textarea>
                  <label for="textarea1">Description</label>
                </div>
                 <!-- Get Date --> 
            <input type="text" class="datepicker" name = "dateProject" id = "dateProject" data-value = "now" style = "display:none">
         
           <br>
            <label class = "white-text">Category</label>
        <br> <br>
    <select name='category_id' class = "col s12">
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
    <br>
    <div class = "right-align">
        <a class="waves-effect waves-light btn">Add Project</a>
    </div>
  
           </div>
                 <br><br>

              </div><!--Container end tag -->
      
 
</div>
 