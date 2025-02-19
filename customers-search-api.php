<?php
require __DIR__ . "/config/pdo-connect.php";

header('Content-Type: application/json');

$output = [
  'success' => false,
  'code' => 0,
  'data' => [],
  'error' => ''
];

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (empty($search)) {
  $output['error'] = '搜尋字眼不得為空';
  echo json_encode($output);
  exit;
}

try {
  // 使用 LIKE 搜尋姓名包含關鍵字
  $sql = "SELECT * FROM `customers` WHERE `name` LIKE ? ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(["%{$search}%"]);

  $output['data'] = $stmt->fetchAll();
  $output['success'] = true;
} catch (PDOException $e) {
  $output['error'] = $e->getMessage();
  $output['code'] = 500;
}

echo json_encode($output);
