<!DOCTYPE html>
<html lang="en">

<?php 

include('head.php');

// Fungsi untuk memeriksa apakah pengguna sudah login
function check_login() {
  session_start();
  if (!isset($_SESSION['Id_pengguna'])) {
      header('Location: login.php');
      exit();
  }
}

// Panggil fungsi cek login
check_login();
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <?php include('navbar.php')?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php?page=dashboard" class="brand-link">
      <span class="brand-text font-weight-light">DASHBOARD</span>
    </a>

    <!-- Sidebar -->
    <?php include('sidebar.php')?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'dashboard':
        include('dashboard.php');
        break;
    case 'data-admin':
        include('data-admin.php');
        break;
    case 'data-pelanggan':
        include('data-pelanggan.php');
        break;
    case 'data-transaksi':
        include('data-transaksi.php');
        break;
    case 'data-rekomendasi':
        include('data-rekomendasi.php');
        break;
    case 'data-keluhan':
        include('data-keluhan.php');
        break;
    case 'data-kategori':
        include('data-kategori.php');
        break;
    case 'data-produk':
        include('data-produk.php');
        break;
    case 'tambah-admin':
        include('tambah/tambah-admin.php');
        break;
    case 'edit-admin':
        include('edit/edit-admin-form.php');
        break;
    case 'hapus-admin':
        include('hapus/hapus-admin.php');
        break;
    case 'tambah-kategori':
        include('tambah/tambah-kategori.php');
        break;
    case 'edit-kategori':
        include('edit/edit-kategori-form.php');
        break;
    case 'hapus-kategori':
        include('hapus/hapus-kategori.php');
        break;
    case 'tambah-produk':
        include('tambah/tambah-produk.php');
        break;
    case 'edit-produk':
        include('edit/edit-produk-form.php');
        break;
    case 'hapus-produk':
        include('hapus/hapus-produk.php');
        break;
    default:
        include('404.php');
        break;
}
?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('footer.php')?>
</body>
</html>
