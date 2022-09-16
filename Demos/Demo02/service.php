<?php

    session_start();

    error_log(json_encode($_POST));
    
    if (isset($_post['action'])){
        $action = strip_tags($_POST['action']);
        if($action == "Test Data"){
            printData();
        }
        else if($action == "ProcessData"){
            ProcessData();
        }
    }

    echo $_SESSION['gameData'];

    function ProcessData(){
        $gameData = json_decode($_POST['gameData']);

        // processing stuff

        $_SESSION['gameData'] = json_encode($gameData);
    }

    function printData(){
        $gameData = array();
        for($i = 0; $i < 10; $i++){
            $gameData[$i] = rand(0, 100);
        }
        
    }
?>


