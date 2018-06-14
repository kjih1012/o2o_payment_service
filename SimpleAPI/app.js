var express = require("express");
var bodyParser = require("body-parser");
var app = express();
var mysql      = require('mysql');

var connection = mysql.createConnection({
              host     : '192.168.35.49',
              user     : 'root',
              password : '0523',
              database : 'o2o'
            });

connection.connect();
connection.on('error', function(err) {
  console.log("[mysql error]",err);
});

global.db = connection;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

var register = require("./routes/register.js")(app);
var login = require("./routes/login.js")(app);

var server = app.listen(6010,'192.168.35.49', function () {
    console.log("Listening on port %s...", server.address().port);


});
