<?php
$host      = "localhost";
$user      = "root";
$pass      = "";
$db        = "akademik";

$koneksi   = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi) { //cek koneksi
    die("koneksi gagal");
}
$nim        = "";
$nama       = "";
$alamat     = "";
$jurusan    = "";
$sukses     = "";
$error      = "";

if(isset($_GET['op'])) {
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id     = $_GET['id'];
    $sql1   = "delete from mahasiswa where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "berhasil hapus data";
    }else{
        $error = "gagal hapus data";
    }
}
if($op == 'edit') {
    $id      = $_GET['id'];
    $sql1    = "select * from mahasiswa where id = '$id'";
    $q1      = mysqli_query($koneksi, $sql1);
    $r1      = mysqli_fetch_array($q1);
    $nim     = $r1['nim'];
    $nama    = $r1['nama'];
    $alamat  = $r1['alamat'];
    $jurusan = $r1['jurusan'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nim     = $_POST['nim'];
    $nama    = $_POST['nama'];
    $alamat  = $_POST['alamat'];
    $jurusan = $_POST['jurusan'];

    if($nim && $nama && $alamat && $jurusan) {
        if ($op == 'edit') { //untuk update
            $sql1 = "update mahasiswa set nim='$nim',nama='$nama',alamat='$alamat',jurusan='$jurusan' where id = '$id'";
            $q1   = mysqli_query($koneksi,$sql1);
            if($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1 = "insert into mahasiswa(nim,nama,alamat,jurusan) values ('$nim','$nama','$alamat','$jurusan')";
            $q1   = mysqli_query($koneksi,$sql1);
            if($q1) {
                $sukses = "berhasil memasukan data baru";
            }else {
                $error  = "gagal memasukan data";
            }
        }
    } else {
        $error = "Silahkan masukan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!--untuk memasukan data-->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="<?php echo $nim ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="<?php echo $nama ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="<?php echo $alamat ?>">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select class="form-control" name="jurusan" id="jurusan">
                            <option value="">-pilih jurusan-</option>
                            <option value="AKL" <?php if ($jurusan == "AKL") echo "selected" ?>> AKL</option>
                            <option value="OTKP" <?php if ($jurusan == "OTKP") echo "selected" ?>> OTKP</option>
                            <option value="BDP" <?php if ($jurusan == "BDP") echo "selected" ?>> BDP</option>
                            <option value="RPL" <?php if ($jurusan == "RPL") echo "selected" ?>> RPL</option>
                        </select>
                    </div>
                    <div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="simpan Data" class="btn btn-primary" />
                        </div>
                </form>
            </div>
        </div>

        <!--untuk mengeluarkan data-->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from mahasiswa order by id desc";
                        $q2   = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id      = $r2['id'];
                            $nim     = $r2['nim'];
                            $nama    = $r2['nama'];
                            $alamat  = $r2['alamat'];
                            $jurusan = $r2['jurusan'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $jurusan ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>