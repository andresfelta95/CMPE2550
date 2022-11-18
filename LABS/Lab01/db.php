<?php
// Start the session
session_start();

// Global variables
$connection = null; // Connection to the database
$response = ""; // Response to the user

// Connect to the database
Connect();

// Function to connect to the database
function Connect()
{
    global $connection; // Call the global variable
    $connection = new mysqli("localhost", "atangari_Tester", "3158959566Andres.", "atangari_Users"); // Create a new connection
    if (!$connection->connect_error)    // If the connection is successful
    {
        $response = "Connected to database";    // Set the response to "Connected to database"
        error_log("Connection successfully established");   // Log the response
    } 
    else    // If the connection is not successful
    {
        $response = "Connect Error (" . $connection->connect_errno . ") " . $connection->connect_error;   // Set the response to the error
        echo json_encode($response);    // Encode the response as JSON
        error_log(json_encode($response));  // Log the response
        die();  // Kill the script
    }
}

function mySQLQuery($query) // Function to query the database
{
    global $connection, $response;  // Call the global variables
    $result = false; //$connection->query($query);
    if ($connection == null)    // If the connection is not established
    {
        $response = "No database connection established";   // Set the response to "No database connection established"
        return $result; // Return the result
    }

    if (!($result = $connection->query($query)))    // If the query is not successful
    {
        $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";    // Set the response to the error
    }

    return $result; // Return the result
}

?>