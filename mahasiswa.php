<?php
require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/sidebar.php";

/* ===========================
   TAMBAH MAHASISWA
=========================== */

if (isset($_POST['tambah'])) {

    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $nim = htmlspecialchars($_POST['nim']);
    $nama = htmlspecialchars($_POST['nama']);
    $prodi = htmlspecialchars($_POST['prodi']);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {

        echo "<script>
        alert('Username sudah digunakan');
        window.location='mahasiswa.php';
        </script>";
    } else {

        mysqli_query($conn, "INSERT INTO users(username,password,role)
        VALUES('$username','$password','mahasiswa')");

        $id_user = mysqli_insert_id($conn);

        mysqli_query($conn, "INSERT INTO mahasiswa(id_user,nim,nama,prodi)
        VALUES('$id_user','$nim','$nama','$prodi')");

        echo "<script>
        alert('Data berhasil ditambahkan');
        window.location='mahasiswa.php';
        </script>";
    }
}

/* ===========================
   EDIT MAHASISWA
=========================== */

if (isset($_POST['edit'])) {

    $id_mahasiswa = $_POST['id_mahasiswa'];

    $nim = $_POST['nim'];

    $nama = $_POST['nama'];

    $prodi = $_POST['prodi'];

    mysqli_query($conn, "
    UPDATE mahasiswa SET

    nim='$nim',

    nama='$nama',

    prodi='$prodi'

    WHERE id_mahasiswa='$id_mahasiswa'
    ");

    echo "<script>

    alert('Data berhasil diubah');

    window.location='mahasiswa.php';

    </script>";
}

/* ===========================
   HAPUS
=========================== */

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    $q = mysqli_query($conn, "
    SELECT id_user
    FROM mahasiswa
    WHERE id_mahasiswa='$id'
    ");

    $d = mysqli_fetch_assoc($q);

    mysqli_query($conn, "
    DELETE FROM mahasiswa
    WHERE id_mahasiswa='$id'
    ");

    mysqli_query($conn, "
    DELETE FROM users
    WHERE id_user='" . $d['id_user'] . "'
    ");

    echo "<script>

    alert('Data berhasil dihapus');

    window.location='mahasiswa.php';

    </script>";
}

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                Data Mahasiswa

            </h3>

            <p class="text-muted">

                Kelola data mahasiswa

            </p>

        </div>

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah">

            <i class="bi bi-plus-circle"></i>

            Tambah Mahasiswa

        </button>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="5%">No</th>

                            <th>NIM</th>

                            <th>Nama</th>

                            <th>Program Studi</th>

                            <th>Username</th>

                            <th width="15%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        $query = mysqli_query($conn, "

SELECT *

FROM mahasiswa

JOIN users

ON mahasiswa.id_user=users.id_user

ORDER BY nim ASC

");

                        if (mysqli_num_rows($query) > 0) {

                            while ($row = mysqli_fetch_assoc($query)) {

                        ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td><?= $row['nim']; ?></td>

                                    <td><?= $row['nama']; ?></td>

                                    <td><?= $row['prodi']; ?></td>

                                    <td><?= $row['username']; ?></td>

                                    <td>

                                        <button

                                            class="btn btn-warning btn-sm"

                                            data-bs-toggle="modal"

                                            data-bs-target="#edit<?= $row['id_mahasiswa']; ?>">

                                            <i class="bi bi-pencil-square"></i>

                                        </button>

                                        <a

                                            href="?hapus=<?= $row['id_mahasiswa']; ?>"

                                            class="btn btn-danger btn-sm"

                                            onclick="return confirm('Yakin ingin menghapus data?')">

                                            <i class="bi bi-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                                <!-- Modal Edit -->

                                <div
                                    class="modal fade"
                                    id="edit<?= $row['id_mahasiswa']; ?>"
                                    tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form method="POST">

                                                <div class="modal-header">

                                                    <h5>Edit Mahasiswa</h5>

                                                    <button

                                                        class="btn-close"

                                                        data-bs-dismiss="modal">

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <input
                                                        type="hidden"
                                                        name="id_mahasiswa"
                                                        value="<?= $row['id_mahasiswa']; ?>">

                                                    <div class="mb-3">

                                                        <label>NIM</label>

                                                        <input

                                                            type="text"

                                                            name="nim"

                                                            class="form-control"

                                                            value="<?= $row['nim']; ?>"

                                                            required>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>Nama</label>

                                                        <input

                                                            type="text"

                                                            name="nama"

                                                            class="form-control"

                                                            value="<?= $row['nama']; ?>"

                                                            required>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>Program Studi</label>

                                                        <input

                                                            type="text"

                                                            name="prodi"

                                                            class="form-control"

                                                            value="<?= $row['prodi']; ?>"

                                                            required>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button

                                                        class="btn btn-secondary"

                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button

                                                        class="btn btn-warning"

                                                        name="edit">

                                                        Simpan

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                        <?php

                            }
                        } else {

                            echo "

<tr>

<td colspan='6' class='text-center'>

Belum ada data mahasiswa.

</td>

</tr>

";
                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Modal Tambah -->

    <div

        class="modal fade"

        id="modalTambah"

        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form method="POST">

                    <div class="modal-header">

                        <h5>Tambah Mahasiswa</h5>

                        <button

                            class="btn-close"

                            data-bs-dismiss="modal">

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label>Username</label>

                            <input

                                type="text"

                                name="username"

                                class="form-control"

                                required>

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input

                                type="password"

                                name="password"

                                class="form-control"

                                required>

                        </div>

                        <div class="mb-3">

                            <label>NIM</label>

                            <input

                                type="text"

                                name="nim"

                                class="form-control"

                                required>

                        </div>

                        <div class="mb-3">

                            <label>Nama Mahasiswa</label>

                            <input

                                type="text"

                                name="nama"

                                class="form-control"

                                required>

                        </div>

                        <div class="mb-3">

                            <label>Program Studi</label>

                            <input

                                type="text"

                                name="prodi"

                                class="form-control"

                                required>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button
                            type="submit"
                            name="tambah"
                            class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <?php
    require_once __DIR__ . "/../includes/footer.php";
    ?>