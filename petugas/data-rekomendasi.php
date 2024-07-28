<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT r.id_rekomendasi_produk, p.nama AS nama_pelanggan, pr.nama AS nama_produk, r.tanggal_rekomendasi 
          FROM rekomendasi_produk r 
          JOIN pelanggan p ON r.id_pelanggan = p.id_pelanggan 
          JOIN produk pr ON r.id_produk = pr.id_produk";
$result = $db->query($query);

if (!$result) {
    die("Query Error: " . $db->error);
}
?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">DATA REKOMENDASI</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID Rekomendasi</th>
                  <th>Nama Pelanggan</th>
                  <th>Nama Produk</th>
                  <th>Tanggal Rekomendasi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id_rekomendasi_produk']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                  <td><?php echo htmlspecialchars($row['tanggal_rekomendasi']); ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID Rekomendasi</th>
                  <th>Nama Pelanggan</th>
                  <th>Nama Produk</th>
                  <th>Tanggal Rekomendasi</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
