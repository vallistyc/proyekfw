<?php
include_once("bootstrap.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    Flash::set("Silakan login terlebih dahulu.");
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

Log::catat("LOGOUT", [
    "email" => $user['email'],
    "status" => "SUKSES"
]);

session_destroy();
header("Location: login.php");
exit();