<?php
class Auth {
 public static function login($email,$password): bool {$s=Database::getConnection()->prepare('SELECT * FROM users WHERE email=?');$s->execute([$email]);$u=$s->fetch();if(!$u||!password_verify($password,$u['password']))return false;session_regenerate_id(true);unset($u['password']);$_SESSION['user']=$u;return true;}
 public static function logout(): void {$_SESSION=[];session_destroy();}
 public static function user(): ?array {return $_SESSION['user']??null;}
 public static function requireLogin(): void {if(!self::user()){pesan('Silakan login terlebih dahulu.','error');pindah('login.php');}}
 public static function requireAdmin(): void {self::requireLogin();if(self::user()['role']!=='admin'){pesan('Halaman ini khusus admin.','error');pindah('../index.php');}}
 public static function requireUser(): void {self::requireLogin();if(self::user()['role']!=='user')pindah('admin/index.php');}
}
