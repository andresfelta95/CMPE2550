<?php
//  This page is used to create a new user
//  The new user needs to have:
//      - A unique username
//      - A First Name
//      - A Last Name
//      - A password that is at least 8 characters long and contains at least one number and one special character
//      - A unique email
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
    <title>User Registration</title>
</head>
<body>
    <Header>
        <h1>User Registration</h1>
    </Header>
    <main>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="Fname">First Name:</label>
            <input type="text" name="Fname" id="Fname" required>
            <br>
            <label for="Lname">Last Name:</label>
            <input type="text" name="Lname" id="Lname" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br>
            <button id="register">Register</button>
        </div>
    </main> 
    <footer>
        &copy; &Lambda;&alpha;&eta;s&epsilon;&zeta;&sigma;&omega;<br/>
        <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
</body>
</html>