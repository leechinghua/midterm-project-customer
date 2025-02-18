<?php

session_start();

if(isset($_SESSION["admin"])){
  include __DIR__ .'/owners-edit-admin.php';
}else{
  include __DIR__ .'/login.php';

}