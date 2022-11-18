//  File to be used to complete Lab01

//  Constants
var roles = []; //  Array to store the roles available in the database

function AJAX(method, url, dataType, data, successCallback, errorCallback) {
  var options = {};
  options["method"] = method;
  options["url"] = url;
  options["dataType"] = dataType;
  options["data"] = data;
  options["success"] = successCallback;
  options["error"] = errorCallback;
  $.ajax(options);
}

var ajaxURL = "service.php"; // service.php is the file that will be used to process the AJAX requests

$().ready(function () {
  //  Get the roles from the database and store them in the roles array
  getRoles();

  $("#login").click(function (e) {
    var postData = {};
    postData["action"] = "login";
    postData["username"] = $("#username").val();
    postData["password"] = $("#password").val();
    AJAX("POST", ajaxURL, "json", postData, successLogin, Bad);
  });
  //  If user clicks on the "Go Register" button, then the user should be redirected to register.php
  $("#GoRegister").click(function (e) {
    window.location.href = "register.php";
  });
  //  If user clicks on the "Register" button, then the user should be registered
  $("#register").click(function (e) {
    var postData = {};
    postData["action"] = "register";
    postData["username"] = $("#username").val();
    postData["password"] = $("#password").val();
    postData["email"] = $("#email").val();
    postData["fname"] = $("#Fname").val();
    postData["lname"] = $("#Lname").val();
    AJAX("POST", ajaxURL, "json", postData, successRegister, Bad);
  });
  //  If user clicks on logout button, then the user should be redirected to login.php
  $("#logout").click(function (e) {
    var postData = {};
    postData["action"] = "logout";
    AJAX("POST", ajaxURL, "json", postData, successLogout, Bad);
  });
  //  If user clicks on UserManagement button
  $("#UserManagement").click(UserManagement);
  //  If user clicks on RoleManagementDiv button
  $("#RoleManagementDiv").click(function (e) {
    var postData = {};
    postData["action"] = "RoleManagement";
    AJAX("POST", ajaxURL, "json", postData, successRoleManagement, Bad);
  });
});
//  Function to login the user
function successLogin(data) {
  if (data["success"] == true) {
    window.location = "index.php";
  } else {
    alert("Login Failed");
  }
}
//  Function to register a new user
function successRegister(data) {
  if (data["success"] == true) {
    alert(data["message"]);
    window.location = "login.php";
  } else {
    alert(data["message"]);
    // refresh the page
    window.location = "register.php";
  }
}
//  Function to logout the user
function successLogout(data) {
  if (data["success"] == true) {
    window.location = "login.php";
  } else {
    alert("Logout Failed");
  }
}
//  Function to display an error message
function Bad(data) {
  alert("Bad");
}
//  Function to get the roles from the database
function getRoles() {
  AJAX(
    "GET",
    ajaxURL,
    "json",
    { action: "getRoles" },
    function (data) {
      roles = data["roles"];
    },
    Bad
  );
}

//  Function to get and display the users in the database in a table with the following columns:
//  Option (with tow buttons: Edit and delete) , UserID, Username, Role in a dropdown list
function successUserManagement(data) {
  if (data["success"] == true) {
    //  Hide div with id "RoleManagementDiv"
    $("#RoleManagementDiv").hide();
    //  Show div with id "UserManagementDiv"
    $("#UserManagementDiv").show();
    //  Clear the div with id "UserManagementDiv"
    $("#UserManagementDiv").empty();
    //  Create a Switch case to display depending on the role of the user
    switch (data["UserRole"]) {
      case "Root":
        displayRooT(data);
        break;
      case "Admin":
        displayAdmin(data);
        break;
      case "User":
        displayUser(data);
        break;
      default:
        break;
    }
  } else {
    alert("UserManagement Failed"); //  Display an error message
  }
}

function successAddUser(data) {
  if (data["success"]) {
    alert("User Added"); //  Display a success message
    UserManagement();
  } else {
    alert("Add User Failed"); //  Display an error message
  }
}

function successEditUser(data) {
  if (data["success"]) {
    alert("User Edited"); //  Display a success message
    UserManagement();
  } else {
    alert("Edit User Failed"); //  Display an error message
  }
}

function successDeleteUser(data) {
  if (data["success"]) {
    alert("User Deleted"); //  Display a success message
    UserManagement();
  } else {
    alert("Delete User Failed"); //  Display an error message
  }
}

function UserManagement() {
  AJAX(
    "GET",
    ajaxURL,
    "json",
    { action: "UserManagement" },
    successUserManagement,
    Bad
  );
}

function displayRooT(data) {
  //  Create a div for username, password, email, fname, lname, role, and  a button to add a new user
  var div = $(document.createElement("div"));
  div.attr("id", "addUserDiv");
  div.append("Username: ");
  var username = $(document.createElement("input"));
  username.attr("type", "text");
  username.attr("id", "username");
  div.append(username);
  div.append("Password: ");
  var password = $(document.createElement("input"));
  password.attr("type", "text");
  password.attr("id", "password");
  div.append(password);
  div.append("Email: ");
  var email = $(document.createElement("input"));
  email.attr("type", "text");
  email.attr("id", "email");
  div.append(email);
  div.append("First Name: ");
  var fname = $(document.createElement("input"));
  fname.attr("type", "text");
  fname.attr("id", "fname");
  div.append(fname);
  div.append("Last Name: ");
  var lname = $(document.createElement("input"));
  lname.attr("type", "text");
  lname.attr("id", "lname");
  div.append(lname);
  div.append("Role: ");
  var role = $(document.createElement("select"));
  role.attr("id", "role");
  for (var i = 0; i < roles.length; i++) {
    var option = $(document.createElement("option"));
    option.attr("value", roles[i]["RoleID"]);
    option.text(roles[i]["RoleName"]);
    role.append(option);
  }
  div.append(role);
  var addUser = $(document.createElement("button"));
  addUser.attr("id", "addUser");
  addUser.text("Add User");
  addUser.on("click", function () {
    var postData = {};
    postData["action"] = "addUser";
    postData["username"] = $("#username").val();
    postData["password"] = $("#password").val();
    postData["email"] = $("#email").val();
    postData["fname"] = $("#fname").val();
    postData["lname"] = $("#lname").val();
    postData["role"] = $("#role").val();
    AJAX("POST", ajaxURL, "json", postData, successAddUser, Bad);
  });
  div.append(addUser);
  $("#UserManagementDiv").append(div);
  //  Create a table with the following columns: Option (with tow buttons: Edit and delete) , UserID, Username, Role in a dropdown list
  var users = data["users"];
  var table = $(document.createElement("table"));
  table.attr("id", "usersTable");
  var tr = $(document.createElement("tr"));
  var th = $(document.createElement("th"));
  th.text("Option");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("UserId");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("UserName");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("Role");
  tr.append(th);
  table.append(tr);
  for (var i = 0; i < users.length; i++) {
    tr = $(document.createElement("tr"));
    var td = $(document.createElement("td"));
    var edit = $(document.createElement("button"));
    edit.attr("id", "edit" + users[i]["UserId"]);
    edit.text("Edit");
    edit.on("click", function () {
      var id = $(this).attr("id").replace("edit", "");
      var postData = {};
      postData["action"] = "editUser";
      postData["UserId"] = id;
      postData["RoleID"] = $("#role" + id).val();
      AJAX("POST", ajaxURL, "json", postData, successEditUser, Bad);
    });
    td.append(edit);
    var del = $(document.createElement("button"));
    del.attr("id", "delete" + users[i]["UserId"]);
    del.text("Delete");
    del.on("click", function () {
      var id = $(this).attr("id").replace("delete", "");
      var postData = {};
      postData["action"] = "deleteUser";
      postData["UserId"] = id;
      AJAX("POST", ajaxURL, "json", postData, successDeleteUser, Bad);
    });
    td.append(del);
    tr.append(td);
    td = $(document.createElement("td"));
    td.text(users[i]["UserId"]);
    tr.append(td);
    td = $(document.createElement("td"));
    td.text(users[i]["UserName"]);
    tr.append(td);
    td = $(document.createElement("td"));
    td.text(users[i]["Password"]);
    tr.append(td);
    td = $(document.createElement("td"));
    var role = $(document.createElement("select"));
    role.attr("id", "role" + users[i]["UserId"]);
    for (var j = 0; j < roles.length; j++) {
      var option = $(document.createElement("option"));
      option.attr("value", roles[j]["RoleID"]);
      option.text(roles[j]["RoleName"]);
      role.append(option);
    }
    role.val(users[i]["RoleId"]);
    td.append(role);
    tr.append(td);
    table.append(tr);
  }
  $("#UserManagementDiv").append(table);
}

function displayAdmin(data) {
  //  Create a div for username, password, email, fname, lname, role, and  a button to add a new user
  var div = $(document.createElement("div"));
  div.attr("id", "addUserDiv");
  div.append("Username: ");
  var username = $(document.createElement("input"));
  username.attr("type", "text");
  username.attr("id", "username");
  div.append(username);
  div.append("Password: ");
  var password = $(document.createElement("input"));
  password.attr("type", "text");
  password.attr("id", "password");
  div.append(password);
  div.append("Email: ");
  var email = $(document.createElement("input"));
  email.attr("type", "text");
  email.attr("id", "email");
  div.append(email);
  div.append("First Name: ");
  var fname = $(document.createElement("input"));
  fname.attr("type", "text");
  fname.attr("id", "fname");
  div.append(fname);
  div.append("Last Name: ");
  var lname = $(document.createElement("input"));
  lname.attr("type", "text");
  lname.attr("id", "lname");
  div.append(lname);
  div.append("Role: ");
  var role = $(document.createElement("select"));
  role.attr("id", "role");
  //  Add the roles to the dropdown list except for the Root role
  for (var i = 0; i < roles.length; i++) {
    if (roles[i]["RoleName"] != "Root") {
      var option = $(document.createElement("option"));
      option.attr("value", roles[i]["RoleID"]);
      option.text(roles[i]["RoleName"]);
      role.append(option);
    }
  }
  div.append(role);
  var addUser = $(document.createElement("button"));
  addUser.attr("id", "addUser");
  addUser.text("Add User");
  addUser.on("click", function () {
    var postData = {};
    postData["action"] = "addUser";
    postData["username"] = $("#username").val();
    postData["password"] = $("#password").val();
    postData["email"] = $("#email").val();
    postData["fname"] = $("#fname").val();
    postData["lname"] = $("#lname").val();
    postData["role"] = $("#role").val();
    AJAX("POST", ajaxURL, "json", postData, successAddUser, Bad);
  });
  div.append(addUser);
  $("#UserManagementDiv").append(div);
  //  Create a table with the following columns: Option (with tow buttons: Edit and delete) , UserID, Username, Role in a dropdown list
  var users = data["users"];
  var table = $(document.createElement("table"));
  table.attr("id", "usersTable");
  var tr = $(document.createElement("tr"));
  var th = $(document.createElement("th"));
  th.text("Option");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("UserId");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("UserName");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("Role");
  tr.append(th);
  table.append(tr);
  for (var i = 0; i < users.length; i++) {
    //  Don't display the root user
    if (users[i]["UserName"] != "root") {
      tr = $(document.createElement("tr"));
      var td = $(document.createElement("td"));
      var edit = $(document.createElement("button"));
      edit.attr("id", "edit" + users[i]["UserId"]);
      edit.text("Edit");
      edit.on("click", function () {
        var id = $(this).attr("id").replace("edit", "");
        var postData = {};
        postData["action"] = "editUser";
        postData["UserId"] = id;
        postData["RoleID"] = $("#role" + id).val();
        AJAX("POST", ajaxURL, "json", postData, successEditUser, Bad);
      });
      td.append(edit);
      var del = $(document.createElement("button"));
      del.attr("id", "delete" + users[i]["UserId"]);
      del.text("Delete");
      del.on("click", function () {
        var id = $(this).attr("id").replace("delete", "");
        var postData = {};
        postData["action"] = "deleteUser";
        postData["UserId"] = id;
        AJAX("POST", ajaxURL, "json", postData, successDeleteUser, Bad);
      });
      td.append(del);
      tr.append(td);
      td = $(document.createElement("td"));
      td.text(users[i]["UserId"]);
      tr.append(td);
      td = $(document.createElement("td"));
      td.text(users[i]["UserName"]);
      tr.append(td);
      td = $(document.createElement("td"));
      td.text(users[i]["Password"]);
      tr.append(td);
      td = $(document.createElement("td"));
      var role = $(document.createElement("select"));
      role.attr("id", "role" + users[i]["UserId"]);
      //  Add the roles to the dropdown list except for the Root role
      for (var j = 0; j < roles.length; j++) {
        if (roles[j]["RoleName"] != "Root") {
          var option = $(document.createElement("option"));
          option.attr("value", roles[j]["RoleID"]);
          option.text(roles[j]["RoleName"]);
          role.append(option);
        }
      }
      role.val(users[i]["RoleId"]);
      td.append(role);
      tr.append(td);
      table.append(tr);
    }
  }
  $("#UserManagementDiv").append(table);
}

function displayUser(data) {
  var div = $(document.createElement("div"));
  $("#UserManagementDiv").append(div);
  var users = data["users"];
  //  Create a table with the following columns: UserID, Username, Password, Role
  var table = $(document.createElement("table"));
  table.attr("id", "usersTable");
  var tr = $(document.createElement("tr"));
  var th = $(document.createElement("th"));
  th.text("UserId");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("UserName");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("Password");
  tr.append(th);
  th = $(document.createElement("th"));
  th.text("Role");
  tr.append(th);
  table.append(tr);
  for (var i = 0; i < users.length; i++) {
    tr = $(document.createElement("tr"));
    var td = $(document.createElement("td"));
    td.text(users[i]["UserId"]);
    tr.append(td);
    td = $(document.createElement("td"));
    td.text(users[i]["UserName"]);
    tr.append(td);
    td = $(document.createElement("td"));
    td.text(users[i]["Password"]);
    tr.append(td);
    td = $(document.createElement("td"));
    td.text(users[i]["RoleName"]);
    tr.append(td);
    table.append(tr);
  }
  $("#UserManagementDiv").append(table);
}
