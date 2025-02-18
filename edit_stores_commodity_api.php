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



$night = intval($_POST['night_price']);
$tent = intval($_POST['tent']);
$bed = intval($_POST['bed']);
$people = intval($_POST['people']);


$sql = "UPDATE `rooms_campsites` SET 
`name`=?,
`normal_price`=?,
`holiday_price`=?,
`night_price`=?,
`tent`=?,
`bed`=?,
`people`=?,
`square_meters`=?,
`introduction`=? 
 WHERE stores_id =? 
 and rooms_campsites_id=? ";

$read = $pdo->prepare($sql);


$read->execute([
    $_POST['name'],
    $_POST['normal_price'],
    $_POST['holiday_price'],
    $night,
    $tent,
    $bed,
    $people,
    $_POST['square_meters'],
    $_POST['introduction'],
    $sid,
    $_POST['rooms_campsites_id']
]);


$output['success'] = !!$read->rowCount();
$output['code'] = 003;
echo json_encode($output);
