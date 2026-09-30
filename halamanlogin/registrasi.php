<?php
include_once("bootstrap.php");

try {
    $daftar_role = Role::get_opsi_role();
} catch (DatabaseException $e) {
    die("Kesalahan database: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
</head>
<body>
    <h1>Halaman Registrasi</h1>
    <?php Flash::tampilkan(); ?>
    <form action="proses_registrasi.php" method="POST">
        <label>Nama:</label>
        <input type="text" name="nama" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Retype Password:</label>
        <input type="password" name="retype_password" required><br>
        <label>No. WhatsApp (opsional):</label>
        <input type="text" name="no_wa"><br>
        <label>Alamat (opsional):</label>
        <input type="text" name="alamat"><br>
        <label>Role:</label>
        <select name="idrole" required>
            <?php foreach ($daftar_role as $role) { $data = $role->get_data(); ?>
                <option value="<?= $data['idrole'] ?>"><?= $data['nama_role'] ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Daftar">
    </form>
</body>
</html>