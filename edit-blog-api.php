<?php
// require __DIR__ .'/parts/admin-required.php';
require __DIR__."/config/pdo-connect.php";

header("Content-Type: application/json");

$output = [
  'success' => false, //是不是新增成功
  'bodyData' => $_POST, //檢查用
  'code' => 0,
];

// TODO 要做欄位資料檢查
// preg_match() 來做正規表達式檢查
// filter_var('subject', FILTER_VALIDATE_URL)) 檢查是不是email格式
// mb_strlen()回傳字串的長度 mb_表multi-byte
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (empty($id)) {
  # 沒有給 primary key
  $output['code'] = 400;
  echo json_encode($output);
  exit;
}

$datetime=strtotime($_POST['datetime']);
if($datetime===false){
  $datetime=date('Y-m-d H:i:s', time());
}else{
  $datetime = date('Y-m-d H:i:s', $datetime);
}
$sql="UPDATE `blog` SET `title`=?, `author`=?,`blog_tag`=?,`content`=?,`create_at`=? WHERE id = ?";

$stmt =$pdo->prepare($sql); #會先檢查 sql語法

$stmt->execute([
  $_POST['title'],
  $_POST['author'],
  $_POST['tag'],
  $_POST['content'],
  $datetime,
  $id
]);

$output['success'] = !! $stmt->rowCount();

echo json_encode($output);