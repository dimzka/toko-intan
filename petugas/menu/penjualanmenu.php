<?php
// Tentukan halaman saat ini berdasarkan URL
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="index.php?page=dashboard" class="nav-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item menu-open">
            <a href="#" class="nav-link <?php echo in_array($current_page, ['data-admin', 'data-pelanggan']) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Kelola
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="index.php?page=data-transaksi" class="nav-link <?php echo $current_page == 'data-transaksi' ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Laporan Transaksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=data-produk" class="nav-link <?php echo $current_page == 'data-produk' ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Produk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=data-kategori" class="nav-link <?php echo $current_page == 'data-kategori' ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=data-keluhan" class="nav-link <?php echo $current_page == 'data-keluhan' ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Keluhan</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="config/logout.php" class="nav-link text-red">
                <i class="nav-icon fas fa-power-off"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>
