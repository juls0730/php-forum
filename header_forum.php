<?php
if ($_SESSION["username"]) { ?>
<!DOCTYPE html>
  <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light shadow p-3 mb-5 bg-body rounded">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Julians Forum</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/account.php"><span class="bi bi-gear-fill"></span> My Account</a></li>
            <li><a class="dropdown-item" href="/members.php"><span class="bi bi-people-fill"></span> Members</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout.php"><span class="bi bi-box-arrow-right"></span> Logout</a></li>
          </ul>
        </li>
        </ul>
        <form class="d-flex" method="POST" action="search.php">
            <input class="form-control me-2" type="text" name="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
         </form>
      </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>


<?php } else {header("Location: login.php");}
?>
