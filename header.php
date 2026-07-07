<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem E-Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-light me-3" id="menu-toggle">
                <i class="bi bi-list"></i>
            </button>
            <span class="navbar-brand mb-0 h1">
                Sistem E-Surat
            </span>
            <div class="ms-auto text-white">
                <i class="bi bi-person-circle"></i>
                <?= ucfirst($_SESSION['role']); ?>
            </div>
        </div>
    </nav>
    <div class="d-flex">