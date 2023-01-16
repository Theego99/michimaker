// script.js
document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    // send the data to the server for authentication
    // ...
    // show a message if the login is successful or not
    // ...
});
