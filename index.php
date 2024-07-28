<?php include 'header.php';
function check_login() {
    
    if (!isset($_SESSION['id_pelanggan'])) {
        header('Location: login.php');
        exit();
    }
  }
  
  // Panggil fungsi cek login
  check_login(); ?>

<?php include 'navbar_categories.php'; ?>
<?php include 'main_content.php'; ?>
<?php include 'footer.php'; ?>
