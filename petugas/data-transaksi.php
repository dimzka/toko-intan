<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT t.id_transaksi, p.nama AS nama_pelanggan, t.tanggal, t.total, t.status 
          FROM transaksi t 
          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan";
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
            <h3 class="card-title">DATA TRANSAKSI</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID Transaksi</th>
                  <th>Nama Pelanggan</th>
                  <th>Tanggal</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                  <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                  <td><?php echo htmlspecialchars($row['total']); ?></td>
                  <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID Transaksi</th>
                  <th>Nama Pelanggan</th>
                  <th>Tanggal</th>
                  <th>Total</th>
                  <th>Status</th>
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
