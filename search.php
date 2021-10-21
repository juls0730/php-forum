<!---This page is currently unused but feel free to actually make it functional it mostly works i think though--->
<?php
session_start();
include "connect.php";
include "header.php";
include "header_forum.php";
$search = $_POST['search'];
$seach = "SELECT * FROM topics WHERE topic_name = :search";
$parse = $pdo->prepare($seach);
$parse->bindValue(':search', $search);
if ($parse->execute()){
    $total = $parse->rowCount();
        if ($total == 0) {
            echo "No topics found.";
        } else {
            echo '<center>';
            echo '<div class="table-responsive" style="width:85%;">';
        echo '<table class="table table-bordered">';
          echo '<thead>';
            echo '<tr>';
              echo '<th scope="col" style="width:3%">id</th>';
              echo '<th scope="col" style="width:7%">Title</th>';
              echo '<th scope="col" style="width:5%">Views</th>';
              echo '<th scope="col" style="width:7%">Creator</th>';
              echo '<th scope="col" style="width:10%">Date Created</th>';
            echo '</tr>';
          echo '</thead>';
        echo '</center>';
            echo "<tbody>";
        while ($rowCount = $parse->fetch(PDO::FETCH_ASSOC)) {
                $id = $rowCount["topic_id"];
                echo '<tr><th scope="row">' . $id . "</th>";
                echo "<td><a href=topic.php?id=" .
                    $id .
                    " class='underline'>" .
                    $rowCount["topic_name"] .
                    "</td>";
                echo "<td>" . $rowCount["views"] . "</td>";
                echo "<td>" . $rowCount["topic_creator"] . "</td>";
                echo "<td>" . $rowCount["date"] . "</td></tr>";
            }
            echo "</tbody>";
        }
}
?>