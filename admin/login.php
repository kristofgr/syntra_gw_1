<?php
require('ENV.php');
require('includes/db.inc.php');
session_start();

if (isset($_SESSION['uid']) && $_SESSION['username']) {
  header("Location: index.php");
  exit;
}

$error = false;

if (isset($_POST['username']) && isset($_POST['password'])) {
  $user = isValidLogin($_POST['username'], $_POST['password']);
  if ($user) {
    $_SESSION['uid'] = $user->id;
    $_SESSION['username'] = $user->username;
    header("Location: index.php");
    exit;
  } else {
    $error = true;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin login</title>
  <?php include("includes/cs.inc.php"); ?>
</head>

<body>

  <div class="container">
    <h1>Admin login</h1>

    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        Incorrect login.
      </div>
    <?php endif; ?>

    <form method="post" action="login.php">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= @$_POST['username']; ?>">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>

</html>