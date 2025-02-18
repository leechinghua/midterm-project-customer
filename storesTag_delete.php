<?php
require __DIR__ . '/config/pdo-connect.php';


$tag = isset($_GET['store_tag_id']) ? intval($_GET['store_tag_id']) : 0;
$sid = isset($_GET['stores_id']) ? intval($_GET['stores_id']) : 0;


if (!empty($tag)) {
    $sql = " DELETE FROM `stores_tag` WHERE store_tag_id = $tag ";
    $pdo->query($sql);  //執行
}


header('Location: edit_stores.php?stores_id=' . $sid);
