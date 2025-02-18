<?php
require __DIR__ . '/config/pdo-connect.php';


$card = isset($_GET['rooms_campsites_id']) ? intval($_GET['rooms_campsites_id']) : 0;
$sid = isset($_GET['stores_id']) ? intval($_GET['stores_id']) : 0;


if (!empty($card)) {
    $sql = " DELETE FROM `rooms_campsites` WHERE rooms_campsites_id = $card ";
    $pdo->query($sql);  //執行
}


header('Location: edit_stores_commodity.php?stores_id=' . $sid);
