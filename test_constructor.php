<?php
include_once("model/role.php");
include_once("model/user.php");

$role_admin = new Role(1, "Admin", true);
$role_dokter = new Role(2, "Dokter", false);

$user = new User(1, "John Doe", " John@Mail.Com ");
$user->set_role($role_admin);
$user->set_role($role_dokter);

print_r($user->get_user());

echo "<br>Object User sebagai string: " . $user;

class Sesi {
    public function __construct() { echo "<br>Object Sesi dibuat"; }
    public function __destruct() { echo "<br>Object Sesi dihapus"; }
}

$s = new Sesi();
unset($s);
echo "<br>Baris terakhir program";