<?php
class User {
 private PDO $db; public function __construct(){$this->db=Database::getConnection();}
 public function register($nama,$email,$no_hp,$password): bool {$s=$this->db->prepare("INSERT INTO users (nama,email,no_hp,password,role) VALUES (?,?,?,?,'user')");return $s->execute([$nama,$email,$no_hp,password_hash($password,PASSWORD_DEFAULT)]);}
 public function findByEmail($email): array|false {$s=$this->db->prepare('SELECT * FROM users WHERE email=?');$s->execute([$email]);return $s->fetch();}
 public function all(): array {return $this->db->query('SELECT id,nama,email,no_hp,role,created_at FROM users ORDER BY created_at DESC')->fetchAll();}
 public function count(): int {return (int)$this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();}
}
