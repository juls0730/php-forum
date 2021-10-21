<?php
session_start();
if ($_SESSION["username"] == !null) { ?>
<html>
<head>
<?php require "header.php"; ?>
<title>Register an account</title>
</head>
<body class="forum-inputs">
 <center>
  <form action="delete_account_parse.php" name="register" method="POST" onSubmit="return cForm()">
   <div>
    <div class="forum-div frosted border border-dark align-middle rounded-3">
     Username is alread collected from the logged in user.
     <br />
     <br/>
     Password: <input class="form-control input" type="password" name="password" placeholder="Password" /> <br />
     <input class="form-control input" type="submit" name="submit" value="Delete Account" /> or <a href="account.php">Return</a>
    </div>
    <p class="bottom-left cco-text" style="font-size: 0.9rem; font-style: italic;">
     <a class="cco-links" href="https://www.flickr.com/photos/oatsy40/14291892698/">"Mountains"</a><span> by <a class="cco-links" href="https://www.flickr.com/photos/oatsy40/">Oatsy40</a></span> is licensed under
     <a class="cco-links" href="https://creativecommons.org/licenses/by/2.0/" style="margin-right: 5px;">CC BY 2.0</a>
    </p>
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
