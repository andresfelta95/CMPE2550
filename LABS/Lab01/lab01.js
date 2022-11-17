//  File to be used to complete Lab01

function AJAX(method, url, dataType, data, successCallback, errorCallback) {

    var options = {};
    options["method"] = method;
    options["url"] = url;
    options["dataType"] = dataType;
    options["data"] = data;
    options["success"] = successCallback;
    options["error"] = errorCallback;
    $.ajax(options);

};

var ajaxURL = "service.php";    // service.php is the file that will be used to process the AJAX requests

$().ready(function() {
    $("#login").click(function(e) {
        var postData = {};
        postData["action"] = "login";
        postData["username"] = $("#username").val();
        postData["password"] = $("#password").val();
        AJAX("POST", ajaxURL, "json", postData, successLogin, Bad);
    });
    //  If user clicks on the "Go Register" button, then the user should be redirected to register.php
    $("#GoRegister").click(function(e) {
        window.location.href = "register.php";
    });

    $("#register").click(function(e) {
        var postData = {};
        postData["action"] = "register";
        postData["username"] = $("#username").val();
        postData["password"] = $("#password").val();
        postData["email"] = $("#email").val();
        postData["fname"] = $("#fname").val();
        postData["lname"] = $("#lname").val();
        AJAX("POST", ajaxURL, "json", postData, successRegister, Bad);
    });
});

function successLogin(data) {
    if (data["success"] == true) {
        window.location = "index.html";
    } else {
        alert("Login Failed");
    }
}

function successRegister(data) {
    if (data["success"] == true) {
        window.location = "index.html";
    } else {
        alert("Register Failed");
    }
}

function Bad(data) {
    alert("Bad");
}

