<?php
include_once("bootstrap.php");

$nama = $_POST['nama'];
$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];
$retype_password = $_POST['retype_password'];
$idrole = (int) $_POST['idrole'];
$no_wa = trim($_POST['no_wa'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

$input = ['nama' => $nama, 'email' => $email, 'password' => $password, 'retype_password' => $retype_password];

if (!Validasi::tidak_kosong($input, ['nama', 'email', 'password', 'retype_password'])) {
    Flash::set("Seluruh field wajib diisi.");
    header("Location: registrasi.php");
    exit();
}

if ($password !== $retype_password) {
    Flash::set("Password dan Retype Password tidak cocok.");
    header("Location: registrasi.php");
    exit();
}

if (!Validasi::email_valid($email)) {
    Flash::set("Format email tidak valid.");
    header("Location: registrasi.php");
    exit();
}

if (!Validasi::password_kuat($password)) {
    Flash::set("Password minimal 8 karakter.");
    header("Location: registrasi.php");
    exit();
}

try {
    $db = new DBconnection();
    $userModel = new UserModel($db);

    if ($userModel->find_by_email($email) !== null) {
        Flash::set("Email sudah terdaftar.");
        $db->close_connection();
        header("Location: registrasi.php");
        exit();
    }

    $db->mulai_transaksi();
    $respon_user = $userModel->insert([
        'nama' => $nama,
        'email' => $email,
        'password' => $password,
    ]);

    if (!$respon_user->status || count($respon_user->data) === 0) {
        $db->rollback();
        Flash::set("Registrasi gagal saat menyimpan data pengguna.");
        $db->close_connection();
        header("Location: registrasi.php");
        exit();
    }
    $iduser = (int) $respon_user->data[0]['iduser'];

    $respon_role = $userModel->simpan_role_aktif($iduser, $idrole);

    if (!$respon_role->status) {
        $db->rollback();
        Flash::set("Registrasi gagal saat menyimpan role.");
        $db->close_connection();
        header("Location: registrasi.php");
        exit();
    }

    if ($no_wa !== '' && $alamat !== '') {
        $respon_pemilik = (new PemilikModel($db))->insert([
            'no_wa' => $no_wa,
            'alamat' => $alamat,
            'iduser' => $iduser,
        ]);
        if (!$respon_pemilik->status) {
            $db->rollback();
            Flash::set("Registrasi gagal saat menyimpan data pemilik.");
            $db->close_connection();
            header("Location: registrasi.php");
            exit();
        }
    }

    $db->commit();
    Log::catat("REGISTRASI", ["email" => $email, "iduser" => $iduser]);
    Flash::set("Registrasi berhasil. ID pengguna: " . $iduser);

    $db->close_connection();
} catch (DatabaseException $e) {
    Flash::set("Kesalahan database: " . $e->getMessage());
}

header("Location: registrasi.php");
exit();