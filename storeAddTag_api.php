<?php
require __DIR__ . '/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 001
];


$sql = "INSERT INTO `stores_tag`(`stores_id`, `tag_id`) VALUES (?,?)";

$read = $pdo->prepare($sql);


$read->execute([
    $_POST['stores_id'],
    $_POST['tag_id']
]);


$output['success'] = !!$read->rowCount();
$output['code'] = 003;
echo json_encode($output);
