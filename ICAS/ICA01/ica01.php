<?php
  require_once 'php/util.php';    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="ICA01" />
    <link rel="stylesheet" href="css/style.css" />        
    <title>ICA01</title>
  </head>
  <body>
    <header>
      <h1>ICA01_php</h1>
    </header>

    <main>
      <section>
        <h2>Part I: Server info</h2>
        
        <h3>Your IP addrres is:</h3>                 
        <div>
          <?php
            echo $_SERVER['REMOTE_ADDR'];
          ?>         
        </div>

        <h3>$_GET Evaluation:</h3>
        <div>
          <?php
            echo var_dump($_GET);
          ?>
        </div>

        <h3>$_POST Evaluation:</h3>
        <div>
          <?php
            echo "Found: ". var_dump($_POST);
          ?>
        </div>
        
      </section>

      <br>

      <section>
        <h2>Part II: </h2>
      </section>

      <br>

      <section>
        <h2>Part III: PHP info</h2>

        <h3>Arry Generated:</h3>
        <ol>
          <?php
            $numbers = GenerateNumbers();
            echo Makelist($numbers);
          ?>                     
        </ol>
      </section>

      <br>
      <section>
        <h2>PART IV: Form Processing</h2>
        <form action="ica01.php" method="get">
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" placeholder="Your Name" />
          <br>
          <label for="hobby">Hobby:</label>
          <input type="text" name="hobby" id="hobby" placeholder="Your Hobby" />
          <input type="submit" value="Refresh" />
          <br>
          <label for="like">How much you like it?</label>
          <input type="range" name="like" id="like" >
        </form>
      </section>
    </main>

    <footer>
      &copy; &Lambda;&alpha;&eta;s&epsilon;&zeta;&sigma;&omega;<br/>
      <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
  </body>
</html>
