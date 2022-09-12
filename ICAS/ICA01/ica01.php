<?php
  $status = "Status:";
  require_once 'php/util.php';
  

  // Check if the form has been submitted
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
      <!-- Part I -->
      <section>
        <h2>Part I: Server info</h2>
        
        <h3>Your IP addrres is:</h3>                 
        <div>
          <?php
            echo $_SERVER['REMOTE_ADDR']; // Display the IP address
          ?>         
        </div>

        <h3>$_GET Evaluation:</h3>
        <div>
          <?php
            echo "Found: " . count($_GET) . " entries in the $ _GET"; // Display the number of entries in the $_GET array
          ?>
        </div>

        <h3>$_POST Evaluation:</h3>
        <div>
          <?php
            echo "Found: " . count($_POST) . " entries in the $ _POST"; // Display the number of entries in the $_POST array
          ?>
        </div>
        <?php $status .= " +Server Info"; //Add to the status ?> 
      </section>

      <br>

      <section>
        <h2>Part II: </h2>

        <h3>$Get Contents:</h3>
        <div>
          <?php
            echo "[Name] = " . $name . "<br>"; // Display the name
            echo  "[Hobby] = ". $hobby . "<br>"; // Display the hobby
            echo  "[How Much] = " . $like; // Display the amount of the person likes the hobby
          ?>
        </div>
        <?php $status .= " +Get Data"; //Add to the status ?> 
      </section>

      <br>

      <section>
        <h2>Part III: PHP info</h2>

        <h3>Arry Generated:</h3>
        <ol>
          <?php
            $numbers = GenerateNumbers(); // Generate an array of 10 random numbers
            $status .= " +Generate Numbers"; //Add to the status
            echo Makelist($numbers); // Display the array
          ?>
          <?php $status .= " +Make List"; //Add to the status ?>                    
        </ol>
        <?php $status .= " +Show Array"; //Add to the status ?>
      </section>

      <br>
      <section>
        <h2>PART IV: Form Processing</h2>
        <form action="ica01.php" method="get">
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" placeholder="Your Name" <?php echo 'value="'. $name .'"' ?> />
          <br>
          <label for="hobby">Hobby:</label>
          <input type="text" name="hobby" id="hobby" placeholder="Your Hobby" <?php echo 'value="'. $hobby .'"' ?> />          
          <br>
          <label for="like">How much you like it?</label>
          <input type="range" name="like" id="like" min="0" max="10" <?php echo 'value="'. $like .'"' ?> />
          <br>
          <input type="submit" class="Button" value="Go Now!">
        </form>
        <?php $status .= " +Process Form"; ?>
      </section>
      
      <br>

      <section>        
        <?php echo $output // Display the output ?>        
      </section>

      <br>

      <section>
        <h2>
          <?php echo $status // Display the status ?> 
        </h2>
          
      </section>
      
    </main>
    
    <br>
    <!-- footer -->
    <footer>
      &copy; &Lambda;&alpha;&beta;&epsilon;&zeta;&sigma;&omega;<br/>
      <script>document.write('Last Modified:' + document.lastModified);</script>
    </footer>
  </body>
</html>
