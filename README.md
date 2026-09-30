# Sistem Pelaporan Barang Hilang

Aplikasi PHP native dengan MySQL (XAMPP), PDO, class OOP, dan Bootstrap 5 CDN.

## Menjalankan di XAMPP

1. Salin folder proyek sebagai `C:\xampp\htdocs\lost-found`.
2. Nyalakan Apache dan MySQL dari XAMPP Control Panel.
3. Buka phpMyAdmin (`http://localhost/phpmyadmin`), lalu import `database/schema.sql` dan `database/seed.sql` secara berurutan.
4. Buka `http://localhost/lost-found/login.php`.

Akun awal:

- Admin: `admin@kampus.test` / `admin123`
- User: `budi@kampus.test` / `user123`

Koneksi database default memakai host `localhost`, database `lost_found`, user `root`, dan password kosong. Folder `uploads/` harus dapat ditulisi Apache untuk menyimpan foto laporan.
