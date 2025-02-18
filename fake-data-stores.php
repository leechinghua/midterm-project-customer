<?php
// exit; # 結束 php 程式
require __DIR__ . '/config/pdo-connect.php';


$cities = ["臺北市", "新北市", "桃園市", "臺中市", "臺南市", "高雄市", "新竹縣", "苗栗縣", "彰化縣", "南投縣", "雲林縣", "嘉義縣", "屏東縣", "宜蘭縣", "花蓮縣", "臺東縣", "澎湖縣", "金門縣", "連江縣", "基隆市", "新竹市", "嘉義市"];

$adjectives = ["美麗的", "寧靜的", "宏偉的", "壯麗的", "迷人的", "神秘的", "清新的", "和平的", "舒適的", "恬靜的", "蔚藍的", "翠綠的", "青蔥的", "清澈的", "純淨的", "明亮的", "溫暖的", "溫馨的", "熱情的", "活潑的"];

$firsts = ["露營地A", "露營地B", "露營地C", "露營地D", "露營地E", "露營地F", "露營地G", "露營地H", "露營地I", "露營地J", "露營地K", "露營地L", "露營地M", "露營地N", "露營地O", "露營地P", "露營地Q", "露營地R", "露營地S", "露營地T", "露營地U", "露營地V", "露營地W", "露營地X", "露營地Y", "露營地Z"];

// 生成30個露營地名稱
$camping_names = [];
foreach ($adjectives as $adjective) {
  foreach ($firsts as $first) {
    $camping_names[] = $adjective . $first;
  }
}
$selected_names = array_rand($camping_names, 25);

$sql = "INSERT INTO `stores`(
        `owners_id`, 
        `name`, 
        `mobile`, 
        `address`,
        `longitude`,
        `latitude`,
        `altitude`,
        `update_time`
    ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        NOW()
    )";

$stmt = $pdo->prepare($sql);

foreach ($selected_names as $name_index) {
  $owners_id = rand(1, 25);
  $mobile = '0918' . rand(100000, 999999);
  $longitude = rand(120.170000, 121.949999) . "E";
  $latitude = rand(21.960000, 25.279999) . "N";
  $altitude = rand(200, 1399) . "m";
  $city = $cities[array_rand($cities)];

  $stmt->execute([
    $owners_id,
    $camping_names[$name_index],
    $mobile,
    $city,
    $longitude,
    $latitude,
    $altitude,
  ]);
}


// for ($i = 0; $i < 25; $i++) {

//   $email = 'mail' . rand(10000, 99999) . '@test.com';
//   $mobile = '0918' . rand(100000, 999999);

//   $owners_id = rand(1, 52);
//   $longitude = rand(120.170000, 121.949999) . "E";
//   $altitude = rand(21.960000, 25.279999) . "N";

//   shuffle($cities);
//   $city = $cities[0];

//   $stmt->execute([
//     $owners_id,

//     $mobile,
//     $city,
//     $longitude,
//     $altitude,
//   ]);
// }

echo json_encode([
  $stmt->rowCount(), // 影響的資料筆數
  $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
