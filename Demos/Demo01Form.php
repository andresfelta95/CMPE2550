<?php
    require_once "Demo01Lib.php";

    if (isset($_POST['name']) && strlen($_POST['name']) > 0
        && isset($_POST['quantity']) && strlen($_POST['quantity']) > 0) {
        $name = strip_tags($_POST['name']);
        $quantity = strip_tags($_POST['quantity']);

        $output = "";
        if(!is_numeric($quantity))
            $output = "Give a number for the quantity field";
        else {
            $start = MakeStartArray($quantity);

            $output .= $name . " wants";
            for ($i = 0; $i < count($start); $i++) {
                $output .= " " . $start[$i];
            }
        }
    }
    error_log(json_encode($_POST));
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
        <h1>CMPE2550 - Demo01 - Form Processing</h1>
    </header>
    <main>
        <form action="Demo01Form.php" method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Who are you?"/>
            </div>
            <div>
                <label for="quantity">quantity:</label>
                <input type="text" name="quantity" id="quantity" placeholder="Gimme a number!" />
            </div>            
            <div>
                <input type="submit" value="Go For It!" />
            </div>
            <div>
                <?php echo $output ?>
            </div>
        </form>
    </main>
</body>
</html>