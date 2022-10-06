// Main function to run the program and call the functions
$(document).ready(function() {
});

// Funciton to set the click event to get the book information
function getBookInfo() {
    // Get the book id from the input box
    var bookId = $("#bookId").val();
    // Check if the book id is empty
    if (bookId == "") {
        // Display error message
        $("#bookInfo").html("Please enter a book id");
    } else {
        // Call the function to get the book information
        getBook(bookId);
    }
}