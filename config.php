<?php
// Konfigurasi aplikasi dan helper tampilan.
define("DB_HOST", "localhost");
define("DB_NAME", "lost_found");
define("DB_USER", "root");
define("DB_PASS", "");
define("UPLOAD_DIR", __DIR__ . "/uploads/");
define("UPLOAD_URL", "uploads/");
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
spl_autoload_register(function ($namaKelas) {
    $file = __DIR__ . "/classes/" . $namaKelas . ".php";
    if (is_file($file)) {
        require_once $file;
    }
});
function e($nilai): string
{
    return htmlspecialchars((string) ($nilai ?? ""), ENT_QUOTES, "UTF-8");
}
function pesan(string $teks, string $tipe = "sukses"): void
{
    $_SESSION["pesan"] = ["teks" => $teks, "tipe" => $tipe];
}
function pindah(string $tujuan): never
{
    header("Location: " . $tujuan);
    exit();
}
