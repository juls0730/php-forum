<?php
session_start();
require "connect.php";
$id = $_GET['id'];
if ($_SESSION["username"]) {
  if($id == null){
    header("Location: index.php");
  } ?>
<html>
  <head>
    <title>Topics</title>
  </head>
  <?php require "header.php"; ?>
  <?php require "header_forum.php"; ?>
  <body>
    <center>
      <div style="word-wrap: break-word;">
        <?php if($id){
          try{
            $id_req = "SELECT * FROM topics WHERE topic_id = :id";
            $id_check = $pdo->prepare($id_req);
            $id_check->bindParam(":id", $id, PDO::PARAM_STR);
            if ($id_check->execute()) {
                $row = $id_check->fetch(PDO::FETCH_ASSOC);
                $creator = $row['topic_creator'];
                try{
                  $user_req = "SELECT * FROM users WHERE username = :username";
                  $user_check = $pdo->prepare($user_req);
                  $user_check->bindParam(":username", $creator, PDO::PARAM_STR);
                  if($user_check->execute()){
                    $row_2 = $user_check->fetch(PDO::FETCH_ASSOC);
                    echo '<p class="text-xl">By: <a class="underline" href="profile.php?id='.$row_2['id'].'">'.$creator.'</a></p>';
                    echo '<p>Date Created: '.$row['date'];
                    echo '<h1 class="text-4xl">'.$row['topic_name'].'</h1>';
                    echo '<p>'.$row['topic_content'].'</p>';
                    echo '<hr class="post"/>';
                  }
                } catch (PDOException $errr) {
                    echo "Connection failed: " . $errr->getMessage();
                }
              }
            } catch (PDOException $err) {
                echo "Connection failed: " . $err->getMessage();
            }
          }
        ?>
      </div>
      <?php echo '<a href="reply.php?topic_id='.$row['topic_id'].'"><button type="button" class="btn btn-primary">Reply</button></a>'; ?>
      <div style="padding-bottom:10px;">
      </center>
        <?php
        $quer = "SELECT * FROM replies WHERE topic_id = :topic_id";
        $check = $pdo->prepare($quer);
        $check->bindParam(
            ":topic_id",
            $id,
            PDO::PARAM_STR
        );
        if($check->execute()){
          while($row_re = $check->fetch(PDO::FETCH_ASSOC)){
            $repp = "SELECT * FROM users WHERE username = :username";
            $repl = $pdo->prepare($repp);
            $repl->bindParam(
                ":username",
                $row_re['reply_creator'],
                PDO::PARAM_STR
            );
            if($repl->execute()){
              $row_cre = $repl->fetch(PDO::FETCH_ASSOC);
              echo '<div id="#id-'.$row_re['reply_id'].'" style="border: 1px solid;">';
              echo '<p>By: <a class="underline" href=profile.php?id='.$row_cre['id'].'>'.$row_re['reply_creator'].'</a> |On: '.$row_re['date'].'</p>';
              echo "<h5>" . $row_re['reply_title'] . "</h5>";
              echo "<p>" . $row_re['reply_content'] . "</p>";
              echo '</div>';
            }
          }
        }
        ?>
      </div>
  </body>
</html>
<?php
} else {header("Location: login.php");}
?>
