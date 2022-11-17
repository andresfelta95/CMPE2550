// Global Variables
var idVal = 0; // the id of the author to get the books for
var authorsArray = []; // array to hold the authors
var typesArray = []; //  Array to hold the type options
// Main function to run the program and call the functions
$(document).ready(function () {
  // Call the function to create the author table
  loadAuthors();
  // check for a click in any books button
  $("#authorsTable").on("click", "button", function () {
    // get the id of the book
    idVal = $(this).attr("id");
    // call the function to load the books
    getBooks(idVal);
  });
});

// Function to create a form to add a new book
function addBookForm() {
  // create the form
  var form = $("<form>");
  // create the label for the title_id
  var label = $("<label>").text("Title ID: ");
  // create the input for the title_id
  var input = $("<input>").attr("type", "text").attr("id", "title_id");
  // create the label for the title
  var label2 = $("<label>").text("Title: ");
  // create the input for the title
  var input2 = $("<input>").attr("type", "text").attr("id", "title");
  // create the label for the type
  var label3 = $("<label>").text("Type: ");
  // create a select for the type
  var select = $("<select>").attr("id", "type");
  // create the options for the select from the types array
  for (var i = 0; i < typesArray[0].length; i++) {
    var option = $(document.createElement("option"))
      .attr("value", typesArray[0][i])
      .text(typesArray[0][i]);
    select.append(option);
  }
  // create the label for the price
  var label4 = $("<label>").text("Price: ");
  // create the input for the price
  var input3 = $("<input>").attr("type", "text").attr("id", "price");
  // create the label for the author
  var label5 = $("<label>").text("Author: ");
  // create a select for the author allowing the user to select multiple authors
  var select2 = $("<select>").attr("id", "author").attr("multiple", "multiple");
  // loop through the authors array
  for (var i = 0; i < authorsArray.length; i++) {
    // create an option for each author
    var option = $(document.createElement("option"));
    // set the value of the option to the author id
    option.attr("value", authorsArray[i].au_id);
    // set the text of the option to the author name
    option.text(authorsArray[i].au_lname + ", " + authorsArray[i].au_fname);
    // append the option to the select
    select2.append(option);
  }
  // create submit button called 'Add Book' with no refresh
  var button = $(document.createElement("button")).attr("type", "button");
  // set the text of the button
  button.text("Add Book");
  // add an event listener to the button
  button.on("click", function () {
    // call the function to add the book
    addBook();
  });
  // append the label, input, label, input, label, select, label, input, label, select, and button to the form
  form.append(
    label,
    input,
    label2,
    input2,
    label3,
    select,
    label4,
    input3,
    label5,
    select2,
    button
  );
  // append the form to the div with the id 'addBook'
  $("#addBook").append(form);
}

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
    console.log(data);
  });
  // when the request fails
  request.fail(function (jqXHR, textStatus) {
    // show the error in the console
    console.log("Request failed: " + textStatus);
  });
}

// Function to display the authors in a table with a books button
function displayAuthors(authors) {
  // Get the last array element and add it to the types array
  typesArray.push(authors[authors.length - 1]);
  // get the authors table
  var authorsTable = $("#authorsTable");
  // clear the authors table
  authorsTable.empty();
  // Add the header row to the authors table as a new row
  authorsTable.append(
    "<tbody><tr><th>Author ID</th><th>Last Name</th><th>First Name</th><th>Phone</th><th>Books</th></tr>"
  );
  // loop through the data
  for (var i = 0; i < authors.length - 1; i++) {
    // get the author
    var author = authors[i];
    // add the author to the authors array
    authorsArray.push(author);
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
  p.html("Retrieved " + (authors.length - 1) + " authors from the database.");
  // call function to create the form to add a new book
  addBookForm();
}

// Function to get the books from the server with a given id using ajax
function getBooks(id) {
  // Enable the edit and delete buttons
  $("#edit").prop("disabled", false);
  $("#delete").prop("disabled", false);
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
    var deleteButton = $(document.createElement("button"));
    // add the text to the button
    deleteButton.html("Delete");
    // class the button delete
    deleteButton.addClass("delete");
    // add click event to the button
    deleteButton.on("click", function () {
      // get the row of the button
      var row = $(this).closest("tr");
      // call the function to delete the book
      deleteRow(row);
    });
    // add the delete button to the cell
    deleteCell.append(deleteButton);
    // add the cell to the row
    row.append(deleteCell);
    // create a new cell for the edit button
    var editCell = $("<td class='edit'></td>");
    // create a new button for the edit
    var editButton = $(document.createElement("button"));
    // add text to the edit button
    editButton.html("Edit");
    // add id to the edit button
    editButton.attr("id", "edit");
    // add click event to the edit button
    editButton.on("click", function () {
      // get the row of the button
      var row = $(this).closest("tr");
      // call the function to edit the book
      editRow(row);
    });
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
  // disable all the edit buttons
  $("#books button").prop("disabled", true);
  // disable the delete button
  $("#delete").prop("disabled", true);
  // get the cells from the row
  var cells = row.children();
  // Make title cell editable
  var titleCell = cells.eq(1);
  // get the title
  var title = titleCell.html();
  // Clear the cell
  titleCell.html("");
  // create a new input field
  var titleInput = $(document.createElement("input"));
  // add name to the input field
  titleInput.attr("name", "title");
  // add the title to the input field
  titleInput.val(title);
  // add id to the input field
  titleInput.attr("id", "title");
  // add the input field to the cell
  titleCell.append(titleInput);
  // Make type cell a dropdown with the options: business, mod_cook, popular_comp, psychology and trad_cook
  // with the current type selected
  var typeCell = cells.eq(2);
  // get the type
  var type = typeCell.html();
  // Clear the cell
  typeCell.html("");
  // create a new select field
  var typeSelect = $(document.createElement("select"));
  // add name to the select field
  typeSelect.attr("name", "type");
  // add id to the select field
  typeSelect.attr("id", "type");
  // create a new option for business
  var businessOption = $(document.createElement("option"));
  // add the text to the option
  businessOption.html("business");
  // add the option to the select field
  typeSelect.append(businessOption);
  // create a new option for mod_cook
  var modCookOption = $(document.createElement("option"));
  // add the text to the option
  modCookOption.html("mod_cook");
  // add the option to the select field
  typeSelect.append(modCookOption);
  // create a new option for popular_comp
  var popularCompOption = $(document.createElement("option"));
  // add the text to the option
  popularCompOption.html("popular_comp");
  // add the option to the select field
  typeSelect.append(popularCompOption);
  // create a new option for psychology
  var psychologyOption = $(document.createElement("option"));
  // add the text to the option
  psychologyOption.html("psychology");
  // add the option to the select field
  typeSelect.append(psychologyOption);
  // create a new option for trad_cook
  var tradCookOption = $(document.createElement("option"));
  // add the text to the option
  tradCookOption.html("trad_cook");
  // add the option to the select field
  typeSelect.append(tradCookOption);
  // set the value of the select field to the type
  typeSelect.val(type);
  // add the select field to the cell
  typeCell.append(typeSelect);
  // Make price cell editable
  var priceCell = cells.eq(3);
  // get the price
  var price = priceCell.html();
  // Clear the cell
  priceCell.html("");
  // create a new input field
  var priceInput = $(document.createElement("input"));
  // set the type of the input field to be text
  priceInput.attr("type", "text");
  // add name to the input field
  priceInput.attr("name", "price");
  // add the id to the input field
  priceInput.attr("id", "price");
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
  // remove the click event from the button
  deleteButton.off("click");
  // enable the cancel button
  deleteButton.prop("disabled", false);
  // add click event to the button
  deleteButton.on("click", function () {
    // call the getBooks function
    getBooks(idVal);
  });
  // Change edit button to a save button
  var editCell = cells.eq(5);
  // get the edit button
  var editButton = editCell.children();
  // change the text of the button
  editButton.html("Save");
  // change the class of the button
  editButton.removeClass("edit");
  editButton.addClass("save");
  // remove the click event from the edit button
  editButton.off("click");
  // enable the save button
  editButton.prop("disabled", false);
  // add click event to the save button
  editButton.on("click", function () {
    // get the row of the button
    var row = $(this).closest("tr");
    // call the function to save the book
    saveRow(row);
  });
}

// Function to save the new values of the book in the database and update the table with an ajax call
function saveRow(row) {
  // enable all the edit buttons
  $("#edit button").prop("disabled", false);
  // create ajax call to save the book
  var request = $.ajax({
    url: "db.php", // the url to the php file
    type: "GET", // the type of request
    data: {
      // the data to send
      Action: "save", // the action to perform
      TitleId: row.find(".titleId").html(), // the id of the book
      Title: row.find("#title").val(), // the new title of the book
      Type: row.find("#type").val(), // the type
      Price: row.find("#price").val(), // the price
      Id: idVal, // the id of the author
    },
  });
  // when the ajax call is complete
  request.done(function (response) {
    // show the response in the console
    console.log(response);
    // call the function to set the table with the new values
    getBooks(idVal);
  });
  // when the ajax call fails
  request.fail(function (jqXHR, textStatus) {
    // show the error in the console
    console.log("Request failed: " + textStatus);
  });
}

// Function to delete the book from the database and update the table with an ajax call
function deleteRow(row) {
  // create ajax call to delete the book
  var request = $.ajax({
    url: "db.php", // the url to the php file
    type: "GET", // the type of request
    data: {
      // the data to send
      Action: "delete", // the action to perform
      TitleId: row.find(".titleId").html(), // the id of the book
    },
  });
  // when the ajax call is complete
  request.done(function (response) {
    // show the response in the console
    console.log(response);
    // call the function to set the table with the new values
    getBooks(idVal);
  });
  // when the ajax call fails
  request.fail(function (jqXHR, textStatus) {
    // show the error in the console
    console.log("Request failed: " + textStatus);
  });
}

// Function to add a new book to the database and update the table with an ajax call
function addBook() {
  var authorsArray = $("#author").val(); // get the selected authors
  // Encode the array to a string
  var authors = JSON.stringify(authorsArray);
  // create ajax call to add the book
  var request = $.ajax({
    url: "db.php", // the url to the php file
    type: "GET", // the type of request
    data: {
      // the data to send
      Action: "add", // the action to perform
      TitleId: $("#title_id").val(), // the id of the book
      Title: $("#title").val(), // the title of the book
      Type: $("#type").val(), // the type
      Price: $("#price").val(), // the price
      Ids: authors, // the ids of the authors
    },
  });
  // when the ajax call is complete
  request.done(function (response) {
    // show the response in the console
    console.log(response);
    // Reset the form
    $("#title_id").val("");
    $("#title").val("");
    $("#type").val("");
    $("#price").val("");
    $("#author").val("");
    // Set placeholder for each input field
    $("#title_id").attr("placeholder", "Suply the Book's ID");
    $("#title").attr("placeholder", "Suply the Book's Title");
    $("#type").attr("placeholder", "Choose a Book Genre");
    $("#price").attr("placeholder", "Suply the Book's Cost");
    $("#author").attr("placeholder", "Choose the Book's Author(s)");
    // call the function to set the table with the new values if there is a selected author
    if (idVal != 0) {
      getBooks(idVal);
    }
    // Add the response into the div with id Addresponse
    $("#Addresponse").html(response);
  });
  // when the ajax call fails
  request.fail(function (jqXHR, textStatus) {
    // show the error in the console
    console.log("Request failed: " + textStatus);
    // Add the error into the div with id Addresponse
    $("#Addresponse").html("Request failed: " + textStatus);
  });
}
