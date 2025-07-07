<?php
include_once 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/* Already logged in? Redirect to dashboard */
if (isset($_SESSION['login_id'])) {
  header('location:dashboard.php');
  exit;
}
/* Handle Login */
if (isset($_POST['signin'])) {
  $username = $_POST['email']; // Input field 'email' used for username
  $password = $_POST['password'];

  $sql_select = "SELECT * FROM `login` WHERE `username`='$username' AND `password`='$password'";
  $data = mysqli_query($conn, $sql_select);
  $data_count = mysqli_num_rows($data);

  if ($data_count > 0) {
    $row = mysqli_fetch_assoc($data);
    $_SESSION['login_id'] = $row['id'];
    header('location:dashboard.php');
    exit;
  } else {
    $sql_select_all = "SELECT * FROM `login`";
    $data_all = mysqli_query($conn, $sql_select_all);
    $row = mysqli_fetch_assoc($data_all);

    if (!$row) {
      echo "<div style='text-align:center;color:red;'>No admin registered. Please create one first.</div>";
    } elseif ($row['username'] != $username && $row['password'] != $password) {
      echo "<div style='text-align:center;color:red;'>Username and Password are incorrect.</div>";
    } elseif ($row['username'] != $username) {
      echo "<div style='text-align:center;color:red;'>Username is incorrect.</div>";
    } else {
      echo "<div style='text-align:center;color:red;'>Password is incorrect.</div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login | AdminLTE</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- iCheck Bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">

  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b>Panel</a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="index.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <button type="submit" class="btn btn-primary btn-block" name="signin">Sign In</button>
            </div>
            <div class="col-6 text-right">
              <a href="forgot.php" style="color: black; font-size: 14px;">Forgot Password?</a>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

</body>

</html>