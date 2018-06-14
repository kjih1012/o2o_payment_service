//****************************************register page***************************************************
var appRouter = function(app) {

app.post('/register',function(req, res) {
   //var parsedBody = req.body;

   //res.send("Request received")
   var post  = req.body;
   var uemail= post.user.email;
   var pass= post.user.password;

   var sql = "SELECT email FROM `user` WHERE `email`='"+uemail+"'";

   var query = db.query(sql, function(err, results){
         if(results[0]) { //if user exists && results[0]!=NULL
           res.send("Register Failed");
         }
         else { //new user Register(results[0] = NULL)
           var sql2 = "INSERT INTO user(email, password) VALUES ('" + uemail + "','" + pass + "')";
           var query2 = db.query(sql2, function(err2, results) {
             if(err2) {
                console.log("error : " + err2);
            }
              res.send("Register Success");
           });
         }
       });
     });
}
module.exports = appRouter;
