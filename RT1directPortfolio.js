var mysql = require('mysql');
var db  = mysql.createConnection({
    host:'localhost',
    user:'root',
    database:'snfdb'
});
var PortfolioMetaModule = module.exports = {
    SelectPortfolioImages:function(socket,portfolio_id){
      console.log('SelectPortfolioImages has been triggered');
     var  selectPortImags  =  db.query('SELECT  portfolio_images.image_description,portfolio_images.featured,portfolio_images.section_id,section.section_name, portfolio_images.portimg_id,portfolio_images.portfolio_id,portfolio_images.path FROM portfolio  left join portfolio_images  on portfolio.portfolio_id = portfolio_images.portfolio_id  left join section on portfolio_images.section_id = section.section_id   where portfolio.portfolio_id =  ? and portfolio_images.available = 0 order by portfolio_images.portimg_id desc',portfolio_id,function(err,rows,fields){
           for (var s in rows ){
               var portfolio_id   = rows[s].portfolio_id;
               var portimg_id     = rows[s].portimg_id;
               var path           = rows[s].path;
               var description    = rows[s].image_description;
               var featured       = rows[s].featured;
               var section_name   = rows[s].section_name;
       if(section_name === null){
            section_name = "none";
            socket.emit('SetPortfolioImages',{portfolio_id:portfolio_id,portimg_id:portimg_id,path:path,description:description,featured:featured,section_name:section_name});     
       }else{
          socket.emit('SetPortfolioImages',{portfolio_id:portfolio_id,portimg_id:portimg_id,path:path,description:description,featured:featured,section_name:section_name});       
       }
           
      }
        
  });
},
    UpdatePortfolioInformation:function(socket,project_id,project_name,description,category_id){
         var updatePortfolioInformation = db.query('UPDATE portfolio set name = ?,description = ?,category_id = ? where portfolio_id = ?',[project_name,description,category_id,project_id],function(err,rows,fields){
               if(err){
                    console.log(err);
                } 
         });
    }
}