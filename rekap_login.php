<?php
    include_once("fungsi_lib.php");
    $lines = file('log_aktivitas.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $rekap = array();

    // mulai sesi untuk menginisialisasi session jika belum pernah ada session sama sekali yang dibuat
    mulai_session();

    if(!isset($_SESSION['user'])) {
        set_flash("Silakan login terlebih dahulu.");
        header("Location: login.php");
        exit();
    }

    // cek apakah

    foreach ($lines as $line) {
        $kolom = explode(" ", $line);
        if ($kolom[2] == "LOGIN") {
            $email = ambil_nilai($kolom[3]);
            $status = ambil_nilai($kolom[4]);
            $ip = ambil_nilai($kolom[5]);
            if (!array_key_exists($email, $rekap)) {
                $rekap[$email] = array(
                    "email" => $email,
                    "ip" => $ip,
                    "login_sukses" => 0,
                    "login_gagal" => 0,
                    "akses" => array()
                );
            }
            if ($status == "SUKSES") {
                $rekap[$email]["login_sukses"]++;
            } else {
                $rekap[$email]["login_gagal"]++;
            }
        }
        else {
            $email = ambil_nilai($kolom[3]);
            $method = ambil_nilai($kolom[4]);
            $url = ambil_nilai($kolom[5]);
            $rekap[$email]["akses"][] = array(
                "method" => $method,
                "url" => $url
            );
        }
    }
    print_r($rekap);
?>