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
   TAMBAH JENIS SURAT
=========================== */

if (isset($_POST['tambah'])) {

    $nama_surat = htmlspecialchars($_POST['nama_surat']);

    mysqli_query($conn, "
        INSERT INTO jenis_surat(nama_surat)
        VALUES('$nama_surat')
    ");

    echo "<script>
        alert('Jenis surat berhasil ditambahkan');
        window.location='jenis_surat.php';
    </script>";
}

/* ===========================
   EDIT JENIS SURAT
=========================== */

if (isset($_POST['edit'])) {

    $id = $_POST['id_jenis'];

    $nama = htmlspecialchars($_POST['nama_surat']);

    mysqli_query($conn, "
        UPDATE jenis_surat
        SET nama_surat='$nama'
        WHERE id_jenis='$id'
    ");

    echo "<script>
        alert('Data berhasil diubah');
        window.location='jenis_surat.php';
    </script>";
}

/* ===========================
   HAPUS
=========================== */

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query($conn, "
        DELETE FROM jenis_surat
        WHERE id_jenis='$id'
    ");

    echo "<script>
        alert('Data berhasil dihapus');
        window.location='jenis_surat.php';
    </script>";
}

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                Jenis Surat

            </h3>

            <p class="text-muted">

                Kelola data jenis surat

            </p>

        </div>

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah">

            <i class="bi bi-plus-circle"></i>

            Tambah Jenis Surat

        </button>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="10%">No</th>

                            <th>Nama Surat</th>

                            <th width="18%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        $query = mysqli_query($conn, "
SELECT *
FROM jenis_surat
ORDER BY nama_surat ASC
");

                        if (mysqli_num_rows($query) > 0) {

                            while ($row = mysqli_fetch_assoc($query)) {

                        ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td><?= $row['nama_surat']; ?></td>

                                    <td>

                                        <button
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit<?= $row['id_jenis']; ?>">

                                            <i class="bi bi-pencil-square"></i>

                                        </button>

                                        <a
                                            href="?hapus=<?= $row['id_jenis']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">

                                            <i class="bi bi-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                                <div
                                    class="modal fade"
                                    id="edit<?= $row['id_jenis']; ?>"
                                    tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form method="POST">

                                                <div class="modal-header">

                                                    <h5>Edit Jenis Surat</h5>

                                                    <button
                                                        class="btn-close"
                                                        data-bs-dismiss="modal">
                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <input
                                                        type="hidden"
                                                        name="id_jenis"
                                                        value="<?= $row['id_jenis']; ?>">

                                                    <div class="mb-3">

                                                        <label>Nama Surat</label>

                                                        <input
                                                            type="text"
                                                            name="nama_surat"
                                                            class="form-control"
                                                            value="<?= $row['nama_surat']; ?>"
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
                                                        name="edit"
                                                        class="btn btn-warning">

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

<td colspan='3' class='text-center'>

Belum ada data.

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

                        <h5>Tambah Jenis Surat</h5>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label>Nama Surat</label>

                            <input
                                type="text"
                                name="nama_surat"
                                class="form-control"
                                placeholder="Contoh : Surat Aktif Kuliah"
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