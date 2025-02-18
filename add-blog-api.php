<?php
// require __DIR__ .'/parts/admin-required.php';
require __DIR__."/config/pdo-connect.php";

header("Content-Type: application/json");

$output = [
  'success' => false, //是不是新增成功
  'bodyData' => $_POST, //檢查用
  'pk' => 0,
];

// TODO 要做欄位資料檢查
// preg_match() 來做正規表達式檢查
// filter_var('subject', FILTER_VALIDATE_URL)) 檢查是不是email格式
// mb_strlen()回傳字串的長度 mb_表multi-byte

$datetime=strtotime($_POST['datetime']);
if($datetime===false){
  $datetime=date('Y-m-d H:i:s', time());
}else{
  $datetime = date('Y-m-d H:i:s', $datetime);
}
$sql="INSERT INTO `blog`( `title`, `author`, `blog_tag`, `content` , `create_at`) VALUES(?, ?, ?, ?, ?)";

$stmt =$pdo->prepare($sql); #會先檢查 sql語法

$stmt->execute([
  $_POST['title'],
  $_POST['author'],
  $_POST['tag'],
  $_POST['content'],
  $datetime
]);

$output['success']= !!$stmt->rowCount(); //兩次!!轉換成布林值
$output['pk'] =$pdo->LastInsertId(); #取得最新新增資料的 primary key 通常是流水號

echo json_encode($output);