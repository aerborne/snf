var mysql = require('mysql');
var db  = mysql.createConnection({
    host:'localhost',
    user:'root',
    database:'snfdb'
});
var photoMetaModule = module.exports = {
    SelectProfilePictures:function(user_id,socket){
        var SelectProfPic = db.query('SELECT * FROM user_images where user_iid = ? and available  = 0 ',user_id,function(err,rows,fields,result){
      for (var o in rows){   
          var user_images_id  = rows[o].user_images_id; 
          var path            = rows[o].path;
          socket.emit('set ProfilePictureGallery',{user_images_id:user_images_id,path:path});
      }
     });
        
  },
  CurretProfilePicture:function(user_id,socket){
        var SelectProfPic = db.query('SELECT * FROM user_images where user_iid = ? and available  = 0 and selected = 0 ',user_id,function(err,rows,fields,result){
        for (var o in rows){
             var curr_user_images_id  = rows[o].user_images_id; 
             var curr_path            = rows[o].path;
             socket.emit('set CurrentPhotoSelected',{curr_user_images_id:curr_user_images_id,curr_path:curr_path});
        }    
        });
  },
  UpdateProfilePicture:function(user_id,new_user_images_id,socket){
      var UpdateOldPhoto = db.query('UPDATE user_images set selected = 1 where user_images_id != ?',new_user_images_id,function(err,rows,fields,result){
           if (err) {  
             console.log(err);
            }else{
                var UpdateNewPhoto =  db.query('UPDATE user_images set selected = 0 where user_images_id = ?',new_user_images_id,function(err,rows,fields,result){
                    if (err) {  
                     console.log(err);
                    }else{
                          var SelectProfPic = db.query('SELECT * FROM user_images where user_iid = ? and user_images_id  = ? and selected = 0 ',[user_id,new_user_images_id],function(err,rows,fields,result){
                            for (var o in rows){
                                var up_user_images_id  = rows[o].user_images_id; 
                                var up_path            = rows[o].path;
                                console.log('up_user_images_id '+up_user_images_id);
                                console.log('up_path '+up_path);
                                socket.emit('set updateProfilePicture',{up_user_images_id:up_user_images_id,up_path:up_path});
                            }
                          });
                    }
                })
            }
      });
  }
};
 
