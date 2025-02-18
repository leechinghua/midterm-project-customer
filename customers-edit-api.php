<?php
require __DIR__ ."/config/pdo-connect.php";

header('Content-Type: application/json');

$output =[
  'success' => false,
  'bodyData' => $_POST,
  'code'=> 0,
];

$birthday = strtotime($_POST['birthday']);
if ($birthday === false) {
  $birthday = null;
} else {
  $birthday = date('Y-m-d', $birthday);
}
$introduction = isset($_POST['introduction']) ? $_POST['introduction'] : null;

// TODO: 要做欄位資料檢查
$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
if (empty($id)) {
  $output['code']=400;
  echo json_encode($output);
  exit;
}

$sql = "UPDATE `customers` SET 
`name` = ?,
`phone` = ?,
`gender` = ?,
`birthday` = ?,
`address` = ?,
`introduction` = ?,
`id_card` = ?
WHERE id = ?";

$stmt = $pdo->prepare($sql); 

$stmt->execute([
  $_POST['name'],
  $_POST['phone'],
  $_POST['gender'],
  $birthday,
  $_POST['address'],
  $introduction,
  $_POST['id_card'],
  $id,
]);
$output['success'] = !!$stmt->rowCount();

echo json_encode($output);