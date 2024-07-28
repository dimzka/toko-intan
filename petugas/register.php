<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="register.php" class="h1"><b>Register</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Create a new account</p>

      <form action="config/register.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Name" name="nama" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="jabatan">Jabatan</label>
          <select id="jabatan" name="jabatan" class="form-control" required>
            <option value="" disabled selected>Select Jabatan</option>
            <option value="Penjualan">Penjualan</option>
            <option value="Admin">Admin</option>
            <option value="Pemilik">Pemilik</option>
          </select>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" name="TblRegister" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>
      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="login.php" class="text-center">Have account</a>
      </p>
      <?php
      if (isset($_GET["error"])) {
          $error = $_GET["error"];
          if ($error == 1)
              echo "<div class='alert alert-danger'>Username or Email already exists</div>";
          else if ($error == 2)
              echo "<div class='alert alert-danger'>An unknown error occurred. Please try again.</div>";
          else if ($error == 5)
              echo "<div class='alert alert-danger'>Please fill out the form.</div>";
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
