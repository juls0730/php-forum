<?php
session_start();
require "connect.php";
$topic_id = $_GET['topic_id'];
if ($_SESSION["username"]) {
  if($topic_id == null){
    header("Location: index.php");
  }
  $idcheck = "SELECT * FROM topics WHERE topic_id = :id";
  $querr = $pdo->prepare($idcheck);
  $querr->bindParam(':id', $topic_id, PDO::PARAM_STR);
  if($querr->execute()){
      $count = $querr->rowCount();
      if($count == 0){
          echo "That topic doesn't exist!";
      }else {
         
?>
<html>
  <head>
    <title>Reply to a thread</title>
  </head>
  <?php require "header.php"; ?>
  <?php require "header_forum.php"; ?>
  <body>
    <form method="post" action="reply_parse.php?topic_id=<?php echo $topic_id; ?>">
      <center>
        <div class="post-div frosted-posts border border-dark rounded-3">
          <p class="post-text">Reply Title: </p><input class="form-control" placeholder="Title" type="text" name="reply_title"><br/>
          <p class="post-text">Body: </p><textarea class="post-textarea form-control" name="reply_body" placeholder="Body..." class="form-control"></textarea><br/>
          <input name="submit" type="submit" class="form-control" value="Post">
        </div>
      </center>
    </form>
  </body>
</html>

<?php
      }
  }
if ($_GET["action"] == logout) {
    session_destroy();
    header("Location: login.php");
}} else {
  header("Location: login.php");
}
?>
