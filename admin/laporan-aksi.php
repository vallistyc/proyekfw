<?php
require __DIR__ . "/../config.php";
Auth::requireAdmin();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    pindah("laporan.php");
}
$id = (int) ($_POST["id"] ?? 0);
$aksi = $_POST["aksi"] ?? "";
$l = new Laporan()->find($id);
if (!$l) {
    pesan("Laporan tidak ditemukan.", "error");
    pindah("laporan.php");
}
$ok = false;
if ($aksi === "publikasi" && $l["status"] === "menunggu") {
    $ok = new Laporan()->setStatus($id, "dipublikasi");
} elseif (
    $aksi === "tolak" &&
    in_array($l["status"], ["menunggu", "dipublikasi"], true) &&
    trim($_POST["catatan"] ?? "") !== ""
) {
    $ok = new Laporan()->setStatus($id, "ditolak", trim($_POST["catatan"]));
} elseif ($aksi === "ditemukan" && $l["status"] === "dipublikasi") {
    $ok = new Laporan()->setStatus($id, "ditemukan");
}
pesan(
    $ok ? "Status laporan diperbarui." : "Aksi tidak valid atau catatan wajib diisi.",
    $ok ? "sukses" : "error",
);
pindah("laporan-detail.php?id=" . $id);
