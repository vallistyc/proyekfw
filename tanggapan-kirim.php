<?php
require __DIR__ . "/config.php";
Auth::requireUser();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    pindah("index.php");
}
$id = (int) ($_POST["id"] ?? 0);
$l = new Laporan()->find($id);
$isi = trim($_POST["pesan"] ?? "");
$kontak = trim($_POST["kontak"] ?? "");
if (
    $l &&
    $l["status"] === "dipublikasi" &&
    $l["user_id"] != Auth::user()["id"] &&
    $isi !== "" &&
    $kontak !== ""
) {
    new Tanggapan()->create($id, Auth::user()["id"], $isi, $kontak);
    pesan("Tanggapan berhasil dikirim.");
} else {
    pesan("Tanggapan tidak dapat dikirim.", "error");
}
pindah("laporan-detail.php?id=" . $id);
