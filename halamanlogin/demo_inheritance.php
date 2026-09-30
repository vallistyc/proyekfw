<?php
include_once __DIR__ . '/demo/hewan.php';

$kucing = new Kucing('Garong');
$kucing->makan(20);
$kucing->lari(10);
$kucing->lompat(5);

echo 'Tingkat lapar: ' . $kucing->get_tingkat_lapar() . '<br>';
echo 'Posisi: ' . $kucing->get_posisi() . '<br>';
$kucing->bersuara();
