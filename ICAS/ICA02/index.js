$(document).ready(function() {
    buildBoard();  
    $(".Board td").click(clickCell);
});

// Create the board and add it to the page when the names are submitted
function buildBoard(){

    var board = $(".Board");
    for (var i = 0; i < 8; i++){
        var row = $("<tr></tr>");
        for (var j = 0; j < 8; j++){
            var cell = $("<td class='" + i +','+ j + "'></td>");
            row.append(cell);
        }
        board.append(row);
    }
   
    var postData = {};
    postData['action'] = "NewGame";
    Gameplay("gameplay.php", "POST", postData, "json", Success, errorMessage);

}

function clickCell(){
    var row = $(this).parent().index();
    var col = $(this).index(); 
    var cell = $(this);
    console.log("Row: " + row + " Col: " + col);   
    var postData = {};
    postData['action'] = "placePiece";
    postData['row'] = row;
    postData['col'] = col;    
    Gameplay("gameplay.php", "POST", postData, "json", Success, errorMessage);
};

function Success(returnData){
    console.log(returnData);
    
    if(returnData['gameOver']){
        if(returnData['winner'] == 1){
            $(".turn").text(returnData['playerOne'] + " Wins!");
            alert(returnData['playerOne'] + " Wins!");
        }
        else if(returnData['winner'] == 2){
            $(".turn").text(returnData['playerTwo'] + " Wins!");
            alert(returnData['playerTwo'] + " Wins!");
        }
        else if(returnData['winner'] == 0){
            $(".turn").text("Tie Game!");
            alert("Tie Game!");
        }
    }
    else if(returnData['turn'] == 1){
        $(".turn").text(returnData['playerOne'] + "'s Turn" + "🔴");
    }
    else if(returnData['turn'] == 2){
        $(".turn").text(returnData['playerTwo'] + "'s Turn" + "🔵");
    }
    for(var i = 0; i < returnData['board'].length; i++){
        for(var j = 0; j < returnData['board'][i].length; j++){                    
            if(returnData['board'][i][j] == 1){
                $(".Board tr:eq(" + i + ") td:eq(" + j + ")").css("background-color", "red");                
            }
            else if(returnData['board'][i][j] == 2){ 
                $(".Board tr:eq(" + i + ") td:eq(" + j + ")").css("background-color", "blue");                              
            }
            else{
                $(".Board tr:eq(" + i + ") td:eq(" + j + ")").css("background-color", "white");
            }
        }
    }
}

function errorMessage (request, status, errorMessage){
    console.log(errorMessage);
}

function Gameplay (url, method, data, dataType, success, error){
    var options = {};
    options['url'] = url;
    options['method'] = method;
    options['data'] = data;
    options['dataType'] = dataType;
    options['success'] = success;
    options['error'] = error;

    $.ajax(options);
}