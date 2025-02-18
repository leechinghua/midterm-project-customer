<?php
require __DIR__ . '/config/pdo-connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!empty($id)) {
  $sql = "DELETE FROM comment  WHERE id=$id";
  $pdo->query($sql);
}
$_SERVER['HTTP_REFERER'];
$comeFrom ="list.php"; //預設值
if(! empty($_SERVER['HTTP_REFERER'])){
  $comeFrom = $_SERVER['HTTP_REFERER'];
}
header("Location: comment-list.php");

