<?php

class Role
{
    private int $idrole;
    private string $nama_role;
    private bool $status;

    public function set_role(int $idrole, string $nama_role, bool $status): void
    {
        $this->idrole = $idrole;
        $this->nama_role = $nama_role;
        $this->status = $status;
    }

    public function get_data(): array
    {
        return [
            'idrole' => $this->idrole,
            'nama_role' => $this->nama_role,
            'status' => $this->status,
        ];
    }

    public function set_status(bool $newstatus): void
    {
        $this->status = $newstatus;
    }

    public function get_status(): bool
    {
        return $this->status;
    }
}

class User
{
    private int $iduser;
    private string $nama;
    private string $email;
    private string $password;
    private array $role = []; // PHP tidak mengenal tipe data "array of object"

    public function set_user(int $iduser, string $nama, string $email, string $password): void
    {
        $this->iduser = $iduser;
        $this->nama = $nama;
        $this->email = strtolower(trim($email)); // normalisasi terpusat di dalam class
        $this->password = $password;
    }

    public function get_user(): array
    {
        return [
            'iduser' => $this->iduser,
            'nama' => $this->nama,
            'email' => $this->email,
            'role' => $this->get_role_aktif()->get_data()['nama_role'],
        ];
    }

    public function set_role(Role $role): void
    {
        if ($role->get_data()['status'] === true) {
            foreach ($this->role as $r) {
                $r->set_status(false);
            }
        }

        $this->role[] = $role;
    }

    public function get_role_aktif(): Role
    {
        $role_aktif = new Role();
        $role_aktif->set_role(0, '-', false);

        foreach ($this->role as $r) {
            if ($r->get_status() === true) {
                $role_aktif = $r;
            }
        }

        return $role_aktif;
    }

    // Ditambahkan pada class User, di bawah get_role_aktif()
    public function get_iduser(): int {
        return $this->iduser;
    }

    public function get_nama(): string {
        return $this->nama;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function get_password(): string {
        return $this->password;
    }
}

class UserDAO {
    private $dbconn;

    public function __construct($dbconn) {
        $this->dbconn = $dbconn;
    }

    // Menyimpan object User baru ke table "user", mengembalikan iduser hasil insert atau null jika gagal
    public function insert(User $user): ?int {
        $query = 'INSERT INTO "user" (nama, email, password) VALUES ($1, $2, $3) RETURNING iduser';
        $result = pg_query_params($this->dbconn, $query, array(
            $user->get_nama(),
            $user->get_email(),
            $user->get_password()
        ));

        if ($result) {
            $baris = pg_fetch_assoc($result);
            return (int) $baris['iduser'];
        }
        return null;
    }

    // Mencari data pengguna berdasarkan email, mengembalikan object User atau null jika tidak ditemukan
    public function find_by_email(string $email): ?User {
        $query = 'SELECT * FROM "user" WHERE email = $1';
        $result = pg_query_params($this->dbconn, $query, array($email));

        if ($result && pg_num_rows($result) > 0) {
            $baris = pg_fetch_assoc($result);
            $user = new User();
            $user->set_user(
                (int) $baris['iduser'],
                $baris['nama'],
                $baris['email'],
                $baris['password']
            );
            return $user;
        }
        return null;
    }

    // Memperbarui data nama, email, dan password pengguna berdasarkan iduser pada object User
    public function update(User $user): bool {
        $query = 'UPDATE "user" SET nama = $1, email = $2, password = $3 WHERE iduser = $4';
        $result = pg_query_params($this->dbconn, $query, array(
            $user->get_nama(),
            $user->get_email(),
            $user->get_password(),
            $user->get_iduser()
        ));
        return $result !== false;
    }

    // Menghapus pengguna berdasarkan iduser
    public function delete(int $iduser): bool {
        $query = 'DELETE FROM "user" WHERE iduser = $1';
        $result = pg_query_params($this->dbconn, $query, array($iduser));
        return $result !== false;
    }
}
?>