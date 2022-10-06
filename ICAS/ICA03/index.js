// Main function to run the program and call the functions
$(document).ready(function() {
    // check for a click in any books button
    $(".books").click(function() {
        // get the id of the button clicked
        var id = $(this).attr("id");
        // call the function to get the books
        getBooks(id);
    });
});

// Function to get the books from the server with a given id using ajax
function getBooks(id) {
    // create a new ajax request
    var request = $.ajax({
        // set the url to the server
        url: "http://localhost:8080/books/" + id,
        // set the type to get
        type: "GET",
        // set the data type to json
        dataType: "json"
    });
    // when the request is successful
    request.done(function(data) {
        // call the function to display the books
        displayBooks(data);
    });
    // when the request fails
    request.fail(function(jqXHR, textStatus) {
        // display an error message
        alert("Request failed: " + textStatus);
    });
}

// Function to display the books in a table with a button to delete and edit
// The table will show the title id, title, type and price
function displayBooks(books) {
    // get the table body
    var tbody = $("#books");
    // clear the table body
    tbody.html("");
    // loop through the books
    for (var i = 0; i < books.length; i++) {
        // get the book
        var book = books[i];
        // create a new row
        var row = $("<tr></tr>");
        // create a new cell for the title id
        var titleIdCell = $("<td></td>");
        // add the title id to the cell
        titleIdCell.html(book.titleId);
        // add the cell to the row
        row.append(titleIdCell);
        // create a new cell for the title
        var titleCell = $("<td></td>");
        // add the title to the cell
        titleCell.html(book.title);
        // add the cell to the row
        row.append(titleCell);
        // create a new cell for the type
        var typeCell = $("<td></td>");
        // add the type to the cell
        typeCell.html(book.type);
        // add the cell to the row
        row.append(typeCell);
        // create a new cell for the price
        var priceCell = $("<td></td>");
        // add the price to the cell
        priceCell.html(book.price);
        // add the cell to the row
        row.append(priceCell);
        // create a new cell for the delete button
        var deleteCell = $("<td></td>");
        // create a new button for the delete
        var deleteButton = $("<button>Delete</button>");
        // add the delete button to the cell
        deleteCell.append(deleteButton);
        // add the cell to the row
        row.append(deleteCell);
        // create a new cell for the edit button
        var editCell = $("<td></td>");
        // create a new button for the edit
        var editButton = $("<button>Edit</button>");
        // add the edit button to the cell
        editCell.append(editButton);
        // add the cell to the row
        row.append(editCell);
        // add the row to the table body
        tbody.append(row);
    }
}