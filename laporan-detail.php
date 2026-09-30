<?php
require __DIR__ . "/config.php";
Auth::requireUser();
$id = (int) ($_GET["id"] ?? 0);
$laporan = new Laporan();
$l = $laporan->find($id);
if (!$l) {
    pesan("Laporan tidak ditemukan.", "error");
    pindah("index.php");
}
$pemilik = $l["user_id"] == Auth::user()["id"];
if (!$pemilik && $l["status"] !== "dipublikasi") {
    pesan("Laporan tidak tersedia.", "error");
    pindah("index.php");
}
$tanggapan = new Tanggapan()->byLaporan($id);
$judul = "Detail Laporan";
require __DIR__ . "/includes/header.php";
?><div class="card shadow-sm"><div class="card-body"><h1 class="h2"><?= e(
    $l["nama_barang"],
) ?></h1><p><span class="badge bg-<?= [
    "menunggu" => "warning text-dark",
    "dipublikasi" => "primary",
    "ditolak" => "danger",
    "ditemukan" => "success",
][$l["status"]] ?>"><?= e(ucfirst($l["status"])) ?></span></p><p><b>Kategori:</b> <?= e(
    $l["nama_kategori"],
) ?> · <b>Lokasi:</b> <?= e($l["nama_lokasi"]) ?></p><p><b>Tanggal hilang:</b> <?= e(
    $l["tanggal_hilang"],
) ?></p><p><?= nl2br(e($l["deskripsi"])) ?></p><?php
if ($l["foto"]): ?><img src="<?= e(
    UPLOAD_URL . $l["foto"],
) ?>" alt="Foto barang" class="img-fluid rounded" style="max-height:360px"><?php else: ?><div class="text-muted"><i class="bi bi-image"></i> Tidak ada foto</div><?php endif;
if ($pemilik):
    if ($l["catatan_admin"]): ?><div class="alert alert-warning mt-3"><b>Catatan admin:</b> <?= e(
    $l["catatan_admin"],
) ?></div><?php endif; ?><h2 class="h4 mt-4">Tanggapan masuk</h2><?php
foreach ($tanggapan as $t): ?><div class="border rounded p-3 mb-2"><b><?= e(
    $t["nama"],
) ?></b> · <?= e($t["created_at"]) ?><p class="mb-1"><?= nl2br(
    e($t["pesan"]),
) ?></p><span class="text-muted">Kontak: <?= e($t["kontak"]) ?></span></div><?php endforeach;
if (!$tanggapan): ?><p class="text-muted">Belum ada tanggapan.</p><?php endif;
if (
    $l["status"] === "dipublikasi"
): ?><form class="mt-3" method="post" action="laporan-ditemukan.php"><input type="hidden" name="id" value="<?= $id ?>"><button class="btn btn-success">Tandai Ditemukan</button></form><?php endif;

else:
     ?><div class="text-muted">Dilaporkan oleh <?= e(
    $l["nama_pelapor"],
) ?></div><form class="mt-4" method="post" action="tanggapan-kirim.php"><input type="hidden" name="id" value="<?= $id ?>"><label class="form-label">Pesan</label><textarea name="pesan" class="form-control mb-3" required></textarea><label class="form-label">Kontak</label><input name="kontak" class="form-control mb-3" required><button class="btn btn-primary">Kirim Tanggapan</button></form><?php
endif;
?></div></div><?php require __DIR__ . "/includes/footer.php";
