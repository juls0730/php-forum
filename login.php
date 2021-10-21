<?php
session_start();
require "connect.php";
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$username = $_POST['username'];
$password = $_POST['password'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($username)) {
    $nameErr = "Name is required";
  } else {
    if (empty($password)) {
      $passErr = "Password is required";
    } else {
      try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        if ($stmt->execute()) {
          $total = $stmt->rowCount();
          $row = $stmt->fetch(PDO::FETCH_NUM);
          $hased_pw = $row[2];
          if ($total == !0) {
            if (crypt($password, $hased_pw) == $hased_pw) {
              $_SESSION['username'] = $username;
              header("Location: index.php");
          } else {
            $passErr = "Password does not match Username.";
          }
        } else {
          $userErr = "Username Not found.";
        }
        } else{
            echo "An error has occoured with the database please try again.";
        }
      } catch (PDOException $err) {
        echo "Connection failed: " . $err->getMessage();
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require "header.php"; ?>
    <style>
        .error {color: #000000;}
    </style>
    <title>Login to an account</title>
    <link href="/CSS/pace-theme-loading-bar.css" rel="stylesheet" />
  </head>
  <body class="forum-inputs">
    <center>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="login" method="POST" onSubmit="return cForm()">
        <div>
          <div class="forum-div frosted border border-dark align-middle rounded-3">
            Username: <input class="form-control input" type="text" name="username" placeholder="Username" />
            <span class="error"><?php echo $userErr;?></span>
            <br />
            Password: <input class="form-control input" type="password" name="password" placeholder="Password" />
            <span class="error"><?php echo $passErr;?></span>
            <br />
            <input class="form-control input" type="submit" name="submit" value="Login" /> or <a href="register.php">Register</a>
          </div>
          <div>
            <p class="adjust-text bottom-left cco-text" style="font-size: 0.9rem; font-style: italic;">Images provided by unsplash</p>
          </div>
        </div>
      </form>
      <div id="error"></div>
    </center>
  </body>
  <script type="text/javascript">
    function cForm() {
      if (document.login.password.value == "") {
        Swal.fire("Oh No!", "The Password field must be filled in!", "error");
        document.login.password.focus();
        return false;
      } else {
        if (document.login.username.value == "") {
          Swal.fire("Oh No!", "The Username field must be filled in!", "error");
          document.login.username.focus();
          return false;
        }
      }
    }
  </script>
</html>
<?php
if($_GET['changed_pass'] == true){
    echo '<script>Swal.fire("Yay!", "The Password Was changed successfully!", "success");</script>';
} else{
}
?>