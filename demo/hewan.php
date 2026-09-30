<?php
class Hewan
{
    private int $jumlah_kaki;
    private int $tingkat_lapar;
    protected int $posisi;

    public function __construct(int $jumlah_kaki, int $tingkat_lapar = 50, int $posisi = 0)
    {
        $this->jumlah_kaki = $jumlah_kaki;
        $this->tingkat_lapar = $tingkat_lapar;
        $this->posisi = $posisi;
    }

    public function makan(int $kalori): bool
    {
        if ($kalori <= 0) {
            return false;
        }

        $this->tingkat_lapar = max(0, $this->tingkat_lapar - $kalori);
        return true;
    }

    public function lari(int $meter): void
    {
        $this->posisi += max(0, $meter);
    }

    public function bersuara(): void
    {
        echo "Hewan bersuara.<br>";
    }

    public function get_tingkat_lapar(): int
    {
        return $this->tingkat_lapar;
    }

    public function get_posisi(): int
    {
        return $this->posisi;
    }
}

class Kucing extends Hewan
{
    private string $nama;

    public function __construct(string $nama)
    {
        parent::__construct(4, 50, 0);
        $this->nama = $nama;
    }

    public function lompat(int $jarak): void
    {
        $this->posisi += max(0, $jarak);
    }

    public function bersuara(): void
    {
        echo $this->nama . " berkata: Meong!<br>";
    }
}

/*
Percobaan 1 - panggil parent::bersuara() di awal method Kucing:
    parent::bersuara();

Percobaan 2 - ubah access modifier Kucing::bersuara() menjadi protected:
    protected function bersuara(): void
Hasilnya, pemanggilan $kucing->bersuara() dari luar class akan error.

Percobaan 3 - tambahkan final pada method Hewan::bersuara():
    final public function bersuara(): void
Hasilnya, deklarasi override Kucing::bersuara() akan menghasilkan fatal error.
*/