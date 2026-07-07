<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        if (password_verify($password, $data['password'])) {
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['username'] = $data['username'];
            if ($data['role'] == "admin") {
                header("Location: admin/dashboard.php");
            } elseif ($data['role'] == "tu") {
                header("Location: tu/dashboard.php");
            } elseif ($data['role'] == "mahasiswa") {
                header("Location: mahasiswa/dashboard.php");
            }
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6ea8fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }
    </style>
</head>

<body>
    <div class="card p-4" style="width:380px;">
        <!-- <h3 class="text-center mb-3">
            <i class="bi bi-envelope-paper-fill text-primary"></i>
        </h3> -->
        <h4 class="text-center mb-4">Sistem E-Surat</h4>

        <?php if (isset($error)) { ?>

            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php
        }
        ?>

        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100" name="login">Login</button>
        </form>
    </div>
</body>

</html>