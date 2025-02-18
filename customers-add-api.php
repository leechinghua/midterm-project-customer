<?php
require __DIR__ ."/config/pdo-connect.php";

header('Content-Type: application/json');

$output =[
  'success' => false,
  'bodyData' => $_POST,
  'pk'=> 0,
];

// TODO: 要做欄位資料檢查

$sql = "INSERT INTO `customers`(`email`, `password`, `created_at`) VALUES (?,?, NOW())";
$stmt = $pdo->prepare($sql); 
$stmt->execute([
  $_POST['email'],
  password_hash($_POST['password'], PASSWORD_DEFAULT),
]);
$output['success'] = !!$stmt->rowCount();
$output['pk'] = $pdo->lastInsertId(); 
# 取得最新新增資料的 primary key (通常是流水號)
echo json_encode($output);