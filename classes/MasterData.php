<?php
abstract class MasterData
{
    protected PDO $db;
    protected string $table;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function all(): array
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY nama")->fetchAll();
    }
    public function find($id): array|false
    {
        $s = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $s->execute([$id]);
        return $s->fetch();
    }
    public function create($nama): bool
    {
        $s = $this->db->prepare("INSERT INTO {$this->table} (nama) VALUES (?)");
        return $s->execute([$nama]);
    }
    public function update($id, $nama): bool
    {
        $s = $this->db->prepare("UPDATE {$this->table} SET nama=? WHERE id=?");
        return $s->execute([$nama, $id]);
    }
    public function delete($id): bool
    {
        if ($this->isUsed($id)) {
            return false;
        }
        $s = $this->db->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $s->execute([$id]);
    }
    abstract public function isUsed($id): bool;
}
