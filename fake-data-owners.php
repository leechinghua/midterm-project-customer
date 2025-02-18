<?php
// exit; # 結束 php 程式
require __DIR__ . '/config/pdo-connect.php';

$lasts = ["何", "傅", "劉", "吳", "呂", "周", "唐", "孫", "宋", "張", "彭", "徐", "於", "曹", "曾", "朱", "李", "林", "梁", "楊", "沈", "王", "程", "羅", "胡", "董", "蕭", "袁", "許", "謝", "趙", "郭", "鄧", "鄭", "陳", "韓", "馬", "馮", "高", "黃"];

$firsts = ["冠廷", "冠宇", "宗翰", "家豪", "彥廷", "承翰", "柏翰", "宇軒", "家瑋", "冠霖", "雅婷", "雅筑", "怡君", "佳穎", "怡萱", "宜庭", "郁婷", "怡婷", "詩涵", "鈺婷"];

$member_status = ["1"];

$id2 = ["1", "2"];

$gender = ["male", "female"];

$cities = ["臺北市", "新北市", "桃園市", "臺中市", "臺南市", "高雄市", "新竹縣", "苗栗縣", "彰化縣", "南投縣", "雲林縣", "嘉義縣", "屏東縣", "宜蘭縣", "花蓮縣", "臺東縣", "澎湖縣", "金門縣", "連江縣", "基隆市", "新竹市", "嘉義市"];

$sql = "INSERT INTO `owners`(
        `name`,
        `gender`, 
        `password`, 
        `birthday`,
        `email`,
        `id_card`,
        `mobile`,
        `address`,
        `bank_account`,
        `member_status`,
        `created_at`
    ) VALUES (
        ?,
        ?,
        ?,
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

for ($i = 0; $i < 25; $i++) {
  shuffle($lasts);
  shuffle($firsts);
  $name = $lasts[0] . $firsts[0];
  $email = 'mail' . rand(10000, 99999) . '@test.com';
  $mobile = '0918' . rand(100000, 999999);
  $t = rand(strtotime('1985-01-01'), strtotime('2000-01-01'));
  $birthday =  date('Y-m-d', $t);
  $bank_account = rand(10000000000000, 99999999999999);
  $password = password_hash(rand(1000, 9999), PASSWORD_DEFAULT);

  shuffle($id2);
  $id = "D" . $id2[0] . rand(10000000, 99999999);

  shuffle($gender);
  $sex = $gender[0];

  shuffle($cities);
  $city = $cities[0];

  shuffle($member_status);
  $ms = $member_status[0];



  $stmt->execute([
    $name,
    $sex,
    $password,
    $birthday,
    $email,
    $id,
    $mobile,
    $city,
    $bank_account,
    $ms,
  ]);
}

echo json_encode([
  $stmt->rowCount(), // 影響的資料筆數
  $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
