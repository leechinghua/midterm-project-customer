<?php
require __DIR__ . '/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 001
];

$sid = isset($_POST['stores_id']) ? intval($_POST['stores_id']) : 0;


if (empty($sid)) {
    $output['code'] = 002;
    echo json_encode($output);
    exit;
}



$sql = "UPDATE `stores` SET 
`name`=?,
`mobile`=?,
`address`=?,
`longitude`=?,
`latitude`=?,
`altitude`=?,
`precautions`=?,
`introduction`=?,
`update_time`= now()
  WHERE stores_id =?";

$read = $pdo->prepare($sql);


$read->execute([
    $_POST['name'],
    $_POST['mobile'],
    $_POST['address'],
    $_POST['longitude'],
    $_POST['latitude'],
    $_POST['altitude'],
    $_POST['precautions'],
    $_POST['introduction'],
    $sid
]);


$output['success'] = !!$read->rowCount();
$output['code'] = 003;
echo json_encode($output);
