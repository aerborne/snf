var mysql = require('mysql');
var db  = mysql.createConnection({
    host:'localhost',
    user:'root',
    database:'snfdb'
});
var projectProgressMetaModule = module.exports = {
      getClientNames:function(script_value,socket){
          var path; 
          var user_iid;
            var getClientNamesQ = db.query(script_value,function(err,rows,fields){
              for(var o in rows){
                 var  lname     = rows[o].lname;
                 var  fname     = rows[o].fname;
                 var  client_id  = rows[o].client_id;
                 var  path      = rows[o].path;
                  socket.emit('set ClientNames',{user_id:client_id,fullname:fname+" "+lname,path:path});
              }
            });   
      },
   
    
      insertProjectProgress:function(project_name,project_description,category_id,client_id,user_id,socket){
            var selectCurr_Tym = db.query('SELECT DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
              }
           
          var insertProjectProgressQ = db.query("INSERT INTO project_progress(name,description,category_id,customer_id,dated,user_iid) VALUES(?,?,?,?,?,?) ",[project_name,project_description,category_id,client_id,curr_tym,user_id],function(err,rows,fields){
                  if (err) {
                                     console.log(err); 
                                     }    
          });  
        });
      },
    
}
//deleteProjectProgressPicUploads