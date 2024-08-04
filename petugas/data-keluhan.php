<?php include('config/config.php');

$db = dbConnect();
$id_pengguna = $_SESSION['Id_pengguna'];

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'setuju':
      $query = "UPDATE keluhan SET status = 'Setuju' , id_pengguna = $id_pengguna WHERE id_keluhan = ?";
      $stmt = $db->prepare($query);
      $stmt->bind_param('i', $_GET['id']);
      $stmt->execute();
      break;
    case 'tolak':
      $query = "UPDATE keluhan SET status = 'Ditolak' ,id_pengguna = $id_pengguna WHERE id_keluhan = ?";
      $stmt = $db->prepare($query);
      $stmt->bind_param('i', $_GET['id']);
      $stmt->execute();
      break;
  }
}

$query = "SELECT k.id_keluhan, p.nama AS nama_pelanggan, k.saran, k.kritik, k.created_at, k.status
          FROM keluhan k 
          JOIN pelanggan p ON k.id_pelanggan = p.id_pelanggan";
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
                                    <th>Saran</th>
                                    <th>Kritik</th>
                                    <th>Dibuat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_keluhan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['saran']); ?></td>
                                    <td><?php echo htmlspecialchars($row['kritik']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td>
                                        <?php
                      if ($row['status'] == 0) {
                        echo "Pending";
                      } else {
                        echo $row['status'];
                      }
                      ?>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 0) : ?>
                                        <a href="index.php?page=data-keluhan&action=setuju&id=<?php echo $row['id_keluhan']; ?>"
                                            class="btn btn-success"
                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui keluhan ini?')">
                                            <i class="fas fa-check"></i>
                                            Setuju
                                        </a>
                                        <a href="index.php?page=data-keluhan&action=tolak&id=<?php echo $row['id_keluhan']; ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan keluhan ini?')">
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
                                    <th>ID Keluhan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Saran</th>
                                    <th>Kritik</th>
                                    <th>Dibuat</th>
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