<?php
include_once("dbconnection.php");
include_once("classes.php");

$userDAO = new UserDAO($dbconn);

// Test insert
$user_baru = new User();
$user_baru->set_user(0, 'Test User', 'test.dao@mail.com', password_hash('testpass123', PASSWORD_DEFAULT));
$id_baru = $userDAO->insert($user_baru);
echo "Insert -> iduser baru: " . $id_baru . "<br>";

// Test find_by_email (ditemukan)
$hasil_cari = $userDAO->find_by_email('test.dao@mail.com');
echo "Find (ada) -> ";
print_r($hasil_cari->get_user());
echo "<br>";

// Test find_by_email (tidak ditemukan)
$hasil_kosong = $userDAO->find_by_email('tidakada@mail.com');
var_dump($hasil_kosong); // harus NULL
echo "<br>";

// Test update
$hasil_cari->set_user($hasil_cari->get_iduser(), 'Test User Updated', 'test.dao@mail.com', $hasil_cari->get_password());
$berhasil_update = $userDAO->update($hasil_cari);
var_dump($berhasil_update); // harus true
echo "<br>";

// Verifikasi update di database
print_r($userDAO->find_by_email('test.dao@mail.com')->get_user());
echo "<br>";

// Test delete
$berhasil_hapus = $userDAO->delete($id_baru);
var_dump($berhasil_hapus); // harus true

// Pastikan sudah terhapus
var_dump($userDAO->find_by_email('test.dao@mail.com')); // harus NULL

pg_close($dbconn);
?>a