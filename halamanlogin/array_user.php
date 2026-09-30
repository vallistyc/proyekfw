<?php
$daftar_user = array(
    "john@mail.com" => array("nama" => "John Doe", "role" => "Admin"),
    "siti@mail.com" => array("nama" => "Siti Aminah", "role" => "Dokter")
);
print_r($daftar_user);
echo $daftar_user["siti@mail.com"]["nama"]; // Siti Aminah
?>