<!-- all of the parse pages can be merged into the normal non-parse page I just didnt because I was new to PHP when I made this -->
<?php
session_start();
require "connect.php";
require "functions.php";
$topic_id = $_GET['topic_id'];
if ($_SESSION["username"]) {
  if($topic_id == null){
    header("Location: index.php");
  }
$creator = $_SESSION["username"];
$title = $_POST["reply_title"];
$body = $_POST["reply_body"];
$MIN_LENGTH_TITLE = 5;
$MAX_LENGTH_TITLE = 50;
$MIN_LENGTH_BODY = 25;
$MAX_LENGTH_BODY = 10000;
  if ($title == null || $body == null) {
        echo "Please fill in all of the fields.";
    } else {
            if (strlen($title) < $MIN_LENGTH_TITLE) {
                echo "Title must be at least 5 charcters long.";
            } else {
                if (strlen($body) < $MIN_LENGTH_BODY) {
                    echo "Body must be at least 15 characters long.";
                } else {
                    if (strlen($title) > $MAX_LENGTH_TITLE) {
                        echo "Title must be less than or equal to 50 characters long.";
                    } else {
                        if (hasInvalidCharactersPost($title)) {
                            echo "Title invalid characters.";
                        } else {
                            if (hasInvalidCharactersPost($body)) {
                                echo "Body invalid characters.";
                            } else {
                              if(hasCurses($title)){
                                echo 'Title has innapropriate words in it.';
                              } else {
                                if(hasCurses($body)){
                                  echo 'Body has innapropriate words in it.';
                                } else {
                                try {
                                    $stmt = $pdo->prepare(
                                        "INSERT INTO `replies`(`topic_id`, `reply_title`, `reply_content`, `reply_creator`) VALUES (:tid, :rpt, :rpc, :rpcr)"
                                    );
                                    $stmt->bindParam(
                                        ":tid",
                                        $topic_id,
                                        PDO::PARAM_STR
                                    );
                                    $stmt->bindParam(
                                        ":rpt",
                                        $title,
                                        PDO::PARAM_STR
                                    );
                                    $stmt->bindParam(
                                        ":rpc",
                                        $body,
                                        PDO::PARAM_STR
                                    );
                                    $stmt->bindParam(
                                        ":rpcr",
                                        $creator,
                                        PDO::PARAM_STR
                                    );

                                    if ($stmt->execute()) {
                                        $id_req = "SELECT * FROM replies WHERE reply_title = :title";
                                        $id_check = $pdo->prepare($id_req);
                                        $id_check->bindParam(
                                            ":title",
                                            $title,
                                            PDO::PARAM_STR
                                        );
                                        if($id_check->execute()) {
                                          $row_u = $id_check->fetch(PDO::FETCH_ASSOC);
                                          echo "Sucessfully created reply.";
                                          echo '<br/><a href="topic.php?id='.$topic_id.'#id='.$row_u['reply_id'].'">Click here to view topic</a>';
                                        }
                                    } else {
                                        echo "Unable to create topic try again later.<br/>";
                                    }
                                } catch (PDOException $err) {
                                    echo "Connection failed: " .
                                        $err->getMessage();
                                }
                            }
                          }
                        }
                      }
                    }
                }
            }
        }
    } else {
      header("Location: index.php");
    }
?>
