<?php
    /* 
    * CMPE 2550 Lab 1
    * Authentication/Authorization
    * Andres Tangarife
    * November, 2022
    * Description: In this lab, you will reinforce and expand your skills with PHP and mySQL database operations.
                    Additionally, you will explore the handling of credentials for authentication of users and
                    authorization of authenticated users for specific resources based on system roles.
    */
    require_once "db.php";  // Require the database connection
    require_once "service.php"; // Require the service functions

    //  Start the session to allow service.php to check if the user is logged in
    session_start();

    // if the user isn't logged in, redirect to the login page
    if (!isLoggedIn())
    {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="lab01.js"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <h1>
            <?php
                echo "Hello World";
            ?>
        </h1>
    </header>
    <main>

    </main>
</body>
</html>