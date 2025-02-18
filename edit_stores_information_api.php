<?php
require __DIR__ . '/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 001
];

$sid = isset($_POST['stores_id']) ? intval($_POST['stores_id']) : 0;



$sql = "UPDATE `stores_informations` SET 
`night_time`= ?,
`entry_time`=?,
`close_time`=?,
`water`=?,
`refrigerator`=?,
`bath_time`=?,
`curfew`=?,
`pet`=? 
WHERE stores_id = $sid;";

$read = $pdo->prepare($sql);


$read->execute([
    $_POST['night_time'],
    $_POST['entry_time'],
    $_POST['close_time'],
    $_POST['water'],
    $_POST['refrigerator'],
    $_POST['bath_time'],
    $_POST['curfew'],
    $_POST['pet']
]);


$output['success'] = !!$read->rowCount();
$output['code'] = 003;
echo json_encode($output);
