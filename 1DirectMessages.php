 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   

 
  <body>
 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
  </body>
<?php 
 $user_id           = $_SESSION['user_id'];
 $select_user_level = queryMysql("SELECT * FROM users where user_iid='$user_id'");
 $row = mysqli_fetch_array($select_user_level);
 $user_level = $row['levels'];
 $username   = $row['username'];
?> 
<div id = "user_id" style = "display:none"><?php echo $user_id; ?></div>
<div id = "username"  style = "display:none"><?php echo $username; ?></div>
<div id = "user_level" style = "display:none"><?php echo $user_level; ?></div>
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
        .words {
            font-family: apple;
            font-size: 20px;
            max-width: 800px;
            margin-top: 10px;
            margin-left: 42%;
          }
    </style>
     
      <link type="text/css" rel="stylesheet" href="css/style2.css"  media="screen,projection"/>
 

 <div class = "row">
 
        
 
                    <div class = "row">
                            
                            <div class  ="col s12 m12 l6">
                             
                                <div class="panel-heading">
                                  <h3 class="panel-title"> Message List</h3>
                                </div>
            
                  
                         <div class = "card-panel">
                             <input id = 'SearchKeyword' type = "text" class = "form-control">
                         <p id = "SearchKeywordResult" style = "position:absolute; background-color:grey "></p>
                        <div class = "right">
                                <input id = "submit" type = "submit" class = "btn" value =  "Search">
                        </div>
                             <br><br>
                        </div>
                            
                     
              
                   
                 
               
                    
                
                               <div class="panel main-color-bg">     
                                <div class="panel-body">       
                                    <div  style="overflow-y:scroll; height:25em;">
                                        <table class="table ">
                                            <tbody>

                                              <tr>
                                                                                                  <td>
                                                <div id  = "online_list"  class = "white-text" style = "font-color:white;"></div>
                                                </td>
                                                   <td>
                                                      <div id  = "Room_levels" class = "white-text" style = "font-color:white;"></div>
                                                   </td>
                                                   <td>
                                                      <div id = "room_names" class = "white-text" style = "font-color:white;"></div>
                                                   </td>
                                                   <td>
                                                      <div id="rooms"  class = "white-text" style = "background-color:orange; font-color:white;"></div>
                                                   </td>
                                                    <td>
                                                       <div id = "messageCounter"  class = "white-text" style = "font-color:white;"> </div>
                                                   </td>
                                                  <td>
                                                       <div id  = "Room_levels" class = "white-text" style = "font-color:white;"></div>
                                                   </td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                                            
                         </div>
                        
                        
                        
                    </div>
                       
                        <div class = "col s12 m12 l6">
                                 <div class="card-panel">
                                    
                                      <h3><div  class = "black-text" id = "receiver_name"></div></h3>
                                  
                                    <div class="panel-body">
                                         <div class= "alert alert-default" role = "alert">         
                                           
                                             <div id ='chat' class = 'chatlogs'>
                                                   <div id="conversation"></div>            
                                             </div>               
                                            </div>
                                            <div class = "row">
                                            <div class = 'col-md-12'>
                                            <div class = 'form-group'>
                                                 <textarea class="form-control" id="data" rows="3" cols = '7'></textarea>
                                            </div>
                                            </div>
                                            </div>
                                            <div class = 'col-md-9'>
                                            </div>

                                             
                                            <div class  = 'right'>
                                                    <input type="button" id="datasend" class = 'btn' value="send" >
                                            </div> 
                                              <br>
                                    </div>
                                    <div class="panel-footer"><div id = "y"></div></div>
                                  </div>

                           
                            </div>
     
      
</div>

<script src = "js/jquery-1.11.3.min.js"></script>

    <script src = "http://localhost:3100/socket.io/socket.io.js"></script>
    <script>
    $(".chatlogs").scrollTop($(".chatlogs")[0].scrollHeight);
        $('#user_id').hide();
        $('#username').hide();
        $('#user_level').hide();
 
        var socket = io.connect('http://localhost:3100');
        
        
        socket.on('Searched Username',function(data){
            // alert($('#user_id').html());
            if( $('#SearchKeyword').val().trim() == '' ) {
                $('#SearchKeywordResult').empty();
            }else{
                 
                if($('#user_id').html() == data.user_id){
                    
                }else{
                     $('#SearchKeywordResult').append(' <div style = "color:white;"><body link="white"><a style = "color:white;" href="#" onclick="switchRoom('+data.user_id+')">'+data.fname+'</a></body</div>');       
                }
             
         
            }       
             });
               $('#submit').click(function(e){
                $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordUsername',$('#SearchKeyword').val(),function(keyword){});
        
              });
              jQuery('#SearchKeyword').on('input propertychange paste', function() {
                   $('#SearchKeywordResult').empty();
                  socket.emit('Search KeywordUsername',$('#SearchKeyword').val(),function(keyword){});
            });
        
        
        
        
        
        

        socket.on('connect', function() {
            socket.emit('addUser',$('#user_id').html(),$('#username').html(),$('#user_level').html(),' ',' ',' ',' ',' ');
        });

        socket.on('updateChat', function(username,data,dateTime) {
         
             var str  = dateTime;
             var date = str.substring(0, 10);
             var time = str.substring(11,16);
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
             //<p class="text-right text-capitalize">Right aligned text.</p>
            //<div class="pull-right">Div floated to right</div>
             if(data.nick == $('#username').html()){
                  $('#conversation').append('<div class = "chat self"><br><p class = "chat-message" >' + data.msg +' <br><br>'+date+' '+time+' </p> <br><br><div style = "margin-left:10em;">' + data.nick + '</div></div>');
             }else{
               $('#conversation').append('<div class = "chat friend"><br>' + data.nick + '<p class = "chat-message">' + data.msg + ' <br><br>'+date+' '+time+' </p><br></div>');  
             }
    $(".chatlogs").scrollTop($(".chatlogs").prop('scrollHeight'))
             
          });

        socket.on('updateRooms', function(rooms, currentRoom) {
            $('#rooms').empty();
            $.each(rooms, function(key, value) {
                if($('#user_id').html() == value){
                         $('#rooms').append('<div style = "font-color:black; cursor:not-allowed; ">Message</div>');
                 }
                else{
                if(value === currentRoom) {
                    $('#rooms').append('<div style = "font-color:white; cursor:pointer;">Message</div>');
                }else {
                    $('#rooms').append('<div style = "color:white;"><body link="white"><a style = "color:white;" href="#" onclick="switchRoom(\''+ value + '\')">Message</a></body</div>');
                }
                }

            });
        });
       socket.on('countMessagesValuesClient',function(countMessagesValues){
           $('#messageCounterAdmin').empty();
           $.each(countMessagesValues,function(key,value){
               $('#messageCounterAdmin').prepend('<div>'+value+'</div>');
           });
});
        
        socket.on('updateRoomsNames',function(room_names){
           // alert('Triggered');
           $('#room_names').empty();
            
           $.each(room_names,function(key,value){
               $('#room_names').append('<div>'
                    + value
                    + '</div>');
           });
        });
     socket.on('updateRoomLevels',function(room_level){
          
        $('#Room_levels').empty();
         $.each(room_level,function(key,value){
            $('#Room_levels').append('<div>'+value+'</div>');
         });
         
     });
  
    socket.on('online_users',function(store_online_list){
      
        $('#online_list').empty();
         $.each(store_online_list,function(key,value){

            $('#online_list').append('<div>'+value+'</div>'); 
         });
    });
 
   socket.on('countMessagesValues',function(countMessagesValuesAdmin){
        
        $('#messageCounter').empty();
        var x =  "0";
         $.each(countMessagesValuesAdmin,function(key,value){
             if(value == 0 ){
              $('#messageCounter').append('<div>'+x+'</div>');       
             }else{
              $('#messageCounter').append('<div>'+value+'</div>');   
             }
                  
           
         });      
   });  
 
   socket.on('Admin OnlineIndicator',function(admin_online_indicator){
         $('#online_list').empty();
        $.each(admin_online_indicator,function(key,value){
            
             if (value == "Online"){
                 $('#online_list').append('<div  style = "background-color:green">'+value+'</div>'); 
             }else{
                 $('#online_list').append('<div  >'+value+'</div>'); 
             }
             
        });
   });
 
   socket.on('Display Receiver',function(data){
     //  alert('data user_level'+data.user_level);
      $('#receiver_name').empty();
      $('#y').empty();
       
      $('#receiver_name').append('<div>'+data.username+'</div>');
      $('#y').append('<div>'+data.user_level+'</div>');
   });
        
        function switchRoom(room) {
            $('#conversation').html(' ');
            socket.emit('switchRoom', room);
            socket.emit('get room_id',room);
            
            
        }

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
        
 
 
$("#conversation").animate({ scrollBottom: $('#conversation').prop("scrollHeight")}, 1000);
 
    </script>

   
<br>
<br>
<br>


