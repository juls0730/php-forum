<?php
session_start();
require "connect.php";
if ($_SESSION["username"]) { ?>
<html>
  <head>
    <title>Post a new Thread</title>
  </head>
  <?php require "header.php"; ?>
  <?php require "header_forum.php"; ?>
  <body>
    <form method="post" action="post_parse.php">
      <center>
        <div class="post-div frosted-posts border border-dark rounded-3">
          <p class="post-text">Thread Name: </p><input class="form-control" placeholder="Title" type="text" name="thread_name"><br/>
          <p class="post-text">Body: </p><textarea class="post-textarea form-control" name="thread_body" placeholder="Body..." class="form-control"></textarea><br/>
          <input name="submit" type="submit" class="form-control" value="Post">
        </div>
      </center>
    </form>
  </body>
</html>
<?php if ($_GET["action"] == logout) {
    session_destroy();
    header("Location: login.php");
}} else {
  header("Location: login.php");
}
?>
