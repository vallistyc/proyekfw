<?php
require __DIR__ . "/config.php";
Auth::requireUser();
$laporan = new Laporan();
$kategori = new Kategori();
$kata = trim($_GET["q"] ?? "");
$kat = $_GET["kategori"] ?? "";
$daftar = $laporan->feed(Auth::user()["id"], $kata, $kat);
$judul = "Beranda";
require __DIR__ . "/includes/header.php";
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3"><div><h1 class="h2">Laporan Barang Hilang</h1><p class="text-muted">Bantu sesama civitas kampus menemukan barang yang hilang.</p></div><a class="btn btn-primary" href="laporan-buat.php">Lapor Kehilangan</a></div><form class="row g-2 mb-4"><div class="col-md-7"><input class="form-control" name="q" placeholder="Cari nama barang" value="<?= e(
    $kata,
) ?>"></div><div class="col-md-3"><select class="form-select" name="kategori"><option value="">Semua kategori</option><?php foreach (
    $kategori->all()
    as $k
): ?><option value="<?= $k["id"] ?>" <?= $kat == $k["id"] ? "selected" : "" ?>><?= e(
    $k["nama"],
) ?></option><?php endforeach; ?></select></div><div class="col-md-2"><button class="btn btn-outline-primary w-100">Cari</button></div></form>
<?php
if (
    !$daftar
): ?><div class="alert alert-info">Belum ada laporan.</div><?php else: ?><div class="row g-3"><?php foreach (
    $daftar
    as $l
): ?><div class="col-md-6 col-lg-4"><div class="card h-100 shadow-sm"><?php if (
    $l["foto"]
): ?><img src="<?= e(
    UPLOAD_URL . $l["foto"],
) ?>" class="card-img-top" style="height:210px;object-fit:cover" alt="Foto <?= e(
    $l["nama_barang"],
) ?>"><?php else: ?><div class="bg-secondary-subtle text-secondary d-flex justify-content-center align-items-center" style="height:210px"><i class="bi bi-image fs-1"></i></div><?php endif; ?><div class="card-body"><h2 class="h5"><?= e(
    $l["nama_barang"],
) ?></h2><p class="mb-1"><?= e($l["nama_kategori"]) ?> · <?= e(
     $l["nama_lokasi"],
 ) ?></p><p class="text-muted">Hilang: <?= e(
    $l["tanggal_hilang"],
) ?></p><a class="btn btn-outline-primary btn-sm" href="laporan-detail.php?id=<?= $l[
    "id"
] ?>">Lihat Detail</a></div></div></div><?php endforeach; ?></div><?php endif;
require __DIR__ . "/includes/footer.php";

