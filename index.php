<!-- the id and views dont work here either sadly -->
<?php
session_start();
require "connect.php";
if ($_SESSION["username"]) { ?>
<html>
  <head>
    <title>Home Page</title>
  </head>
  <?php require "header.php"; ?>
  <?php require "header_forum.php"; ?>
  <body>
    <center>
      <a href="post.php"><button type="button" class="btn btn-primary">Post Thread</button></a>
      <br/>
      <br/>
      <div class="table-responsive" style="width:85%;">
        <?php echo '<table class="table table-bordered">'; ?>
          <thead>
            <tr>
              <th scope="col" style="width:3%">id</th>
              <th scope="col" style="width:7%">Title</th>
              <th scope="col" style="width:5%">Views</th>
              <th scope="col" style="width:7%">Creator</th>
              <th scope="col" style="width:10%">Date Created</th>
            </tr>
          </thead>
        </center>
      </body>
    </html>
<?php
try {
    $quer = "SELECT * FROM topics";
    $check = $pdo->prepare($quer);

    if ($check->execute()) {
        $total = $check->rowCount();
        if ($total == 0) {
            echo "No topics found.";
        } else {
            echo "<tbody>";
            while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
                $id = $row["topic_id"];
                echo '<tr><th scope="row">' . $id . "</th>";
                echo "<td><a href=topic.php?id=" .
                    $id .
                    " class='underline'>" .
                    $row["topic_name"] .
                    "</td>";
                echo "<td>" . $row["views"] . "</td>";
                echo "<td>" . $row["topic_creator"] . "</td>";
                echo "<td>" . $row["date"] . "</td></tr>";
            }
            echo "<tbody>";
        }
    }
} catch (PDOException $err) {
    echo "Connection failed: " . $err->getMessage();
}
echo "</table>";
echo "<tr><td></tr></td>";
echo "</div>";
if ($_GET["action"] == logout) {
    session_destroy();
    header("Location: login.php");
}
} else {header("Location: login.php");}
?>
