<?php
    require_once "Demo01Lib.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>CMPE2550 - Demo01 - Introduction to PHP</h1>
    </header>
    <div>
        <?php
            echo "This is sttuf I want the engien to process<br/>More Stuff";
            error_log("This is a message to the log file");
        ?>
    </div>
    <hr>
    <div>
        <?php
            $myNum = rand(2, 20);
            echo ShowCollection( MakeArray( $myNum) );            
        ?>
    </div>
</body>
</html>