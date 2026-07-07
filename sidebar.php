<div class="sidebar bg-dark text-white p-3" id="sidebar">
    <h5 class="text-center mb-4">
        <i class="bi bi-envelope-paper"></i>
        SIMSURAT
    </h5>

    <?php if ($_SESSION['role'] == "admin") { ?>
        <a href="dashboard.php" class="menu">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>
        <a href="mahasiswa.php" class="menu">
            <i class="bi bi-people"></i>
            Data Mahasiswa
        </a>
        <a href="jenis_surat.php" class="menu">
            <i class="bi bi-file-earmark-text"></i>
            Jenis Surat
        </a>
    <?php } ?>

    <?php if ($_SESSION['role'] == "tu") { ?>
        <a href="dashboard.php" class="menu">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>
        <a href="pengajuan.php" class="menu">
            <i class="bi bi-folder2-open"></i>
            Pengajuan Surat
        </a>
    <?php } ?>

    <?php if ($_SESSION['role'] == "mahasiswa") { ?>
        <a href="dashboard.php" class="menu">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>
        <a href="pengajuan.php" class="menu">
            <i class="bi bi-file-earmark-plus"></i>
            Ajukan Surat
        </a>
        <a href="status.php" class="menu">
            <i class="bi bi-clock-history"></i>
            Status Surat
        </a>
    <?php } ?>

    <hr>
    <a href="../logout.php" class="menu text-danger"><i class="bi bi-box-arrow-right"></i>Logout</a>
</div>
<div class="content p-4 w-100">