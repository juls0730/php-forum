<?php
session_start();
require "connect.php";
if ($_SESSION["username"]) { ?>
<html>
  <head>
    <title>HomePage</title>
  </head>
  <?php require "header.php"; ?>
  <?php require "header_forum.php"; ?>
  <?php
  $query = "SELECT * FROM users WHERE username = :username";
  $dets = $pdo->prepare($query);
  $dets->bindParam(":username", $_SESSION['username'], PDO::PARAM_STR);
  if ($dets->execute()) {
    $row = $dets->fetch(PDO::FETCH_NUM);
    $replies = $row['3'];
    $topics = $row['4'];
    $score = $row['5'];
    echo '<center>';
    echo '<h1 class="text-3xl">Logged in as '.$_SESSION['username'].'</h1>';
    echo '<p>Topics Created: '.$topics.'</p>';
    echo '<p>Repies: '.$replies.'</p>';
    echo '<p>Score: '.$score.'</p>';
    echo '<a  href="change_password.php"><button type="button" class="btn btn-primary">Change Password</button></a>';
    echo '<br/>';
    echo '<br/>';
    echo '<a  href="delete_account.php"><button type="button" class="btn btn-danger">Delete Account</button></a>';
    echo '</center>';
  } ?>
  <body>
  </body>
</html>
<?php if ($_GET["action"] == logout) {
    session_destroy();
    header("Location: login.php");
}} else{
  header("Location: login.php");
}
?>
