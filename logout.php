<?php
session_start();
require "connect.php";
if ($_SESSION["username"]) {
  session_destroy();
  header("Location: login.php");
} else{
  header("Location: login.php");
}
?>
