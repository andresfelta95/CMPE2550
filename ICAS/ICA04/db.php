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
if (isset($_GET["Action"])) 
{
    $action = strip_tags($_GET["Action"]);
    if ($action == "getBooks") {
        $authorId = strip_tags($_GET["Id"]);
        $response = GetBooks($authorId);
    }
    else if($action == "getAuthors")
    {
        $response = GetAuthors();
    }
    else if($action == "save")
    {
        // Check price is a number greater than 0 and less than 100
        if (isset($_GET["Price"]) && is_numeric($_GET["Price"]) && $_GET["Price"] > 0 && $_GET["Price"] < 100) {
            $price = strip_tags($_GET["Price"]);
        }
        else {
            $response = "Price must be a number greater than 0 and less than 100";
        }
        // Check if the book title is not empty
        if (isset($_GET["Title"]) && $_GET["Title"] != "") {
            $title = strip_tags($_GET["Title"]);
        }
        else {
            $response = "Title must not be empty";
        }
        // Check if the author id is not empty
        if (isset($_GET["Id"]) && $_GET["Id"] != "") {
            $authorId = strip_tags($_GET["Id"]);
        }
        else {
            $response = "AuthorId must not be empty";
        }
        // If there are no errors then save the book
        $bookTitleId = strip_tags($_GET["TitleId"]);
        $bookType = strip_tags($_GET["Type"]);
        $response = SaveBook($authorId, $bookTitleId, $title, $bookType, $price);
    }
    else if($action == "delete")
    {
        $bookId = strip_tags($_GET["TitleId"]);
        $response = DeleteBook($bookId);
    }
    else if($action == "add")
    {
        // Check price is a number greater than 0 and less than 100
        if (isset($_GET["Price"]) && is_numeric($_GET["Price"]) && $_GET["Price"] > 0 && $_GET["Price"] < 100) {
            $price = strip_tags($_GET["Price"]);
        }
        else {
            $response = "Price must be a number greater than 0 and less than 100";
        }
        // Check if the book title is not empty
        if (isset($_GET["Title"]) && $_GET["Title"] != "") {
            $title = strip_tags($_GET["Title"]);
        }
        else {
            $response = "Title must not be empty";
        }
        // Check if the title id is not empty
        if (isset($_GET["TitleId"]) && $_GET["TitleId"] != "") {
            $titleId = strip_tags($_GET["TitleId"]);
        }
        else {
            $response = "TitleId must not be empty";
        }
        // Check if the author array is not empty
        if (isset($_GET["Ids"]) && $_GET["Ids"] != "") {
            $authors = json_decode($_GET["Ids"]);
        }
        else {
            $response = "Authors must not be empty";
        }
        // check if the book type is not empty
        if (isset($_GET["Type"]) && $_GET["Type"] != "") {
            $bookType = strip_tags($_GET["Type"]);
        }
        else {
            $response = "Book type must not be empty";
        }
        // If there are no errors then add the book
        $response = AddBook($authors, $titleId, $title, $bookType, $price);
    }
    error_log(json_encode($_GET));
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

// Function to get the authors id, last name, first name, and phone number
function GetAuthors()
{
    global $response;   // Call the global variable
    $query = "SELECT au_id, au_lname, au_fname, phone FROM `authors`"; // Query to get the authors id, last name, first name, and phone number
    $result = mySQLQuery($query);   // Call the mySQLQuery function
    $response = array();    // Create an array for the response
    if ($result)    // If the query is successful
    {
        while ($row = $result->fetch_assoc()) // While there are rows in the result
        {
            $response[] = $row; // Add the row to the response
        }
        // Create a new query to get the distinct book types and add them to the response
        $query = "SELECT DISTINCT `type` FROM `titles`";
        $result = mySQLQuery($query);   // Call the mySQLQuery function
        if ($result)    // If the query is successful
        {
            $types = array();   // Create an array for the types
            while ($row = $result->fetch_assoc()) // While there are rows in the result
            {
                $types[] = $row["type"];    // Add the type to the types array
            }
            $response[] = $types;   // Add the types array to the response
        }
    }
    else    // If the query is not successful
    {
        $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";    // Set the response to the error
    }
    echo json_encode($response);    // Encode the response as JSON
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

// Function to save the book edited by the user
function SaveBook($authorId, $bookTitleId, $bookTitle, $bookType, $bookPrice)
{
    global $connection, $response;  // Call the global variables
    $query = "UPDATE `titles` 
            SET `title` = '$bookTitle', 
            `type` = '$bookType', 
            `price` = '$bookPrice' 
            WHERE `title_id` = '$bookTitleId'"; // Query to update the book title, type, and price
    $result = mySQLQuery($query);   // Call the mySQLQuery function
    if ($result)    // If the query is successful
    {
        $response = "Book saved successfully"; // Set the response to "Book saved successfully"
    }
    else    // If the query is not successful
    {
        $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";    // Set the response to the error
    }
    echo json_encode($response);    // Encode the response as JSON
}

// Function to delete the book from titleauthor and titles
function DeleteBook($bookId)
{
    global $connection, $response;  // Call the global variables
    $query = "DELETE FROM `titleauthor` WHERE `title_id` = '$bookId'"; // Query to delete the book from titleauthor
    $result = mySQLQuery($query);   // Call the mySQLQuery function
    if ($result)    // If the query is successful
    {
        $query = "DELETE FROM `titles` WHERE `title_id` = '$bookId'"; // Query to delete the book from titles
        $result = mySQLQuery($query);   // Call the mySQLQuery function
        if ($result)    // If the query is successful
        {
            $response = "Book deleted successfully"; // Set the response to "Book deleted successfully"
        }
        else    // If the query is not successful
        {
            $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";    // Set the response to the error
        }
    }
    else    // If the query is not successful
    {
        $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";    // Set the response to the error
    }
    echo json_encode($response);    // Encode the response as JSON
}

// Function to add a new book in titles table, and titleauthor table with the author id
function AddBook($authorId, $bookTitleId, $bookTitle, $bookType, $bookPrice)
{
    global $connection, $response;  // Call the global variables
    $query = "INSERT INTO `titles` (`title_id`, `title`, `type`, `price`) VALUES ('$bookTitleId', '$bookTitle', '$bookType', '$bookPrice')"; // Query to insert the book title, type, and price
    $result = mySQLQuery($query);   // Call the mySQLQuery function
    if ($result)    // If the query is successful
    {
        $au_ord = 0; // Get the length of the array
        $royalTyper = 100 / count($authorId);
        // Query to insert for each author id and the book title id
        foreach ($authorId as $id)
        {
            $au_ord ++; //  Set value for au_ord
            $query = "INSERT INTO `titleauthor` (`au_id`, `title_id`, `au_ord`, `royaltyper`) VALUES ('$id', '$bookTitleId', '$au_ord', '$royalTyper')"; // Query to insert the author id and the book title id
            $result = mySQLQuery($query);   // Call the mySQLQuery function
        }
        $response = "Book added successfully"; // Set the response to "Book added successfully"
    }
    else    // If the query is not successful
    {
        $response = "Query Error : (" . $connection->errno . ") : (" . $connection->error . ")";    // Set the response to the error
    }
    echo json_encode($response);    // Encode the response as JSON
}
?>