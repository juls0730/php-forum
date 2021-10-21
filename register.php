<!-- ah yes, the classic spaghetti code checking phase, I would reccomend using switches if i were you -->
<?php
require "connect.php";
require "functions.php";
require "header.php";
$nameErr = $passErr = $capErr = "";
$captcha = $_POST['g-recaptcha-response'];
$secretKey = "CAPTCHA_SECRET";
$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
$response = file_get_contents($url);
$responseKeys = json_decode($response, true);
$username = $_POST["username"];
$password = $_POST["password"];
$crypt_pass = encrypt($password);
$MIN_LENGTH = 8;
$MAX_LENGTH = 50;
$sql = "SELECT * FROM users WHERE username = :check_username";
$count = $pdo->prepare($sql);
$count->bindParam(":check_username", $username, PDO::PARAM_STR);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($count->execute()) {
    $total = $count->rowCount();
    $row = $count->fetch(PDO::FETCH_NUM);
    if ($total == 0) {
      if ($password == null) {
        $passErr = 'Password is required.';
      } else {
        if ($username == null) {
          $nameErr = "Username is required";
        } else {
          if (strlen($password) < $MIN_LENGTH) {
            $passErr = "Password must be at least 8 charcters long.";
          } else {
            if (strlen($username) > $MAX_LENGTH) {
              $nameErr = "Username must be at most 50 characters long.";
            } else {
              if (hasInvalidCharacters($username)) {
                $nameErr = "Username has invalid characters.";
              } else {
                if (hasCurses($username)) {
                  $nameErr = "Username has innapropriate words.";
                } else {
                  if ($responseKeys["success"]) {
                    try {
                      $stmt = $pdo->prepare("INSERT INTO `users`(`username`, `password`) VALUES (:username, :password)");
                      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
                      $stmt->bindParam(":password", $crypt_pass, PDO::PARAM_STR);

                      if ($stmt->execute()) {
                        echo "<center>";
                        echo "<div style='background-color:white;'>";
                        echo "Sucessfully registered as: " . $username;
                        echo "<br/><a href=login.php>click here to Login</a>";
                        echo "</div>";
                        echo "</center>";
                      } else {
                        $passErr = "Unable to Register Please try again.<br/>";
                      }
                    } catch (PDOException $err) {
                      echo "Connection failed: " . $err->getMessage();
                    }
                  } else {
                    $capErr = 'please fininsh the captcha';
                  }
                }
              }
            }
          }
        }
      }
    } else {
      $nameErr = "Username Already Taken Please try another.";
    }
  }
}
?>
<!DOCTYPE HTML>
<html>
 <head>
     <style>
        .error {color: #000000;}
    </style>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
  <?php require "header.php"; ?>
  <title>Register an account</title>
 </head>
 <body class="forum-inputs">
  <center>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="register" method="POST" onSubmit="return cForm()">
    <div>
     <div class="forum-div frosted border border-dark align-middle rounded-3">
      Username: <input class="form-control input" type="text" name="username" placeholder="Username" />
      <span class="error"><?php echo $nameErr;?></span>
      <br />
      Password: <input class="form-control input" type="password" name="password" placeholder="Password" />
      <span class="error"><?php echo $passErr;?></span>
      <br />
      <div class="g-recaptcha" data-sitekey='6LeuYGkaAAAAAL2yGReUjj9SKRsTcab-7pwZvQFz'></div>
      <span class="error"><?php echo $capErr;?></span>
      <br/>
      <input class="form-control input" type="submit" name="submit" value="Register" /> or <a href="login.php">Login</a>
     </div>
     <p class="bottom-left cco-text" style="font-size: 0.9rem; font-style: italic;">Images provided by unsplash</p>
    </div>
   </form>
  </center>
 </body>
 <script type="text/javascript">
  function cForm() {
   if (document.register.password.value == "") {
     Swal.fire(
       'Oh No!',
       'The Password field must be filled in!',
       'error'
     )
    document.register.password.focus();
    return false;
   } else {
    if (document.register.username.value == "") {
      Swal.fire(
        'Oh No!',
        'The Username field must be filled in!',
        'error'
      )
     document.register.username.focus();
     return false;
    }
   }
  }
 </script>
</html>
