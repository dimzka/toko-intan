<?php include('config/config.php');

$db = dbConnect();

$query = "SELECT p.id_produk, p.nama, p.deskripsi, p.harga, p.stok, p.gambar, k.nama AS kategori, p.created_at 
          FROM produk p 
          JOIN kategori k ON p.id_kategori = k.id_kategori";
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
            <h3 class="card-title">DATA PRODUK</h3>
            <div class="card-tools">
              <a href="index.php?page=tambah-produk" class="btn btn-success">Tambah Data</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Gambar</th>
                  <th>Kategori</th>
                  <th>Dibuat</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
    <?php
    $i = 1; // Inisialisasi variabel counter
    while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $i++; // Tampilkan nomor urut dan increment ?></td>
        <td><?php echo htmlspecialchars($row['nama']); ?></td>
        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
        <td><?php echo htmlspecialchars($row['harga']); ?></td>
        <td><?php echo htmlspecialchars($row['stok']); ?></td>
        <td><img src="image/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Produk" width="100"></td>
        <td><?php echo htmlspecialchars($row['kategori']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        <td>
            <a href="index.php?page=edit-produk&id=<?php echo $row['id_produk']; ?>" class="btn btn-primary btn-sm">Edit</a>
            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id_produk']; ?>)">Delete</button>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>

              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Gambar</th>
                  <th>Kategori</th>
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
            window.location.href = 'hapus/hapus-produk.php?id=' + id;
        }
    }
</script>
