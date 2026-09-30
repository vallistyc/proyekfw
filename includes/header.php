<?php $pengguna = Auth::user();
$admin = str_contains($_SERVER["PHP_SELF"], "/admin/");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e(
    $judul ?? "Lost & Found Kampus",
) ?></title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"></head><body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary"><div class="container"><a class="navbar-brand" href="<?= $admin
    ? "index.php"
    : "index.php" ?>">Lost &amp; Found</a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button><div id="menu" class="collapse navbar-collapse"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
<?php if (!$pengguna): ?><li><a class="nav-link" href="<?= $admin
    ? "../login.php"
    : "login.php" ?>">Login</a></li><li><a class="nav-link" href="<?= $admin
    ? "../register.php"
    : "register.php" ?>">Daftar</a></li>
<?php elseif ($pengguna["role"] === "admin"): ?><li><a class="nav-link" href="<?= $admin
    ? "index.php"
    : "admin/index.php" ?>">Dashboard</a></li><li><a class="nav-link" href="<?= $admin
    ? "laporan.php"
    : "admin/laporan.php" ?>">Laporan</a></li><li><a class="nav-link" href="<?= $admin
    ? "kategori.php"
    : "admin/kategori.php" ?>">Kategori</a></li><li><a class="nav-link" href="<?= $admin
    ? "lokasi.php"
    : "admin/lokasi.php" ?>">Lokasi</a></li><li><a class="nav-link" href="<?= $admin
    ? "user.php"
    : "admin/user.php" ?>">User</a></li><li><a class="btn btn-light btn-sm" href="<?= $admin
    ? "../logout.php"
    : "logout.php" ?>">Logout</a></li>
<?php else: ?><li><a class="nav-link" href="<?= $admin
    ? "../index.php"
    : "index.php" ?>">Beranda</a></li><li><a class="nav-link" href="<?= $admin
    ? "../histori.php"
    : "histori.php" ?>">Histori Laporan</a></li><li><a class="btn btn-light btn-sm" href="<?= $admin
    ? "../laporan-buat.php"
    : "laporan-buat.php" ?>">Lapor Kehilangan</a></li><li><a class="nav-link" href="<?= $admin
    ? "../logout.php"
    : "logout.php" ?>">Logout</a></li><?php endif; ?></ul></div></div></nav>
<main class="container py-4"><?php if (isset($_SESSION["pesan"])) {

    $m = $_SESSION["pesan"];
    unset($_SESSION["pesan"]);
    ?><div class="alert alert-<?= $m["tipe"] === "error"
    ? "danger"
    : "success" ?> alert-dismissible fade show"><?= e(
     $m["teks"],
 ) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php
} ?>

