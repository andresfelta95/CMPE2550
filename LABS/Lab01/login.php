<?php
 require_once "db.php";  // Require the database connection
 require_once "service.php";   // Require the service functions
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="lab01.js"></script>
    <title>Andres Tangarife - Lab01</title>
</head>
<body>
    <header>
        <h1>
            Login Page
        </h1>
    </header>
    <main>
        <!-- Main page where user can login or click regiter and be redirected to the userCreation page -->
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <button id="login">Login</button>
            <button id="GoRegister">Register</button>
    </main>
    <footer>
        &copy; &Lambda;&alpha;&eta;s&epsilon;&zeta;&sigma;&omega;<br/>
        <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
</body>
</html>