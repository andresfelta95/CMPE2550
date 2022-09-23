<?php
    session_start();

    error_log(json_encode($_POST));

    if (isset($_POST['action'])){
        $action = strip_tags($_POST['action']);
        if($action == "placePiece"){            
            PlacePiece();
        }
        else if($action == "NewGame"){
            $gameData = json_decode($_SESSION['gameData'], true);
            $gameData['gameOver'] = false;
            $gameData['winner'] = 0;
            $_SESSION['gameData'] = json_encode($gameData);
        }
    }

    // main function to place a piece
    function PlacePiece(){
        $gameData = json_decode($_SESSION['gameData']);
        $row = strip_tags($_POST['row']);
        $col = strip_tags($_POST['col']);
        $board = $gameData->board;
        $gameData->validMoves = GetValidMoves($gameData->board, $gameData->turn);           // get valid moves for the current player
        if($gameData->board[$row][$col] == 0 && $gameData->validMoves[$row][$col] == 1){    // if the square is empty and a valid move
            $gameData->board[$row][$col] = $gameData->turn;                                 // place the piece
            $gameData->board = FillInPieces($gameData->board, $row, $col, $gameData->turn); // fill in pieces
            $gameData->turn = ($gameData->turn == 1) ? 2 : 1;
            $gameData->gameOver = IsGameOver($gameData->board);
            $gameData->playerOneScore = GetScore($gameData->board, 1);                      // get player 1 score
            $gameData->playerTwoScore = GetScore($gameData->board, 2);                      // get player 2 score
            if($gameData->gameOver){
                $gameData->winner = GetWinner($gameData->board);
                if($gameData->winner == 1){
                    $gameData->formTitle = $gameData->playerOne . " wins!";
                }
                else if($gameData->winner == 2){
                    $gameData->formTitle = $gameData->playerTwo . " wins!";
                }
                else{
                    $gameData->formTitle = "It's a tie!";
                }
            }
        }
        else {
            $gameData->gameOver = IsGameOver($gameData->board);
            $gameData->PlayerOneScore = GetScore($gameData->board, 1);                      // get player 1 score
            $gameData->PlayerTwoScore = GetScore($gameData->board, 2);                      // get player 2 score
            if($gameData->gameOver){
                $gameData->winner = GetWinner($gameData->board);
                if($gameData->winner == 1){
                    $gameData->formTitle = $gameData->playerOne . " wins!";
                }
                else if($gameData->winner == 2){
                    $gameData->formTitle = $gameData->playerTwo . " wins!";
                }
                else{
                    $gameData->formTitle = "It's a tie!";
                }
            }
        }
        $_SESSION['gameData'] = json_encode($gameData);
    }

    // if the new pice is placed in a valid spot, check to fill in any pieces that need to be flipped
    function FillInPieces($board, $row, $col, $turn){
        $board[$row][$col] = $turn;
        $board = CheckUp($board, $row, $col, $turn);
        $board = CheckDown($board, $row, $col, $turn);
        $board = CheckLeft($board, $row, $col, $turn);
        $board = CheckRight($board, $row, $col, $turn);
        $board = CheckUpLeft($board, $row, $col, $turn);
        $board = CheckUpRight($board, $row, $col, $turn);
        $board = CheckDownLeft($board, $row, $col, $turn);
        $board = CheckDownRight($board, $row, $col, $turn);
        return $board;
    }

    // check up for pieces to flip
    function CheckUp($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $row--;
        while($row >= 0 && $board[$row][$col] == $opponent){
            $row--;
        }
        if($row >= 0 && $board[$row][$col] == $turn){
            $row++;
            while($row < 8 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $row++;
            }
        }
        return $board;
    }

    //check down for pieces to flip
    function CheckDown($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $row++;
        while($row < 8 && $board[$row][$col] == $opponent){
            $row++;
        }
        if($row < 8 && $board[$row][$col] == $turn){
            $row--;
            while($row >= 0 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $row--;
            }
        }
        return $board;
    }

    // check left to see if any pieces need to be flipped
    function CheckLeft($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $col--;
        while($col >= 0 && $board[$row][$col] == $opponent){
            $col--;
        }
        if($col >= 0 && $board[$row][$col] == $turn){
            $col++;
            while($col < 8 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $col++;
            }
        }
        return $board;
    }

    // Check to see if there are any pieces to the right that need to be flipped
    function CheckRight($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $col++;
        while($col < 8 && $board[$row][$col] == $opponent){
            $col++;
        }
        if($col < 8 && $board[$row][$col] == $turn){
            $col--;
            while($col >= 0 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $col--;
            }
        }
        return $board;
    }

    // check up and left for pieces to flip
    function CheckUpLeft($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $row--;
        $col--;
        while($row >= 0 && $col >= 0 && $board[$row][$col] == $opponent){
            $row--;
            $col--;
        }
        if($row >= 0 && $col >= 0 && $board[$row][$col] == $turn){
            $row++;
            $col++;
            while($row < 8 && $col < 8 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $row++;
                $col++;
            }
        }
        return $board;
    }

    // check up and to the right for pieces to flip
    function CheckUpRight($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $row--;
        $col++;
        while($row >= 0 && $col < 8 && $board[$row][$col] == $opponent){
            $row--;
            $col++;
        }
        if($row >= 0 && $col < 8 && $board[$row][$col] == $turn){
            $row++;
            $col--;
            while($row < 8 && $col >= 0 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $row++;
                $col--;
            }
        }
        return $board;
    }

    // Check down left for any pieces that need to be flipped
    function CheckDownLeft($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $row++;
        $col--;
        while($row < 8 && $col >= 0 && $board[$row][$col] == $opponent){
            $row++;
            $col--;
        }
        if($row < 8 && $col >= 0 && $board[$row][$col] == $turn){
            $row--;
            $col++;
            while($row >= 0 && $col < 8 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $row--;
                $col++;
            }
        }
        return $board;
    }

    // Check Down Right for any pices that need to be flipped
    function CheckDownRight($board, $row, $col, $turn){
        $opponent = ($turn == 1) ? 2 : 1;
        $row++;
        $col++;
        while($row < 8 && $col < 8 && $board[$row][$col] == $opponent){
            $row++;
            $col++;
        }
        if($row < 8 && $col < 8 && $board[$row][$col] == $turn){
            $row--;
            $col--;
            while($row >= 0 && $col >= 0 && $board[$row][$col] == $opponent){
                $board[$row][$col] = $turn;
                $row--;
                $col--;
            }
        }
        return $board;
    }

    //Get the valid moves for the current player    
    function GetValidMoves($board, $turn){
        $validMoves = array(
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0)
        );
        for($row = 0; $row < 8; $row++){
            for($col = 0; $col < 8; $col++){
                if($board[$row][$col] == 0){
                    if(CheckDirection($board, $row, $col, $turn, 0, 1) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, 0, -1) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, 1, 0) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, -1, 0) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, 1, 1) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, -1, -1) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, 1, -1) == true){
                        $validMoves[$row][$col] = 1;
                    }
                    if(CheckDirection($board, $row, $col, $turn, -1, 1) == true){
                        $validMoves[$row][$col] = 1;
                    }
                }
            }
        }
        return $validMoves;
    }

    //Check if a move is valid in a given direction
    function CheckDirection($board, $row, $col, $turn, $rowDir, $colDir){
        $row += $rowDir;
        $col += $colDir;
        if($row < 0 || $row > 7 || $col < 0 || $col > 7){
            return false;
        }
        if($board[$row][$col] == 0){
            return false;
        }
        if($board[$row][$col] == $turn){
            return false;
        }
        while($row >= 0 && $row <= 7 && $col >= 0 && $col <= 7){
            if($board[$row][$col] == 0){
                return false;
            }
            if($board[$row][$col] == $turn){
                return true;
            }
            $row += $rowDir;
            $col += $colDir;
        }
        return false;
    }

    //Check if the game is over
    function IsGameOver($board){
        $validMoves = GetValidMoves($board, 1);
        $validMoves2 = GetValidMoves($board, 2);
        for($row = 0; $row < 8; $row++){
            for($col = 0; $col < 8; $col++){
                if($validMoves[$row][$col] == 1 || $validMoves2[$row][$col] == 1){
                    return false;
                }
            }
        }
        return true;
    }

    //Check score and return winner
    function GetWinner($board){//0 = tie, 1 = player 1, 2 = player 2
        $playerOneScore = 0;
        $playerTwoScore = 0;
        for($row = 0; $row < 8; $row++){
            for($col = 0; $col < 8; $col++){
                if($board[$row][$col] == 1){
                    $playerOneScore++;
                }
                else if($board[$row][$col] == 2){
                    $playerTwoScore++;
                }
            }
        }
        if($playerOneScore > $playerTwoScore){
            return 1;
        }
        else if($playerTwoScore > $playerOneScore){
            return 2;
        }
        else{
            return 0;
        }
    }

    //Get the score of players
    function GetScore($board, $turn){
        $playerOneScore = 0;
        $playerTwoScore = 0;
        for($row = 0; $row < 8; $row++){
            for($col = 0; $col < 8; $col++){
                if($board[$row][$col] == 1){
                    $playerOneScore++;
                }
                else if($board[$row][$col] == 2){
                    $playerTwoScore++;
                }
            }
        }
        if($turn == 1){
            return $playerOneScore;
        }
        else{
            return $playerTwoScore;
        }
    }
    echo $_SESSION['gameData'];
    ?>