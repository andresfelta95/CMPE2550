<?php

// Global variables
$connection = null;
$response = "";

Connect();
// Function to connect to the database
function Connect()
{
    global $connection;
    $connection = new mysqli("localhost", "atangari_Tester", "3158959566Andres.", "atangari_Test");
    if (!$connection->connect_error) 
    {
        $response = "Connected to database";
        error_log("Connection successfully established");
    } 
    else 
    {
        $response = "Connect Error (" . $connection->connect_errno . ") " . $connection->connect_error;
        echo json_encode($response);
        error_log(json_encode($response));
        die();
    }
}

function mySQLQuery($query)
{
    global $connection, $response;
    $result = false; //$connection->query($query);
    if ($connection == null)
    {
        $response = "No database connection established";
        return $result;
    }

    if (!($result = $connection->query($query)))
    {
        $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";
    }

    return $result;
}

?>