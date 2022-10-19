<?php
    require_once "db.php";  // Require the db.php file    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./index.js"></script>
    <title>Andres Tangarife - ICA04</title>
</head>
<body>
    <header>
        <h1>ICA04 - mySQL Data Manipulation</h1>
    </header>
    <main>
        <h2>Authors</h2>
        <table id="authorsTable"></table>
        <hr>
        <h2>Books</h2>
        <table id="books"></table>
        <hr>
        <div id="addBook"></div>
    </main>
    <footer>
      &copy; &Lambda;&alpha;&eta;s&epsilon;&zeta;&sigma;&omega;<br/>
      <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
</body>
</html>