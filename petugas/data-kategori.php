<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT * FROM kategori";
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
            <h3 class="card-title">DATA KATEGORI</h3>
            <div class="card-tools">
              <a href="index.php?page=tambah-kategori" class="btn btn-success">Tambah Data</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id_kategori']); ?></td>
                  <td><?php echo htmlspecialchars($row['nama']); ?></td>
                  <td>
                    <a href="index.php?page=edit-kategori&id=<?php echo $row['id_kategori']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id_kategori']; ?>)">Delete</button>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
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
            window.location.href = 'hapus/hapus-kategori.php?id=' + id;
        }
    }
</script>
