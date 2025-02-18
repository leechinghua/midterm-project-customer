<?php

require __DIR__ .'/config/pdo-connect.php';

$ownersId = isset($_GET['owners_id']) ? intval($_GET['owners_id']) :0;

if(! empty($ownersId)) {
  $sql = "DELETE FROM owners WHERE owners_id=$ownersId";
  $pdo->query($sql);

}

$comeFrom = 'owners-list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
  $comeFrom = $_SERVER['HTTP_REFERER'];
}
header('Location: '. $comeFrom);

// TODO: 頁碼問題 會直接跳轉到第一頁