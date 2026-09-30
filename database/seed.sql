USE lost_found;
INSERT IGNORE INTO users (nama,email,no_hp,password,role) VALUES ('Administrator','admin@kampus.test','081234567890','$2y$12$/ux.2n/GG5jveAC5GKJtj.acnlpAOQ0snN9ogLzjWLXC6rwHNk2Mi','admin'),('Budi Santoso','budi@kampus.test','081234567891','$2y$12$2fdyUvnXs9jbyJ70PB3LIu2qP2YxL82trYTg8ehuTx725ZXRzQw6e','user');
INSERT IGNORE INTO kategori (nama) VALUES ('Dompet'),('HP'),('Kunci'),('Tas'),('KTM/Dokumen'),('Elektronik'),('Lainnya');
INSERT IGNORE INTO lokasi (nama) VALUES ('Gedung A'),('Perpustakaan'),('Kantin'),('Parkiran'),('Masjid');
