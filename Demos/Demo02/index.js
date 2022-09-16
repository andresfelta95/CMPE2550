$(document).ready(function(){
    Send();
})


function Send(){
    var postData = {};
    postData['action'] = "Test Data";
    postData['someItem'] = "some Value";

    Obiwan("service.php", "POST", postData, "json", Yay, Booo);
}

function Yay(returnData){
    console.log(returnData);
}

function Booo (request, status, errorMessage){
    console.log(errorMessage);
}

function Obiwan (url, method, data, dataType, success, error){
    var options = {};
    options['url'] = url;
    options['method'] = method;
    options['data'] = data;
    options['dataType'] = dataType;
    options['success'] = success;
    options['error'] = error;

    $.ajax(options);
}