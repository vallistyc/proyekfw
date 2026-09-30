<?php
require __DIR__ . "/config.php";
Auth::requireUser();
$status = $_GET["status"] ?? null;
$valid = ["menunggu", "dipublikasi", "ditolak", "ditemukan"];
if (!in_array($status, $valid, true)) {
    $status = null;
}
$daftar = new Laporan()->byUser(Auth::user()["id"], $status);
$tg = new Tanggapan();
$labels = [
    "menunggu" => "Menunggu",
    "dipublikasi" => "Dipublikasi",
    "ditolak" => "Ditolak",
    "ditemukan" => "Ditemukan",
];
$warna = [
    "menunggu" => "warning text-dark",
    "dipublikasi" => "primary",
    "ditolak" => "danger",
    "ditemukan" => "success",
];
$judul = "Histori Laporan";
require __DIR__ . "/includes/header.php";
?><h1 class="h2">Histori Laporan</h1><div class="mb-3 d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="histori.php">Semua</a><?php foreach (
    $labels
    as $s => $label
): ?><a class="btn btn-sm btn-outline-primary" href="?status=<?= $s ?>"><?= $label ?></a><?php endforeach; ?></div><div class="table-responsive"><table class="table table-striped align-middle bg-white"><thead><tr><th>Nama barang</th><th>Status</th><th>Catatan admin</th><th>Tanggapan</th><th>Aksi</th></tr></thead><tbody><?php
foreach ($daftar as $l): ?><tr><td><?= e(
    $l["nama_barang"],
) ?></td><td><span class="badge bg-<?= $warna[$l["status"]] ?>"><?= $labels[
    $l["status"]
] ?></span></td><td><?= e($l["catatan_admin"] ?: "-") ?></td><td><?= $tg->countByLaporan(
    $l["id"],
) ?></td><td><a class="btn btn-sm btn-outline-primary" href="laporan-detail.php?id=<?= $l[
    "id"
] ?>">Detail</a> <?php if (
    in_array($l["status"], ["menunggu", "ditolak"], true)
): ?><a class="btn btn-sm btn-outline-secondary" href="laporan-edit.php?id=<?= $l[
    "id"
] ?>">Edit</a><?php endif; ?> <?php if (
     $l["status"] === "menunggu"
 ): ?><form class="d-inline" method="post" action="laporan-hapus.php" onsubmit="return confirm('Yakin hapus?')"><input type="hidden" name="id" value="<?= $l[
    "id"
] ?>"><button class="btn btn-sm btn-outline-danger">Hapus</button></form><?php endif; ?></td></tr><?php endforeach;
if (!$daftar): ?><tr><td colspan="5" class="text-center">Belum ada laporan.</td></tr><?php endif;
?></tbody></table></div><?php require __DIR__ . "/includes/footer.php";
