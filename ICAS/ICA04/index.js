// Main function to run the program and call the functions
$(document).ready(function () {
  // Call the function to create the author table
  loadAuthors();
  // check for a click in any books button 
  $("#authorsTable").on("click", "button", function () {
    // get the id of the book
    var id = $(this).attr("id");
    // call the function to load the books
    getBooks(id);
  });
  // check for a click in an edit button in the books table
  $("#books").on("click", "button", function () {
    // get the row of the button
    var row = $(this).parent().parent();
    // call the function to change the appearance of the row
    editRow(row);
  });
});


// Funtion to load the authors table at the start of the program
function loadAuthors() {
  // get the authors table
  var request = $.ajax({
    // url to get the authors table
    url: "db.php",
    // Type of request
    type: "GET",
    // data to send to the server
    data: {
      // action to get the authors table
      Action: "getAuthors",
    },
    // data type to expect
    dataType: "json",
  });
  // when the request is successful
  request.done(function (data) {
    // show the data in the console
    // console.log(data);
    // call the function to display the authors
    displayAuthors(data);
  });
  // when the request fails
  request.fail(function (jqXHR, textStatus) {
    // show the error in the console
    console.log("Request failed: " + textStatus);
  });
}

// Function to display the authors in a table with a books button
function displayAuthors(authors) {
  // get the authors table
  var authorsTable = $("#authorsTable");
  // clear the authors table
  authorsTable.empty();
  // Add the header row to the authors table as a new row
  authorsTable.append(
    "<tbody><tr><th>Author ID</th><th>Last Name</th><th>First Name</th><th>Phone</th><th>Books</th></tr>"
  );
  // loop through the data
  for (var i = 0; i < authors.length; i++) {
    // get the author
    var author = authors[i];
    // add the author to the authors table
    authorsTable.append(
      "<tr><td>" +
        author.au_id +
        "</td><td>" +
        author.au_lname +
        "</td><td>" +
        author.au_fname +
        "</td><td>" +
        author.phone +
        "</td><td><button class='books' id='" +
        author.au_id +
        "'>Books</button></td></tr>"
    );
  }
    // close the table
    authorsTable.append("</tbody>");
  // add retrieve value from the database creating a paragraph
  var p = $("<p></p>");
  // add the paragraph to the table body
  authorsTable.append(p);
  // add the text to the paragraph
  p.html("Retrieved " + authors.length + " books from the database.");
}

// Function to get the books from the server with a given id using ajax
function getBooks(id) {
  // create a new ajax request
  var request = $.ajax({
    // set the url to the server
    url: "db.php",
    // set the type to get
    type: "GET",
    // set the data to the id
    data: {
      Action: "getBooks",
      Id: id,
    },
    // set the data type to json
    dataType: "json",
  });
  // when the request is successful
  request.done(function (data) {
    // Show the data in the console
    console.log(data);
    // call the function to display the books
    displayBooks(data);
  });
  // when the request fails
  request.fail(function (jqXHR, textStatus) {
    // display an error message
    console.log("Request failed: " + textStatus);
  });
}

// Function to display the books in a table with a button to delete and edit
// The table will show the title id, title, type and price
function displayBooks(books) {
  // get the table body
  var tbody = $("#books");
  // clear the table body
  tbody.html("");
  // Add header row to the table
  tbody.append(
    "<tr><th>Title ID</th><th>Title</th><th>Type</th><th>Price</th><th>Delete</th><th>Edit</th></tr>"
  );
  // loop through the books
  for (var i = 0; i < books.length; i++) {
    // get the book
    var book = books[i];
    // create a new row
    var row = $("<tr></tr>");
    // create a new cell for the title id
    var titleIdCell = $("<td class='titleId'></td>");
    // add the title id to the cell
    titleIdCell.html(book.title_id);
    // add the cell to the row
    row.append(titleIdCell);
    // create a new cell for the title
    var titleCell = $("<td class='title'></td>");
    // add the title to the cell
    titleCell.html(book.title);
    // add the cell to the row
    row.append(titleCell);
    // create a new cell for the type
    var typeCell = $("<td class='type'></td>");
    // add the type to the cell
    typeCell.html(book.type);
    // add the cell to the row
    row.append(typeCell);
    // create a new cell for the price
    var priceCell = $("<td class='price'></td>");
    // add the price to the cell
    priceCell.html(book.price);
    // add the cell to the row
    row.append(priceCell);
    // create a new cell for the delete button
    var deleteCell = $("<td class='delete'></td>");
    // create a new button for the delete
    var deleteButton = $("<button class='delete'>Delete</button>");
    // add the delete button to the cell
    deleteCell.append(deleteButton);
    // add the cell to the row
    row.append(deleteCell);
    // create a new cell for the edit button
    var editCell = $("<td></td>");
    // create a new button for the edit
    var editButton = $("<button class='edit'>Edit</button>");
    // add the edit button to the cell
    editCell.append(editButton);
    // add the cell to the row
    row.append(editCell);
    // add the row to the table body
    tbody.append(row);
  }
  // add retrieve value from the database creating a paragraph
  var p = $("<p></p>");
  // add the paragraph to the table body
  tbody.append(p);
  // add the text to the paragraph
  p.html("Retrieved " + books.length + " books from the database.");
}

// Function to to change the appearance of the row and add the input fields
function editRow(row) {
  // get the cells from the row
  var cells = row.children();
  // Make title id cell editable
    var titleIdCell = cells.eq(0);
    // get the title id
    var titleId = titleIdCell.html();
    // create a new input field
    var titleIdInput = $("<input type='text' class='titleId' />");
    // add the title id to the input field
    titleIdInput.val(titleId);
    // add the input field to the cell
    titleIdCell.html(titleIdInput);
    // Make title cell editable
    var titleCell = cells.eq(1);
    // get the title
    var title = titleCell.html();
    // create a new input field
    var titleInput = $("<input type='text' class='title' />");
    // add the title to the input field
    titleInput.val(title);
    // add the input field to the cell
    titleCell.html(titleInput);
    // Make type cell a dropdown with the options: business, mod_cook, popular_comp, psychology and trad_cook
    // with the current type selected
    var typeCell = cells.eq(2);
    // get the type
    var type = typeCell.html();
    // create a new select field
    var typeSelect = $("<select class='type'></select>");
    // create a new option for business
    var businessOption = $("<option value='business'>business</option>");
    // create a new option for mod_cook
    var modCookOption = $("<option value='mod_cook'>mod_cook</option>");
    // create a new option for popular_comp
    var popularCompOption = $("<option value='popular_comp'>popular_comp</option>");
    // create a new option for psychology
    var psychologyOption = $("<option value='psychology'>psychology</option>");
    // create a new option for trad_cook
    var tradCookOption = $("<option value='trad_cook'>trad_cook</option>");
    // add the options to the select field
    typeSelect.append(businessOption);
    typeSelect.append(modCookOption);
    typeSelect.append(popularCompOption);
    typeSelect.append(psychologyOption);
    typeSelect.append(tradCookOption);
    // set the current type to be selected
    typeSelect.val(type);
    // add the select field to the cell
    typeCell.html(typeSelect);
    // Make price cell editable
    var priceCell = cells.eq(3);
    // get the price
    var price = priceCell.html();
    // create a new input field
    var priceInput = $("<input type='text' class='price' />");
    // add the price to the input field
    priceInput.val(price);
    // add the input field to the cell
    priceCell.html(priceInput);
    // Change delete button to a cancel button
    var deleteCell = cells.eq(4);
    // get the delete button
    var deleteButton = deleteCell.children();
    // change the text of the button
    deleteButton.html("Cancel");
    // change the class of the button
    deleteButton.removeClass("delete");
    deleteButton.addClass("cancel");
    // Change edit button to a save button
    var editCell = cells.eq(5);
    // get the edit button
    var editButton = editCell.children();
    // change the text of the button
    editButton.html("Save");
    // change the class of the button
    editButton.removeClass("edit");
    editButton.addClass("save");
}
