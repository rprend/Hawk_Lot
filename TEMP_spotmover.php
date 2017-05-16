<?php
include "header/header-control.php";
if($_SESSION['logon']>=1){
$resp = 0;

$jsonString = file_get_contents('jocklot.json');
$data = json_decode($jsonString, true);

$orig = $data['features'];

$i = 0;

/*$data['features'][$i]['geometry']['coordinates'][0][0][0] = $orig[$i]['geometry']['coordinates'][0][0][0] -5.5;
$data['features'][$i]['geometry']['coordinates'][0][0][1] = $orig[$i]['geometry']['coordinates'][0][0][1] + 5;
$data['features'][$i]['geometry']['coordinates'][0][1][0] = $orig[$i]['geometry']['coordinates'][0][1][0] - 20.7;
$data['features'][$i]['geometry']['coordinates'][0][1][1] = $orig[$i]['geometry']['coordinates'][0][1][1] + 13.15;
$data['features'][$i]['geometry']['coordinates'][0][2][0] = $orig[$i]['geometry']['coordinates'][0][2][0] - 20.7;
$data['features'][$i]['geometry']['coordinates'][0][2][1] = $orig[$i]['geometry']['coordinates'][0][2][1] + 19;
$data['features'][$i]['geometry']['coordinates'][0][3][0] = $orig[$i]['geometry']['coordinates'][0][3][0] -5.5;
$data['features'][$i]['geometry']['coordinates'][0][3][1] = $orig[$i]['geometry']['coordinates'][0][3][1] + 10.9;
$data['features'][$i]['geometry']['coordinates'][0][4][0] = $orig[$i]['geometry']['coordinates'][0][4][0] -5.5;
$data['features'][$i]['geometry']['coordinates'][0][4][1] = $orig[$i]['geometry']['coordinates'][0][4][1] + 5;
*/
//ROW ONE
/*
for($i=1; $i < 11; $i++){
  $data['features'][$i]['geometry']['coordinates'][0][0][0] = $data['features'][$i-1]['geometry']['coordinates'][0][0][0];
  $data['features'][$i]['geometry']['coordinates'][0][0][1] = $data['features'][$i-1]['geometry']['coordinates'][0][3][1] - 1.7 + .01 * $i;
  $data['features'][$i]['geometry']['coordinates'][0][1][0] = $data['features'][$i-1]['geometry']['coordinates'][0][1][0];
  $data['features'][$i]['geometry']['coordinates'][0][1][1] = $data['features'][$i-1]['geometry']['coordinates'][0][2][1] - 1.7 + .01 * $i;
  $data['features'][$i]['geometry']['coordinates'][0][2][0] = $data['features'][$i-1]['geometry']['coordinates'][0][2][0];
  $data['features'][$i]['geometry']['coordinates'][0][2][1] = $data['features'][$i]['geometry']['coordinates'][0][1][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][3][0] = $data['features'][$i-1]['geometry']['coordinates'][0][3][0];
  $data['features'][$i]['geometry']['coordinates'][0][3][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][4][0] = $data['features'][$i-1]['geometry']['coordinates'][0][4][0];
  $data['features'][$i]['geometry']['coordinates'][0][4][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1];
}
*/

//ROW TWO (BEGINNING AT 532)
/*
$up_or_down = - 1;
for($i=20; $i > 11; $i--){
  $data['features'][$i]['geometry']['coordinates'][0][0][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][0][0];
  $data['features'][$i]['geometry']['coordinates'][0][0][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][1] - 1.7 + .01 * $i;
  $data['features'][$i]['geometry']['coordinates'][0][1][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][1][0];
  $data['features'][$i]['geometry']['coordinates'][0][1][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][1] - 1.7 + .01 * $i;
  $data['features'][$i]['geometry']['coordinates'][0][2][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][0];
  $data['features'][$i]['geometry']['coordinates'][0][2][1] = $data['features'][$i]['geometry']['coordinates'][0][1][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][3][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][0];
  $data['features'][$i]['geometry']['coordinates'][0][3][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][4][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][4][0];
  $data['features'][$i]['geometry']['coordinates'][0][4][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1];
}
*/
/*
//row three
$up_or_down = 1;
for($i=23; $i < 33; $i++){
  $data['features'][$i]['geometry']['coordinates'][0][0][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][0][0];
  $data['features'][$i]['geometry']['coordinates'][0][0][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][1] - 1.7 + .01 * $i;
  $data['features'][$i]['geometry']['coordinates'][0][1][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][1][0];
  $data['features'][$i]['geometry']['coordinates'][0][1][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][1] - 1.7 + .01 * $i;
  $data['features'][$i]['geometry']['coordinates'][0][2][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][0];
  $data['features'][$i]['geometry']['coordinates'][0][2][1] = $data['features'][$i]['geometry']['coordinates'][0][1][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][3][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][0];
  $data['features'][$i]['geometry']['coordinates'][0][3][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][4][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][4][0];
  $data['features'][$i]['geometry']['coordinates'][0][4][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1];
}
*/
/*
//row four

$up_or_down = 1;
for($i=34; $i < 44; $i++){
  $data['features'][$i]['geometry']['coordinates'][0][0][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][0][0];
  $data['features'][$i]['geometry']['coordinates'][0][3][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][0][1] +1.7;

  $data['features'][$i]['geometry']['coordinates'][0][1][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][1][0];
  $data['features'][$i]['geometry']['coordinates'][0][2][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][1][1] +1.7;

  $data['features'][$i]['geometry']['coordinates'][0][2][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][0];
  $data['features'][$i]['geometry']['coordinates'][0][0][1] = $data['features'][$i]['geometry']['coordinates'][0][3][1] + 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][1][1] = $data['features'][$i]['geometry']['coordinates'][0][2][1] + 5.9;

  $data['features'][$i]['geometry']['coordinates'][0][3][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][0];
  $data['features'][$i]['geometry']['coordinates'][0][4][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][4][0];
  $data['features'][$i]['geometry']['coordinates'][0][4][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1];
}
*/
/*
//row five
$up_or_down = 1;
for($i=10; $i < 11; $i++){
  $data['features'][$i]['geometry']['coordinates'][0][0][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][0][0];
  $data['features'][$i]['geometry']['coordinates'][0][0][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][1] - 1.7;
  $data['features'][$i]['geometry']['coordinates'][0][1][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][1][0];
  $data['features'][$i]['geometry']['coordinates'][0][1][1] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][1] - 1.7;
  $data['features'][$i]['geometry']['coordinates'][0][2][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][2][0];
  $data['features'][$i]['geometry']['coordinates'][0][2][1] = $data['features'][$i]['geometry']['coordinates'][0][1][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][3][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][3][0];
  $data['features'][$i]['geometry']['coordinates'][0][3][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1] - 5.9;
  $data['features'][$i]['geometry']['coordinates'][0][4][0] = $data['features'][$i-(1*$up_or_down)]['geometry']['coordinates'][0][4][0];
  $data['features'][$i]['geometry']['coordinates'][0][4][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1];
}
*/

//for fine-tuned adjustments...

for($i=54; $i <= 54; $i++){
  $q = .05;
  $data['features'][$i]['geometry']['coordinates'][0][3][1] = $data['features'][$i]['geometry']['coordinates'][0][3][1] + $q;
  $data['features'][$i]['geometry']['coordinates'][0][4][1] = $data['features'][$i]['geometry']['coordinates'][0][4][1] + $q;
  $data['features'][$i]['geometry']['coordinates'][0][2][1] = $data['features'][$i]['geometry']['coordinates'][0][2][1] + $q;
  $data['features'][$i]['geometry']['coordinates'][0][1][1] = $data['features'][$i]['geometry']['coordinates'][0][1][1] + $q;
  $data['features'][$i]['geometry']['coordinates'][0][0][1] = $data['features'][$i]['geometry']['coordinates'][0][0][1] + $q;
}

/*  if($i >= 1){
    $data['features'][$i]['geometry']['coordinates'][0][0][1] = $orig[$i]['geometry']['coordinates'][0][0][1] + 11.4 + 3.3;
    $data['features'][$i]['geometry']['coordinates'][0][0][1] = $orig[$i]['geometry']['coordinates'][0][1][1] + 11.4 + 3.3;
    $data['features'][$i]['geometry']['coordinates'][0][0][1] = $orig[$i]['geometry']['coordinates'][0][2][1] + 11.4 + 3.3;
    $data['features'][$i]['geometry']['coordinates'][0][0][1] = $orig[$i]['geometry']['coordinates'][0][3][1] + 11.4 + 3.3;
    $data['features'][$i]['geometry']['coordinates'][0][0][1] = $orig[$i]['geometry']['coordinates'][0][0][1] + 11.4 + 3.3;
  }
}
*/

$newJsonString = json_encode($data);
file_put_contents('jocklot.json', $newJsonString);
}
?>
