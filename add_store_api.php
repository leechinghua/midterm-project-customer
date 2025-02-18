<?php
require __DIR__ . '/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 001
];


$sql = "INSERT INTO `stores`(`owners_id`, `name`, `mobile`, `address`, `longitude`, `latitude`, `altitude`, `precautions`, `introduction`, `update_time`) VALUES (?,?,?,?,?,?,?,?,?,NOW())";

$read = $pdo->prepare($sql);


$read->execute([
    $_POST['owners_id'],
    $_POST['name'],
    $_POST['mobile'],
    $_POST['address'],
    $_POST['longitude'],
    $_POST['latitude'],
    $_POST['altitude'],
    $_POST['precautions'],
    $_POST['introduction']
]);


$output['success'] = !!$read->rowCount();
$output['code'] = 003;
echo json_encode($output);
