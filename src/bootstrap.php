<?php
// ===== Config =====
define('BASE_URL', 'http://localhost/lost-found/public/');
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');

// ===== Session =====
session_start();

// ===== Class lama (dari project sebelumnya) =====
require_once __DIR__ . '/classes/dbconnection.php';
require_once __DIR__ . '/classes/respon.php';

// ===== Autoload class baru =====
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) require_once $file;
});