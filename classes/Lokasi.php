<?php
class Lokasi extends MasterData {protected string $table='lokasi';public function isUsed($id): bool {$s=$this->db->prepare('SELECT COUNT(*) FROM laporan WHERE lokasi_id=?');$s->execute([$id]);return (int)$s->fetchColumn()>0;}}
