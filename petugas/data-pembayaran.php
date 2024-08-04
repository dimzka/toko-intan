<?php include('config/config.php');

$db = dbConnect();

if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'setuju':
            $query = "UPDATE bukti SET status = 1 WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();

            $query = "UPDATE transaksi SET status = 'Completed' WHERE id_transaksi = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_GET['id_transaksi']);
            $stmt->execute();
            break;
        case 'tolak':
            $query = "UPDATE bukti SET status = 2 WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();
            break;
    }
}

$query = "SELECT t.id_transaksi, p.nama AS nama_pelanggan, t.tanggal, t.total, bukti.status, bukti.file, bukti.id as id_bukti
          FROM bukti
          JOIN transaksi t ON bukti.id_transaksi = t.id_transaksi 
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
            <h3 class="card-title">DATA Pembayaran</h3>
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
                  <th>Butki Pembayaran</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                  <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                  <td><?php echo htmlspecialchars($row['total']); ?></td>
                  <td>
                    <a class="btn btn-primary" href="../uploads/<?php echo $row['file']; ?>" download="">
                        <i class="fas fa-download"></i>
                        Unduh
                    </a>
                  </td>
                  <td>
                    <?php
                        if($row['status'] == 0){
                            echo "Pending";
                        }else if($row['status'] == 1){
                            echo "Dibayar";
                        }else {
                            echo "Dibatalkan";
                        }
                    ?>
                  </td>
                  <td>
                    <?php if($row['status'] == 0): ?>
                        <a href="index.php?page=validate-transaksi&action=setuju&id=<?php echo $row['id_bukti']; ?>&id_transaksi=<?php echo $row['id_transaksi']; ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui transaksi ini?')">
                            <i class="fas fa-check"></i>
                            Setuju
                        </a>
                        <a href="index.php?page=validate-transaksi&action=tolak&id=<?php echo $row['id_bukti']; ?>&id_transaksi=<?php echo $row['id_transaksi']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                            <i class="fas fa-times"></i>
                            Tolak
                        </a>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                <th>ID Transaksi</th>
                  <th>Nama Pelanggan</th>
                  <th>Tanggal</th>
                  <th>Total</th>
                  <th>Butki Pembayaran</th>
                  <th>Status</th>
                  <th>Aksi</th>
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
