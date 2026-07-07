<?php
require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/sidebar.php";

// Ambil data mahasiswa
$id_user = $_SESSION['id_user'];

$data = mysqli_query($conn, "
SELECT *
FROM mahasiswa
WHERE id_user='$id_user'
");

$mhs = mysqli_fetch_assoc($data);

$id_mahasiswa = $mhs['id_mahasiswa'];

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                Status Pengajuan Surat

            </h3>

            <p class="text-muted">

                Riwayat seluruh pengajuan surat Anda

            </p>

        </div>

        <a
            href="pengajuan.php"
            class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Ajukan Surat

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="5%">No</th>

                            <th>Jenis Surat</th>

                            <th>Keperluan</th>

                            <th>Tanggal Pengajuan</th>

                            <th>Status</th>

                            <th>Keterangan</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        $query = mysqli_query($conn, "

SELECT

pengajuan_surat.*,

jenis_surat.nama_surat

FROM pengajuan_surat

JOIN jenis_surat
ON pengajuan_surat.id_jenis = jenis_surat.id_jenis

WHERE id_mahasiswa='$id_mahasiswa'

ORDER BY id_pengajuan DESC

");

                        if (mysqli_num_rows($query) > 0) {

                            while ($row = mysqli_fetch_assoc($query)) {

                        ?>

                                <tr>

                                    <td><?= $no++; ?></td>

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

                                        ?>

                                            <span class="badge bg-secondary">

                                                <i class="bi bi-hourglass-split"></i>

                                                Menunggu

                                            </span>

                                        <?php

                                        } elseif ($row['status'] == "Diproses") {

                                        ?>

                                            <span class="badge bg-warning text-dark">

                                                <i class="bi bi-arrow-repeat"></i>

                                                Diproses

                                            </span>

                                        <?php

                                        } elseif ($row['status'] == "Selesai") {

                                        ?>

                                            <span class="badge bg-success">

                                                <i class="bi bi-check-circle-fill"></i>

                                                Selesai

                                            </span>

                                        <?php

                                        } else {

                                        ?>

                                            <span class="badge bg-danger">

                                                <i class="bi bi-x-circle-fill"></i>

                                                Ditolak

                                            </span>

                                        <?php

                                        }

                                        ?>

                                    </td>

                                    <td><?= $row['keterangan']; ?></td>

                                </tr>

                            <?php

                            }
                        } else {

                            ?>

                            <tr>

                                <td colspan="5" class="text-center">

                                    Belum ada pengajuan surat.

                                </td>

                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-4 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>

                        Total Pengajuan

                    </h5>

                    <?php

                    $total = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE id_mahasiswa='$id_mahasiswa'
"));

                    ?>

                    <h2 class="fw-bold text-primary">

                        <?= $total['total']; ?>

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>

                        Sedang Diproses

                    </h5>

                    <?php

                    $proses = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE id_mahasiswa='$id_mahasiswa'
AND status='Diproses'
"));

                    ?>

                    <h2 class="fw-bold text-warning">

                        <?= $proses['total']; ?>

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>

                        Surat Selesai

                    </h5>

                    <?php

                    $selesai = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE id_mahasiswa='$id_mahasiswa'
AND status='Selesai'
"));

                    ?>

                    <h2 class="fw-bold text-success">

                        <?= $selesai['total']; ?>

                    </h2>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
require_once __DIR__ . "/../includes/footer.php";
?>