<!-- ah yes, the calsic spaghetti code checking phase, I would reccomend using switches if i were you -->
<?php
session_start();
require "connect.php";
require "functions.php";
$newPassErr = $passErr = $capErr = "";
    $username = $_SESSION["username"];
    $password = $_POST["password"];
    $new_pass = $_POST["newpass"];
    $MIN_LENGTH = 8;
    $sql = "SELECT * FROM users WHERE username = :check_username";
    $count = $pdo->prepare($sql);
    $count->bindParam(":check_username", $username, PDO::PARAM_STR);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($count->execute()) {
        $row = $count->fetch(PDO::FETCH_NUM);
        $hased_pw = $row["2"];

        if (empty($new_pass)) {
            $newPassErr = "Please fill in the password field.";
        } else {
            if(empty($password)){
	$passErr = "Please fill in the password field";
           }
            if (strlen($new_pass) < $MIN_LENGTH) {
                $newPassErr = "New Password must be at least 8 charcters long.";
            } else {
                if (crypt($password, $hased_pw) == $hased_pw) {
                    $new_hashed_pass = encrypt($new_pass);
                    try {
                        $stmt = $pdo->prepare(
                            "UPDATE `users` SET `password` = :password WHERE username = :username"
                        );
                        $stmt->bindParam(
                            ":password",
                            $new_hashed_pass,
                            PDO::PARAM_STR
                        );
                        $stmt->bindParam(
                          ":username",
                          $username,
                          PDO::PARAM_STR
                        );

                        if ($stmt->execute()) {
                            header("Location: login.php?changed_pass=true");
                        } else {
                            $newPassErr = "Unable to Change Password Please try again.<br/>";
                        }
                    } catch (PDOException $err) {
                        $newPassErr = "Connection failed: " . $err->getMessage();
                    }
                } else {
                    $passErr = "Password Does not match username.";
                }
            }
        }
    }
}
if ($_SESSION["username"] == !null) { ?>
<html>
<head>
<?php require "header.php"; ?>
<title>Change your account password</title>
</head>
    <body class="forum-inputs">
      <center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div>
            <div class="forum-div frosted border border-dark align-middle rounded-3">
              Current Password: <input class="form-control input" type="password" name="password" placeholder="Current Password">
              <span class="error"><?php echo $passErr;?></span>
              <br/>
              New Password: <input class="form-control input" type="password" name="newpass" placeholder="New Password">
              <span class="error"><?php echo $newPassErr;?></span>
              <br/><input class="form-control input" type="submit" name="submit" value="Change Password">
            </div>
            <p class="bottom-left cco-text" style="font-size: 0.9rem;font-style: italic;">Images provided by unsplash</p>
          </div>
        </form>
      </center>
    </body>
</html>
<?php

}else{
  header("Location: login.php");
}
?>

