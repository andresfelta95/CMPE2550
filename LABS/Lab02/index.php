<?php

      

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="lab02.js"></script>
    <title>Lab02 - REST IPA</title>
</head>
<body>
    <header>
        <h1>Lab02 - Messages</h1>
    </header>
    <main>
        <div id="New Message">
            <label for="filter">
                <input type="text" id="filter" placeholder="Suply a filter">
            </label>
            <button id="Search">Search</button>
            <label for="Message">
                <input type="text" id="Message" placeholder="Enter a message to share">
            </label>
            <button id="send">Send</button>
        </div>
        <div id="Messages"></div>
    </main>
</body>
</html>