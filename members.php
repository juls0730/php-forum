<?php
session_start();
require "connect.php";
if ($_SESSION["username"]) { ?>
<html>
  <head>
    <title>HomePage</title>
  </head>
  <?php require "header.php"; ?>
  <?php require "header_forum.php";
  $sql = "SELECT * FROM users";
  $record = $pdo->prepare($sql);
  if($record->execute()){
    echo '<center>';
    echo '<h1 class="text-4xl">Members</h1>';
    while($result = $record->fetch(PDO::FETCH_ASSOC)){
      echo '<a href="/profile.php/?id=' . $result['id'] . '" class="underline">'.$result['username'].'</a><br/>';
    }
    echo '</center>';
  }
  ?>
  <body>
  </body>
</html>
<?php if ($_GET["action"] == logout) {
    session_destroy();
    header("Location: login.php");
}} else {echo "<a href=login.php>Please sign in</a>";}
?>
