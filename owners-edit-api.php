<?php
require __DIR__ .'/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false,
  'bodyDate' => $_POST,
  'code' => 0,
];

$ownersId = isset($_POST['owners_id']) ? intval($_POST['owners_id']) :0;
if(empty($ownersId)) {
  $output ['code'] = 400;
  echo json_encode($output);
  exit;
}

// TODO: 欄位檢查 密碼雜湊
// var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));


$birthday = strtotime($_POST['birthday']);
if($birthday === false){
  $birthday= null;
}else{
  $birthday = date('Y-m-d', $birthday);
}




$sql="UPDATE `owners` SET 
`name`=?,
`gender`=?,
-- `password`=?,
`birthday`=?,
-- `email`=?,
`id_card`=?,
`mobile`=?,
`address`=?,
`bank_account`=?,
`member_status`=?
WHERE owners_id=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
  $_POST['name'],
  $_POST['gender'],
  // $_POST['password'],
  $birthday,
  // $_POST['email'],
  $_POST['id_card'],
  $_POST['mobile'],
  $_POST['address'],
  $_POST['bank_account'],
  $_POST['member_status'],
  $ownersId
]);

$output['success'] = !! $stmt->rowCount();


echo json_encode($output); 