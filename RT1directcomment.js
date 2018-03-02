var mysql = require('mysql');
var db  = mysql.createConnection({
    host:'localhost',
    user:'root',
    database:'snfdb'
});
var commentMetaModule = module.exports = {
  commentModule:function(user_id,variable_id,comment_value ,room,tablename,comment_id_name,reference_id_name,principal_id,type){
       var user_lname,user_fname; 
       var comment_id;
       console.log('socket room id '+room);
      var selectCurr_Tym = db.query('SELECT  DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
                   console.log("curr time value "+curr_tym);
              }
           var select_user_information = db.query('SELECT * FROM users where user_iid = ?',user_id,function(err,rows,fields,results){
             for (var s in rows){
                  user_lname    = rows[s].fname;
                  user_fname    = rows[s].lname;
                    if (err) {console.log(err);}        
             }
            console.log("user_fname value: "+user_fname);
            console.log("user_lname value: "+user_lname);
    
           var insert_user_comment = db.query('INSERT INTO '+tablename+' (comment,user_id,date,'+reference_id_name+',parent_comment_id) VALUES(?,?,?,?,?)',[comment_value,user_id,curr_tym,variable_id,principal_id],function(err,rows,fields){
             if(err){
                 console.log(err);
             }else{
                 console.log('INSERT SUCCESSFULLY'); 
                 var select_recent_comment = db.query('SELECT '+comment_id_name+' as comment_id_name,comment,date FROM '+tablename+' where user_id = ? and date = ? and comment = ?',[user_id,curr_tym,comment_value],function(err,rows,fields){
                      if(err){
                        console.log(err);
                      }else{
                          for (var s in rows){
                            comment_id = rows[s].comment_id_name;
                             var comment    = rows[s].comment;
                             var date       = rows[s].date;  
                       
                        }
                      }
                     //Create function
                     
            if(type == "1"){
                  io.sockets.in(room).emit("set MainCommentDisplay",{fullname:user_fname+" "+user_lname,comment_value:comment_value,user_id:user_id,comment_dt:curr_tym,variable_id:variable_id,comment_id:comment_id,time:'current',parent_comment_id:principal_id});
            }else{
                  io.sockets.in(room).emit("set commentDisplay",{fullname:user_fname+" "+user_lname,comment_value:comment_value,user_id:user_id,comment_dt:curr_tym,variable_id:variable_id,comment_id:comment_id,time:'current',parent_comment_id:principal_id});
            }
            
                 });
        
            }          
           });
             
            
        }); //end of the select_user_information query
     }); //end of selectCurr_Tym query
  },
    
commentHistoryModule:function(pupdate_id,room,tablename,comment_id_name,reference_id_name,offset,type){
   
    var count_history_comments = db.query('SELECT COUNT(*) as counted_rows,'+reference_id_name+' as reference_id_name FROM '+tablename+' left join  users on users.user_iid = '+tablename+'.user_id   where '+reference_id_name+'= ? and '+tablename+'.available = 0  and parent_comment_id = 0 ORDER BY UNIX_TIMESTAMP(date) desc',pupdate_id,function(err,rows,fields,result){
        for(var s in rows){
            var counted_rows = rows[s].counted_rows;
            var variable_id  = rows[s].reference_id_name;
            if(offset == ""){
              room.emit('counted rows',{counted_rows:counted_rows,variable_id:variable_id});   
            }else{     
            }
        }
});                  
    var select_history_comments = db.query('SELECT parent_comment_id,lname,fname,'+comment_id_name+' as comment_id_name,'+reference_id_name+' as reference_id_name  ,comment,user_id,DATE_FORMAT(date,?) as dates,date FROM '+tablename+'  left join  users on users.user_iid = '+tablename+'.user_id   where '+reference_id_name+' = ?  and '+tablename+'.available = 0 and parent_comment_id = 0  ORDER BY UNIX_TIMESTAMP(date) desc  LIMIT 10'+offset,['%Y-%m-%d %h:%i:%s %p',pupdate_id],function(err,rows,fields,results){
             for (var s in rows){
                var   comment_value        = rows[s].comment;
                var   user_id              = rows[s].user_id;
                var   curr_tym             = rows[s].dates;
                var   comment_id           = rows[s].comment_id_name;
                var   reference_id_name    = rows[s].reference_id_name;
                var   lname                = rows[s].lname; 
                var   fname                = rows[s].fname; 
                var   parent_comment_id    = rows[s].parent_comment_id;
                    if (err) {  
                      console.log(err);
                    }else{
                        commentMetaModule.ReplyCommentHistoryModule(comment_id,room,tablename,comment_id_name,reference_id_name,"");
                        
                          if(type == "1"){
                                room.emit("set MainCommentDisplay",{fullname:fname+" "+lname,comment_value:comment_value,user_id:user_id,comment_dt:curr_tym,variable_id:pupdate_id,comment_id:comment_id,time:'history',parent_comment_id:0});
                          }else{
                                room.emit("set commentDisplay",{fullname:fname+" "+lname,comment_value:comment_value,user_id:user_id,comment_dt:curr_tym,variable_id:pupdate_id,comment_id:comment_id,time:'history',parent_comment_id:0});
                          }
                             
                   
                   }
             }
    });    
},
DeletecommentHistoryModule:function(comment_id,room,tablename,comment_id_name,filter_name,filter_value,mode){
     var select_history_comments = db.query('UPDATE '+tablename+' SET '+filter_name+' = ? where '+comment_id_name+' = ?',[filter_value,comment_id],function(err,rows,fields,results){
                    if (err) {
                      console.log(err);
                    }else{
                  
                        io.sockets.in(room).emit('deactivate commment',{comment_id:comment_id,mode:mode,comment:filter_value});
                    }
     });
},
ReplyCommentHistoryModule:function(comment_id,room,tablename,comment_id_name,reference_id_name,offset,type){
      console.log("type value"+type+"+++++++++++++++++++++++++++++++++");
   var comment_owner_id;
    var count_history_comments = db.query('SELECT COUNT(*) as counted_rows,parent_comment_id FROM '+tablename+' left join  users on users.user_iid = '+tablename+'.user_id   where  parent_comment_id = ? and '+tablename+'.available = 0 ORDER BY UNIX_TIMESTAMP(date) desc',comment_id,function(err,rows,fields,result){
        if(err){
            console.log(err);
        }else{ 
            for(var s in rows){
            var counted_rows         = rows[s].counted_rows;
            var variable_id        = rows[s].parent_comment_id;
            if(variable_id   == null){ 
            }else{ 
                // console.log('counted rows:'+counted_rows);
               
                 if(offset == ""){
           
                 room.emit('counted ReplyRows',{counted_rows:counted_rows,variable_id:variable_id});
             
                 
            }else{     
                 
            }
            }
                   
            
           
           }
        }
    });
    var comment_owner = db.query('SELECT user_id FROM '+tablename+' where '+comment_id_name+' = ?',comment_id,function(err,rows,fields,result){
        if(err){
            console.log(err);
            
        }else{
            for(var s in rows){
                comment_owner_id = rows[s].user_id; 
            }
        }
    });
     var select_history_comments = db.query('SELECT parent_comment_id,lname,fname,'+comment_id_name+' as comment_id_name,comment,user_id,DATE_FORMAT(date,?) as dates,date FROM '+tablename+'  left join  users on users.user_iid = '+tablename+'.user_id   where parent_comment_id = ?  and '+tablename+'.available = 0  ORDER BY UNIX_TIMESTAMP(date) desc  LIMIT 10'+offset,['%Y-%m-%d %h:%i:%s %p',comment_id],function(err,rows,fields,results){
             for (var s in rows){
                var   comment_value        = rows[s].comment;
                var   user_id              = rows[s].user_id;
                var   curr_tym             = rows[s].dates;
                var   comment_id           = rows[s].comment_id_name;
                var   lname                = rows[s].lname; 
                var   fname                = rows[s].fname; 
                var   parent_comment_id    = rows[s].parent_comment_id;
                    if (err) {  
                      console.log(err);
                    }else{
                      if(type == "1"){
                           room.emit('set MainReplyCommentDisplays',{comment_value:comment_value,user_id:user_id,comment_dt:curr_tym,comment_id:comment_id,fullname:fname+" "+lname,parent_comment_id:parent_comment_id,time:"history",comment_owner_id:comment_owner_id});
                      }else{
                           room.emit('set ReplyCommentDisplays',{comment_value:comment_value,user_id:user_id,comment_dt:curr_tym,comment_id:comment_id,fullname:fname+" "+lname,parent_comment_id:parent_comment_id,time:"history",comment_owner_id:comment_owner_id});
                      }
                     
                       
                   }
             }
    });     
}
      
};
//modalCommentDiv'+comment_id+'
//deleteCommentModal'+comment_id+'
//Make Synergy Comment Display 
