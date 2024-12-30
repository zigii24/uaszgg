<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<title>
    Document
</title>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">LBK MAJU JAYA</span>
    </nav>
    <div class="container">
        <br>
        <h4><center>DAFTAR PESERTA KURSUS BAHASA JEPANG</center></h4>

        <?php
        include "koneksi.php";

        // Cek apakah ada kiriman form dari method GET untuk hapus data
        if (isset($_GET['id_peserta'])) {
            $id_peserta = htmlspecialchars($_GET["id_peserta"]);
            $sql = "DELETE FROM peserta WHERE id_peserta='$id_peserta'";
            $hasil = mysqli_query($kon, $sql);

            // Kondisi apakah berhasil atau tidak
            if ($hasil) {
                header("Location:index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
            }
        }

        // Cek apakah ada input pencarian
        $search = "";
        if (isset($_GET['search'])) {
            $search = htmlspecialchars($_GET['search']);
        }
        ?>

        <!-- Formulir Pencarian -->
        <form method="GET" action="index.php">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau sekolah" value="<?php echo $search; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <br>

        <table class="my-3 table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Jurusan</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th colspan='2'>Aksi</th>
                </tr>
            </thead>

            <?php
            // Query untuk data dengan pencarian jika ada input search
            $sql = "SELECT * FROM peserta";
            if (!empty($search)) {
                $sql .= " WHERE nama LIKE '%$search%' OR sekolah LIKE '%$search%'";
            }
            $sql .= " ORDER BY id_peserta DESC";

            $hasil = mysqli_query($kon, $sql);
            $no = 0;
            while ($data = mysqli_fetch_array($hasil)) {
                $no++;
            ?>
            <tbody>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data["nama"]; ?></td>
                    <td><?php echo $data["sekolah"]; ?></td>
                    <td><?php echo $data["jurusan"]; ?></td>
                    <td><?php echo $data["no_hp"]; ?></td>
                    <td><?php echo $data["alamat"]; ?></td>
                    <td>
                        <a href="update.php?id_peserta=<?php echo htmlspecialchars($data['id_peserta']); ?>" class="btn btn-warning" role="button">Update</a>
                        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_peserta=<?php echo $data['id_peserta']; ?>" class="btn btn-danger" role="button">Delete</a>
                    </td>
                </tr>
            </tbody>
            <?php
            }
            ?>
        </table>

        <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>
    </div>
</body>
</html>
