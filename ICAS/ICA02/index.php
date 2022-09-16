<?php
    session_start();

    
    $formTitle = "Enter your names below"; // default form title 
    $playerOne = "";
    $playerTwo = "";
    $PlaceBoard = "";
    
    if(isset($_POST['NewGame'])){  // if the NewGame button was clicked
        if(isset($_POST['playerOne']) && strlen($_POST['playerOne']) > 0
        && isset($_POST['playerTwo']) && strlen($_POST['playerTwo']) > 0)   // if both player names are valid
        {
            $playerOne = strip_tags($_POST['playerOne']);
            $playerTwo = strip_tags($_POST['playerTwo']);
            $PlaceBoard = 'class=Board';
            $formTitle = "Click on a square to place your piece";
            $_SESSION['playerOne'] = $playerOne;
            $_SESSION['playerTwo'] = $playerTwo;
            //Create 8x8 board in a 2D array
            $board = array(
                array(0,0,0,0,0,0,0,0),
                array(0,0,0,0,0,0,0,0),
                array(0,0,0,0,0,0,0,0),
                array(0,0,0,1,2,0,0,0),
                array(0,0,0,2,1,0,0,0),
                array(0,0,0,0,0,0,0,0),
                array(0,0,0,0,0,0,0,0),
                array(0,0,0,0,0,0,0,0)
            );
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
            $gameData = array(
                'playerOne' => $playerOne,
                'playerTwo' => $playerTwo,
                'board' => $board,
                'turn' => rand(1,2),
                'winner' => 0,
                'validMoves' => $validMoves,
                'gameOver' => false,
                'formTitle' => $formTitle                
            );
            $_SESSION['gameData'] = json_encode($gameData);
        }
        else{  // if both player names are not valid
            $PlaceBoard = 'class=Board style="display:none"';
            $formTitle = "Names must be at least 1 character long";
            echo "<script type='text/javascript'>alert('Names must be at least 1 character long');</script>";
        }
    }
    
    if(isset($_POST['QuitGame']))  // if the QuitGame button was clicked
    {
        session_unset();
        session_destroy();        
        header("Location: index.php");
    }
    
    
    error_log(json_encode($_POST));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>
    <title>ICA02 - Othello</title>
</head>
<body>
    <header>
        <h1>Othello</h1>

        <h2>Instructions</h2>
        <p>Click on a square to place your piece. 
            The pieces will flip to your color if they are surrounded by your pieces. 
            The game ends when the board is full or there are no more valid moves.
        </p>        
    </header>
    <main>
        <section>
            <form action="index.php" method="post" id="form">
                <h2><?php echo  $formTitle ?></h2>
                <input type="text" name="playerOne" placeholder="Player one name here" <?php echo 'value='.'"'.$playerOne.'"'?>>
                <input type="text" name="playerTwo" placeholder="Player two name here" <?php echo 'value='.'"'.$playerTwo.'"'?>>
                <input type="submit" name="NewGame" value="New Game">
                <input type="submit" name="QuitGame" value="Quit Game">
                <label for="" class="turn"></label>
            </form>
        </section>
        <hr>
        <table <?php echo $PlaceBoard?> >
        </table>
    </main>
    <footer>
        &copy; &Lambda;&alpha;&beta;&epsilon;&zeta;&sigma;&omega;<br/>
        <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
</body>
</html>