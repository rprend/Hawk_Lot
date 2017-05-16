<?php include "header/header-control.php"; ?>
<html lang="en">
<head>
    <title>HawkLot</title>
    <?php include "header/header-head.php"; ?>
    <style>
    #bug {
      height:50px;
      width:500px;
      font-size:12pt;
    }
    </style>
</head>
<body>
  <?php include "header/header-body.php"; ?>
  <div class="container" align="center">
    <form method="post" action="reportbug.php">
      <h1>Enter your bug</h1>
      <div class="form-group">
        <input id="bug" name="bug" type="textarea" class="input-md" placeholder="Please enter the bug you discovered" rows="5" cols="100">
        </input>
      </div>

    <div>
      <button type="sumbit" name="submit" id="submit" class="btn btn-primary btn-lg " action="reportbug.php">Submit</button>
    </div>
  </div>

    <?php
      include("dbconnect.php");
        if(isset($_POST['submit'])) {
          $text = mysqli_real_escape_string($conn, $_POST['bug']);
          $query = "INSERT INTO bugs(issue, currtime) VALUES('$text', CURRENT_TIMESTAMP)";
          $runquery = mysqli_query($conn, $query);
          if (!$runquery) {
            die('Invalid query: ' . mysql_error());
          }
          mysqli_close($conn);
          echo '<meta http-equiv="refresh" content="0;url=index.php">';
          exit;
        }
        ?>
</form>

</body>
</html>
