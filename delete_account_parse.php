<?php
session_start();
require "connect.php";
require "functions.php";
$username = $_SESSION["username"];
$password = $_POST["password"];
$MIN_LENGTH = 8;
$sql = "SELECT * FROM users WHERE username = :check_username";
$count = $pdo->prepare($sql);
$count->bindParam(":check_username", $username, PDO::PARAM_STR);
if ($count->execute()) {
    $row = $count->fetch(PDO::FETCH_ASSOC);
    if ($password == null) {
        echo "Please fill in all of the fields.";
    } else {
        if (crypt($password, $row['password']) == $row['password']) {
          $del = "DELETE FROM users WHERE username = :username";
          $dele = $pdo->prepare($del);
          $dele->bindParam(":username", $username, PDO::PARAM_STR);
          if ($dele->execute()) {
              echo "Sucessfully Deleted account.";
              session_destroy();
          } else {
              echo "Unable to Change Password Please try again.<br/>";
          }
        } else {
          echo 'Password does not match username.<br/>';

        }
      }
    }
?>
