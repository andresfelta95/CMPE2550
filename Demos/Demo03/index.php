<?php

require_once "db.php";

function TestQuery( $data)
{
    global $connection, $response;

    $data = $connection->real_escape_string($data);

    $query = "SELECT title_id, title, price FROM `titles` WHERE title LIKE '%$data%'";

    
    $output .= "<ul>";
    if ($result = mySQLQuery($query))
    {
        while ($row = $result->fetch_assoc())
        {
            $output .= "<li>" . $row["title_id"] . " - " .$row["title"] . " - " . $row["price"] . "</li>";
        }
        $output .= "</ul>";
    }
    else
    {
        $output = $response;
    }
    return $output;
}

function TableOutput($data)
{
    global $connection, $response;

    $data = $connection->real_escape_string($data);

    $query = "SELECT title_id, title, price FROM `titles` WHERE title LIKE '%$data%'";

    $output = "<table>";
    $output .= "<tr><th>Title ID</th><th>Title</th><th>Price</th></tr>";
    if ($result = mySQLQuery($query))
    {
        while ($row = $result->fetch_assoc())
        {
            $output .= "<tr><td>" . $row["title_id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["price"] . "</td></tr>";
        }
        $output .= "</table>";
    }
    else
    {
        $output = $response;
    }
    return $output;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo03 - Databases</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div>
        <h1>Demo03 - Databases</h1>
    </div>
    <div>
        <?php echo TestQuery("User"); ?>
    </div>
    <div>
        <?php echo TableOutput("computer"); ?>
    </div>
</body>
</html>