<?php
    //  This page is used to Manage the database

    function CreateUser()
    {
        //  This function creates a user in the database
        //  The user needs to have:
        //      - A unique username
        //      - A First Name
        //      - A Last Name
        //      - A password that is at least 8 characters long and contains at least one number and one special character
        //      - A unique email
        //   When the password is stored in the database, it is encrypted using the password_hash() function

        //  Get the user information from the form
        $username = strip_tags($_POST['username']);
        $Fname = strip_tags($_POST['fname']);
        $Lname = strip_tags($_POST['lname']);
        $password = strip_tags($_POST['password']);
        $email = strip_tags($_POST['email']);

        $response = array();    //  Create an array to hold the response

        //  Check to see if the username is unique
        $sql = "SELECT * FROM Users WHERE UserName = '$username'";
        $result = mySQLQuery($sql);
        if (mysqli_num_rows($result) > 0)
        {
            //  The username is not unique
            $response["message"] = "Username is not unique";
            echo json_encode($response);
            error_log($response["message"]);
            return;
        }

        //  Check to see if the email is unique
        $sql = "SELECT * FROM Users WHERE Email = '$email'";
        $result = mySQLQuery($sql);
        if (mysqli_num_rows($result) > 0)
        {
            //  The email is not unique
            $response["message"] = "Email is not unique";
            echo json_encode($response);
            error_log($response["message"]);
            return;
        }

        //  Check to see if the password is at least 8 characters long and contains at least one number and one special character
        if (strlen($password) < 8)
        {
            //  The password is not at least 8 characters long
            $response["message"] = "Password is not at least 8 characters long";
            echo json_encode($response);

            return;
        }
        if (!preg_match("#[0-9]+#", $password))
        {
            //  The password does not contain at least one number
            $response["message"] = "Password does not contain at least one number";
            echo json_encode($response);
            error_log($response["message"]);
            return;
        }
        if (!preg_match("#[a-zA-Z]+#", $password))
        {
            //  The password does not contain at least one letter
            $response["message"] = "Password does not contain at least one letter";
            echo json_encode($response);
            error_log($response["message"]);
            return;
        }
        if (!preg_match("#\W+#", $password))
        {
            //  The password does not contain at least one special character
            $response["message"] = "Password does not contain at least one special character";
            echo json_encode($response);
            error_log($response["message"]);
            return;
        }

        //  The password is valid, so encrypt it
        $password = password_hash($password, PASSWORD_DEFAULT);
        error_log($password);
        //  Create the user in the table Users and set the user's role to "User" in the table UserRoles
        $sql = "INSERT INTO Users (UserName, Fname, Lname, Password, Email) VALUES ('$username', '$Fname', '$Lname', '$password', '$email')";
        $result = mySQLQuery($sql);
        //  Get the UserID of the user that was just created
        $sql = "SELECT UserID FROM Users WHERE UserName = '$username'";
        $result = mySQLQuery($sql);
        $row = mysqli_fetch_assoc($result);
        $userID = $row["UserID"];
        //  Set the user's role to "User" in the table UserRoles
        $sql = "INSERT INTO UsersRole (UserID, UserName, RoleId) VALUES ('$userID', '$username', 3)";
        $result = mySQLQuery($sql);
        if ($result)
        {
            //  The user was created successfully
            $response["message"] = "User created successfully";
            $response["success"] = true;
            echo json_encode($response);
            error_log($response["success"]);
        }
        else
        {
            //  The user was not created successfully
            $response["message"] = "User was not created successfully";
            echo json_encode($response);
            error_log($response["message"]);
        }
    }

    // Function to get the Exisiting Roles
    function getRoles()
    {
        global $connection; // Call the global variable
        $query = "SELECT RoleId, RoleName FROM Roles"; // Query to get the Roles
        $result = mySQLQuery($query);   // Run the query
        $roles = array();   // Create an array for the roles
        $response = array();    // Create an array for the response
        while ($row = mysqli_fetch_assoc($result)) // While there are rows in the result
        {
            $roles[] = $row;    // Add the row to the roles array
        }
        $response["success"] = true;    // Set the response success to true
        $response["roles"] = $roles;    // Set the response roles to the roles array
        echo json_encode($response);    // Encode the response as JSON
        error_log($response["success"]);    // Log the response success
    }

    // Function to get the Manage user
    function getUserManagement()
    {
        global $connection; // Call the global variable
        $query = "SELECT Users.UserId, Users.UserName, Users.Password, Roles.RoleName FROM Users JOIN UsersRole ON Users.UserID = UsersRole.UserID JOIN Roles ON UsersRole.RoleID = Roles.RoleID"; // Query the database for the users
        $result = mySQLQuery($query);   // Run the query
        $users = array();   // Create an array for the users
        $response = array();    // Create an array for the response
        while ($row = mysqli_fetch_assoc($result)) // While there are rows in the result
        {
            $users[] = $row;    // Add the row to the users array
        }
        $response["success"] = true;    // Set the response success to true
        $response["users"] = $users;    // Set the response users to the users array
        $response["UserRole"] = $_SESSION["role"];    // Set the response user role to the user role in the session
        echo json_encode($response);    // Encode the response as JSON
        error_log(json_encode($response));    // Log the response success
    }
?>