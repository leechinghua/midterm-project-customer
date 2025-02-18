<?php
// exit; # 結束 php 程式
require __DIR__ . '/config/pdo-connect.php';

$normal_price = ["2000", "1500", "1200", "1100", "1000"];

$holiday_price = ["3400", "3200", "2800", "2200", "2100"];

$night_price = ["900", "800"];

$square_meters = ["4m * 4m", "5m * 5m", "6m * 6m"];

$campName = ["草地B1", "草地B2", "草地B3", "草地B4", "碎石地C1", "碎石地C2", "碎石地C3", "碎石地C4", "露營車1號", "露營車2號", "露營車3號", "露營車4號"];

$campIntro = ["營帳介紹"];

$sql = "INSERT INTO `rooms_campsites`(
        `stores_id`,
        `name`, 
        `normal_price`, 
        `holiday_price`, 
        `night_price`,
        `tent`,
        `people`,
        `square_meters`,
        `introduction`
    ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
    )";

$stmt = $pdo->prepare($sql);

for ($i = 0; $i < 10; $i++) {
  $stores_id = rand(4, 25);

  shuffle($campName);
  $camp = $campName[0];

  shuffle($normal_price);
  $normal_p = $normal_price[0];

  shuffle($holiday_price);
  $holiday_p = $holiday_price[0];

  shuffle($night_price);
  $night_p = $night_price[0];

  $people = rand(1, 12);

  shuffle($square_meters);
  $sm = $square_meters[0];

  shuffle($campIntro);
  $campInf = $campIntro[0];

  $tent = rand(1, 10);


  $stmt->execute([
    $stores_id,
    $camp,
    $normal_p,
    $holiday_p,
    $night_p,
    $tent,
    $people,
    $sm,
    $campInf,
  ]);
}

echo json_encode([
  $stmt->rowCount(), // 影響的資料筆數
  $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
