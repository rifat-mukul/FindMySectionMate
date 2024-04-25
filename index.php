<?php
session_start();
// echo var_dump(session_start());
// $session_expiration = 10;
// session_set_cookie_params($session_expiration);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location:login.php");
  // echo var_dump($_SESSION());

  exit;
}
if($_SESSION['loggedin'] < time()){
       header("location:logout.php");
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome - <?php echo $_SESSION['username'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php
  require 'partials/_nav.php';
  ?>
  <div class="container mt-3">

    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Well done! <?php echo $_SESSION['username'] ?></h4>
      <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
      <hr>
      <p class="mb-0">Whenever you need to, make sure to Logout. <a href="./logout.php" class="btn btn-danger" role="button">Logout</a>
      </p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
