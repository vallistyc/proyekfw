<?php
class Tanggapan
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function create($laporanId, $userId, $pesan, $kontak): bool
    {
        $s = $this->db->prepare(
            "INSERT INTO tanggapan (laporan_id,user_id,pesan,kontak) VALUES (?,?,?,?)",
        );
        return $s->execute([$laporanId, $userId, $pesan, $kontak]);
    }
    public function byLaporan($laporanId): array
    {
        $s = $this->db->prepare(
            "SELECT t.*,u.nama FROM tanggapan t JOIN users u ON u.id=t.user_id WHERE t.laporan_id=? ORDER BY t.created_at DESC",
        );
        $s->execute([$laporanId]);
        return $s->fetchAll();
    }
    public function countByLaporan($laporanId): int
    {
        $s = $this->db->prepare("SELECT COUNT(*) FROM tanggapan WHERE laporan_id=?");
        $s->execute([$laporanId]);
        return (int) $s->fetchColumn();
    }
}
