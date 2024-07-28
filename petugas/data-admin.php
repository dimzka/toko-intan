<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT * FROM pengguna";
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
            <h3 class="card-title">DATA PENGGUNA</h3>
            <div class="card-tools">
              <a href="index.php?page=tambah-admin" class="btn btn-success">Tambah Data</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Password</th>
                  <th>Jabatan</th>
                  <th>Dibuat</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id_pengguna']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama']); ?></td>
                  <td><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo htmlspecialchars($row['email']); ?></td>
                  <td><?php echo str_repeat('*', strlen($row['password'])); ?></td>
                  <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                  <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                  <td>
                    <a href="index.php?page=edit-admin&id=<?php echo $row['id_pengguna']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id_pengguna']; ?>)">Delete</button>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Password</th>
                  <th>Jabatan</th>
                  <th>Dibuat</th>
                  <th>Action</th>
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
<script type="text/javascript">
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = 'index.php?page=hapus-admin&id=' + id;
        }
    }
</script>
