<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="forgot-password.php" class="h1"><b>Forgot Password</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Enter your email to reset your password</p>
      <form action="config/forgot-password.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="TblReset" class="btn btn-primary btn-block">Reset Password</button>
          </div>
        </div>
      </form>
      <p class="mb-0">
        <a href="login.php" class="text-center">Have account</a>
      </p>
      <?php
      if (isset($_GET["error"])) {
          $error = $_GET["error"];
          if ($error == 1)
              echo "<div class='alert alert-danger'>Failed to send reset link. Please try again.</div>";
          else if ($error == 2)
              echo "<div class='alert alert-danger'>Email not found.</div>";
          else if ($error == 3)
              echo "<div class='alert alert-danger'>An unknown error occurred. Please try again.</div>";
      } else if (isset($_GET["success"])) {
          echo "<div class='alert alert-success'>Reset link has been sent to your email.</div>";
      }
      ?>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="app/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="app/dist/js/adminlte.min.js"></script>
</body>
</html>
