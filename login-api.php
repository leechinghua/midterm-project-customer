<?php
require __DIR__ .'/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false,
  'bodyDate' => $_POST,
  'code' => 0,
];

if(empty($_POST['email'])or empty($_POST['password'])){
  echo json_encode($output);
  exit;
}


$sql = "SELECT * FROM admin WHERE email=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['email']]);
$row = $stmt->fetch();

if(empty($row)){
  $output['code'] = 400;
  echo json_encode($output);
  exit;
}


if(password_verify($_POST['password'],$row['password'])){
  $output['code'] = 200;
  $output['success'] = true;
  // $output['row']=$row;

  $_SESSION['admin'] = [
    'id'=>$row['id'],
    'email'=> $row['email'],
    'nickname'=>$row['nickname']
  ];
}else{
  $output['code'] = 420;
}

echo json_encode($output);
