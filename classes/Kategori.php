<?php
class Kategori extends MasterData
{
    protected string $table = "kategori";
    public function isUsed($id): bool
    {
        $s = $this->db->prepare("SELECT COUNT(*) FROM laporan WHERE kategori_id=?");
        $s->execute([$id]);
        return (int) $s->fetchColumn() > 0;
    }
}
