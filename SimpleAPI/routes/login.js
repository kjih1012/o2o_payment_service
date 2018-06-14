//****************************************login page***************************************************
var appLogin = function(app) {

app.post('/login',function(req, res) {
   //var parsedBody = req.body;

   //res.send("Request received")
   var post  = req.body;
   var uemail= post.user.email;
   var pass= post.user.password;

   var sql = "SELECT * FROM user WHERE `email`='"+uemail+"'";

   var query = db.query(sql, function(err, results){
         if(results[0]) { //if user exists && results[0]!=NULL
           //if(results[0].email == uemail) 이미 이메일을 검사
            if(results[0].password == pass)
              res.send("Login Success");
              else {
                res.send("Login Failed")
              }
         }
         else { //new user login(results[0] = NULL)
           res.send("Not Registered");
            }
       });
  });
}
module.exports = appLogin;
