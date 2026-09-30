<?php 
$host = "localhost";
$port = "5432";
$dbname = "kuliah_wf_2025";
$user = "postgres";
$password = "Iv4ldh10";

$dbconn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$dbconn) {
    die("Connection failed: koneksi ke PostgreSQL tidak dapat dibuat.");
}

echo "Koneksi ke PostgreSQL berhasil dibuat.";
?>