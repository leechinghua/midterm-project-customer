<?php

session_start();

if(isset($_SESSION["admin"])){
  include __DIR__ .'/owners-delete-admin.php';
}else{
  include __DIR__ .'/owners-delete-superman.php';
}