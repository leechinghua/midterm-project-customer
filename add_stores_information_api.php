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

if ($_POST['water'] == 'YES') {
    $_POST['water'] = 1;
} else if ($_POST['water'] == 'NO') {
    $_POST['water'] = 0;
} else {
    $_POST['water'] = "";
}

if ($_POST['refrigerator'] == 'YES') {
    $_POST['refrigerator'] = 1;
} else if ($_POST['refrigerator'] == 'NO') {
    $_POST['refrigerator'] = 0;
} else {
    $_POST['refrigerator'] = "";
}

if ($_POST['pet'] == 'YES') {
    $_POST['pet'] = 1;
} else if ($_POST['pet'] == 'NO') {
    $_POST['pet'] = 0;
} else {
    $_POST['pet'] = "";
}


$sql = "INSERT INTO `stores_informations`( `stores_id`, `night_time`, `entry_time`, `close_time`, `water`, `refrigerator`, `bath_time`, `curfew`, `pet`) VALUES (?,?,?,?,?,?,?,?,?)";

$read = $pdo->prepare($sql);


$read->execute([
    $sid,
    $_POST['night_time'],
    $_POST['entry_time'],
    $_POST['close_time'],
    $_POST['water'],
    $_POST['refrigerator'],
    $_POST['bath_time'],
    $_POST['curfew'],
    $_POST['pet'],
]);


$output['success'] = !!$read->rowCount();
$output['code'] = 003;
echo json_encode($output);
