var siofu = require("socketio-file-upload");
var express = require('express'),
  app = express().use(siofu.router),
  http = require('http'),
  server = http.createServer(app),
  bodyParser =  require('body-parser'),
  multer = require('multer')
  io = require('socket.io').listen(server);
var multer	=	require('multer');
var dateformat = require('dateformat');
var now = new Date();
var fieldnameValue;

server.listen(3100);
// routing
app.get('/', function (req, res) {
  res.sendFile(__dirname + '/1DirectMessages.html');
  res.sendFile(__dirname + '/index.html');
});
var mysql = require('mysql');
var db  = mysql.createConnection({
    host:'localhost',
    user:'root',
    database:'snfdb'
});
//Declaring Variables for MessageModule Start
var messageCounterValues = [];
var ratingValues = [1,2,3,4,5];
var rooms = [];
var room_names = [];
var  room_level = [];
var online_list = [];
var admin_online_indicator = [];
var client_online_indicator = [];
var store_admin_online = [];
var pathArray = [];
online_users  = [];
company_users = [];
admin = [];
client = [];
var user_level;
var messageCounter ;
var admin_list = [];
var admin_online_list = [];
//Declaring Variables for MessageModule End
//Declaring Variables for CommentModule Start
var primary_user_id ;
var  primary_comment_id;
var commentCtr = 0;
//Declaring Variables for CommentModule End

var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;

db.connect(function(err){
   if(err)console.log(err)
});


var bcrypt = require('bcrypt-nodejs');
const saltRounds = 10;
const myPlaintextPassword = '12345qwerty';
const someOtherPlaintextPassword = 'not_bacon';
var salt = bcrypt.genSaltSync(saltRounds);
var hash = bcrypt.hashSync(myPlaintextPassword, salt);

console.log('hash password '+hash);


//console.log(bcrypt.compareSync(someOtherPlaintextPassword, hash));
io.sockets.on('connection', function(socket) {


    ///////start test zone
      // Make an instance of SocketIOFileUpload and listen on this socket:

    /////////////////////////////test end zone
     SelectClients(socket);



socket.on('Relate PicturesPortfolioToProject',function(name,path){
    console.log('Relate Pictures has been triggered');
    var selectPortfolio_id  = db.query('SELECT * FROM portfolio where available = 0 order by portfolio_id desc limit 1 ',function(err,rows,fields){
        for (var s in rows){
               if(err){
                 console.log(err);
               }
            var portfolio_id   = rows[s].portfolio_id;

        }

            //console.log('latest portfolio id '+portfolio_id);
    var selectCurr_Tym = db.query('SELECT  DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
              }

         var insertImages = db.query("insert into portfolio_images(name,portfolio_id,path,upload_datetime) values(?,?,?,?)",[name,portfolio_id,path,curr_tym],function(err,rows,fields){
         if(err){

             console.log(err);
         }
        });

      });

    });
//


    /*
    var insertImages = db.query("insert into projectprog_image(name,pupdate_id,path) values('$shortname','$pupdate_id','$filePath')",function(err,rows,fields){
         if(err){
             console.log(err);
         }
     });
     */
});




socket.on('Add Portfolio',function(portfolio_name,description,category_id,user_id,project_id){
    console.log('portfolio_name: '+portfolio_name);
    console.log('description: '+description);
    console.log('category_id: '+category_id);
    var  insertPortfolio = db.query('INSERT INTO portfolio(name,description,category_id,user_iid,dated,projprog_id) VALUES(?,?,?,?,?,?)',[portfolio_name,description,category_id,user_id,dateTime,project_id],function(err,rows,fields){
        if(err){
            console.log(err);
        }
      var setImported  =  db.query('UPDATE project_progress SET imported =  1 where projprog_id = ?',project_id,function(err,rows,fields){
           if(err){
               console.log(err);
           }
      });
    });
});
 socket.on('Get pupdate_ID',function(projprog_id){
     ///console.log('projprog_id get pupdate_id'+projprog_id);
     SelectProjectUpdateSections(socket,projprog_id);
     SelectAllPictures(socket,projprog_id);
     SelectNoneSectionPictures(socket,projprog_id);

});
socket.on('Get portfolio_id',function(portfolio_id){
    //console.log('portfolio id value:  '+portfolio_id);
    SelectPortfolioSections(socket,portfolio_id);
    SelectAllPortfolioPictures(socket,portfolio_id);
    SelectNoneSectionPortfolioPictures(socket,portfolio_id);
    SelectPortfolioFeatPictures(socket,portfolio_id);

});
socket.on('Get FeaturePhotosProjProgID',function(projprog_id){

     SelectProjProgFeatPictures(socket,projprog_id);

});
    //Create Feature

socket.on('Display SectionPictures',function(pupdate_id,section_id){
     SelectSectionPictures(socket,pupdate_id,section_id);
});
socket.on('Display SectionPortfolioPictures',function(portfolio_id,section_id){
     //console.log('display portfolio_id :'+portfolio_id);
     //console.log('display section_id :'+section_id);
    SelectSectionPortfolioPictures(socket,portfolio_id,section_id)

});

socket.on ('Get EditCategoy',function(category_id,category_name){
     console.log('category id'+category_id);
     console.log('category name'+category_name);
  var editCategoryName  = db.query('UPDATE category set category_name  = ? where category_id = ?',[category_name,category_id],function(err,rows,fields){
       if (err) {
         console.log(err);
       }
  });
});

socket.on('Get DeleteORRestore',function(primary_id,name,tablename,primaryColumnName,available){
     console.log('primary_id: '+primary_id);
     console.log('name:' +name);
     console.log('tablename '+tablename);
     console.log('primaryColumnName'+primaryColumnName);
var  RestoreCategory  = db.query('UPDATE '+tablename+' set available = '+available+' where '+primaryColumnName+' = ?',[primary_id],function(err,rows,fields){
      if(err){
        console.log(err);
      }
});
});

//Client Pagination for selecting users for the create project function
 socket.on('Client Pagination',function(OffsetCounter){
     console.log('Client Pagination');
     var  selectClient  = db.query('SELECT * FROM users where levels = ?  and available = ? LIMIT 10 OFFSET ?',['Client',0,OffsetCounter],function(err,rows,fields){
        for(var s in rows){
              var user_id = rows[s].user_iid;
              var lname   = rows[s].lname;
              var fname   = rows[s].fname;
              var mname   = rows[s].mname;
              var username = rows[s].username;

             console.log('user_id '+user_id);

            socket.emit('Selected Clients',{user_id:user_id,lname:lname,fname:fname,mname:mname,username:username});
        }
    });

 });


    socket.on('Get EditedHomeHeader',function(header,content,element_id){
  console.log('GET EDITED RESPONSE');


         var  searchClient  = db.query("UPDATE homepage SET header = ?, content  = ?  WHERE element_id = ?; ",[header,content,element_id],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                        console.log(err);
                 }

        }
              io.sockets.emit('DisplayHeader',{header:header,content:content});
    });

});

 socket.on('Get EditedHomeHeader1',function(header,content,element_id){
  console.log('GET EDITED RESPONSE11111111111');
         var  searchClient  = db.query("UPDATE homepage SET header = ?, content  = ?  WHERE element_id = ?; ",[header,content,element_id],function(err,rows,fields){
           for(var s in rows){
             //var counter = rows[s].NumberOfProductsa;
            // console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }

        }
              io.sockets.emit('DisplayHeader1',{header:header,content:content});
    });

});

     socket.on('Get EditedHomeHeader2',function(landline,mobilenumber,emailAdd,MailAddress,contact_id){
  console.log('GET EDITED RESPONSE CONTACT US1');
         var  searchClient  = db.query("UPDATE contact SET landline = ?, mobile_no = ?,email_address = ?, mail_address = ?  WHERE contact_id = ?; ",[landline,mobilenumber,emailAdd,MailAddress,contact_id],function(err,rows,fields){
           for(var s in rows){

             //console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }

        }
            io.sockets.emit('DisplayHeader2',{landline:landline,mobilenumber:mobilenumber,emailAdd:emailAdd,MailAddress:MailAddress});
    });

});


 /// SEARCH SOCKETS ============================================
socket.on('Search Keyword',function(keyword){
    console.log('Search Keyword triggerd');
       var  searchClient  = db.query("SELECT * FROM users where levels = 'Client' and (lname like ?  or fname like ? or username like ?) and available = 0 limit 5",[keyword+'%',keyword+'%',keyword+'%'],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var user_id = rows[s].user_iid;
              var lname   = rows[s].lname;
              var fname   = rows[s].fname;
              var mname   = rows[s].mname;
              var username = rows[s].username;

             console.log('user_id '+user_id);

            socket.emit('Searched Clients',{user_id:user_id,lname:lname,fname:fname,mname:mname,username:username});
        }
    });
});
////////////////////////////////////////////////////////////////////////////////////////////    ///////////////////////////
socket.on('Search KeywordAdmin',function(keyword,available){
    console.log('Search Keyword triggerd');
       var  searchClient  = db.query("SELECT * FROM users where  (lname like ?  or fname like ? or username like ?)  limit 5",[keyword+'%',keyword+'%',keyword+'%'],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var user_id = rows[s].user_iid;
              var lname   = rows[s].lname;
              var fname   = rows[s].fname;
              var mname   = rows[s].mname;
              var username = rows[s].username;

             console.log('user_id '+user_id);

            socket.emit('Searched Clients',{user_id:user_id,lname:lname,fname:fname,mname:mname,username:username});
        }
    });
});
socket.on('Search KeywordUsername',function(keyword){
    console.log('Search Keyword triggerd');
       var  searchClient  = db.query("SELECT * FROM users where  (lname like ? OR fname like ? ) and available = 0 limit 5",[keyword+'%',keyword+'%'],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);

                  if (err) {
                                 console.log(err);
                                 }
              var user_id = rows[s].user_iid;
              var lname   = rows[s].lname;
              var fname   = rows[s].fname+" "+rows[s].lname;;
              var mname   = rows[s].mname;
              var username = rows[s].username;
            console.log('username'+username);
             console.log('user_id '+user_id);

            socket.emit('Searched Username',{user_id:user_id,lname:lname,fname:fname,mname:mname,username:username});
        }
    });
});
socket.on('Search KeywordCategory',function(keyword,available){
    console.log('Search Keyword triggerd');
       var  searchClient  = db.query("SELECT * FROM category where  (category_name like ?  ) and available = ? limit 5",[keyword+'%',available],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var category_id = rows[s].category_id;
              var category_name   = rows[s].category_name;

             console.log('category_id '+category_id);
             console.log('category_name'+category_name);

            socket.emit('Searched Category',{category_id:category_id,category_name:category_name});
        }
    });
});

socket.on('Search KeywordSection',function(keyword,available){
    console.log('Search Keyword triggerd');
       var  searchClient  = db.query("SELECT * FROM section where  (section_name like ?) and available = ? limit 5",[keyword+'%',available],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var category_id = rows[s].section_id;
              var category_name   = rows[s].section_name;

             console.log('category_id '+category_id);
             console.log('category_name'+category_name);

            socket.emit('Searched Section',{category_id:category_id,category_name:category_name});
        }
    });
});

socket.on('Search KeywordPortfolio',function(keyword,available){
    console.log('Search Keyword triggerd');
    console.log('Keyword '+keyword);
    console.log('Available'+available);

       var  searchClient  = db.query("SELECT * FROM portfolio where  (name like ?  ) and available = ? limit 5",[keyword+'%',available],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var portfolio_id = rows[s].portfolio_id;
              var name   = rows[s].name;

             console.log('portfolio_id '+portfolio_id);
             console.log('name'+name);

            socket.emit('Searched Portfolio',{portfolio_id:portfolio_id,name:name});
        }
    });
});
socket.on('Search KeywordProject',function(keyword,available){
    console.log('Search Keyword triggerd');
       var  searchClient  = db.query("SELECT * FROM project_progress where  (name like ?  ) and available = ? limit 5",[keyword+'%',available],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var projprog_id = rows[s].projprog_id;
              var name   = rows[s].name;
              var category_id  = rows[s].category_id;

             console.log('name'+name);

            socket.emit('Searched Project',{projprog_id:projprog_id,name:name,category_id:category_id});
        }
    });
});
socket.on('Search KeywordProjectIntD',function(keyword,user_id,available){
    console.log('Search Keyword triggerd');

       var  searchClient  = db.query("SELECT * FROM project_progress where  (name like ?  )  and  user_iid = ? and available = ?  limit 5",[keyword+'%',user_id,available],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var projprog_id = rows[s].projprog_id;
              var name   = rows[s].name;
              var category_id  = rows[s].category_id;

             console.log('name'+name);

            socket.emit('Searched ProjectIntD',{projprog_id:projprog_id,name:name,category_id:category_id});
        }
    });
});
    socket.on('Search KeywordPortfolioIntD',function(keyword,user_id,available){
    console.log('Search Keyword triggerd');
    console.log('Keyword '+keyword);
    console.log('user_id'+user_id);
    console.log('available '+available);
       var  searchClient  = db.query("SELECT * FROM portfolio where  (name like ?  ) and available = ?  and user_iid = ? limit 5",[keyword+'%',available,user_id],function(err,rows,fields){
                if (err) {
                                 console.log(err);
                                 }
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var portfolio_id = rows[s].portfolio_id;
              var name   = rows[s].name;

             console.log('portfolio_id '+portfolio_id);
             console.log('name'+name);

            socket.emit('Searched PortfolioIntD',{portfolio_id:portfolio_id,name:name});
        }
    });
});

socket.on('Search KeywordProjectClient',function(keyword,user_id){
    console.log('keyword'+keyword);
    console.log('user_id'+user_id);
    console.log('Search Keyword triggerdKeyword Project CLient');
       var  searchClient  = db.query("SELECT * FROM project_progress where  (name like ?) and available = 0 and customer_id = ? limit 5",[keyword+'%',user_id],function(err,rows,fields){
           for(var s in rows){
             var counter = rows[s].NumberOfProductsa;
             console.log('counter'+counter);
                  if (err) {
                                 console.log(err);
                                 }
              var projprog_id = rows[s].projprog_id;
              var name   = rows[s].name;
              var category_id  = rows[s].category_id;

             console.log('name'+name);

            socket.emit('Searched ProjectClient',{projprog_id:projprog_id,name:name,category_id:category_id});
        }
    });
});


  //////////////////////////////
  admin_list = [];
  admin_online_list = [];

   var pupdate_id_data ;
 var OnlineList = db.query('SELECT * FROM users ',function(err,rows,fields,result){
        room_names = [];
        room_level = [];
        online_list = [];

        rooms = [];
      for (var o in rows){
                var user_iid    = rows[o].user_iid;
                var username    = rows[o].fname+" "+rows[o].lname;
                var user_level  = rows[o].levels;
                online_list.push(user_iid);
                rooms.push(user_iid);
                room_names.push(username);
                room_level.push(user_level);
               if(user_level != 'Client'){
                    admin_online_list.push(user_iid);
                    //console.log(' aaa  user_id'+user_iid)
               }

            }
socket.on('Edit UserInfo',function(a){
     console.log(a);
});

socket.on('Update UserPassword',function(NewPassword,user_id){
    const saltRound = 10;
     var salt = bcrypt.genSaltSync(saltRound)
     var hash = bcrypt.hashSync(NewPassword,salt);
     console.log('Hash New Password'+hash);

 var  updatePassword = db.query('UPDATE users set pass = ? where  user_iid = ? ',[hash,user_id],function(err,rows,fields){
      if (err) {
                                 console.log(err);
                                 }
 });
});

//Check if category name is unique
socket.on('Check  category_name',function(category_name){
   console.log('category_name '+category_name);
   var check_category_name = db.query('SELECT COUNT(category_id) AS rows  FROM category where category_name = ?  and available = 0',[category_name],function(err,rows,fields){
           for (var o in rows){
                var rows    = rows[o].rows;
                console.log('count:'+rows);
            }
         socket.emit('check category_name_result',{rows:rows});
   });
});
socket.on('Register Category',function(category_name){
    var  insertCategory = db.query('INSERT INTO category(category_name) VALUES(?)',[category_name],function(err,rows,fields){
          if(err){
             console.log(err);
          }
    });


});
//Check Section name if it is unique
socket.on('Check  section_name',function(section_name){
     console.log('section name '+section_name);
    var check_section_name = db.query('SELECT COUNT(section_id) AS rows  FROM section where section_name = ?  and available = 0',[section_name],function(err,rows,fields){
      if(err){
          console.log(err);
      }
          for (var o in rows){
                var rows    = rows[o].rows;
                console.log('count:'+rows);
            }
         socket.emit('check section_name_result',{rows:rows});
    });
});
//Register Section Name
socket.on('Register Section',function(section_name){
    var insertSection = db.query('INSERT INTO section(section_name) VALUES(?)',[section_name],function(err,rows,fields){
         if(err){
             console.log(err);
         }
    });
});
socket.on('Register  User2',function(Lname,Fname,Mname,username,password,mobilenumber,gender,birthdate,levels){
    console.log('HELLO');
     console.log("Lname "+Lname);
     console.log("Fname "+Fname);
     console.log("Mname "+Mname);
     console.log("username "+username);
     console.log("password "+password);
     console.log("mobilenumber "+mobilenumber);
     console.log("gender "+gender);
     console.log("birthdate "+birthdate);
     //Hashing Password
       const saltRound = 10;
       var salt = bcrypt.genSaltSync(saltRounds)
       var hash = bcrypt.hashSync(password,salt);
       console.log('Hash Password'+hash);
     var selectCurr_Tym = db.query('SELECT NOW() as curr_tym',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
              }
          var saveNotification = db.query('INSERT INTO users(lname,fname,mname,username,pass,levels,available,rdate,gender,mobilenumber,dateofbirth) VALUES(?,?,?,?,?,?,?,?,?,?,?)',[Lname,Fname,Mname,username,hash,levels,'0',curr_tym,gender,mobilenumber,birthdate],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
     });
     });

});
socket.on('Update NewUserPassword',function(new_password,user_id){
      const saltRound = 10;
       var salt = bcrypt.genSaltSync(saltRounds)
       var hash = bcrypt.hashSync(new_password,salt);
     var saveNotification = db.query('update users set pass = ? where user_iid = ?',[hash,user_id],function(err,rows,fields){
         if(err){
             console.log(err);
         }else{

         }
     });

});

     socket.on('Register  User',function(Lname,Fname,Mname,username,password,mobilenumber,gender,birthdate){
    console.log('HELLO');
     console.log("Lname "+Lname);
     console.log("Fname "+Fname);
     console.log("Mname "+Mname);
     console.log("username "+username);
     console.log("password "+password);
     console.log("mobilenumber "+mobilenumber);
     console.log("gender "+gender);
     console.log("birthdate "+birthdate);
     //Hashing Password
       const saltRound = 10;
       var salt = bcrypt.genSaltSync(saltRounds)
       var hash = bcrypt.hashSync(password,salt);
       console.log('Hash Password'+hash);
     var saveNotification = db.query('INSERT INTO users(lname,fname,mname,username,pass,levels,available,rdate,gender,mobilenumber,dateofbirth) VALUES(?,?,?,?,?,?,?,?,?,?,?)',[Lname,Fname,Mname,username,hash,'Client','0',dateTime,gender,mobilenumber,birthdate],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
     });
});
socket.on('Update Users',function(Lname,Fname,Mname,mobilenumber,gender,birthdate,level,username,user_id){
   console.log('Lname'+Lname);
   console.log('Fname'+Fname);
   console.log('Mname'+Mname);
   console.log('Gender'+gender);
   console.log('mobilenumber'+mobilenumber);
   console.log('birthdate '+birthdate);
   console.log('levels'+level);
   console.log('user_id'+user_id);
   console.log('username'+username);
     var updateUsers =  db.query('UPDATE users set lname = ?, fname = ? , mname = ?, mobilenumber = ?, dateofbirth = ?, gender = ?, levels = ?, username = ? where  user_iid = ? ',[Lname,Fname,Mname,mobilenumber,birthdate,gender,level,username,user_id],function(err,rows,fields,results){
              if (err) {
                                console.log(err);
                                }

     });
});
socket.on('Update UsersSelf',function(Lname,Fname,Mname,mobilenumber,gender,birthdate,level,user_id){
   console.log('Lname'+Lname);
   console.log('Fname'+Fname);
   console.log('Mname'+Mname);
   console.log('Gender'+gender);
   console.log('mobilenumber'+mobilenumber);
   console.log('birthdate '+birthdate);
   console.log('levels'+level);
   console.log('user_id'+user_id);
   console.log('username'+username);
     var updateUsers =  db.query('UPDATE users set lname = ?, fname = ? , mname = ?, mobilenumber = ?, dateofbirth = ?, gender = ?, levels = ?  where  user_iid = ? ',[Lname,Fname,Mname,mobilenumber,birthdate,gender,level,user_id],function(err,rows,fields,results){
              if (err) {
                                console.log(err);
                                }

     });
});
socket.on('Update user_availability',function(user_id,available){
     console.log('user_id '+user_id);
     console.log('available '+available);

    var updateAvailability = db.query('UPDATE users set available = ? where user_iid = ?',[available,user_id],function(err,rows,fields,result){
             if (err) {
                                 console.log(err);
                                 }
    });
});
socket.on('determine levels',function(username){
      var selectUserValues = db.query('SELECT * FROM users where username = ?',username,function(err,rows,fields,result){
          for(var o in rows){
              var pass    = rows[o].pass;
              var levels   = rows[o].levels;
              var user_id = rows[o].user_iid;
             socket.emit('determine pages',{user_id:user_id,pass:pass,levels:levels})
          }
      })
});
socket.on('add user_profile_picture',function(user_id,name,path){
     console.log('add user_profile_picture has been triggered');
     console.log('user_id l'+user_id+'l');
     console.log('name '+name);
     console.log('path '+path);
      var resetAssignedProfilePicturee = db.query('update  user_images  set selected = "1" where user_iid = ?',user_id,function(err,rows,fields){
           if (err) {
                console.log(err);
          }
      });
      var addUserProfilePicture = db.query('INSERT INTO user_images(name,user_iid,path,image_upload_date) VALUES(?,?,?,?)',[name,user_id,path,dateTime],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
     });
    socket.emit('display user_profile_picture',{upload_user_id:user_id,path:path});

});


socket.on('Check Login',function(username,password){
    console.log('Check Login has been triggered');

    var OnlineListsss = db.query('SELECT  *  FROM users where username =  ?  and available = 0 ',username,function(err,rows,fields,result){
     for (var o in rows){
         console.log('query');
                var pass       = rows[o].pass;
                var level      = rows[o].level;
                var user_id    = rows[o].user_iid;
     var result       = bcrypt.compareSync(password,pass); // true
         console.log(bcrypt.compareSync(password,pass));
         console.log('Results: '+result);
          socket.emit('Accept Login',{result:result,level:level,user_id:user_id})
      }
        //io.sockets.emit('Username Error',{rows:rows});
          //io.sockets.emit('updateRooms', rooms,null);

     });
});
socket.on('Update Username',function(username,user_id){
      var  updatePassword = db.query('UPDATE users set username = ? where  user_iid = ? ',[username,user_id],function(err,rows,fields){
                                if (err) {
                                 console.log(err);
                                 }
 });
});
socket.on('Check CurrentPassword',function(currentPassword,user_id){
     console.log('Current Password '+currentPassword);
     console.log('user_id '+user_id);
     var  CheckPassword  = db.query('SELECT * FROM users where user_iid = ?',user_id,function(err,rows,fields,results){
         for (var o in rows){
              var  pass = rows[o].pass;
              var result  = bcrypt.compareSync(currentPassword,pass);
              console.log(bcrypt.compareSync(currentPassword,pass));
              console.log('Results:'+result);
              socket.emit('Password Results',{result:result})
         }
     });

});
socket.on('Check Username',function(variable_value,u_primary_id_col_n,variable_col_n,tblName){

    var OnlineListsss = db.query('SELECT COUNT('+u_primary_id_col_n+') AS rows  FROM '+tblName+' where '+variable_col_n+' = ? ',variable_value,function(err,rows,fields,result){

      for (var o in rows){
                var rows    = rows[o].rows;
             if (err) {
          console.log(err);
     }

         console.log('count:'+rows);
      }
        socket.emit('Username Error',{rows:rows});
          //io.sockets.emit('updateRooms', rooms,null);

     });
});
socket.on('Check Username2',function(variable_value,u_primary_id,u_primary_id_col_n,variable_col_n,tblName){

     console.log('username '+username);
    console.log('variable_value: '+variable_value);
    console.log('u_primary_id_col_n: '+u_primary_id_col_n);
    console.log('variable_col_n: '+variable_col_n);
    console.log('tblName: '+tblName);
    var OnlineListsss = db.query('SELECT COUNT('+u_primary_id_col_n+') AS rows  FROM '+tblName+' where '+variable_col_n+' = ? and '+u_primary_id_col_n+' != ?',[variable_value,u_primary_id],function(err,rows,fields,result){

       if (err) {
          console.log(err);
     }
      for (var o in rows){
                var rows    = rows[o].rows;
         console.log('count:'+rows);
      }
        socket.emit('Username Error',{rows:rows});
          //io.sockets.emit('updateRooms', rooms,null);

     });
});
socket.on('select update_percent_id',function(percent_id){
   console.log('percent id value : '+percent_id);
      var percent_id_information =   db.query('SELECT * FROM projectprog_update  left join users on projectprog_update.user_id = users.user_iid where pupdate_id = ?',percent_id,function(err,rows,fields,result){
          for (var s in rows){
               var percent_value          = rows[s].percent_d;
               var project_update_date    = rows[s].dated;
               var publisher_lname        = rows[s].lname;
               var publisher_fname        = rows[s].fname;
               var description            = rows[s].descriptions;
          }

            socket.emit('set update_percent_id_info',{percent_value:percent_value,project_update_date:project_update_date,publisher_lname:publisher_lname,publisher_fname:publisher_fname,description:description});

});
    set_picture_sections("all",percent_id);
          var select_all_section = db.query('SELECT DISTINCT section.section_id,section_name FROM `projectprog_image` left join section on projectprog_image.section_id = section.section_id WHERE pupdate_id = ?',percent_id,function(err,rows,fields,results){
       for (var s in rows){
            var section_id   =  rows[s].section_id;
            var section_name =  rows[s].section_name;
         console.log('section name'+section_name);
          socket.emit('select all_section',{section_id:section_id,section_name:section_name});
       }
 });
});
///clientViewPortfolio
    var select_all_section = db.query('SELECT * FROM section where available = 0',function(err,rows,fields,results){
         for(var s in rows){
             var section_id = rows[s].section_id;
             var section_name = rows[s].section_name;
            socket.emit('populate_section_btn',{section_id:section_id,section_name:section_name});
         }
    });
    socket.on('selected_portfolio_section',function(section_id,portfolio_id){
       var section_filter = "";
        var section_name  = "";
      if (section_id == "all"){
        //  console.log('sort section is all');
             section_name  = "All"
      }else if(section_id == "none"){
            section_filter =  "AND section_id is NULL";
             section_name = "None";
      }else{
            section_filter = "AND section_id ="+section_id;
             var get_section_name = db.query('select * from section where available = 0 and section_id = ?',section_id,function(err,rows,fields,results){
                  for (var o in rows){
                       if (err) {
                                 console.log(err);
                                 }
                       section_name = rows[o].section_name;
                  }
             });
      }
        var percent_percent_id_pictures = db.query('SELECT * FROM portfolio_images where portfolio_id = ? and available = 0 '+section_filter,[portfolio_id],function(err,rows,fields,results){
         //   console.log('query has been triggerd');
             var count_pictures = 0;
             for (var s in rows){
                  var portimg_id          = rows[s].portimg_id;
                  var path                = rows[s].path;
                  var image_description   = rows[s].image_description;
                  var upload_datetime     = rows[s].upload_datetime
                    if (err) {
                                 console.log(err);
                                 }
                 socket.emit('set PortPictureGallery',{portimg_id:portimg_id,path:path,image_description:image_description,section_name:section_name,date:upload_datetime});
                 console.log(portimg_id );
                 console.log(path);
                 console.log(image_description);
                 console.log(section_name);

             }

        });

    });

//clientViewPortfolio


function select_all_section(percent_id){
    console.log(percent_id);
    /*
     var select_all_section = db.query('SELECT DISTINCT section.section_id,section_name FROM `projectprog_image` left join section on projectprog_image.section_id = section.section_id WHERE pupdate_id = ?',percent_id,function(err,rows,fields,results){
       for (var s in rows){
            var section_id   =  rows[s].section_id;
            var section_name =  rows[s].section_name;
         console.log('section name'+section_name);
          socket.emit('select all_section',{section_id:section_id,section_name:section_name});
       }
 });
 */
}

socket.on('set picture_sections',function(section_id,percent_id){
    set_picture_sections(section_id,percent_id," ");
});
function set_picture_sections(section_id,percent_id){
    console.log('set picture section is triggered');
    var  section_filter = "";
    if (section_id == "all"){
        console.log('sort section is all');
            socket.emit('current section_name',{section_name:"All"});
    }else if(section_id == "none"){
        section_filter =  "AND section_id is NULL";
        socket.emit('current section_name',{section_name:"None"});
    }else{
        section_filter = "AND section_id ="+section_id;
         var select_section_name = db.query('SELECT * FROM section where section_id = ?',section_id,function(err,rows,fields,results){
        for(var s in rows){
            var section_name = rows[s].section_name;
           socket.emit('current section_name',{section_name:section_name});
        }
      });
    }
    console.log('SECTION FILTER VALUE '+section_filter);
        var percent_percent_id_pictures = db.query('SELECT * FROM projectprog_image where pupdate_id = ? and available = 0 '+section_filter,[percent_id],function(err,rows,fields,results){
         //   console.log('query has been triggerd');
             var count_pictures = 0;
             for (var s in rows){
                  var projprogimg_id      = rows[s].projprogimg_id;
                  var path                = rows[s].path;
                  var image_description   = rows[s].image_description;
                    if (err) {
                                 console.log(err);
                                 }
                 console.log('projprogimg_id value: '+projprogimg_id);
               socket.emit('set percent_id_pictures',{projprogimg_id:projprogimg_id,path:path,image_description:image_description});
               count_pictures++;
             }
               socket.emit('sum_count ofPercentPictures',{count_pictures:count_pictures});
        });

}
socket.on('get picture_description',function(variable_id,cn_comment_code){
     var percent_percent_id_pictures = db.query(' SELECT  image_description FROM projectprog_image   where projprogimg_id  = ?',variable_id,function(err,rows,fields,results){
         //   console.log('query has been triggerd');
             for (var s in rows){
                var description  = rows[s].image_description;
             }
         socket.emit('Set picture_description',{description:description});
     });

});







//History Comment Retrieve start
socket.on('get commentRoomID',function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset,type){
     var RTcomment = require("./RT1directcomment.js");


  socket.room  = room_id;
  var room_d   = socket.room;
  socket.join(socket.room);
   console.log('Retrieved commment history module');
   console.log('room value '+room_d);
    RTcomment.commentHistoryModule(variable_id,socket,tablename,comment_id_name,reference_id_name,offset,type);
socket.on('trigger deactivate_comment',function(variable_id,filter_name,filter_value,mode){         RTcomment.DeletecommentHistoryModule(variable_id,room_d,tablename,comment_id_name,filter_name,filter_value,mode);
     });
   //Create for reply comment offset
});









socket.on('get offsetReplyComment',function(variable_id,room_id,comment_id_name,reference_id_name,tablename,offset,type){
    console.log("=============== type")

      var RTcomment = require("./RT1directcomment.js");
  socket.room  = room_id;
  socket.join(socket.room);
  var room_d = socket.room;
  RTcomment.ReplyCommentHistoryModule(variable_id,socket,tablename,comment_id_name,reference_id_name,offset,type);
});
 socket.on('get picture_comment',function(comment,user_id,variable_id,comment_id_name,reference_id_name,tablename,principal_id,room_id,type){
       var RTcomment = require("./RT1directcomment.js");
       socket.room  = room_id;
       socket.join(socket.room);
       var room_d = socket.room;

     console.log("ROOM VALUE: "+room_d);
     RTcomment.commentModule(user_id,variable_id,comment,room_d,tablename,comment_id_name,reference_id_name,principal_id,type);
});
 socket.on('get  principal_id',function(principal_id,comment_id_name,reference_id_name,tablename){
     var OnlineListsss = db.query('SELECT * FROM '+tablename+' where parent_comment_id = ?',principal_id,function(err,rows,fields,result){
      for (var o in rows){
          var owner_comment_user_id  = rows[o].user_id;
        socket.emit('owner_comment_user_id',{owner_comment_user_id:owner_comment_user_id});

      }
     });
});

//Upload Photo Module Start UpPhoto
     var RTdirectPhotoUpload = require("./RT1directPhotoUpload.js");
socket.on('Select ProfilePictures',function(user_id){
    RTdirectPhotoUpload.SelectProfilePictures(user_id,socket);
    RTdirectPhotoUpload.CurretProfilePicture(user_id,socket);
     //Update Profile Picture
      socket.on('Update ProfilePicture',function(new_user_images_id){ RTdirectPhotoUpload.UpdateProfilePicture(user_id,new_user_images_id,socket)
      });
});

socket.on('Get ChangeProfilePictureInformations',function(){
     RTdirectPhotoUpload.UploadProfPic(value);
});


//Upload Photo Module End
//==============================================
//Add Project Progress   Module   Start
var RTdirectAddProjectProgress = require("./RT1directAddProjectProgress.js");
socket.on('Get ClientsInformation',function(script_value){
    RTdirectAddProjectProgress.getClientNames(script_value,socket);
});
socket.on('insert projectProgress',function(project_name,project_description,category_id,client_id,user_id){
    RTdirectAddProjectProgress.insertProjectProgress(project_name,project_description,category_id,client_id,user_id,socket);
});



var DeletefileNameArr =  [];
socket.on('get_delete_upload_pic',function(temp_id,filename,availability,pred_pupdate_id,path){
    console.log('temp_id value '+temp_id);
    console.log('filename value '+filename);
    console.log('availability value '+availability);
     var finalPath = path+filename
    //  var selectCurr_Tym = db.query('SELECT DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
    //           for(var o in rows){
    //              var  curr_tym    = rows[o].curr_tym;
    //           }
    //   var AdminList = db.query('INSERT INTO projectprog_image(name,pupdate_id,path,available,upload_datetime) VALUES(?,?,?,?,?)',[filename,pred_pupdate_id,finalPath,availability,curr_tym],function(err,rows,fields,result){
    //         if (err) {
    //             console.log(err);
    //         }
    //   });
    // });
   socket.emit('trigger deleteProjectPhoto',function(){});
});
socket.on('get project_update_data',function(projprog_id,descriptions,percent,user_id){

    var selectCurr_Tym = db.query('SELECT DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
              }
      // var AdminList = db.query('INSERT INTO projectprog_update(projprog_id,percent_d,descriptions,dated,user_id) VALUES(?,?,?,?,?) ',[projprog_id,percent,descriptions,curr_tym,user_id],function(err,rows,fields,result){
         socket.emit('delete selectedPictures',function(){});
          var updateProjectStatus = db.query('UPDATE project_progress set current_percent = ? where projprog_id = ?',[percent,projprog_id],function(err,rows,fields,result){});
      // });
    });
});
//client history notification
socket.on('retrieved  clientnotification',function(receiver_id,room_id){
    socket.room = room_id;
    socket.join(socket.room);
    console.log('socket.id '+socket.room);
   var retrieved_notfication_row = db.query('SELECT * FROM `notification` left join notification_users on notification.notification_id = notification_users.notification_id  where notification_users.notification_id_receiver = ? and notification_users.seen_by_receiver = 0  order by  notification.notification_date desc',receiver_id,function(err,rows,fields){
         for (var q in rows){
             if(err){
                 console.log(err);
             }
              var notification_message   = rows[q].notification_message;
              var notification_date      = rows[q].notification_date;
              var reference_link         = rows[q].reference_link;
             console.log(notification_message);
             io.sockets.in(socket.room).emit('client projectupdates',{noti_upd_msg:notification_message ,rfer_lnk:reference_link ,curr_tym:notification_date });
         }

   });

    var retrieved_notfication_row = db.query('SELECT COUNT(*) as num_rows FROM `notification` left join notification_users on notification.notification_id = notification_users.notification_id  where notification_users.notification_id_receiver = ? and notification_users.seen_by_receiver = 0  order by  notification.notification_date desc',receiver_id,function(err,rows,fields){
        for (var q in rows){
             var  noti_no   = rows[q].num_rows;
             io.sockets.in(socket.room).emit('client ctr_noti',{noti_no:noti_no});
        }

   });


});
socket.on('push clientnotification',function(room_id,sender_id,receiver_id,msg,rfr_link){
    console.log("push room_id "+room_id);
     socket.room = room_id;
    socket.join(socket.room);
 var curr_tym;
 var notification_id;

    var selectCurr_Tym = db.query('SELECT DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                  curr_tym    = rows[o].curr_tym;
              }

                          //room socket for  client that receive notification
                      socket.room = room_id;
                      socket.join(socket.room);

                 var saveNotification = db.query('INSERT INTO  notification (notification_message,notification_type,notification_date,reference_link)values(?,?,?,?)',[msg,'project_update',curr_tym,rfr_link],function(err,rows,fields){
                                         if (err) {
                                             //console.log(err);
                                             }
                      var select_notification_id = db.query('SELECT * FROM notification where notification_message = ? and notification_type = ? and notification_date = ?',[msg,"project_update",curr_tym],function(err,rows,fields){
                                 for (var m in rows) {
                                         notification_id = rows[m].notification_id;
                                        //console.log('notification id obtained:',notification_id);
                                        if (err) {
                                            //console.log(err);
                                            }
                                 }
                            var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,receiver_id,sender_id],function(err,rows,fields){
                                         if (err) {
                                             //console.log(err);
                                             }
                                io.sockets.in(socket.room).emit('client projectupdates',{noti_upd_msg:msg ,rfer_lnk:rfr_link,curr_tym:curr_tym});

                            });
                        });
                 });
     });

});
socket.on('noti_seen client',function(receiver_id){
      var  updateDescription  =  db.query('UPDATE notification_users SET seen_by_receiver = 1  where notification_id_receiver = ?',[receiver_id],function(err,rows,fields){
      });
});
socket.on('get_portoflio_data',function(name,descriptions,category_id,user_id){


    var selectCurr_Tym = db.query('SELECT DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
              }
      // var AdminList = db.query('INSERT INTO portfolio(name,description,category_id,dated,user_iid) VALUES(?,?,?,?,?)',[name,descriptions,category_id,curr_tym,user_id],function(err,rows,fields,result){
          socket.emit('delete selectedPortPictures',function(){});
      // });
    });

});
socket.on('get_delete_upload_port_pic',function(temp_id,filename,availability,pred_pupdate_id,path){
    console.log('temp_id value '+temp_id);
    console.log('filename value '+filename);
    console.log('availability value '+availability);
     var finalPath = path+filename
     console.log("final_path value "+finalPath);


     var selectCurr_Tym = db.query('SELECT DATE_FORMAT(NOW(),?)  as curr_tym','%Y-%m-%d %H:%i:%s %p',function(err,rows,fields){
              for(var o in rows){
                 var  curr_tym    = rows[o].curr_tym;
              }
      // var AdminList = db.query('INSERT INTO portfolio_images(name,portfolio_id,path,available,upload_datetime) VALUES(?,?,?,?,?)',[filename,pred_pupdate_id,finalPath,availability,curr_tym],function(err,rows,fields,result){
      //       if (err) {
      //           console.log(err);
      //       }
      // });
    });
    socket.emit('trigger deletePortPhoto',function(){});
});

///////////
socket.on('Delete Project',function(projprog_id,tablename,column_id_name){
     var deleteProject = db.query("UPDATE "+tablename+" SET available = 1 where "+column_id_name+" = ?",projprog_id,function(err,rows,fields){
               if(err){
                    console.log(err);
               }
          });

});
socket.on('Assign Section',function(tablename,column_id_name,section_id,projprogimg_id){
      var  assignSection  = db.query('UPDATE  '+tablename+' SET section_id = ?  where  '+column_id_name+' = ?',[section_id,projprogimg_id],function(err,rows,fields){
           if(err){
                console.log(err);
           }
      });

});
///////
//Add Project Progress   Module   End
//Portfolio Module Start============================================
var RTdirectPortfolio = require("./RT1directPortfolio.js");
socket.on('Get PortfolioIDfImage',function(portfolio_id){
     console.log('GET PORTFOLIO ID ');
     console.log('Portfolio ID'+portfolio_id);
     RTdirectPortfolio.SelectPortfolioImages(socket,portfolio_id);
});
socket.on('Select FeaturePortfolioImages',function(tablename,column_id_name,portimg_id,featured){
        //console.log('portimg_id value '+portimg_id);

     console.log('Select Featured Portfolio Images has been triggerd');
      var SelectFeatureImages  = db.query('UPDATE '+tablename+' set featured = ? where '+column_id_name+' = ?',[featured,portimg_id],function(err,rows,fields){
           console.log('Query Completed');
          if(err){
              console.log(err);
          }
      });

});
socket.on('update portfolioInformation',function(project_id,project_name,description,category_id){
    RTdirectPortfolio.UpdatePortfolioInformation(socket,project_id,project_name,description,category_id);
});
////////////////////
socket.on('Get GalleryProjProgId',function(projprog_id){
    console.log("Hell world");
    SelectGalleryProjProgImages(socket,projprog_id)
});

socket.on('InsertPortfolioImageDescription',function(portimg_id,image_description){
        console.log('portimg_id: '+portimg_id);
        console.log('image_description: '+image_description);

 var  updateDescription  =  db.query('UPDATE portfolio_images SET image_description = ? where portimg_id = ?',[image_description,portimg_id],function(err,rows,fields){
      if(err){
          console.log(err);
      }
 });

});
//Portfolio Module End ================================
//Main Portfolio Rating Start
socket.on('Rate Portfolio',function(rating_value,portfolio_id,logged_user_id,room_id){
     var ValidateRate = db.query('SELECT COUNT(*) as num_rows FROM rating_portfolio where portfolio_id  = ?  and   user_iid  = ?',[portfolio_id,logged_user_id],function(err,rows,fields,result){
            for (var o in rows){
                 var num_rows  = rows[o].num_rows;
                 console.log(num_rows);
               if(num_rows == 0){
                   console.log('insert rate');
                     var InsertRate = db.query('INSERT INTO rating_portfolio(rating,portfolio_id,user_iid) VALUES(?,?,?)',[rating_value,portfolio_id,logged_user_id],function(err,rows,fields,result){
                          times_ratedF(portfolio_id,room_id);
                     });
               }else{
                     console.log('update rate');
                  var UpdateRate = db.query('UPDATE rating_portfolio set rating = ? where  portfolio_id  = ? and user_iid = ?',[rating_value,portfolio_id,logged_user_id],function(err,rows,fields,result){
                          times_ratedF(portfolio_id,room_id);
                     });
               }
            }
     });
});
function times_ratedF(portfolio_id,room_id){
          socket.room = room_id;
          socket.join(socket.room);
          var  RatedTimes = db.query('SELECT COUNT(*) as times_rated from rating_portfolio where portfolio_id = ?',portfolio_id,function(err,rows,fields,result){
                  for(var q in rows){
                       var times_rated  = rows[q].times_rated;
                       console.log("times rated: "+times_rated);
                          if(times_rated == 0){
                                //socket.emit null average
                                console.log('portfolio has not been rated');
                              io.sockets.in(socket.room).emit('portfolio_average',{portfolio_ave:"0"});
                          }else{
                                var  RatedTimes = db.query('SELECT CEIL(AVG(rating))  as portfolio_ave FROM `rating_portfolio` WHERE portfolio_id = ?',portfolio_id,function(err,rows,fields,result){
                                  for(var s in rows){
                                      var portfolio_ave =  rows[s].portfolio_ave;
                                      console.log("portfolio average: "+portfolio_ave);
                                      io.sockets.in(socket.room).emit('portfolio_average',{portfolio_ave:portfolio_ave});
                                   }
                                });
                          }
                }
          });
}
socket.on('Retrieved PortfolioHistoryAverage',function(portfolio_id,room_id){
    times_ratedF(portfolio_id,room_id);
});

///Rate Portfolio image start here
 socket.on('Rate PortfolioImages',function(rating_value,portfolio_id,logged_user_id,room_id){
        var ValidateRate = db.query('SELECT COUNT(*) as num_rows FROM rating_portfolio_image where portimg_id  = ?  and   user_iid  = ?',[portfolio_id,logged_user_id],function(err,rows,fields,result){
            for (var o in rows){
                 var num_rows  = rows[o].num_rows;
               if(num_rows == 0){
                     var InsertRate = db.query('INSERT INTO rating_portfolio_image(rating,portimg_id,user_iid) VALUES(?,?,?)',[rating_value,portfolio_id,logged_user_id],function(err,rows,fields,result){
                          times_ratedFPIC(portfolio_id,room_id);
                     });
               }else{
                  var UpdateRate = db.query('UPDATE rating_portfolio_image set rating = ? where  portimg_id  = ? and user_iid = ?',[rating_value,portfolio_id,logged_user_id],function(err,rows,fields,result){
                          times_ratedFPIC(portfolio_id,room_id);
                     });
               }
            }
       });
 });
function times_ratedFPIC(portfolio_id,room_id){

          socket.room = room_id;
          socket.join(socket.room);
          var  RatedTimes = db.query('SELECT COUNT(*) as times_rated from rating_portfolio_image where portimg_id = ?',portfolio_id,function(err,rows,fields,result){
                  for(var q in rows){
                       var times_rated  = rows[q].times_rated;
                       console.log("times rated: "+times_rated);
                          if(times_rated == 0){

                               // console.log('portfolio has not been rated');
                                //console.log('portfolio image average value: 0 portfolio_id'+portfolio_id);
                             io.sockets.in(socket.room).emit('portfolioImage_average',{portfolio_ave:"0",portfolio_id:portfolio_id});
                          }else{
                                var  RatedTimes = db.query('SELECT CEIL(AVG(rating))  as portfolio_ave FROM `rating_portfolio_image` WHERE portimg_id = ?',portfolio_id,function(err,rows,fields,result){
                                  for(var s in rows){
                                      var portfolio_ave =  rows[s].portfolio_ave;

                                      //console.log('portfolio has not been rated');
                                      //console.log('portfolio image average value: '+portfolio_ave+'  portfolio_id'+portfolio_id);

                                      io.sockets.in(socket.room).emit('portfolioImage_average',{portfolio_ave:portfolio_ave,portfolio_id:portfolio_id});
                                   }
                                });
                          }
                }
          });
}
 socket.on('Retrieved PortfolioImageHistoryAverage',function(portfolio_id,room_id){
    times_ratedFPIC(portfolio_id,room_id);
});
//Main Portfolio Rating End
//DASHBOARD COMPONENTS

 socket.on('update featuredProject',function(project_id,featured_status){
      var selectAdminID = db.query('UPDATE  portfolio  set featured = ? where portfolio_id = ?',[featured_status,project_id],function(err,rows,fields){});
 });
////Query Project Reports start
socket.on('query  allProjectReports',function(){
     queryReports("");
});
socket.on('query wProjFilter',function (fullquery){
    queryReports(fullquery);
})
function queryReports(queryFilter){

     var queryReports = db.query('SELECT DISTINCT (project_progress.name) ,category.category_name,users.lname,users.fname,project_progress.customer_id,project_progress.dated,project_progress.projprog_id,current_percent from project_progress left join projectprog_update on projectprog_update.projprog_id = project_progress.projprog_id left join category on project_progress.category_id = category.category_id left join users on project_progress.customer_id = users.user_iid '+queryFilter,function(err,rows,fields){
                    console.log('queryReports ================================');

                 for (var o in rows){
                        var name            =    rows[o].name;
                        var category_name   =    rows[o].category_name;
                        var publisher       =    rows[o].fname+" "+rows[o].lname;
                        var dated           =    rows[o].dated;
                        var projprog_id     =    rows[o].projprog_id;
                        var current_percent =    rows[o].current_percent;
                        //console.log('name           '+name);
                        //console.log('category_name  '+category_name);
                        //console.log('fullname       '+publisher);
                        //console.log('dated          '+dated);
                        //console.log('projprog_id    '+projprog_id);


                      socket.emit('get allProjectReports',{name:name,category_name:category_name,customer:publisher,dated:dated,projprog_id,current_percent:current_percent});
         }
     });
}
//DASHBOARD COMPONENTS
socket.on('delete items',function(primary_id,primary_id_name,tablename){
      var queryReports = db.query('UPDATE '+tablename+' set  available =  1 where '+primary_id_name+'= ?',primary_id,function(err,rows,fields){});
});



socket.on('UpdateChatList',function(){
    console.log('shettttttttt');
     var OnlineListsss = db.query('SELECT * FROM users ',function(err,rows,fields,result){
        room_names = [];
        room_level = [];
        online_list = [];
        rooms = [];
      for (var o in rows){
                var user_iid    = rows[o].user_iid;
                var username    = rows[o].username;
                var user_level  = rows[o].levels;
                online_list.push(user_iid);
                rooms.push(user_iid);
                room_names.push(username);
                room_level.push(user_level);
            }
          console.log(user_iid);
          console.log(username);
          console.log(user_level);
          io.sockets.emit('updateRooms', rooms,null);
          io.sockets.emit('updateRoomsNames',room_names);
          io.sockets.emit('updateRoomLevels',room_level);
          AdminOnlineIndicator(socket);
                       var selectAdminID = db.query('SELECT * FROM users where levels = ?','Admin',function(err,rows,fields){
                                for (var o in rows){
                                        var user_id    = rows[o].user_iid;

                                      // console.log('outside' + user_id);
                                      if(user_id in admin){
                                         //console.log('UpdateAdminCounterList...........');
                                         //console.log('user id inside the admin array'+admin[user_id]);
                                          //console.log('user_id '+user_id);

                                           countMessagesAdmin(admin[user_id],user_id);
                                      }

                                }
        });

     });

});

     socket.on('Update ClientChatList',function(){
         console.log("HELLO WORLD");
                var AdminList = db.query('SELECT * FROM users where levels = "Admin"  or  levels  = "Interior Designer"',function(err,rows,fields,result){
                         admin_online_list = [] ;
                         admin_list =  [] ;
                      for (var o in rows){
                            var username =  rows[o].username;
                            admin_list.push(username);
                            admin_online_list.push(rows[o].user_iid);
                       }
                      io.sockets.emit('admin',admin_list);
                     ClientOnlineIndicator(socket)
               });
     });




//Use only for Project and Project Updates Notification
socket.on('NewProject Notification',function(user_id,customer_id,newProjectMessage,key_id,notification_type){

console.log('New Project Notification Console=================');
   // console.log('user_id '+user_id);
//    console.log('customer_id '+customer_id);
  //  console.log('newProjectMesage '+newProjectMessage);
    //console.log('key_id '+key_id);
    //console.log('New Project Notification ');

     if (customer_id in client){
        client[customer_id].emit('Set NewProjectNotification',{msg:newProjectMessage,key_id:key_id});
        saveNotificationDb(user_id,customer_id,newProjectMessage,dateTime,notification_type,key_id,client[customer_id]);
     }else{
        saveNotificationDbOffline(user_id,customer_id,newProjectMessage,dateTime,notification_type,key_id)
     }
});


 socket.on('Seen Notification',function(){
        var seenNotification = db.query('UPDATE notification_users SET seen_by_receiver = 1 WHERE notification_id_receiver= ?',socket.username,function(err,rows,fields,results){
            console.log('socket.username'+socket.username);
            countNotification(socket,socket.username);
   });
});

socket.on('NewComment NotificationPortfolio',function(user_id,user_level,newCommentMessage,key_id,notification_type,pupdate_id){
     var notification_id;
     var saveNotification = db.query('INSERT INTO  notification (notification_message,notification_type,notification_date,reference_link)values(?,?,?,?)',[newCommentMessage,notification_type,dateTime,key_id],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
        var select_notification_id = db.query('SELECT * FROM notification where notification_message = ? and notification_type = ? and notification_date = ?',[newCommentMessage,notification_type,dateTime],function(err,rows,fields){
                     for (var m in rows) {
                             notification_id = rows[m].notification_id;
                            console.log('notification id obtained:',notification_id);
                            if (err) {
                                console.log(err);
                                }
                     }
            //Make a query to the client that has commented in portfolio
             var  selectAdmins = db.query('SELECT   DISTINCT users.user_iid, users.username  FROM portfolio_update_comments  left join users on portfolio_update_comments.user_id  = users.user_iid    where users.levels = "Client" and portfolio_id = ?',pupdate_id,function(err,rows,fields,result){
                  for (var s in rows){
                    var client_id = rows[s].user_iid;
                    var  username  = rows[s].username;
                          console.log('Client idwwwwwwwwwwwwwwwwww '+client_id);
                        if (client_id in client){
                            console.log('admin id that is online'+client_id);

                       client[client_id].emit('Set NewProjectNotification',{msg:newCommentMessage,key_id:key_id,username:username})
                            var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,client_id,user_id],function(err,rows,fields){
                                 //console.log('notification users inserted ');
                                 //console.log('notification id '+notification_id);
                                 //console.log('admin id '+admin_id);
                                    if (err) {
                                     console.log(err);
                                     }
                              console.log('New Comment')
                              console.log('admin_id'+ client_id)

                         });
    countNotification(client[client_id],client_id);
                    }else{
                          var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,client_id,user_id],function(err,rows,fields){
                                 //console.log('notification users inserted ');
                                 //console.log('notification id '+notification_id);
                                 //console.log('admin id '+admin_id);
                                    if (err) {
                                     console.log(err);
                                     }
                              console.log('New Comment')
                              console.log('admin_id'+ client_id)

                         });
                    }


                  }
              });
        });
     });
});

     socket.on('NewComment Notification',function(user_id,user_level,newCommentMessage,key_id,notification_type,pupdate_id){
   /// console.log('comment notification contents');
//    console.log('user_id: '+user_id);
  //  console.log('custom_id: '+user_level);
    //console.log('newCommentMessage: '+newCommentMessage);
    //console.log('key_id: '+key_id);
    //console.log('notification_type: '+notification_type);

 if(user_level == "Client"){
     var notification_id;
     var saveNotification = db.query('INSERT INTO  notification (notification_message,notification_type,notification_date,reference_link)values(?,?,?,?)',[newCommentMessage,notification_type,dateTime,key_id],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
        var select_notification_id = db.query('SELECT * FROM notification where notification_message = ? and notification_type = ? and notification_date = ?',[newCommentMessage,notification_type,dateTime],function(err,rows,fields){
                     for (var m in rows) {
                             notification_id = rows[m].notification_id;
                            console.log('notification id obtained:',notification_id);
                            if (err) {
                                console.log(err);
                                }
                     }
             var  selectAdmins = db.query('SELECT * FROM users where levels = "Admin"  or levels = "Interior Designer"',function(err,rows,fields,result){
                  for (var s in rows){
                    var  admin_id  = rows[s].user_iid;
                    var  username  = rows[s].username;

                        if (admin_id in admin){
                            console.log('admin id that is online'+admin_id);

                     admin[admin_id].emit('Set NewProjectNotification',{msg:newCommentMessage,key_id:key_id,username:username});



                            var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,admin_id,user_id],function(err,rows,fields){
                                 //console.log('notification users inserted ');
                                 //console.log('notification id '+notification_id);
                                 //console.log('admin id '+admin_id);
                                    if (err) {
                                     console.log(err);
                                     }
                              console.log('New Comment')
                              console.log('admin_id'+ admin_id)

                         });
                    countNotification(admin[admin_id],admin_id);
                    }else{
                          var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,admin_id,user_id],function(err,rows,fields){
                                 //console.log('notification users inserted ');
                                 //console.log('notification id '+notification_id);
                                 //console.log('admin id '+admin_id);
                                    if (err) {
                                     console.log(err);
                                     }
                              console.log('New Comment')
                              console.log('admin_id'+ admin_id)

                         });
                    }
                  }
              });
        });
     });
}else{
     var notification_id;
     var saveNotification = db.query('INSERT INTO  notification (notification_message,notification_type,notification_date,reference_link)values(?,?,?,?)',[newCommentMessage,notification_type,dateTime,key_id],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
        var select_notification_id = db.query('SELECT * FROM notification where notification_message = ? and notification_type = ? and notification_date = ?',[newCommentMessage,notification_type,dateTime],function(err,rows,fields){
                     for (var m in rows) {
                             notification_id = rows[m].notification_id;
                            console.log('notification id obtained:',notification_id);
                            if (err) {
                                console.log(err);
                                }
                     }
             var  selectClient = db.query('SELECT customer_id FROM project_progress LEFT JOIN projectprog_update ON  project_progress.projprog_id =  projectprog_update.projprog_id where pupdate_id = ?',pupdate_id,function(err,rows,fields,result){
                  for (var s in rows){
                    var  client_id  = rows[s].customer_id;

                        if (client_id in client){
                            console.log('admin id that is online'+client_id);
            var selectAdminUsername = db.query('SELECT username from users where user_iid =?',user_id,function(err,rows,fields,result){
                    for (var s in rows){
                        var username = rows[s].username;
                       client[client_id].emit('Set NewProjectNotification',{msg:newCommentMessage,key_id:key_id,username:username});
                    }
            });
                            var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,client_id,user_id],function(err,rows,fields){
                                 //console.log('notification users inserted ');
                                 //console.log('notification id '+notification_id);
                                 //console.log('admin id '+admin_id);
                                    if (err) {
                                     console.log(err);
                                     }
                              console.log('New Comment')
                              console.log('client_id'+ client_id)

                         });
                    countNotification(client[client_id],client_id);
                    }else{
                          var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,client_id,user_id],function(err,rows,fields){
                                 //console.log('notification users inserted ');
                                 //console.log('notification id '+notification_id);
                                 //console.log('admin id '+admin_id);
                                    if (err) {
                                     console.log(err);
                                     }
                              console.log('New Comment')
                              console.log('admin_id'+ client_id)

                         });
                    }
                  }
              });
        });
      });

}

});



/// Socket Realtime messaging starts here**********************
    var AdminList = db.query('SELECT * FROM users where levels = "Admin"  or  levels  = "Interior Designer"',function(err,rows,fields,result){
      for (var o in rows){
          var username =  rows[o].username;
          admin_list.push(username);
          //admin_online_list.push(rows[o].user_iid);
      }
});

var Rusername;
socket.on('addUser', function(user_id,username,user_level,pupdate_id,cn_comment_code,tableName,comment_id_name,reference_id_name){
     console.log('Add user called================== ');


    //    console.log('User values that has been elicited...................................');
       // console.log('user_id'+user_id);
    //    console.log('username'+username);
      //  console.log('user_level'+user_level);
        console.log("-------------------------------------------");
    //Query for the latest comment id
    var  SelectLatest_Id  = db.query("SELECT  "+comment_id_name+" as comment_id_name FROM  "+tableName+" order by "+comment_id_name+" DESC limit 1",function(err,rows,fields){
          for (var r in rows){
             var comment_id  = rows[r].comment_id_name;
             //console.log('This is the comment id '+comment_id);
             primary_comment_id  = comment_id;
               }
               });



        Rusername = username;
        socket.username = user_id;
        socket.user_level = user_level;
        online_users[socket.username] = socket;
        AdminOnlineIndicator(socket);
        ClientOnlineIndicator(socket);
        countNotification(socket,socket.username);

if(pupdate_id !=  " "){
      console.log('COMMMMMMENNNNNNNNNT MODULE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
      console.log('Comment UPDATE        =++++++++++++pupdate_id'+pupdate_id);
           countMessagesClient(socket,socket.username);
           countNotification(socket,socket.username);
          // console.log('tableName '+tableName);
           ///console.log('comment_id_name'+comment_id_name);
           //console.log('reference_id_name'+reference_id_name);
    console.log('pudapte_id'+pupdate_id);
    socket.room  =  cn_comment_code+pupdate_id;
    console.log('room_ids: '+socket.room);
        socket.join(socket.room);
           socket.nickname   = username;
           pupdate_id_data   = pupdate_id;


socket.on('Set RatingTable',function(tablename,column_id_name,reference_id_name){
     var ratingTableName = tablename;
     var ratingReferenceID = reference_id_name;
     SumRatingAve(pupdate_id,io.sockets.in(socket.room),ratingTableName,ratingReferenceID);
});
    //Populate Portfolio Thumbnail Gallery
socket.on('Set PortfolioThumbnail',function(portfolio_id){

    console.log('Set Portfolio Thumbnail has been triggered=====================');
    console.log('portfolio id:  '+portfolio_id);

    var saveNotification = db.query('SELECT * FROM  portfolio_images where portfolio_id = ? and available = 0',[portfolio_id],function(err,rows,fields){
         for(var s in rows){
               var featpath       = rows[s].path;
               var portimg_id = rows[s].portimg_id;
              if (err) {
                     console.log(err);
                }
          io.sockets.in(socket.room).emit('Setted  PortfolioThumbnail',{featpath:featpath,portimg_id:portimg_id,portfolio_id:portfolio_id});

         }

      });
});
socket.on('Set ProjectUpdateThumbnail',function(pupdate_id){
   // console.log('HOPPPPPPPEEE');
    //console.log('pupdate_id'+pupdate_id);
       var saveNotificationa = db.query('SELECT * FROM  projectprog_image where pupdate_id = ? and available = 0',[pupdate_id],function(err,rows,fields){
         for(var s in rows){
             console.log('QWEQWEQWEQWEQWE');
               var featpath       = rows[s].path;
             console.log(featpath);
               var projprogimg_id = rows[s].projprogimg_id;
              if (err) {
                     console.log(err);
                }
          io.sockets.in(socket.room).emit('Setted  ProjectUpdateThumbnail',{featpath:featpath,projprogimg_id:projprogimg_id,pupdate_id:pupdate_id});

         }

      });
});
socket.on('Set ProjectUpdateThumbnailSect',function(pupdate_id,section_id){
    console.log('SectionPicture triggered');

     var saveNotificationazz = db.query('SELECT * FROM  projectprog_image where pupdate_id = ? and available = 0 and section_id = ?',[pupdate_id,section_id],function(err,rows,fields){
         for(var s in rows){
              var featpath       = rows[s].path;
             console.log(featpath);
               var projprogimg_id = rows[s].projprogimg_id;
              if (err) {
                     console.log(err);
                }
          io.sockets.in(socket.room).emit('Setted  ProjectUpdateThumbnailSect',{featpath:featpath,projprogimg_id:projprogimg_id,pupdate_id:pupdate_id});

         }

      });
});
socket.on('Set ProjectUpdateThumbnailSectNull',function(pupdate_id){
    var selectSectionImage = db.query(' SELECT  * FROM projectprog_image where pupdate_id = ? and available = 0 and section_id is null ',pupdate_id,function(err,rows,fields){
          for(var s in rows){
             console.log('QWEQWEQWEQWEQWE');
               var featpath       = rows[s].path;
             console.log(featpath);
               var projprogimg_id = rows[s].projprogimg_id;
              if (err) {
                     console.log(err);
                }
          io.sockets.in(socket.room).emit('Setted  ProjectUpdateThumbnailSectNull',{featpath:featpath,projprogimg_id:projprogimg_id,pupdate_id:pupdate_id});

         }
    });
});
                  //console.log('Obtained User_id:'+user_id);
                  //console.log("Obtain username:"+socket.nickname);
                  //console.log('Retrived pupdate_id Yooo:'+pupdate_id_data);
                  //console.log('Primary Comment id :'+  primary_comment_id);
                  RetrievedProjectCommentUpdates(pupdate_id_data,socket,tableName,comment_id_name,reference_id_name);
                  RetrievedProjectReplyCommentUpdates(pupdate_id_data,socket,tableName,comment_id_name,reference_id_name);

    socket.on('GetComment',function(data,callback){
         var  RepeatingCommments =  [] ;
          RepeatingCommments.push(data);
        var comment = data;
         console.log('comment value '+comment);

        for (var s in  RepeatingCommments){
             console.log('Repeating Comments '+RepeatingCommments[s]);
        }
        /*
        primary_comment_id++;
        commentCtr++;
         console.log('Get Comment has been triggerdddd');
            ///console.log('tramsitting submittions');
            //console.log(data);
            //console.log('/Show Comment Function/ primary_comment_id Status count'+commentCtr);
            //console.log('/Show Comment Function/ primary_comment_id Status count'+primary_comment_id);
            //console.log(comment +" "+socket.nickname);
            //console.log('=============Comment Has been delivered============');
               io.sockets.in(socket.room).emit('show comment',{comment:comment,username:socket.nickname,comment_id:primary_comment_id,user_id:user_id});
                 SaveUserCommentsDB(pupdate_id_data,user_id,comment,tableName,comment_id_name,reference_id_name);
                 */
         });
     console.log('=======================================================');
    socket.on('GetReplyComment',function(data,Parent_id){
           var user_socket = socket;
           var ReplyComment = data;
           var ParentComment_id  = Parent_id;
           primary_comment_id++;
           commentCtr++;
          //console.log('This is the parent ID'+ParentComment_id);
           //console.log("Trasmitting ReplyFunction");
           //console.log('/Show Comment Function/ primary_comment_id Status count'+commentCtr);
           //console.log('/Show Comment Function/ primary_comment_id Status count'+primary_comment_id);
           //console.log('ReplyComment data:'+ReplyComment);
           //console.log('Username data:'+socket.nickname);
           //console.log("=====================Comment has been Delivered=====================");
           io.sockets.in(socket.room).emit('show ReplyComment'+ParentComment_id,{ReplyComment:ReplyComment,username:socket.nickname,replyComment_id:primary_comment_id,user_id:user_id,parent_comment_id:ParentComment_id});

           SaveUserReplyCommentsDB(Parent_id,pupdate_id_data,user_id,ReplyComment,tableName,comment_id_name,reference_id_name);
        });
///Edit Comments
socket.on('Edit Comment',function(comment_id,comment){
      var saveNotification = db.query('UPDATE '+tableName+' set comment = ? where '+comment_id_name+'='+comment_id,[comment,comment_id],function(err,rows,fields){
                if (err) {
                     console.log(err);
                }

              io.sockets.in(socket.room).emit('Set EditedComment',{comment_id:comment_id,comment:comment});
          console.log ('Sockets in is done');
      });
});



function DeleteComment(comment_id,FuncName,Name,tableName,comment_id_name,reference_id_name){
    var  comment_id  = comment_id;
          //console.log(Name+"deleted comment id "+comment_id);
           //console.log('tableName '+tableName);
          // console.log('comment_id_name'+comment_id_name);
           //console.log('reference_id_name'+reference_id_name);
          io.sockets.in(socket.room).emit(FuncName,{comment_id:comment_id});

    var DeleteComments = db.query('UPDATE '+tableName+' set available = 1 where '+comment_id_name+' = ?',comment_id,function(err,rows,fields){
         //console.log('Comment Deleted');
               //console.log(Name+" deleted comment id "+comment_id);
         if (err) {
                       console.log(err);
                  }
     });
}
socket.on('Delete Comment',function(comment_id){
    DeleteComment(comment_id,'deleted comment','Current Comment ',tableName,comment_id_name,reference_id_name);
});
 socket.on('Delete History Comment',function(comment_id){

    DeleteComment(comment_id,'Deleted History Comment','History Comment ',tableName,comment_id_name,reference_id_name);
});
socket.on('Delete ReplyHistoryComment',function(comment_id){
  console.log('HELLOOOO');
    DeleteComment(comment_id,'Delete ReplyHistory Comment','Reply History Comment ',tableName,comment_id_name,reference_id_name);
});
socket.on('Delete ReplyComment',function(comment_id){
    DeleteComment(comment_id,'Deleted ReplyComment','Reply History ',tableName,comment_id_name,reference_id_name);
});
////////////////////////////PORTFOLIO RATING------------------------------------------

socket.on('Set RatingTable',function(tablename,column_id_name,reference_id_name){
socket.on('Retrieved PortfolioAve',function(portfolio_id){
    console.log('Retrieved PortfolioAve has been trigerred');
     SumRatingAve(portfolio_id,socket.room,tablename,reference_id_name)
});
      socket.on('ratePortfolio',function(value,pupdate_id,user_id){
        //  console.log('ratePortfolio VALUES:----------------');
        //  console.log('Rating Value'+value);
        //  console.log('Portfolio_ID'+pupdate_id);
        //  console.log('User ID'+user_id);

          var checkUserRating = db.query('SELECT  COUNT(*) as counts  FROM  '+tablename+'  where  '+reference_id_name+' = ?  AND user_iid = ?  ',[pupdate_id ,user_id],function(err,rows,fields){
                  for (var s in rows){
                      var count    =  rows[s].counts;
                if(count == 0 ){
                   var savePortfolio = db.query('INSERT INTO  '+tablename+'(rating,'+reference_id_name+',user_iid)values(?,?,?)',[value,pupdate_id,user_id],function(err,rows,fields){
                                     if (err) {
                                         console.log(err);
                                         }
                  console.log('Portfolio = '+pupdate_id + 'has been rated');

           SumRatingAve(pupdate_id,socket.room,tablename,reference_id_name);
                  });
                }else{
                    console.log("HAS RATED the portfolio");

                         var updatePortfolio = db.query('UPDATE '+tablename+' SET rating = ? WHERE user_iid = ? and '+reference_id_name+' =  ?',[value,user_id,pupdate_id],function(err,rows,fields,results){

                         console.log('Portfolio = '+pupdate_id + 'has been rated');

                               SumRatingAve(pupdate_id,socket.room,tablename,reference_id_name);


                        });
                }

            }
          });
  });
    socket.on('updatePortfolioAve',function(pupdate_id){

          console.log('updatePortfolioAve is ok');
        var selectPortfolioAve = db.query('SELECT ROUND(AVG(rating)) AS AverageRate FROM '+tablename+' where '+reference_id_name+' = ?',[pupdate_id],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
                for (var r in rows) {
                var AverageRate           = rows[r].AverageRate;
                    console.log('room no.'+socket.room);
                    console.log('AverageRate Value'+AverageRate);
                 io.sockets.in(socket.room).emit('AverageRate Value',{AverageRate:AverageRate,portfolio_id:pupdate_id});
                }
        });
    });

});

//End Rating Portfolio ==============+++++++++=================
  /////  Portfolio Descriptions

     socket.on('Get EditedDescriptions',function(portfolio_id,description,tablename,columnIdName,projectName,category_id){
         console.log('Get EditedDescriptions has been triggered');
         //console.log('Get EditedDescriptions Triggered');
         //console.log('portfolio id: '+portfolio_id);
         //console.log('description: '+description);
         //console.log('tableName: '+tablename);
         //console.log('columnIdName: '+columnIdName);
         //console.log('project Name: '+projectName);
       var  updateDescription  = db.query('UPDATE '+tablename+' SET  description = ?, name = ?, category_id = ? WHERE  '+columnIdName+' = ? ',[description,projectName,category_id,portfolio_id],function(err,rows,fields){
             if (err) {
                      console.log(err);
             }
        var  selectCategoryName = db.query('SELECT * FROM  category where category_id = ?',category_id,function(err,rows,fields){
                for (var s in rows){
                    var category_name  = rows[s].category_name;

             io.sockets.in(socket.room).emit('Set EditedDescriptions',{projectName:projectName,description:description,category_name:category_name});
                    }
          });
       });
 });

//Project Progress Update function not Project Progress
 socket.on('Get EditedProjectDescriptions',function(portfolio_id,description,tablename,columnIdName){
      console.log('Get EditedProjectDescription Trigggered');
      console.log('projectprog_update _id : '+portfolio_id);
      console.log('description: '+description);
      console.log('tablename: '+tablename);
      console.log('columnIdName: '+columnIdName);
       var updateDescription  = db.query('UPDATE '+tablename+' SET descriptions  = ? where '+columnIdName+' = ?',[description,portfolio_id],function(err,rows,fields){
            if (err) {
                      console.log(err);
             }
                  io.sockets.in(socket.room).emit('Set EditedProjectDescriptions',{description:description})
       });
 });


socket.on('Get ProjProgIDfImage',function(projprog_id){
   console.log('Trigger Get ProjProgIDfImage=====');
   console.log(projprog_id);
    SelectProjProgImages(io.sockets.in(socket.room),projprog_id)
});



socket.on('InsertProjProgImageDescription',function(projprogimg_id,image_description){
    /// console.log("insert projprog image description triggered");
     var  updateDescription  =  db.query('UPDATE projectprog_image SET image_description = ? where projprogimg_id = ?',[image_description,projprogimg_id],function(err,rows,fields){
      if(err){
          console.log(err);
      }
   });
});
//Edit assign section
socket.on('Assign Section',function(tablename,column_id_name,section_id,projprogimg_id){
      var  assignSection  = db.query('UPDATE  '+tablename+' SET section_id = ?  where  '+column_id_name+' = ?',[section_id,projprogimg_id],function(err,rows,fields){
           if(err){
                console.log(err);
           }
      });

});

socket.on('Get DeleteProjProgImage',function(projprogimg_id){
      console.log('Delete Projprogimg_id'+projprogimg_id);
var deleteProjProgImage = db.query('UPDATE projectprog_image SET available = 1 where projprogimg_id = ?',projprogimg_id,function(err,rows,fields){
      if(err){
          console.log(err);
      }
});
});
socket.on('Get DeletePortfolioImage',function(projprogimg_id){
      console.log('Delete Projprogimg_id'+projprogimg_id);
var deleteProjProgImage = db.query('UPDATE portfolio_images SET available = 1 where portimg_id = ?',projprogimg_id,function(err,rows,fields){
      if(err){
          console.log(err);
      }
});
});
    socket.on('Select FeaturePortfolioImages',function(tablename,column_id_name,portimg_id,featured){
        //console.log('portimg_id value '+portimg_id);

     console.log('Select Featured Portfolio Images has been triggerd');
      var SelectFeatureImages  = db.query('UPDATE '+tablename+' set featured = ? where '+column_id_name+' = ?',[featured,portimg_id],function(err,rows,fields){
           console.log('Query Completed');
          if(err){
              console.log(err);
          }
      });

});
socket.on('Delete Project',function(portfolio_id,tablename,columnIdName){
     var  deleteproject = db.query('UPDATE  '+tablename+' SET  available = 1  WHERE  '+columnIdName+' = ? ',portfolio_id,function(err,rows,fields){
             if (err) {
                      console.log(err);
             }
             io.sockets.in(socket.room).emit('Set DeletedPhase')
       });
});
}else{
      console.log('Message Function Detected........');
      console.log('MEssage  MODULE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');



       if(socket.user_level == 'Client'){


                       RetrieveNotificationHistory(socket.username,socket);
                       console.log('A Client user has connected  user_id = '+socket.username);
                       client[socket.username] = socket;
                       socket.room = user_id;
                       var chatlog = socket;
                       socket.join(socket.room);
                       updateRoomList(socket, socket.room);

                       retrievedHistory(socket.room,chatlog);
                       socket.emit('admin',admin_list);
                  ClientOnlineIndicator(socket);
                       countMessagesClient(socket,socket.username);

       }else{
                      RetrieveNotificationHistory(socket.username,socket);
                      countMessagesClient(socket,socket.username);

                      countMessagesAdmin(socket,socket.username);
                      socket.join(socket.room);
                      //updateClient(socket, user_id, socket.room);
                      //updateChatRoom(socket, 'connected');
                      updateRoomList(socket, socket.room);
                      var chatlog = socket;
                      retrievedHistory(socket.room,chatlog);
                      admin[socket.username] = socket;
                      company_users[socket.username] = socket;
                      ClientOnlineIndicator(socket);







       }
//}

socket.on('sendChat', function (data) {
         var  sender_socket = socket;
         var  receiver_socket =  socket.room;

    if(socket.user_level == "Client"){
               //console.log('Sending Message Client to Admin');

          var  selectAdmins = db.query('SELECT * FROM users where levels = "Admin" or levels = "Interior Designer"',function(err,rows,fields,result){
                 io.sockets.in(socket.room).emit('updateChat',Rusername,data,dateTime);
              for (var s in rows){
                    var user_id  = rows[s].user_iid;

                      if(user_id in admin){
                      SaveMessages(socket.username,user_id,data,dateTime,admin[user_id],'Admin');
                      }else{
                         SaveMessageForOffline(socket.username,user_id,data,dateTime);
                      }
                 }
          });
    }else{

         var selectLevels = db.query('SELECT * FROM users where user_iid = ? ',socket.room,function(err,rows,fields,result){
             for (var r in rows) {
                  var user_level         = rows[r].levels;
                 if(user_level == "Client"){
                       io.sockets.in(socket.room).emit('updateChat',Rusername,data,dateTime);
                         seenMessagesClient(socket,socket.username,socket.room);
                      if (receiver_socket in client){

                          console.log('Sennd Message to client ');
                          SaveMessages(socket.username,socket.room,data,dateTime,client[receiver_socket],user_level);
                      }else{

                           SaveMessageForOffline(socket.username,socket.room,data,dateTime);
                      }
                 }else{
                          io.sockets.in(socket.room).emit('updateChat',Rusername,data,dateTime);
                        seenMessagesClient(socket,socket.username,socket.room);
                    if (receiver_socket in admin){
                          SaveMessages(socket.username,socket.room,data,dateTime,admin[receiver_socket],user_level);
                    }else{
                         SaveMessageForOffline(socket.username,socket.room,data,dateTime);
                    }
                }
             }
       });
    }

});
    //when we switch a room
    socket.on('switchRoom', function(newRoom) {
         //console.log(newRoom+'this is the room id ');
                   socket.leave(socket.room);
                    socket.join(newRoom);
                    DisplayReceiverDescription(socket,newRoom);
                    retrievedHistory(newRoom,socket);
                    //updateClient(socket, socket.username, newRoom);
                    //update old room
                    //updateChatRoom(socket, 'disconnected');
                    //change room
                    socket.room = newRoom;
                    //update new room
                   // updateChatRoom(socket, 'connected');
                    updateRoomList(socket, socket.room);
                    seenMessagesClient(socket,socket.username,newRoom);

    });

    //disconnecting from a room
socket.on('disconnect', function(){
   delete online_users[socket.username];
   delete admin[socket.username];
   delete client[socket.username];
   delete company_users[socket.username];
   AdminOnlineIndicator(socket);
      ClientOnlineIndicator(socket);




        //updateGlobal(socket, 'disonnected');
   socket.leave(socket.room);
    admin_online_list = [];


});

socket.on('Seen Messsages Client',function(){
    console.log("SEEN MESSAGES");
         var seenClientMessages = db.query('UPDATE convo SET seen = 1 where to_id = ?',socket.username,function(err,rows,fields,results){

              countMessagesClient(socket,socket.username);
         });
    });

    }


  });

});
});
//Rating Starts here


//Comment Starts here ===============================================================================================

function  SumRatingAve(portfolio_id,socket,tablename,reference_id_name){
         var selectPortfolioAve = db.query('SELECT ROUND(AVG(rating)) AS AverageRate FROM '+tablename+' where  '+reference_id_name+' = ?',[portfolio_id],function(err,rows,fields){
                             if (err) {
                                 console.log(err);
                                 }
                for (var r in rows) {
                var AverageRate           = rows[r].AverageRate;
                    console.log('AverageRate Value'+AverageRate);
                 io.sockets.in(socket).emit('AverageRate Value',{AverageRate:AverageRate,portfolio_id:portfolio_id});
                }
        });
}



function SaveUserCommentsDB(pupdate_id_data,user_id,comment,tableName,comment_id_name,reference_id_name){
   // console.log('pudapte_id  obtained'+pupdate_id_data);
   // console.log('user_id  obtained'+user_id);
    //console.log('comment  obtained'+comment);
         var insertUserComments = db.query('INSERT INTO '+tableName+'('+reference_id_name+',user_id,comment,available,date)values(?,?,?,?,?)',[pupdate_id_data,user_id,comment,0,dateTime],function(err,rows,fields){
        // console.log("INSERT Comment SUCCESS :");
                      if (err) {
                           console.log(err);
                      }
   });
    var SelectCommentID = db.query('SELECT projprog_update_comment_id FROM projprog_update_comments where date = ? and pupdate_id = ? and user_id = ? and comment = ? and available = ?',[pupdate_id_data,user_id,comment,0,dateTime],function(err,rows,fields){
          for (var r in rows) {
             var comment_id   = rows[r].projprog_update_comment_id;
          }

    });
}
function SaveUserReplyCommentsDB(parent_comment_id,pupdate_id_data,user_id,comment,tableName,comment_id_name,reference_id_name){
    //console.log('parent_comment_id: '+parent_comment_id);
    //console.log('pudapte_id  obtained'+pupdate_id_data);
   // console.log('user_id  obtained'+user_id);
    //console.log('comment  obtained'+comment);
      var insertUserComments = db.query('INSERT INTO '+tableName+'(parent_comment_id,'+reference_id_name+',user_id,comment,available,date)values(?,?,?,?,?,?)',[parent_comment_id,pupdate_id_data,user_id,comment,0,dateTime],function(err,rows,fields){
         //console.log("INSERT Comment SUCCESS :");
                      if (err) {
                           console.log(err);
                      }
    });

}

function RetrievedProjectCommentUpdates(pupdate_id,user_socket,tableName,comment_id_name,reference_id_name){
    //console.log("RetrievedProjectCommentUpdates READED");
      var  SelectComment  = db.query('SELECT '+comment_id_name+' AS comment_id_name,user_iid,comment,username  FROM '+tableName+'  left join users on '+tableName+'.user_id = users.user_iid where '+reference_id_name+'  = ?  and '+tableName+'.available = 0  and parent_comment_id = 0  order by '+comment_id_name+'  desc',pupdate_id,function(err,rows,fields){
        for (var r in rows) {
                var user_id      = rows[r].user_iid;
                var comment      = rows[r].comment;
                var username     = rows[r].username;
                var comment_id   = rows[r].comment_id_name;
            //console.log("                                           ");
            //console.log("==========================================");
            //console.log("SELECTING COMMENT HISTORY");
           // console.log("Comment ID:"+comment_id);
            //console.log("User_id: "+user_id);
            //console.log("Retrived Comment: "+comment);
            //console.log("Retrived username: "+username);
            //console.log('user_socket: '+user_socket);
            //console.log("==========================================");
            //console.log("                                           ");
            user_socket.emit('Comment History',{comment:comment,username:username,pupdate_id:pupdate_id,comment_id:comment_id,user_id:user_id});
               //console.log('Comment history data:',{comment:comment,username:username,comment_id:comment_id});
        }
     });
}
function RetrievedProjectReplyCommentUpdates(pupdate_id,user_socket,tableName,comment_id_name,reference_id_name){
   // console.log('RetrievedProjectReplyCommentUpdates READED');
         var  SelectComment  = db.query('SELECT  user_iid,comment,username,parent_comment_id,'+comment_id_name+' AS comment_id_name  FROM '+tableName+'  left join users on '+tableName+'.user_id = users.user_iid where '+reference_id_name+'  = ?  and '+tableName+'.available = 0  and parent_comment_id != 0    order by '+comment_id_name+'  desc',pupdate_id,function(err,rows,fields){
        for (var r in rows) {
                var user_id           = rows[r].user_iid;
                var comment           = rows[r].comment;
                var username          = rows[r].username;
                var comment_id        = rows[r].comment_id_name;
                var parent_comment_id = rows[r].parent_comment_id;
            //console.log("                                           ");
            //console.log("==========================================");
            //console.log("SELECTING REPLY COMMENT HISTORY");
           // console.log('Parent_Comment_Id: '+parent_comment_id);
            //console.log("Comment ID:"+comment_id);
           // console.log("User_id: "+user_id);
           // console.log("Retrived Comment: "+comment);
           // console.log("Retrived username: "+username);
            //console.log('user_socket: '+user_socket);
            //console.log("==========================================");
           // console.log("                                          ");

                user_socket.emit('Show ReplyCommentHistory',{parent_comment_id:parent_comment_id,comment:comment,username:username,pupdate_id:pupdate_id,comment_id:comment_id,user_id:user_id});
              // console.log('Reply Comment History data:',{parent_comment_id:parent_comment_id,comment:comment,username:username,pupdate_id:pupdate_id,comment_id:comment_id,user_id:user_id});


        }
     });
}
// Function Private Message Start here ************************************
function DisplayReceiverDescription(socket,receiver_id){
     var  DisplayReceiver = db.query('SELECT * FROM users WHERE user_iid = ? ',receiver_id,function(err,rows,fields,results){
         for (var s in rows){
              var username    =  rows[s].username;
              var user_level  =  rows[s].levels;
             //console.log('user_level'+rows[s].levels);
             socket.emit('Display Receiver',{username:username,user_level:rows[s].levels});
         }

     });
}
function AdminOnlineIndicator(socket){
    admin_online_indicator = [];
     for (var s in online_list){
          if(online_list[s] in online_users){
              admin_online_indicator.push('Online');
          }else{
              admin_online_indicator.push('Offline');
          }
     }
     io.sockets.emit('Admin OnlineIndicator',admin_online_indicator);
}
function ClientOnlineIndicator(socket){
    store_admin_online = [];

    for (var s in admin_online_list){
          //console.log('user_id'+admin_online_list[s]);

           if(admin_online_list[s] in company_users){
                store_admin_online.push('Online');
             //    console.log('online');
           }else{
                store_admin_online.push('Offline');
              //   console.log('offline');
           }
    }
    io.sockets.emit('admin_online_list',store_admin_online);
}

function seenMessagesClient(socket,to_id,from_id){
     var seenClientMessages = db.query('UPDATE convo SET seen = 1 where to_id = ? and from_id = ?', [to_id,from_id],function(err,rows,fields,results){
              countMessagesAdmin(socket,socket.username);
              countMessagesClient(socket,socket.username);
     });
}
//update single client with this.
/*
function updateClient(socket, username, newRoom) {
    socket.emit('updateChat', 'SERVER', 'You\'ve connected to '+ newRoom);
}
*/
function updateRoomList(socket, currentRoom ) {
    socket.emit('updateRooms', rooms, currentRoom);
    socket.emit('updateRoomsNames',room_names);
    socket.emit('updateRoomLevels',room_level);
}
function updateClientOnline(socket){
     socket.emit('admin',admin_list);
}

function countMessagesAdmin(socket,to_id,from_id){
     var  countMessagesValuesAdmin = [];
    //console.log('wtf');
console.log('CountMessagesAdmin has been triggered');
for (var a in online_list){
     var countMessages = db.query('SELECT COUNT(*) as  message_count FROM  convo where from_id = ?   and to_id =  ? and seen = 0' ,[online_list[a],to_id],function(err,rows,fields){
         for (var a in rows){
           var message_count = rows[a].message_count;
           countMessagesValuesAdmin.push(message_count);
             //console.log('Message Count'+message_count);

              }
           socket.emit('countMessagesValues',countMessagesValuesAdmin);
     });
  }

}
function countMessagesClient(socket,to_id){
    console.log('CountMessagesClient has been triggered');
    //console.log('qweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeew');
    var  countMessagesValues = [];
    var countMessages = db.query('SELECT COUNT(*) as  message_count FROM  convo where   to_id =  ? and seen = 0',to_id,function(err,rows,fields){
           for (var a in rows){
               var message_count = rows[a].message_count;
               countMessagesValues.push(message_count);
                socket.emit('countMessagesValuesClient',countMessagesValues);
               countMessagesValues = [];
          }
        //console.log('message count'+message_count);

    });

}
function ratingChoices(socket,nns){
    socket.emit('RatingChoices',ratingValues);
}
      //SaveMessages(socket.username,socket.room,data,dateTime,client[receiver_socket],user_level);
function SaveMessages(sender_id,receiver_id,message, date_time,socket,user_level){
      var  message_id;
      //console.log('Saving database');
      //console.log('message value:',message);
      //console.log('datetime value:',date_time);
      //console.log('Sender user id obtained:',sender_id);
      //console.log('Receiver user id obtained:',receiver_id);
              var insertMessage = db.query('INSERT INTO message(message,date_time)values(?,?)',[message,date_time],function(err,rows,fields){
                      console.log("INSERT MESSAGE SUCCESS  1 :");
                          if (err) {
                              //console.log(err);
                              }
              var selectMessage = db.query('SELECT * FROM message where message = ? and date_time = ?  ',[message,date_time],function(err,rows,fields){
                          for (var m in rows) {
                             message_id = rows[m].message_id;
                            console.log('message id obtained:',message_id);
                            if (err) {
                                //console.log(err);
                                }
                          }
              var insertConvo = db.query('INSERT INTO convo (from_id,to_id,message_id_fk)values(?,?,?)',[sender_id,receiver_id,message_id],function(err,rows,fields){
                             console.log("INSERT CONVO SUCCESS 3 :");
                             if (err) {
                                // console.log(err);
                                 }
                          if(user_level == "Client"){
                              countMessagesClient(socket,receiver_id);
                          }else{
                                  countMessagesClient(socket,receiver_id);
                              countMessagesAdmin(socket,receiver_id,sender_id);
                          }


                          });
                    });
                 });
             console.log('Successfully  saved');
}
function SaveMessageForOffline(sender_id,receiver_id,message, date_time){
      var  message_id;
     // console.log('Saving database');
      //console.log('message value:',message);
     // console.log('datetime value:',date_time);
     // console.log('Sender user id obtained:',sender_id);
     // console.log('Receiver user id obtained:',receiver_id);
              var insertMessage = db.query('INSERT INTO message(message,date_time)values(?,?)',[message,date_time],function(err,rows,fields){
                      //console.log("INSERT MESSAGE SUCCESS :");
                          if (err) {
                              console.log(err);
                              }
              var selectMessage = db.query('SELECT * FROM message where message = ? and date_time = ?  ',[message,date_time],function(err,rows,fields){
                          for (var m in rows) {
                             message_id = rows[m].message_id;
                            //console.log('message id obtained:',message_id);
                            if (err) {
                                //console.log(err);
                                }
                          }
              var insertConvo = db.query('INSERT INTO convo (from_id,to_id,message_id_fk)values(?,?,?)',[sender_id,receiver_id,message_id],function(err,rows,fields){
                             //console.log("INSERT CONVO SUCCESS :");
                             if (err) {
                                 //console.log(err);
                                 }



                          });
                    });
                 });
            //console.log('Successfully  saved');
}
function retrievedHistory(user_nick,user_socket){

            console.log('RETRIVED HISTORY HAS BEEN TRIGGERED');
             var SelectHistory = db.query('SELECT DISTINCT message,date_time,username FROM message inner join convo on convo.message_id_fk = message.message_id inner join users on convo.from_id = users.user_iid where convo.from_id = ? or convo.to_id = ? ORDER BY  message.message_id',[user_nick,user_nick],function(err,rows,fields){
                for (var r in rows) {
                   var msg         = rows[r].message;
                   var date_time   = rows[r].date_time;
                   var name        = rows[r].username ;
                   var user_iid    = rows[r].user_iid;
                              if( user_nick == user_iid ){
                                //  console.log('if user nick is reach');
                                 user_socket.emit('chatHistory',{msg:msg,nick:"You",date:date_time});
                               //  console.log({msg:msg,nick:"You",date:date_time});
                              }else{
                                 user_socket.emit('chatHistory',{msg:msg,nick:name,date,date:date_time});
                               //console.log({msg:msg,nick:name,date:date_time});
                              }
               }
            });
}

//We will use this function to update the chatroom when a user joins or leaves
function updateChatRoom(socket, message) {
    socket.broadcast.to(socket.room).emit('updateChat', 'SERVER', socket.username + ' has ' + message);
}
//We will use this function to update everyone!
function updateGlobal(socket, message) {
    socket.broadcast.emit('updateChat', 'SERVER', socket.username + ' has ' + message);
}

function saveNotificationDb(user_id,customer_id,msg,DateTime,notification_type,key_id,socket){ //1  to 1 data
    var notification_id;
     var saveNotification = db.query('INSERT INTO  notification (notification_message,notification_type,notification_date,reference_link)values(?,?,?,?)',[msg,notification_type,DateTime,key_id],function(err,rows,fields){
                             if (err) {
                                 //console.log(err);
                                 }
          var select_notification_id = db.query('SELECT * FROM notification where notification_message = ? and notification_type = ? and notification_date = ?',[msg,notification_type,DateTime],function(err,rows,fields){
                     for (var m in rows) {
                             notification_id = rows[m].notification_id;
                            //console.log('notification id obtained:',notification_id);
                            if (err) {
                                //console.log(err);
                                }
                     }
                var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,customer_id,user_id],function(err,rows,fields){
                             if (err) {
                                 //console.log(err);
                                 }
                    countNotification(socket,customer_id);
                });
            });
     });
}
function saveNotificationDbOffline(user_id,customer_id,msg,DateTime,notification_type,key_id){ //1  to 1 data
    var notification_id;
     var saveNotification = db.query('INSERT INTO  notification (notification_message,notification_type,notification_date,reference_link)values(?,?,?,?)',[msg,notification_type,DateTime,key_id],function(err,rows,fields){
                             if (err) {
                                 //console.log(err);
                                 }
          var select_notification_id = db.query('SELECT * FROM notification where notification_message = ? and notification_type = ? and notification_date = ?',[msg,notification_type,DateTime],function(err,rows,fields){
                     for (var m in rows) {
                             notification_id = rows[m].notification_id;
                            //console.log('notification id obtained:',notification_id);
                            if (err) {
                                //console.log(err);
                                }
                     }
                var saveNotification_Users = db.query('INSERT INTO  notification_users (notification_id,notification_id_receiver,notification_id_sender)values(?,?,?)',[notification_id,customer_id,user_id],function(err,rows,fields){
                             if (err) {
                                 //console.log(err);
                                 }
                });
            });
     });
}
function RetrieveNotificationHistory(user_id,user_socket){
    var notification_table = 'notification';
     //console.log('RetrieveNotificationHistory has been triggered');
      //console.log('The value of user_id is: '+user_id);
     var SelectHistory = db.query('SELECT * FROM  '+notification_table+' LEFT JOIN  notification_users ON notification.notification_id = notification_users.notification_id left join users on notification_users.notification_id_sender = users.user_iid where notification_users.notification_id_receiver =  ? ORDER BY notification.notification_id DESC LIMIT 5',user_id,function(err,rows,fields){
                for (var r in rows) {

                   var  notification_message     = rows[r].notification_message;
                   var  reference_link           = rows[r].reference_link;
                   var  notification_date        = rows[r].notification_date;
                   var  username                 = rows[r].username;

                    user_socket.emit('ProjectNotificationHistory',{notification_message:notification_message,reference_link:reference_link,notification_date:notification_date,username:username });
                // console.log('notification_message: '+notification_message);
                    //console.log('reference_link: '+reference_link);
                   // console.log('notification date: '+notification_date);
               }
            });
}
function countNotification(user_socket,user_id){
    //console.log('CountMessagesClient has been triggered');
    var  countNotification = [];
    var countNotifications = db.query('SELECT  COUNT(*) as  notification_count FROM  notification right join  notification_users  on notification.notification_id = notification_users.notification_id  where notification_id_receiver = ? and seen_by_receiver = 0',user_id,function(err,rows,fields){
           for (var a in rows){

               var notification_count = rows[a].notification_count;
               //console.log(notification_count);
               countNotification.push(notification_count);

          }
        //console.log('notification count'+notification_count);
        user_socket.emit('countNotification',countNotification);
    });
}
 //Retrieved Portfolio with latest uploads
function portfolioHome(socket){
 var selectPortfolioHome = db.query('SELECT portfolio.portfolio_id,portfolio.name,portfolio.description,category.category_name,category.category_id,portfolio.user_iid FROM  portfolio  left join category  on portfolio.category_id = category.category_id  where  portfolio.available = 0  order by portfolio.portfolio_id desc limit 6',function(err,rows,fields){
      for (var a in rows){
        var  portfolio_id   = rows[a].portfolio_id;
        var  name           = rows[a].name;
        var  description    = rows[a].description;
        var  category_name  = rows[a].category_name;
        var  user_id        = rows[a].user_iid;
              RetrievedPaths(socket,portfolio_id,name,description,category_name,user_id);
      }
 });
}
//Retrieved Portofolio Items Start ---------
function  retrievePortfolio(socket,category_id){
     console.log('RetrivePortfolio ----');
        var selectPortfolio = db.query('SELECT portfolio.portfolio_id,portfolio.name,portfolio.description,category.category_name,category.category_id,portfolio.user_iid FROM  portfolio  left join category  on portfolio.category_id = category.category_id  where category.category_id = ?   and portfolio.available = 0  order by portfolio.portfolio_id desc',category_id,function(err,rows,fields){
           for (var a in rows){
            var  portfolio_id   = rows[a].portfolio_id;
            var  name           = rows[a].name;
            var  description    = rows[a].description;
            var  category_name  = rows[a].category_name;
            var  user_id        = rows[a].user_iid;
                  RetrievedPaths(socket,portfolio_id,name,description,category_name,user_id);

           }
    });
}

function   RetrievedPaths(socket,portfolio_id,name,description,category_name,user_id){
    var selectPathImage = db.query('SELECT * FROM  portfolio_images  where portfolio_id = ? limit   1',portfolio_id,function(err,rows,fields){
                  for (var s in rows){
                       var path      = rows[s].path;
                       var featured  = rows[s].featured;
            console.log('==============================================');
                   console.log('portfolio_id: '+portfolio_id);
                   console.log('Path '+path);
                 RetrievedRating(socket,portfolio_id,name,description,category_name,user_id,path,featured);

         console.log('==============================================');
                  }
             });
}
function RetrievedRating(socket,portfolio_id,name,description,category_name,user_id,path,featured){
    var selectPathImage = db.query('SELECT ROUND(AVG(rating)) AS AverageRate FROM rating_portfolio where portfolio_id = ?',portfolio_id,function(err,rows,fields){
      for(var s in rows){
         var AverageRate = rows[s].AverageRate;
          ProducedFeatureImG(socket,portfolio_id);
               socket.emit('retrievedPortfolio',{portfolio_id:portfolio_id,name:name,description:description,category_name:category_name,user_id:user_id,path:path,AverageRate:AverageRate,featured:featured});
      }
    });
}


function ProducedFeatureImG(socket,portfolio_id){
    console.log('ProducedFeatureIMg has been triggerd');
    var selectFeatured = db.query('SELECT * FROM portfolio_images where portfolio_id = ? and featured = 1',portfolio_id,function(err,rows,fields){
       for(var s in rows){
          var featpath = rows[s].path;
          socket.emit('retrievedFeaturedIMG',{featpath:featpath,portfolio_id:portfolio_id});
       }
    });
}
//Feature Photos

///   Retrieved Portofolio Items  END








//Retrieved Portfolio Images End
function SelectClients(socket){
   /// console.log('Select Clients Triggered');
    var  selectClient  = db.query('SELECT * FROM users where levels = ?  and available = 0 LIMIT 10 OFFSET 0','Client',function(err,rows,fields){
        for(var s in rows){
              var user_id = rows[s].user_iid;
              var lname   = rows[s].lname;
              var fname   = rows[s].fname;
              var mname   = rows[s].mname;
              var username = rows[s].username;

            // console.log('user_id '+user_id);

            socket.emit('Selected Clients',{user_id:user_id,lname:lname,fname:fname,mname:mname,username:username});
        }
    });
}


//SelectProjProgImages(io.sockets.in(socket.room),projprog_id);
function SelectProjProgImages(socket,projprog_id){
     console.log('SelectProjProg has been triggered');
     var selectProjProgImags = db.query('SELECT  projectprog_image.pupdate_id,projectprog_image.path,projectprog_image.featured,projectprog_image.section_id,section.section_name,projectprog_image.projprogimg_id,projectprog_image.available, projectprog_image.image_description FROM `projectprog_image`  left join projectprog_update on projectprog_image.pupdate_id = projectprog_update.pupdate_id left join section on projectprog_image.section_id = section.section_id  where  projectprog_update.pupdate_id =  ?  and projectprog_image.available = 0 order by projectprog_image.projprogimg_id desc',projprog_id,function(err,rows,fields){
          for (var s in rows){
                 if (err) {
                                 console.log(err);
                                 }


             var  pupdate_id         = rows[s].pupdate_id;
             var  path               = rows[s].path;
             var  projprogimg_id     = rows[s].projprogimg_id;
             var  description        = rows[s].image_description
             var  section_name       = rows[s].section_name;
             var  featured           = rows[s].featured;

        if(section_name === null){
            section_name = "none";

          socket.emit('SetProjProgImg',{pupdate_id:pupdate_id,path:path,projprogimg_id:projprogimg_id,description:description,section_name:section_name,featured:featured});
           }else{
                socket.emit('SetProjProgImg',{pupdate_id:pupdate_id,path:path,projprogimg_id:projprogimg_id,description:description,section_name:section_name,featured:featured});
           }
          }
     });
      //Create
}
function SelectGalleryProjProgImages(socket,projprog_id){

  console.log('SelectGalleryProjProgImages has been triggerd');
  var selectImages = db.query('SELECT projectprog_update.available ,projectprog_image.projprogimg_id,projectprog_image.name,projectprog_image.path,projectprog_image.available FROM project_progress  left join projectprog_update on project_progress.projprog_id = projectprog_update.projprog_id left join projectprog_image on projectprog_update.pupdate_id  = projectprog_image.pupdate_id  where project_progress.projprog_id = ? and projectprog_image.available = 0 and projectprog_update.available = 0 and projectprog_update.available = 0',projprog_id,function(err,rows,fields){
       for(var s in rows){
            if(err){
                console.log(err);
            }
          var projprogimg_id   = rows[s].projprogimg_id;
          var path             = rows[s].path;
          var available        = rows[s].available;
          var name             = rows[s].name;
       socket.emit('Set SelectGalleryProjProgImages',{projprogimg_id:projprogimg_id,path:path,available:available,name:name});
       }

  });
}
function SelectProjectUpdateSections(socket,projprog_id){
    var selectProjProgImags = db.query('SELECT DISTINCT projectprog_image.section_id,section.section_name,projectprog_image.pupdate_id FROM `projectprog_image` left join projectprog_update on projectprog_image.pupdate_id = projectprog_update.pupdate_id left join section on projectprog_image.section_id = section.section_id where projectprog_update.pupdate_id = ? and projectprog_image.available = 0 and section.section_id is not null order by projectprog_image.projprogimg_id desc',projprog_id,function(err,rows,fields){
          for (var s in rows){
             var section_id   = rows[s].section_id;
             var section_name = rows[s].section_name;
             var pupdate_id   = rows[s].pupdate_id;
              if(section_name === null){
                  var section_name = "none";
                //socket.emit('Set Section',{section_id:section_id,section_name:section_name,pupdate_id:pupdate_id});
              }else{
                  socket.emit('Set Section',{section_id:section_id,section_name:section_name,pupdate_id:pupdate_id});
              }
          }
    });
}
function SelectPortfolioSections(socket,portfolio_id){
     var selectProjProgImags = db.query('select DISTINCT portfolio_images.section_id,section.section_name,portfolio_images.portfolio_id  from portfolio  left join portfolio_images  on portfolio.portfolio_id = portfolio_images.portfolio_id left join section on  portfolio_images.section_id =  section.section_id where portfolio.portfolio_id = ? and portfolio_images.available = 0',portfolio_id,function(err,rows,fields){
          for (var s in rows){
             var section_id   = rows[s].section_id;
             var section_name = rows[s].section_name;
             var portfolio_id   = rows[s].portfolio_id;
              if(section_name === null){
                  var section_name = "none";
               // socket.emit('Set PortfolioSection',{section_id:section_id,section_name:section_name,portfolio_id:portfolio_id});
              }else{
                  socket.emit('Set PortfolioSection',{section_id:section_id,section_name:section_name,portfolio_id:portfolio_id});
              }
          }
    });
}
function   SelectSectionPictures(socket,pupdate_id,section_id){
    console.log('SelectSectionPictures has been triggered');
    console.log('pupdate id value: '+pupdate_id);
    console.log('section id value: '+section_id);
    var selectSectionPictureQ = db.query('SELECT * FROM projectprog_image where pupdate_id = ? and section_id = ? and available = 0',[pupdate_id,section_id],function(err,rows,fields){
         for(var s in rows){
              if(err){
                console.log(err);
            }
            var  path            = rows[s].path;
            var  projprogimg_id  = rows[s].projprogimg_id;

             console.log('path '+path);
             console.log('projprogimg_id '+projprogimg_id);
             socket.emit('Set DisplaySectionPictures',{path:path,projprogimg_id:projprogimg_id,section_id:section_id});
         }
    });
}
function SelectSectionPortfolioPictures(socket,portfolio_id,section_id){
   var selectSectionPictureQ = db.query('SELECT * FROM portfolio_images where portfolio_id = ? and section_id = ? and available = 0',[portfolio_id,section_id],function(err,rows,fields){
         for(var s in rows){
              if(err){
                console.log(err);
            }
            var  path            = rows[s].path;
            var  portimg_id      = rows[s].portimg_id;

             console.log('path '+path);
             console.log('projprogimg_id '+portimg_id);
             socket.emit('Set DisplaySectionPortfolioPictures',{path:path,portimg_id:portimg_id,section_id:section_id});
         }
    });
}
function SelectAllPictures(socket,pupdate_id){
       //console.log('Select All pictures called');
       var selectSectionPictureQ = db.query('SELECT * FROM projectprog_image where pupdate_id = ? and available = 0',[pupdate_id],function(err,rows,fields){
         for(var s in rows){
              if(err){
                console.log(err);
            }
            var  path            = rows[s].path;
            var  projprogimg_id  = rows[s].projprogimg_id;

             console.log('path '+path);
             console.log('projprogimg_id '+projprogimg_id);
             socket.emit('Set AllSectionPictures',{path:path,projprogimg_id:projprogimg_id});
         }
    });
}
function SelectAllPortfolioPictures(socket,portfolio_id){
      var selectSectionPictureQ = db.query('SELECT * FROM portfolio_images where portfolio_id = ? and available = 0',[portfolio_id],function(err,rows,fields){
         for(var s in rows){
              if(err){
                console.log(err);
            }
            var  path            = rows[s].path;
            var  portimg_id  = rows[s].portimg_id;

             console.log('path '+path);
             console.log('projprogimg_id '+portimg_id);
             socket.emit('Set AllSectionPortfolioPictures',{path:path,projprogimg_id:portimg_id});
         }
    });
}
function SelectNoneSectionPictures(socket,pupdate_id){
      var SelectNoneSectionP = db.query('SELECT * FROM projectprog_image  where pupdate_id = ? and available = 0 and section_id is null',pupdate_id,function(err,rows,fields){
          for(var s in rows){
                if(err){
                     console.log(err);
                }
             var path = rows[s].path;
             var projprogimg_id = rows[s].projprogimg_id;
                socket.emit('Set NoneSectionPictures',{path:path,projprogimg_id:projprogimg_id});
          }
      });
}
function  SelectNoneSectionPortfolioPictures(socket,portfolio_id){
       var SelectNoneSectionP = db.query('SELECT * FROM portfolio_images  where portfolio_id = ? and available = 0 and section_id is null',portfolio_id,function(err,rows,fields){
          for(var s in rows){
                if(err){
                     console.log(err);
                }
             var path = rows[s].path;
             var portimg_id = rows[s].portimg_id;
                socket.emit('Set NoneSectionPortfolioPictures',{path:path,portimg_id:portimg_id});
          }
      });
}
function  SelectProjProgFeatPictures(socket,pupdate_id){
    console.log('pupdate_id features'+pupdate_id);
    var SelectNoneSectionPs = db.query('SELECT * FROM project_progress  left join projectprog_update on projectprog_update.projprog_id =  project_progress.projprog_id left join projectprog_image  on projectprog_update.pupdate_id  = projectprog_image.pupdate_id  where project_progress.projprog_id =  ? and  projectprog_image.featured =  1 and projectprog_image.available = 0',pupdate_id,function(err,rows,fields){
          for(var s in rows){
             var path = rows[s].path;
            // console.log('path shit'+path);
             var projprogimg_id = rows[s].projprogimg_id;
                    socket.emit('Set FeaturePictures',{path:path,projprogimg_id:projprogimg_id});
          }
      });
}

function SelectPortfolioFeatPictures(socket,portfolio_id){
    //Create Function
      console.log('pupdate_id features'+portfolio_id);
    var SelectNoneSectionPs = db.query('select  *  from  portfolio  left join  portfolio_images  on portfolio.portfolio_id = portfolio_images.portfolio_id  left join   section  on portfolio_images.section_id = section.section_id where portfolio_images.featured = 1 and portfolio_images.available = 0 and portfolio.portfolio_id = ?',portfolio_id,function(err,rows,fields){
          for(var s in rows){
             var path = rows[s].path;
            // console.log('path shit'+path);
             var portimg_id = rows[s].portimg_id;
                    socket.emit('Set FeaturePortfolioPictures',{path:path,portimg_id:portimg_id});
          }
      });
}
