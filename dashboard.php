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
   CARD DASHBOARD
=========================== */

// Total Pengajuan
$q1 = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
");
$totalPengajuan = mysqli_fetch_assoc($q1)['total'];

// Menunggu
$q2 = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE status='Menunggu'
");
$totalMenunggu = mysqli_fetch_assoc($q2)['total'];

// Diproses
$q3 = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE status='Diproses'
");
$totalDiproses = mysqli_fetch_assoc($q3)['total'];

// Selesai
$q4 = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE status='Selesai'
");
$totalSelesai = mysqli_fetch_assoc($q4)['total'];

// Ditolak
$q5 = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM pengajuan_surat
WHERE status='Ditolak'
");

$totalDitolak = mysqli_fetch_assoc($q5)['total'];
?>

<div class="container-fluid">

    <div class="mb-4">

        <h3 class="fw-bold">

            Dashboard Tata Usaha

        </h3>

        <p class="text-muted">

            Selamat datang,
            <b><?= $_SESSION['username']; ?></b>

        </p>

    </div>

    <div class="row">

        <div class="col-lg col-md-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Total Pengajuan

                            </small>

                            <h2 class="fw-bold mt-2">

                                <?= $totalPengajuan; ?>

                            </h2>

                        </div>

                        <div class="fs-1 text-primary">

                            <i class="bi bi-envelope-paper-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Menunggu

                            </small>

                            <h2 class="fw-bold mt-2">

                                <?= $totalMenunggu; ?>

                            </h2>

                        </div>

                        <div class="fs-1 text-secondary">

                            <i class="bi bi-hourglass-split"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Diproses

                            </small>

                            <h2 class="fw-bold mt-2">

                                <?= $totalDiproses; ?>

                            </h2>

                        </div>

                        <div class="fs-1 text-warning">

                            <i class="bi bi-arrow-repeat"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Selesai

                            </small>

                            <h2 class="fw-bold mt-2">

                                <?= $totalSelesai; ?>

                            </h2>

                        </div>

                        <div class="fs-1 text-success">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Ditolak

                            </small>

                            <h2 class="fw-bold mt-2">

                                <?= $totalDitolak; ?>

                            </h2>

                        </div>

                        <div class="fs-1 text-danger">

                            <i class="bi bi-x-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Pengajuan Surat Terbaru

                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-primary">

                                <tr>

                                    <th>No</th>

                                    <th>Nama Mahasiswa</th>

                                    <th>Jenis Surat</th>

                                    <th>Tanggal</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $no = 1;

                                $data = mysqli_query($conn, "

SELECT

mahasiswa.nama,

jenis_surat.nama_surat,

pengajuan_surat.tanggal_pengajuan,

pengajuan_surat.status

FROM pengajuan_surat

JOIN mahasiswa
ON pengajuan_surat.id_mahasiswa=mahasiswa.id_mahasiswa

JOIN jenis_surat
ON pengajuan_surat.id_jenis=jenis_surat.id_jenis

ORDER BY id_pengajuan DESC

LIMIT 5

");

                                if (mysqli_num_rows($data) > 0) {

                                    while ($d = mysqli_fetch_assoc($data)) {

                                ?>

                                        <tr>

                                            <td><?= $no++; ?></td>

                                            <td><?= $d['nama']; ?></td>

                                            <td><?= $d['nama_surat']; ?></td>

                                            <td><?= date('d-m-Y', strtotime($d['tanggal_pengajuan'])); ?></td>

                                            <td>

                                                <?php

                                                if ($d['status'] == "Menunggu") {

                                                    echo "<span class='badge bg-secondary'>Menunggu</span>";
                                                } elseif ($d['status'] == "Diproses") {

                                                    echo "<span class='badge bg-warning text-dark'>Diproses</span>";
                                                } elseif ($d['status'] == "Selesai") {

                                                    echo "<span class='badge bg-success'>Selesai</span>";
                                                } elseif ($d['status'] == "Ditolak") {

                                                    echo "<span class='badge bg-danger'>Ditolak</span>";
                                                }

                                                ?>

                                            </td>

                                        </tr>

                                <?php

                                    }
                                } else {

                                    echo "

<tr>

<td colspan='5' class='text-center'>

Belum ada pengajuan surat.

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

        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Menu Cepat

                    </h5>

                </div>

                <div class="card-body d-grid gap-3">

                    <a
                        href="pengajuan.php"
                        class="btn btn-primary">

                        <i class="bi bi-folder2-open"></i>

                        Kelola Pengajuan Surat

                    </a>

                </div>

            </div>

            <div class="card shadow-sm border-0 mt-4">

                <div class="card-body">

                    <h6 class="fw-bold">

                        Informasi

                    </h6>

                    <hr>

                    <p class="mb-2">
                        Total Surat Masuk :
                        <b><?= $totalPengajuan; ?></b>
                    </p>

                    <p class="mb-2">
                        Sedang Diproses :
                        <b><?= $totalDiproses; ?></b>
                    </p>

                    <p class="mb-2">
                        Surat Selesai :
                        <b><?= $totalSelesai; ?></b>
                    </p>

                    <p class="mb-0">
                        Surat Ditolak :
                        <b class="text-danger"><?= $totalDitolak; ?></b>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
require_once __DIR__ . "/../includes/footer.php";
?>