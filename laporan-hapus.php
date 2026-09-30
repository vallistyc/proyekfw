<?php
require __DIR__.'/config.php';Auth::requireUser();if($_SERVER['REQUEST_METHOD']!=='POST')pindah('histori.php');$id=(int)($_POST['id']??0);$l=(new Laporan())->find($id);if($l&&$l['user_id']==Auth::user()['id']&&$l['status']==='menunggu'){(new Laporan())->delete($id);pesan('Laporan dihapus.');}else pesan('Laporan tidak dapat dihapus.','error');pindah('histori.php');
