<?php
require __DIR__ .'/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false,
  'bodyDate' => $_POST,
  'pk' => 0,
];


// TODO: 欄位檢查 密碼雜湊
// var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));


$birthday = strtotime($_POST['birthday']);
if($birthday === false){
  $birthday= null;
}else{
  $birthday = date('Y-m-d', $birthday);
}

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$sql="INSERT INTO `owners`(`name`, `gender`, `password`, `birthday`, `email`, `id_card`, `mobile`, `address`, `bank_account`, `member_status`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW())";

$stmt = $pdo->prepare($sql);

$stmt->execute([
  $_POST['name'],
  $_POST['gender'],
  $password,
  $birthday,
  $_POST['email'],
  $_POST['id_card'],
  $_POST['mobile'],
  $_POST['address'],
  $_POST['bank_account'],
  $_POST['member_status']
]);

$output['success'] = !! $stmt->rowCount();
$output['pk'] = $pdo->lastInsertId();

echo json_encode($output); 