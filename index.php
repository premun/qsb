<?php

include 'library.php';

$blokace = fa($Sql->q('SELECT val FROM sys WHERE entity = "stav_hry"'));
if($blokace['val'] == 0) {
	$_SESSION['chyba'] = 'Hra zablokována - probíhají úpravy';
}

do_header('Vítejte');
$fp = fopen('./vypisy/index.txt','r');
$obsah = fread($fp,4200000);
fclose($fp);
echo stripslashes($obsah);

$page = new cPage('uvod');

$result = $Sql->q('SELECT * FROM novinky ORDER BY id DESC LIMIT 0,4');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$data2['novinka'] = nl2br($row['novinka']);
	$data2['datum'] = date('H:i j.n.Y',$row['cas']);
	$data2['titulek'] = $row['titulek'];
	$data[] = $data2;
}

$novinky = $page->getTable('NOVINKY',$data);

$page->swap('NEWS',$novinky);

$page->finish();

do_footer();
?>