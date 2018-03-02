 <div class = "row">
 
 
          <div class="col s12 m12"> 
                    <div class = "center-align">
                        <span class="card-title "><h1>Register User</h1></span>
                   </div>
                      
            <form id="myForm" action="" method = "POST" class="well">
                 <div class="form-group">
                    <label>Lastname:</label>
                    <input type="text"  id =  "Lname" name = "Lastname" class="validate" placeholder="Lastname"  value = "<?php echo $lname; ?>"> 
                    <p id = 'errorLname' class = "#ef5350 red lighten-1" style = "color:white" ></p>
                </div>
                  
                  <div class="right-align">
                 <input  type = "submit"  id = "btn_submitEditUsers<?php echo $user_id;?>" value = "Register" class = "btn" >
                      </div>
                <br>
              </form> 
            
          </div>
      </div> 
      
 