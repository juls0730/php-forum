<!-- the replies, topics created, and current score dont work -->
<?php
session_start();
require "connect.php";
if ($_SESSION["username"]) { ?>
<html>
  <head>
    <title>Profile Page</title>
  </head>
  <?php require "header.php"; ?>
  <?php
  require "header_forum.php";
  echo '<center>';
  if ($_GET["id"]) {
    $sql = "SELECT * FROM users WHERE id = :id";
    $check = $pdo->prepare($sql);
    $check->bindParam(":id", $_GET["id"], PDO::PARAM_STR);
    if ($check->execute()) {
      $total = $check->rowCount();
      $row = $check->fetch(PDO::FETCH_NUM);
      if ($total == 0) {
        echo 'ID not found.';
      } else {
        if ($check->execute()) {
          $total = $check->rowCount();
          $row = $check->fetch(PDO::FETCH_NUM);
          echo '<h1 class="">' . $row['1'] . '</h1><br/>';
          echo '<b>Replies: </b><i>' . $row['3'] . "</i><br/>";
          echo '<b>Topics Created: </b><i>' . $row['4'] . '</i><br/>';
          echo '<b>Current score: </b><i>' . $row['5'] . '</i><br/>';
        }
      }
    }
  } else {
    header("Location: index.php");
  }
  echo '</center>';
  ?>
  <body>
  </body>
</html>
<?php if ($_GET["action"] == logout) {
  session_destroy();
  header("Location: login.php");
}} else {echo "<a href=login.php>Please sing in</a>";}
?>
