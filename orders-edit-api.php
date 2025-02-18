<?php

require __DIR__ . "./config/pdo-connect.php";

header("Content-Type: application/json");

$output = [
  "success" => false,
  "bodyData" => $_POST,
  "code" => 0,
];

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
if (empty($id)) {
  $output["code"] = 400;
  echo json_encode($output);
  exit;
};

// 測試
$sql5 = "UPDATE
orders
JOIN rooms_campsites ON orders.room_campsite_id = rooms_campsites.rooms_campsites_id
JOIN stores ON orders.store_id = stores.stores_id
JOIN customers ON orders.customer_id = customers.id
SET
payment_status=?,
note=?,
guests=?,
checkin_date=?,
checkout_date=?,
total_day=?,
total_price=?,
room_campsite_id=?
WHERE orders.id = ?";


$stmt = $pdo->prepare($sql5);
$stmt->execute([
  $_POST["payment_status"],
  $_POST["note"],
  $_POST["guests"],
  $_POST["checkin_date"],
  $_POST["checkout_date"],
  $_POST["total_day"],
  $_POST["total_price"],
  $_POST["rooms_campsites_name"],
  $id
]);


//
// $sql = "UPDATE `orders` SET 
// `payment_status`=?,
// `note`=? 
// WHERE id =?";

// $stmt = $pdo->prepare($sql);

// $stmt->execute([
//   $_POST["payment_status"],
//   $_POST["note"],
//   $id
// ]);

# 查看是否有編輯， !! => 代表轉成布林值
$output["success"] = !!$stmt->rowCount();

# 編輯成功時，追蹤編號設成200
if ($output["success"]) {
  $output["code"] = 200;
}

echo json_encode($output);
