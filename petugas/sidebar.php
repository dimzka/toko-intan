<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nama']?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
<?php
 // Pastikan session sudah dimulai
if (isset($_SESSION['jabatan'])) {
    switch ($_SESSION['jabatan']) {
        case 'admin':
            include('menu/adminmenu.php');
            break;
        case 'pemilik':
            include('menu/pemilikmenu.php');
            break;
        case 'penjualan':
            include('menu/penjualanmenu.php');
            break;
        default:
            echo 'Menu tidak tersedia.';
            break;
    }
} else {
    echo 'Gagal memuat menu. Silakan login terlebih dahulu.';
}
?>
<!-- /.sidebar-menu -->
    </div>