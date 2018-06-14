//---------------------------------------------signup page call------------------------------------------------------
exports.signup = function(req, res){
   message = '';
   if(req.method == "POST"){
      var post  = req.body;
      var email= post.email;
      var pass= post.password;
     

      var sql = "INSERT INTO `users`(`email', `password`) VALUES ('" + email + "','" + pass + "')";

      var query = db.query(sql);
      res.send("Request received");
/*, function(err, result) {

         message = "Succesfully! Your account has been created.";
         res.render('signup.ejs',{message: message});
      });

   } else {
      res.render('signup');
   }
*/
};