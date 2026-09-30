<?php
include_once __DIR__ . '/bootstrap.php';

$daftar_user = [
    new User(1, 'User Biasa', 'user@example.com'),
    new Pemilik(2, 'Pemilik Toko', 'pemilik@example.com', '08123456789', 'Jl. Contoh 1'),
];

foreach ($daftar_user as $user) {
    echo '<h2>' . htmlspecialchars(get_class($user)) . '</h2>';
    echo '<p>' . htmlspecialchars((string) $user) . '</p>';
    echo '<pre>' . htmlspecialchars(print_r($user->get_user(), true)) . '</pre>';
}

try {
    $db = new DBconnection();
    $daftar_model = [
        new UserModel($db),
        new RoleModel($db),
        new PemilikModel($db),
    ];

    foreach ($daftar_model as $model) {
        echo '<p>' . htmlspecialchars($model->nama_tabel())
            . ': ' . count($model->find_all()) . ' data</p>';
    }
    $db->close_connection();
} catch (DatabaseException $e) {
    echo '<p>Kesalahan database: ' . htmlspecialchars($e->getMessage()) . '</p>';
}