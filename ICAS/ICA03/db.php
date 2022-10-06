<?php
// Start the session
session_start();

// Global variables
$connection = null; // Connection to the database
$response = ""; // Response to the user

// Connect to the database
Connect();

// if books button is clicked then display a table of books from the author id
if (isset($_POST["books"]))
{
    $authorID = $_POST["books"];    // Get the author id
    echo GetBooks($authorID);   // Call the GetBooks function and echo the output
}
else
{
    echo GetAuthors();  // Call the GetAuthors function and echo the output
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

// Function to get the books from the author and display them in a table with a button to edit or delete them
// function getBooks($authorID)
// {
//     global $connection, $response;  // Call the global variables
//     $query = "SELECT title_id, title, price FROM `titles` WHERE author_id = $authorID"; // Query to get the books from the author
//     $output = "<table>";    // Create a table
//     $output .= "<tr><th>Title ID</th><th>Title</th><th>Price</th><th>Edit</th><th>Delete</th></tr>"; // Create the table headers
//     if ($result = mySQLQuery($query))   // If the query is successful
//     {
//         while ($row = $result->fetch_assoc()) // While there are rows in the result
//         {
//             $output .= "<tr><td>" . $row["title_id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["price"] . "</td><td><button id=$row[title_id] class='edit'>Edit</button></td><td><button id=$row[title_id] class='delete'>Delete</button></td></tr>"; // Add a row to the table with the book information and buttons to edit or delete the book
//         }
//         $output .= "</table>";  // Close the table
//     }
//     else
//     {
//         $output = $response;    // Set the output to the response
//     }
//     return $output; // Return the output
// }

?>