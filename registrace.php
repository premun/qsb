<?php

include 'library.php';

do_header('Registrace');
$page = new cPage('registrace');

$stav = fa($Sql->q('SELECT val FROM sys WHERE entity = "stav_hry"'));
if($stav['val'] == 0) {
	$page->ext('BLOCK',1);
	exit;
}

if($_GET['action'] == 'regkey') {
	if($_GET['login'] == '' || $_GET['key'] == '') {
		$page->ext('INFO',1);
		exit;
	}
	$result = $Sql->q('SELECT * FROM hraci WHERE id = '.$_GET['login']);
	if(p($result) == 0) {
		$page->ext('ID',1,0,$_GET);
		exit;
	}
	$row = fa($result);
	$id = $row['id'];
	
	$result = $Sql->q('SELECT * FROM registrace WHERE login = '.$id);
	if(p($result) == 0) {
		$page->ext('FINISHED',1);
		exit;
	}
	
	$result = $Sql->q('SELECT login FROM registrace WHERE login = '.$id.' AND `key` = "'.$_GET['key'].'"');
	if(p($result) == 0) {
		$page->ext('REGKEY',1);
		exit;
	}
	$row2 = fa($result);
	
	$page->ext('AKTIVACE',1,0,array('LOGIN' => getNick($row2['login']),'ID' => $row2['login']));
	
	exit;
}

$max['o'] = 21;
$min['o'] = 4;

$pod[0] = "Peníze místo kluzáku";
$pod[1] = "Sport";
$pod[2] = "Combi";
$pod[3] = "Wrecker";

$result = $Sql->q('SELECT id,nazev,popis,r,a,o,kluzak FROM rasy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	
	$row['checked'] = ($i == 0 ? 'checked="checked" ' : '');
	$row['agresivita'] = drawBar($row['a']);
	$row['reflexy'] = drawBar($row['r']);
	$row['obchod'] = drawBar(($row['o']+$min['o'])/$max['o']*100);
	$row['kluzak'] = $pod[$row['kluzak']];
	
	$data[] = $row;
}

$rasy = $page->getTable('RASY',$data);

$page->swap('RASY',$rasy);

$page->finish();

do_footer();
?>