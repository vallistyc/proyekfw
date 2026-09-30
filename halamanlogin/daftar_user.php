<?php
include_once __DIR__ . '/bootstrap.php';

try {
    $db = new DBconnection();
    $userModel = new UserModel($db);
    $daftar_data = $userModel->find_all();
} catch (DatabaseException $e) {
    die('Kesalahan database: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar User</title>
</head>
<body>
    <h1>Daftar User</h1>
    <table border="1" cellpadding="6">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role aktif</th>
            <th>Jenis user</th>
        </tr>
        <?php foreach ($daftar_data as $data) {
            $user = $userModel->buat_object($data);
            $info = $user->get_user();
            $jenis = $user instanceof Pemilik
                ? 'Pemilik'
                : ($user instanceof Dokter ? 'Dokter' : 'User biasa');
        ?>
            <tr>
                <td><?= htmlspecialchars($info['nama']) ?></td>
                <td><?= htmlspecialchars($info['email']) ?></td>
                <td><?= htmlspecialchars($info['role']) ?></td>
                <td><?= $jenis ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $db->close_connection(); ?>