<?php
include_once("model/konfigurasi.php");
include_once("model/log.php");

echo "Aplikasi : " . Konfigurasi::APP_NAME . "<br>";
echo "Versi : " . Konfigurasi::VERSI . "<br>";
echo "File log : " . Konfigurasi::FILE_LOG . "<br><br>";

Log::catat("UJI", ["keterangan" => "percobaan_static"]);
Log::catat("UJI", ["keterangan" => "percobaan_static_kedua"]);

echo "Jumlah baris log yang ditulis script ini: " . Log::jumlah_baris();