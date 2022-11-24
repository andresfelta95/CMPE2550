<?php

    //  In this lab, we will move away from working on our user management and roles pages.
    //  Instead of using the SESSION on the server to help us manage our operations, we will explore the idea of RESTful web APIs.
    //  We will use the RESTful web API to manage our user management and roles pages.
    //  we will look at the RESTful design pattern.  REST stands for REpresentational State Transfer.
    //  It focuses on using different methods within the HTTP protocol to indicate to the server the CRUD action you would like to take:


    require_once "db.php";  // Require the database connection
    require_once "dbManage.php";   // Require the service functions

    // Check if the user wants to Register
    if (isset($_POST['action']) && $_POST['action'] == "register")
    {
        error_log($_POST['action']);
        error_log($_POST['username']);
        error_log($_POST['fname']);
        error_log($_POST['lname']);
        error_log($_POST['password']);
        //  Check to see if the user has entered all of the required information
        if (isset($_POST['username']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['password']) && isset($_POST['email']))
        {            
            //  Create the user
            CreateUser();
        }
        else
        {
            //  The user has not entered all of the required information
            $response["message"] = "Missing required information";
            echo json_encode($response);
            error_log($response["message"]);
        }
    }
    //  Cheack if the user wants to login
    else if (isset($_POST['action']) && $_POST['action'] == "login")
    {
        //  Check to see if the user has entered all of the required information
        if (isset($_POST['username']) && isset($_POST['password']))
        {
            error_log($_POST['action']);
            error_log($_POST['username']);
            error_log($_POST['password']);
            //  Login the user
            loginUser();
        }
        else
        {
            //  The user has not entered all of the required information
            $response["message"] = "Missing required information";
            echo json_encode($response);
            error_log($response["message"]);
        }
    }
    //  Check if the user wants to logout
    else if (isset($_POST['action']) && $_POST['action'] == "logout")
    {
        error_log($_POST['action']);
        //  Logout the user
        logoutUser();
    }
    //  Check if the user wants to get the roles
    else if (isset($_GET['action']) && $_GET['action'] == "getRoles")
    {
        error_log($_GET['action']);
        //  Get the roles
        getRoles();
    }
    //  Check if the user wants to get the Manage user
    else if (isset($_GET['action']) && $_GET['action'] == "UserManagement")
    {
        error_log($_GET['action']);
        //  Get the Manage user
        getUserManagement();
    }

///////////////////////////////////////////////////////////////////////////////////////
//  Functions
///////////////////////////////////////////////////////////////////////////////////////


    // Function to check if the user is logged in
    function isLoggedIn()
    {
        global $connection; // Call the global variable
        if (isset($_SESSION['username']))   // If the username is set
        {
            $username = $_SESSION['username'];  // Set the username to the session username
            $query = "SELECT * FROM Users WHERE username='$username' LIMIT 1"; // Query the database for the user
            $result = mySQLQuery($query);   // Run the query
            if (mysqli_num_rows($result) > 0)   // If the query returns a result
            {
                $user = mysqli_fetch_assoc($result); // Set the user to the result
                if ($user)  // If the user exists
                {
                    if ($user['UserName'] === $username)   // If the username matches the session username
                    {
                        return true;    // Return true
                    }
                }
            }
        }
        return false;   // Return false
    }

    // Function to log the user in
    function loginUser()
    {
        global $connection; // Call the global variable
        if (isset($_POST['username']) && isset($_POST['password']))   // If the username and password are set
        {
            $username = strip_tags($_POST['username']);    // Set the username to the POST username
            $password = strip_tags($_POST['password']);    // Set the password to the POST password
            $query = "SELECT * FROM Users WHERE username='$username' LIMIT 1"; // Query the database for the user
            $result = mySQLQuery($query);   // Run the query
            $response = array();    // Create an array for the response
            if (mysqli_num_rows($result) > 0)   // If the query returns a result
            {
                $user = mysqli_fetch_assoc($result); // Set the user to the result
                if ($user)  // If the user exists
                {
                    if ($user['UserName'] === $username)   // If the username matches the username from the form
                    {
                        if (password_verify($password, $user['Password'])) // If the password matches the password from the form
                        {
                            //  Get the users Role goinf from Roles, then to UsersRole, then to Users
                            $query = "SELECT * FROM Roles JOIN UsersRole ON Roles.RoleID = UsersRole.RoleID JOIN Users ON UsersRole.UserID = Users.UserID WHERE Users.UserName = '$username'";
                            $result = mySQLQuery($query);   // Run the query
                            $userRole = mysqli_fetch_assoc($result); // Set the userRole to the result
                            $response["success"] = true;    // Set the success to true
                            $response["message"] = "Login Successful"; // Set the response message to "Login Successful"
                            $_SESSION['username'] = $username;  // Set the session username to the username
                            $_SESSION['role'] = $userRole['RoleName']; // Set the session role to the userRole
                            echo json_encode($response);    // Encode the response and echo it
                            error_log($response["message"]);    // Log the response message
                        }
                        else
                        {
                            $response["message"] = "Incorrect Password"; // Set the response message to "Incorrect Password"
                            error_log($response["message"]);    // Log the response message
                        }
                    }
                }
            }
            else
            {
                $response["message"] = "User does not exist"; // Set the response message to "User does not exist"
                error_log($response["message"]);    // Log the response message
            }
        }
    }

    // Function to log the user out
    function logoutUser()
    {
        global $connection; // Call the global variable
        session_destroy();  // Destroy the session
        unset($_SESSION['username']);   // Unset the session username
        unset($_SESSION['role']);   // Unset the session role
        $response = array();    // Create an array for the response
        $response["success"] = true;    // Set the response success to true
        $response["message"] = "Logout Successful";   // Set the response message to "Logout Successful"
        echo json_encode($response);    // Encode the response as JSON
        header("location: login.php");  // Redirect to the login page
    }

    // Function to check if the user is an admin
    function isAdmin()
    {
        if (isset($_SESSION['role']))   // If the session role is set
        {
            if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Root") // If the session role is "Admin" or "Root"
            {
                return true;    // Return true
            }
        }
        return false;   // Return false
    }

    
?>
