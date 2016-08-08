<?php

include 'library.php';
do_header('Rasy');

$page = new cPage('rasy');

$max['o'] = 21;
$min['o'] = 4;

$pod[0] = "Peníze místo kluzáku";
$pod[1] = "Sport";
$pod[2] = "Combi";
$pod[3] = "Wrecker";

$result = $Sql->q('SELECT id,nazev,popis,r,a,o,kluzak FROM rasy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	
	$row['agresivita'] = drawBar($row['a']);
	$row['reflexy'] = drawBar($row['r']);
	$row['obchod'] = drawBar(($row['o']+$min['o'])/$max['o']*100);
	$row['kluzak'] = $pod[$row['kluzak']];
	
	$data[] = $row;
}

$page->getTable('RASY',$data,'RASY');

$page->finish();

do_footer();
?>