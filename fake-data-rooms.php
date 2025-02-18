<?php
// exit; # 結束 php 程式
require __DIR__ . '/config/pdo-connect.php';

$normal_price = ["2000", "1500", "1200", "1100", "1000"];

$holiday_price = ["3400", "3200", "2800", "2200", "2100"];

$night_price = ["900", "800"];

$square_meters = ["4m * 4m", "5m * 5m", "6m * 6m"];

$campName = ["小木屋A1", "小木屋A2", "小木屋A3", "小木屋A4", "木屋雅房A5", "木屋雅房A6", "木屋雅房A7", "木屋雅房A8"];

$campIntro = ["房間介紹"];

$sql = "INSERT INTO `rooms_campsites`(
        `stores_id`,
        `name`, 
        `normal_price`, 
        `holiday_price`, 
        `night_price`,
        `bed`,
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

  $bed = rand(1, 4);


  $stmt->execute([
    $stores_id,
    $camp,
    $normal_p,
    $holiday_p,
    $night_p,
    $bed,
    $people,
    $sm,
    $campInf,
  ]);
}

echo json_encode([
  $stmt->rowCount(), // 影響的資料筆數
  $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
