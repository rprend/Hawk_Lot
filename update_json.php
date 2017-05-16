<?php
include "header/header-control.php";
if($_SESSION['logon']<1) {
  header("refresh:0; url=index.php");
  echo "USER IS NOT LOGGED ON";
  session_destroy();
  exit;
}

if(isset($_GET['lot'])){
  $lot = $_GET['lot'];
}

/*$parkinglot = file_get_contents('parking_lot.json');
$newlot = file_get_contents($lot);

file_put_contents('parking_lot.json', $newlot);
file_put_contents($lot, $parkinglot);
*/
?>
