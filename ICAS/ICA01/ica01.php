<?php
  $status = "Status:";
  require_once 'php/util.php';
  
  if (isset($_GET['name']) && strlen($_GET['name']) > 0
        && isset($_GET['hobby']) && strlen($_GET['hobby']) > 0) {

        $name = strip_tags($_GET['name']);
        $hobby = strip_tags($_GET['hobby']);
        $like = strip_tags($_GET['like']);

        $output = "<h2> $name ";
        
        for ($i = 0; $i < $like; $i++) {
          $output .= " really";
          
        }
        $output .= " likes to " . $hobby . "</h2>";
        $status .= " +Getting Data";
    }
    error_log(json_encode($_GET));
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
    <br>
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
            echo "Found: " . count($_GET) . " entries in the $ _GET";
          ?>
        </div>

        <h3>$_POST Evaluation:</h3>
        <div>
          <?php
            echo "Found: " . count($_POST) . " entries in the $ _POST";
          ?>
        </div>
        <?php $status .= " +Server Info"; ?>
      </section>

      <br>

      <section>
        <h2>Part II: </h2>

        <h3>$Get Contents:</h3>
        <div>
          <?php
            echo "[Name] = " . $_GET['name'] . "<br>";
            echo  "[Hobby] = ". $_GET['hobby'] . "<br>";
            echo  "[How Much] = " . $_GET['like'];
          ?>
        </div>
        <?php $status .= " +Get Data"; ?>
      </section>

      <br>

      <section>
        <h2>Part III: PHP info</h2>

        <h3>Arry Generated:</h3>
        <ol>
          <?php
            $numbers = GenerateNumbers();
            $status .= " +Generate Numbers";
            echo Makelist($numbers);
          ?>
          <?php $status .= " +Make List"; ?>                    
        </ol>
        <?php $status .= " +Show Array"; ?>
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
          <br>
          <label for="like">How much you like it?</label>
          <input type="range" name="like" id="like" min="0" max="10">
          <br>
          <input type="submit" class="Button" value="Go Now!">
        </form>
        <?php $status .= " +Process Form"; ?>
      </section>
      
      <br>

      <section>        
        <?php echo $output ?>        
      </section>

      <br>

      <section>
        <h2>
          <?php echo $status ?>
        </h2>
          
      </section>
      
    </main>
    
    <br>
    
    <footer>
      &copy; &Lambda;&alpha;&eta;s&epsilon;&zeta;&sigma;&omega;<br/>
      <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
  </body>
</html>
