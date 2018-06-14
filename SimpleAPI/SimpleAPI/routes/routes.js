var user = require('./user)(app);
var appRouter = function(app) {

app.post('/applogin', user.signup);

   /*function(req, res) {
   var parsedBody = req.body;
   console.log(parsedBody)
   res.send("Request received")
});*/

}

module.exports = appRouter;
module.exports = user;