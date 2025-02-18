<?php

# 用來篩選檔案類型, 並決定副檔名
$extMap = [
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
  'image/webp' => '.webp',
];

# 表單裡上傳多個檔案的欄位名稱
$fieldName = 'photos';

# 放檔案的資料夾
$dir = __DIR__ . './uploads/blog_img/';

# 存放上傳後的檔名
$files = [];



if (
  !empty($_FILES) # 要有上傳的檔案
  and
  !empty($_FILES[$fieldName]) # 要有指定的欄位名稱
  and
  is_array($_FILES[$fieldName]['name']) # 有上傳多個檔案
) {
  foreach ($_FILES[$fieldName]['name'] as $k => $name) {
    if ($_FILES[$fieldName]['error'][$k] === 0) {
      # 檔案上傳沒有錯誤
      $type = $_FILES[$fieldName]['type'][$k];
      if (!empty($extMap[$type])) {
        # 有對應到副檔名
        $randomNumber = mt_rand(97, 122); // 隨機生成97到122之間的數字（ASCII碼中的小寫字母）
        $randomLetter = chr($randomNumber);
        $currentTimestamp = time();
        $dateString = date('YmdHis', $currentTimestamp);
        
        $filename = $randomLetter . mt_rand(0000, 9999) . $dateString; # 主檔名
        $ext = $extMap[$type]; # 副檔名
        $file = $dir . $filename . $ext; # 到搬動到哪裡
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$k], $file)) {
          $files[] = $filename . $ext;
        }
      }
    }
  }
}
header('Content-Type: application/json');
echo json_encode(['files' => $files]);
