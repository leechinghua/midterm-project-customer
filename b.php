<?php
// $birthday = strtotime('2024-05-06T14:43:09');
// echo date("Y-m-d H:i:s",$birthday);

$currentTimestamp = time();
$TaipeiTimestamp = $currentTimestamp ;
$dateString = date('YmdHis', $TaipeiTimestamp);
echo $dateString;