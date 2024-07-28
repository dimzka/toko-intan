<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT k.id_keluhan, p.nama AS nama_pelanggan, u.nama AS nama_pengguna, k.saran, k.kritik, k.created_at 
          FROM keluhan k 
          JOIN pelanggan p ON k.id_pelanggan = p.id_pelanggan 
          JOIN pengguna u ON k.id_pengguna = u.id_pengguna";
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
            <h3 class="card-title">DATA KELUHAN</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID Keluhan</th>
                  <th>Nama Pelanggan</th>
                  <th>Nama Pengguna</th>
                  <th>Saran</th>
                  <th>Kritik</th>
                  <th>Dibuat</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id_keluhan']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama_pengguna']); ?></td>
                  <td><?php echo htmlspecialchars($row['saran']); ?></td>
                  <td><?php echo htmlspecialchars($row['kritik']); ?></td>
                  <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID Keluhan</th>
                  <th>Nama Pelanggan</th>
                  <th>Nama Pengguna</th>
                  <th>Saran</th>
                  <th>Kritik</th>
                  <th>Dibuat</th>
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
