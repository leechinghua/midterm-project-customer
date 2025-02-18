<?php

session_start();

if (isset($_SESSION["admin"])) {
  include __DIR__ . '/orders-delete-admin.php';
} else {
  include __DIR__ . '/orders-delete-superman.php';
}
