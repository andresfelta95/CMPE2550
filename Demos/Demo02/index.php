<?php
    session_start();

    if (isset($_POST['submit'])&&$_POST['submit']=='stop') {
        session_unset();
        session_destroy();
    }

    if (isset($_POST['submit'])&&$_POST['submit']=='start') {
        $_SESSION['playerOne'] = strip_tags($_POST['playerOne']);
        // $_SESSION['end'] = $_SESSION['start'] + $_POST['duration'];
    }

    error_log(json_encode($_POST));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <scrip src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <scrip src="index.js"></scrip>
    <title>Document</title>
</head>
<body>
    <header>
        <h1>My First PHP Page</h1>
    </header>
    <form action="index.php" method="post">
        <input type="submit" name="submit" value="Start">
        <input type="submit" name="submit" value="Stop">
    </form>
</body>
</html>