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
            if($gameData['turn'] == 1){
                $gameData['formTitle'] = $gameData['playerOne'] . "'s turn";
            }
            else if($gameData['turn'] == 2){
                $gameData['formTitle'] = $gameData['playerTwo'] . "'s turn";
            }
            
            $_SESSION['gameData'] = json_encode($gameData);
        }
    }

    
    function PlacePiece(){
        $gameData = json_decode($_SESSION['gameData']);
        $row = strip_tags($_POST['row']);
        $col = strip_tags($_POST['col']);
        $board = $gameData->board;
        $gameData->validMoves = GetValidMoves($gameData->board, $gameData->turn);
        if($gameData->board[$row][$col] == 0 && $gameData->validMoves[$row][$col] == 1){
            $gameData->board[$row][$col] = $gameData->turn;
            $gameData->turn = ($gameData->turn == 1) ? 2 : 1;
            $gameData->gameOver = IsGameOver($gameData->board);
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

    function GetWinner($board){
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
    echo $_SESSION['gameData'];
    ?>