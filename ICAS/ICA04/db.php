<?php
// Start the session
session_start();

// Global variables
$connection = null; // Connection to the database
$response = ""; // Response to the user

// Connect to the database
Connect();

// Get 

// if books button is clicked then display a table of books from the author id
if (isset($_GET["Action"])) {
    $action = strip_tags($_GET["Action"]);
    if ($action == "getBooks") {
        $authorId = strip_tags($_GET["Id"]);
        $response = GetBooks($authorId);
    }
}

// Function to connect to the database
function Connect()
{
    global $connection; // Call the global variable
    $connection = new mysqli("localhost", "atangari_Tester", "3158959566Andres.", "atangari_Test"); // Create a new connection
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

// Function to get the books title id, title, and price from the author id and send the response as JSON
function GetBooks($authorID)
{
    global $connection, $response;  // Call the global variables
    $query = "SELECT tl.title_id, tl.title, tl.type, tl.price FROM `titles` tl JOIN `titleauthor` ta ON tl.title_id = ta.title_id WHERE ta.au_id LIKE '$authorID%'"; // Query to get the books title id, title, and price from the author id
    $result = mySQLQuery($query);   // Call the mySQLQuery function
    $response = array();    // Create an array for the response
    if ($result)    // If the query is successful
    {
        while ($row = $result->fetch_assoc()) // While there are rows in the result
        {
            $response[] = $row; // Add the row to the response
        }
    }
    else
    {
        $response = $response;  // Set the response to the response
    }
    echo json_encode($response);    // Encode the response as JSON
}

?>