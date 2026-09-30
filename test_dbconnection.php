<?php
include_once("model/respon.php");
include_once("model/databaseexception.php");
include_once("model/dbconnection.php");

try {
    $db = new DBconnection();
    $respon = $db->send_query('SELECT * FROM role ORDER BY idrole');

    echo "status : " . ($respon->status ? "true" : "false") . "<br>";
    echo "message : " . $respon->message . "<br>";
    echo "jumlah : " . count($respon->data) . " baris<br>";

    $gagal = $db->send_query('SELECT * FROM tabel_tidak_ada');
    echo "status : " . ($gagal->status ? "true" : "false") . "<br>";
    echo "message : " . $gagal->message;

    $db->close_connection();
} catch (DatabaseException $e) {
    echo "Kesalahan database: " . $e->getMessage();
}