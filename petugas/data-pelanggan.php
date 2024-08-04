<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT * FROM pelanggan";
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
            <h3 class="card-title">DATA PELANGGAN</h3>

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID Pelanggan</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
                  <th>Dibuat</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['id_pelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_telp']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID Pelanggan</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
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