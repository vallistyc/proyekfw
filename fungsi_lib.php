<?php
// Memulai session hanya apabila belum aktif
function mulai_session(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Menyimpan flash message
function set_flash(string $pesan): void {
    mulai_session();
    $_SESSION['flash_msg'] = $pesan;
}

// Menampilkan flash message, kemudian menghapusnya
function tampilkan_flash(): void {
    mulai_session();
    if (isset($_SESSION['flash_msg'])) {
        echo "<p style='color:red;'>" . $_SESSION['flash_msg'] . "</p>";
        unset($_SESSION['flash_msg']);
    }
}

// Mengambil value dari teks berformat key=value, contoh: email=john@mail.com
function ambil_nilai(string $teks): string {
    $bagian = explode("=", $teks);
    return $bagian[1];
}

// Menambahkan satu baris pada file log aktivitas
function catat_log(string $jenis, array $data): void {
    $baris = date('Y-m-d H:i:s') . " " . $jenis;
    foreach ($data as $key => $value) {
        $baris .= " " . $key . "=" . $value;
    }
    file_put_contents("log_aktivitas.txt", $baris . PHP_EOL, FILE_APPEND);
}


 // Ditambahkan pada fungsi_lib.php setelah koneksi database tersedia
function cari_user_by_email($dbconn, string $email): ?array {
    $query = 'SELECT * FROM "user" WHERE email = $1';
    $result = pg_query_params($dbconn, $query, array($email));
    
    if ($result && pg_num_rows($result) > 0) {
    return pg_fetch_assoc($result);

    }
    return null;
}

// Memeriksa apakah seluruh field wajib pada array data sudah terisi
function validasi_tidak_kosong(array $data): bool {
    foreach ($data as $value) {
        if (empty($value)) {
            return false;
        }
    }
    return true;
}

// Memeriksa format email menggunakan filter_var
function validasi_format_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Memeriksa panjang password minimal 8 karakter
function validasi_panjang_password(string $password): bool {
    return strlen($password) >= 8;
}

// Memeriksa apakah email sudah terdaftar pada table "user"
function validasi_email_terdaftar($dbconn, string $email): bool {
    return cari_user_by_email($dbconn, $email) !== null;
}
?>