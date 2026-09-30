<?php
include_once("bootstrap.php");

$email = strtolower(trim($_POST['username'])); // form login.php pakai nama field "username"
$password = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'] ?? '-';

try {
    $db = new DBconnection();
    $userModel = new UserModel($db);
    $user = $userModel->verifikasi($email, $password);

    if ($user === null) {
        $db->close_connection();
        Log::catat("LOGIN", ["email" => $email, "status" => "GAGAL", "ip" => $ip]);
        Flash::set("Email atau password tidak sesuai.");
        header("Location: login.php");
        exit();
    }

    $db->close_connection();

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['user'] = $user->get_user();
    $_SESSION['jenis_user'] = get_class($user);

    Log::catat("LOGIN", ["email" => $email, "status" => "SUKSES", "ip" => $ip]);
    header("Location: dashboard.php");
    exit();

} catch (DatabaseException $e) {
    Flash::set("Kesalahan database: " . $e->getMessage());
    header("Location: login.php");
    exit();
}