
<?php 
 $user_id = $_SESSION['user_id'];
 $select_user_level = queryMysql("SELECT * FROM users where user_iid='$user_id'");
 $row = mysqli_fetch_array($select_user_level);
 $user_level = $row['levels'];
 $username   = $row['username'];
?> 
<div id = "user_id" style = "display:none"><?php echo $user_id; ?></div>
<div id = "username" style = "display:none" ><?php echo $username; ?></div>
<div id = "user_level"style = "display:none"><?php echo $user_level; ?></div>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {}
        .roomsContainer {
            float:left;
            width:100px;
            height:300px;
            padding:10px;
            overflow:scroll-y;
        }
        .conversationContainer {
            float:left;
            width:300px;
            height:250px;
            overflow:scroll-y;
            padding:10px;
        }
        #data {

        }
    </style>
   

</head>
<body>
<div class="panel panel-default ">
    
          <h3>Direct Messaging </h3>
        
                <div class="panel-body"> 
                    <div class = "row">
                            <div class = "card-panel  col  s12 m12 l6">
                            <div class= "alert alert-default" role = "alert">             
                             <div class = 'chatlogs'>
                                   <div id="conversation"></div>            
                             </div>               
                            </div>
                            <div class = "row">
                            <div class = 'col s12'>
                            
                                 <textarea class="materialize-textarea" id="data" rows="3" cols = '7'></textarea>
                           
                            </div>
                            </div>
                            
                        
                         
                            <div class  = 'right'>
                                	<input type="button" id="datasend" class = 'btn' value="send" >
                            </div> 
                            <div class = "clearfix"></div>
                               <br><br><br>
                            </div>
                        
                            <div class  ="col s12 m12 l6">
                            
                                
                                <div class="card-panel panel main-color-bg">       
                                    <div  style="overflow-y:scroll; height:30em;overflow:hidden;">
                                            <table >
                                            <tbody>
                                              <tr>
                                                <td>
                                                 <div class = "white-text" id = "admin_list"></div>        
                                                </td>
                                                <td>
                                                 <div class = "white-text" id = "admin_online_list"></div>
                                                </td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                                           
                         </div>
                        
                    </div>
                </div>
          </div>
        <script src = "js/JQuery-1.8.0.js"></script>   
 
      <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>
    <script>
        socket.emit("Update ClientChatList",function(){});
 $( document ).ready(function() {
 
              var  ctrReply  = 0;   
              var  socket    =  io.connect('http://localhost:3100');        
        
      

        socket.on('connect', function() {
                socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),' ',' ',' ',' ',' ');
        });
   
        socket.on('updateChat', function(username, data,dateTime) {                         
             var str  = dateTime;
             var date = str.substring(0, 10);
             var time = str.substring(10,14);
             //alert(dateTime);
          if(username == $('#username').html()){
               $('#conversation').append('<div class = "chat self"><br><p class = "chat-message" >' + data +' <br><br>'+date+' '+time+' </p> <br><br><div style = "margin-left:10em;">' + username + '</div></div>');
          }else{
              $('#conversation').append('<div class = "chat friend"><br>' + username + '<p class = "chat-message"> ' + data + '<br><br>'+date+' '+time+'</p></div>');
          }
             $(".chatlogs").scrollTop($(".chatlogs").prop('scrollHeight'));
        });
        
   
        socket.on('chatHistory', function(data) {
              var str  = data.date;
             var date = str.substring(0, 10);
             var time = str.substring(11,16);
           if(data.nick == $('#username').html()){
                  $('#conversation').append('<div class = "chat self"><br><p class = "chat-message" >' + data.msg +' <br><br>'+date+' '+time+' </p> <br><br><div style = "margin-left:10em;">' + data.nick + '</div></div>');
             }else{
               $('#conversation').append('<div class = "chat friend"><br>' + data.nick + '<p class = "chat-message">' + data.msg + ' <br><br>'+date+' '+time+' </p><br></div>');  
             }
            
             $(".chatlogs").scrollTop($(".chatlogs").prop('scrollHeight'));
            
          });
    
    
        socket.on('admin',function(admin_list){
           $('#admin_list').empty();
           $.each(admin_list,function(key,value){
               $('#admin_list').append('<div>'
                    + value
                    + '</div>');
           });
        });
        
        socket.on('admin_online_list',function(store_admin_online){
   
         $('#admin_online_list').empty();
        $.each(store_admin_online,function(key,value){
                if (value  ==  "Online"){
                     $('#admin_online_list').append('<div style = "background-color:green">ONLINE</div>');
                    
                     
                }else{
                    $('#admin_online_list').append('<div>OFFLINE</div>');
                    
                }
           
        });
   });
       socket.on('countMessagesValuesClient',function(countMessagesValues){
           //alert('Triggered');
           $('#messageCounter').empty();
           $.each(countMessagesValues,function(key,value){
               $('#messageCounter').append('<div>'+value+'</div>');
           });
        });
        $('#MessageClick').click(function(){
           socket.emit('Seen Messsages Client'); 
        });  
    
    
        //when the page loads we need to do a few things
        $(function() {
            //get sent data on click
           $('#datasend').click( function() {
                var message = $('#data').val();
                //clear the input box
                $('#data').val('');
                $('#data').focus();
                //send it to the server
                socket.emit('sendChat', message);
            });

            //allow the client to use enter key
            $('#data').keypress(function(e) {
                if(e.which == 13) {
                    $(this).blur();
                    //select the send box
                    $('#datasend').focus().click();
                    //Select the input box
                    $('#data').focus();
                }
            });

        });
 });
 
    </script>




