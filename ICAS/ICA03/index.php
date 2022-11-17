<?php
    require_once "db.php";  // Require the db.php file

    // Function to get the author information and display it in a table with a button to call Getbooks function
    function GetAuthors()
    {
        global $connection, $response; // Call the global variables

        $query = "SELECT au_id, au_lname, au_fname, phone FROM `authors`"; // Query to get the author information

        $output = "<table>";    // Create a table
        $output .= "<tr><th>Author ID</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Books</th></tr>"; // Create the table headers
        if ($result = mySQLQuery($query))   // If the query is successful
        {
            while ($row = $result->fetch_assoc()) // While there are rows in the result
            {
                $output .= "<tr><td>" . $row["au_id"] . "</td><td>" . $row["au_fname"] . "</td><td>" . $row["au_lname"] . "</td><td>" . $row["phone"] . "</td><td><button id='".$row["au_id"]."' class='books'>Books</button></td></tr>"; // Add a row to the table with the author information and a button to call the GetBooks function
            }
            $output .= "</table>";  // Close the table
            // Display the amount of authors
            $output .= "<p>There are " . $result->num_rows . " authors in the database.</p>";
        }
        else
        {
            $output = $response;    // If the query is not successful, set the output to the response
        }
        return $output; // Return the output
    }
    //Function to get the book from a specific author and display it in a table
    // function GetBooks($authorID)
    // {
    //     global $connection, $response; // Call the global variables
    //     $query = "SELECT title_id, title, price FROM `titles` WHERE author_id = $authorID"; // Query to get the books from the author
    //     $output = "<table>";    // Create a table
    //     $output .= "<tr><th>Title ID</th><th>Title</th><th>Price</th></tr>"; // Create the table headers
    //     if ($result = mySQLQuery($query))   // If the query is successful
    //     {
    //         while ($row = $result->fetch_assoc()) // While there are rows in the result
    //         {
    //             $output .= "<tr><td>" . $row["title_id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["price"] . "</td></tr>"; // Add a row to the table
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./index.js"></script>
    <title>Andres Tangarife - ICA03</title>
</head>
<body>
    <header>
        <h1>ICA03 - mySQL Data Retrieval</h1>
    </header>
    <main>
        <div id="authors">
            <h2>Authors</h2>
            <?php echo GetAuthors(); ?>
        </div>
        <table id="books">
            <h2>Books</h2>
        </table>
    </main>
    <footer>
      &copy; &Lambda;&alpha;&eta;s&epsilon;&zeta;&sigma;&omega;<br/>
      <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
</body>
</html>