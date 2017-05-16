<?php
$db = 'UserDB';
$conn = mysqli_connect("localhost", "root", "viD0pf1V2QOxrQMc");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
mysqli_select_db($conn, $db);
?>
