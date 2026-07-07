<?php
require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

if ($_SESSION['role'] != 'tu') {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/sidebar.php";

/* ===========================
   UPDATE STATUS
=========================== */

if (isset($_POST['update'])) {

    $id = $_POST['id_pengajuan'];
    $status = $_POST['status'];
    $keterangan = "";

    // Keterangan otomatis
    if ($status == "Menunggu") {

        $keterangan = "Pengajuan surat sedang menunggu verifikasi dari Tata Usaha.";
    } elseif ($status == "Diproses") {

        $keterangan = "Surat sedang diproses oleh Bagian Tata Usaha.";
    } elseif ($status == "Selesai") {

        $keterangan = "Surat telah selesai diproses. Silakan mengambil surat di Bagian Tata Usaha pada jam kerja (Senin - Jumat, 08.00 - 15.00 WIB).";
    } elseif ($status == "Ditolak") {

        $keterangan = "Pengajuan surat ditolak. Silakan menghubungi Bagian Tata Usaha untuk informasi lebih lanjut.";
    }

    mysqli_query($conn, "
    UPDATE pengajuan_surat
    SET
        status='$status',
        keterangan='$keterangan'
    WHERE id_pengajuan='$id'
    ");

    echo "<script>
    alert('Status berhasil diperbarui');
    window.location='pengajuan.php';
    </script>";
}
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                Data Pengajuan Surat

            </h3>

            <p class="text-muted">

                Kelola status pengajuan surat mahasiswa

            </p>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>No</th>

                            <th>Nama Mahasiswa</th>

                            <th>Jenis Surat</th>

                            <th>Keperluan</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                            <th width="12%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        $query = mysqli_query($conn, "

SELECT

pengajuan_surat.*,

mahasiswa.nama,

mahasiswa.nim,

jenis_surat.nama_surat

FROM pengajuan_surat

JOIN mahasiswa
ON pengajuan_surat.id_mahasiswa=mahasiswa.id_mahasiswa

JOIN jenis_surat
ON pengajuan_surat.id_jenis=jenis_surat.id_jenis

ORDER BY tanggal_pengajuan DESC

");

                        if (mysqli_num_rows($query) > 0) {

                            while ($row = mysqli_fetch_assoc($query)) {

                        ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td>

                                        <b><?= $row['nama']; ?></b>

                                        <br>

                                        <small class="text-muted">

                                            <?= $row['nim']; ?>

                                        </small>

                                    </td>

                                    <td>

                                        <?= $row['nama_surat']; ?>

                                    </td>

                                    <td>

                                        <?= $row['keperluan']; ?>

                                    </td>

                                    <td>

                                        <?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?>

                                    </td>

                                    <td>

                                        <?php

                                        if ($row['status'] == "Menunggu") {

                                            echo "<span class='badge bg-secondary'>Menunggu</span>";
                                        } elseif ($row['status'] == "Diproses") {

                                            echo "<span class='badge bg-warning text-dark'>Diproses</span>";
                                        } elseif ($row['status'] == "Selesai") {

                                            echo "<span class='badge bg-success'>Selesai</span>";
                                        } elseif ($row['status'] == "Ditolak") {

                                            echo "<span class='badge bg-danger'>Ditolak</span>";
                                        }

                                        ?>

                                    </td>

                                    <td>

                                        <button

                                            class="btn btn-primary btn-sm"

                                            data-bs-toggle="modal"

                                            data-bs-target="#edit<?= $row['id_pengajuan']; ?>">

                                            <i class="bi bi-pencil-square"></i>

                                        </button>

                                    </td>

                                </tr>

                                <!-- Modal Update -->

                                <div

                                    class="modal fade"

                                    id="edit<?= $row['id_pengajuan']; ?>"

                                    tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form method="POST">

                                                <div class="modal-header">

                                                    <h5>

                                                        Update Status Surat

                                                    </h5>

                                                    <button

                                                        class="btn-close"

                                                        data-bs-dismiss="modal">

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <input

                                                        type="hidden"

                                                        name="id_pengajuan"

                                                        value="<?= $row['id_pengajuan']; ?>">

                                                    <div class="mb-3">

                                                        <label>

                                                            Nama Mahasiswa

                                                        </label>

                                                        <input

                                                            type="text"

                                                            class="form-control"

                                                            value="<?= $row['nama']; ?>"

                                                            readonly disabled>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>

                                                            Jenis Surat

                                                        </label>

                                                        <input

                                                            type="text"

                                                            class="form-control"

                                                            value="<?= $row['nama_surat']; ?>"

                                                            readonly disabled>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>

                                                            Keperluan

                                                        </label>

                                                        <textarea

                                                            class="form-control"

                                                            rows="3"

                                                            readonly disabled><?= $row['keperluan']; ?></textarea>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>Status</label>

                                                        <select
                                                            name="status"
                                                            class="form-select"
                                                            required>

                                                            <option value="Menunggu"
                                                                <?= ($row['status'] == "Menunggu") ? "selected" : ""; ?>>
                                                                Menunggu
                                                            </option>

                                                            <option value="Diproses"
                                                                <?= ($row['status'] == "Diproses") ? "selected" : ""; ?>>
                                                                Diproses
                                                            </option>

                                                            <option value="Selesai"
                                                                <?= ($row['status'] == "Selesai") ? "selected" : ""; ?>>
                                                                Selesai
                                                            </option>

                                                            <option value="Ditolak"
                                                                <?= ($row['status'] == "Ditolak") ? "selected" : ""; ?>>
                                                                Ditolak
                                                            </option>

                                                        </select>

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

                                                        name="update"

                                                        class="btn btn-primary">

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

<td colspan='7' class='text-center'>

Belum ada data pengajuan surat.

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

</div>

<?php
require_once __DIR__ . "/../includes/footer.php";
?>