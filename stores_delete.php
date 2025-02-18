<?php
require __DIR__ . '/config/pdo-connect.php';

$sid = isset($_GET['stores_id']) ? intval($_GET['stores_id']) : 0;

if (!empty($sid)) {
    $sql = " DELETE FROM stores WHERE stores_id = $sid ";
    $pdo->query($sql);  //執行
}


$comeForm = 'stores.php';
//頁面有數值，就在該數值
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeForm = $_SERVER['HTTP_REFERER'];
}

header('Location: ' . $comeForm);
