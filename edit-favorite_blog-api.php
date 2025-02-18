<?php
// require __DIR__ .'/parts/admin-required.php';
require __DIR__."/config/pdo-connect.php";

header("Content-Type: application/json");

$output = [
  'success' => false, //是不是新增成功
  'bodyData' => $_POST, //檢查用
  'code' => 0,
];
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (empty($id)) {
  # 沒有給 primary key
  $output['code'] = 400;
  echo json_encode($output);
  exit;
}
// TODO 要做欄位資料檢查
// preg_match() 來做正規表達式檢查
// filter_var('subject', FILTER_VALIDATE_URL)) 檢查是不是email格式
// mb_strlen()回傳字串的長度 mb_表multi-byte


$sql="UPDATE `favorite_blog` SET `customer_id`=?,`blog_id`=? WHERE favorite_blog.id=?";

$stmt =$pdo->prepare($sql); #會先檢查 sql語法

$stmt->execute([
  $_POST['customerId'],
  $_POST['blogId'],
  $id
 
]);

$output['success'] = !! $stmt->rowCount();

echo json_encode($output);