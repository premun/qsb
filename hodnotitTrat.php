<?php

include 'library.php';

$id = $_GET['id'];
$opt = $_GET['opt'];

if(!is_numeric($id) || !is_numeric($opt) || $opt > 3 || $opt < 1) {
	$_SESSION['chyba'] = "Zboží přidáno";
	go('showTrat.php?id='.$id);
	exit;
}

$result = $Sql->q('SELECT * FROM trate WHERE id = '.$id);
if(p($result) == 0) {
	$_SESSION['chyba'] = "Trať nebyla nalezena";
	go('trate.php?action=all');
	exit;
}

$trat = fa($result);

$rat = fa($Sql->q('SELECT trate FROM hraci WHERE id = '.UID));
if(ereg(','.$trat['id'].',',$rat['trate'])) {
	$_SESSION['chyba'] = "Tuto trať už jsi hodnotil";
	go('trate.php?action=all');
	exit;
}

if($opt == 1) $col = 'proti';
if($opt == 2) $col = 'mezi';
if($opt == 3) $col = 'pro';

if($rat['trate'] == '') $rat['trate'] = ',';

$Sql->q('UPDATE trate SET '.$col.' = '.$col.'+1 WHERE id = '.$id);

$Sql->q('UPDATE hraci SET trate = "'.$rat['trate'].$id.'," WHERE id = '.UID);
  
$_SESSION['chyba'] = "Hodnocení proběhlo úspěšně";
go('showTrat.php?id='.$id);
?>