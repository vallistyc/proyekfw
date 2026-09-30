<?php
include_once("bootstrap.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    Flash::set("Silakan login terlebih dahulu.");
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

Log::catat("AKSES", [
    "email" => $user['email'],
    "method" => $_SERVER['REQUEST_METHOD'],
    "url" => $_SERVER['REQUEST_URI']
]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat datang, <?= $user['nama'] ?></h1>
    <p>Anda login sebagai <?= $user['email'] ?></p>
    <p>Role aktif: <strong><?= $user['role'] ?></strong></p>
    <?php if (isset($user['no_wa'])) { ?>
        <p>No. WhatsApp: <?= htmlspecialchars($user['no_wa']) ?></p>
        <p>Alamat: <?= htmlspecialchars($user['alamat']) ?></p>
    <?php } ?>
    <p><?= Konfigurasi::APP_NAME ?> versi <?= Konfigurasi::VERSI ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>