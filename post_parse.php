<?php
session_start();
require "connect.php";
require "functions.php";
$creator = $_SESSION["username"];
$title = $_POST["thread_name"];
$body = $_POST["thread_body"];
$MIN_LENGTH_TITLE = 5;
$MAX_LENGTH_TITLE = 50;
$MIN_LENGTH_BODY = 50;
$MAX_LENGTH_BODY = 10000;
$sql = "SELECT * FROM topics WHERE topic_name = :check_title";
$count = $pdo->prepare($sql);
$count->bindParam(":check_title", $title, PDO::PARAM_STR);
if ($count->execute()) {
    $total = $count->rowCount();
    $row = $count->fetch(PDO::FETCH_NUM);

    if ($title == null || $body == null) {
        echo "Please fill in all of the fields.";
    } else {
        if ($total == 0) {
            if (strlen($title) < $MIN_LENGTH_TITLE) {
                echo "Title must be at least 5 charcters long.";
            } else {
                if (strlen($body) < $MIN_LENGTH_BODY) {
                    echo "Body must be at least 50 characters long.";
                } else {
                    if (strlen($title) > $MAX_LENGTH_TITLE) {
                        echo "Title must be less than or equal to 50 characters long.";
                    } else {
                      if (strlen($body) > $MAX_LENGTH_BODY) {
                        echo "Body must be less than or equal to 10000 characters long.";
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
                                        "INSERT INTO `topics`(`topic_name`, `topic_content`, `topic_creator`) VALUES (:tpn, :tpc, :tpcr)"
                                    );
                                    $stmt->bindParam(
                                        ":tpn",
                                        $title,
                                        PDO::PARAM_STR
                                    );
                                    $stmt->bindParam(
                                        ":tpc",
                                        $body,
                                        PDO::PARAM_STR
                                    );
                                    $stmt->bindParam(
                                        ":tpcr",
                                        $creator,
                                        PDO::PARAM_STR
                                    );

                                    if ($stmt->execute()) {
                                        $id_req = "SELECT * FROM topics WHERE topic_name = :title";
                                        $id_check = $pdo->prepare($id_req);
                                        $id_check->bindParam(
                                            ":title",
                                            $title,
                                            PDO::PARAM_STR
                                        );
                                        if($id_check->execute()) {
                                          $row_u = $id_check->fetch(PDO::FETCH_ASSOC);
                                          echo "Sucessfully created topic.";
                                          echo '<br/><a href="topic.php?id='.$row_u['topic_id'].'">Click here to view topic</a>';
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
            echo "Thread with that name already exists.";
        }
    }
}
?>
