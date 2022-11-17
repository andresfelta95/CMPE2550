<?php
    require_once "db.php";  // Require the database connection
    require_once "dbManage.php";   // Require the service functions
    
    
    
    //  Check if the user is logged in
    if (isLoggedIn())
    {
        //  If the user is logged in, redirect to the index page
        header("Location: index.php");
    }
    //  If user isn't logged in and is in the index page, redirect to the login page
    else if (isIndex())
    {
        header("Location: login.php");
    }    
    // Check if the user wants to Register
    if (isset($_POST['Action']) && $_POST['Action'] == "Register")
    {
        //  If the user wants to register, redirect to the userCreation page
        header("Location: userCreation.php");
    }   
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
                    if ($user['username'] === $username)   // If the username matches the session username
                    {
                        return true;    // Return true
                    }
                }
            }
        }
        return false;   // Return false
    }
    
    // Function to check if the user is in the index page
    function isIndex()
    {
        $url = $_SERVER['REQUEST_URI']; // Get the URL
        $url = explode("/", $url);  // Split the URL by "/"
        $url = $url[count($url) - 1];   // Get the last element of the URL
        if ($url == "index.php")    // If the URL is index.php
        {
            return true;    // Return true
        }
        return false;   // Return false
    }
    
    
    // // Function to create a new user
    // function createUser($username, $password, $role)
    // {
    //     global $response;   // Call the global variable
    //     $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')"; // Create the query
    //     $result = mySQLQuery($query);   // Query the database
    //     if ($result)    // If the query is successful
    //     {
    //         $response = "User created successfully";    // Set the response to "User created successfully"
    //         return true;    // Return true
    //     }
    //     else    // If the query is not successful
    //     {
    //         $response = "User creation failed"; // Set the response to "User creation failed"
    //         return false;   // Return false
    //     }
    // }