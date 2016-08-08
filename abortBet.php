<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

if(!is_numeric($id)) {
	go('sazky.php');
	exit;
}

$result = $Sql->q('SELECT id,sazka,zavod,login,vyhra FROM sazky WHERE id = '.$id);
$sazka = fa($result);

$page = new cPage('sazky');

$page->setCommon('COMMON_RUSENI');

if($sazka['login'] != UID) {
	$page->ext('CANCEL',1,'Sázky');
	exit;
}

$vklad = $sazka['sazka'];
$zpet = round($vklad*0.75);
$zavod = $sazka['zavod'];

$result2 = $Sql->q('SELECT id,vitez FROM zavody WHERE id = '.$zavod);
$zavod = fa($result2);

if($zavod['vitez'] != 0) {
	$page->ext('ODJET',1,'Sázky');
	exit;
}

if($_GET['action'] == 'auto') { 
	$Sql->q('UPDATE sazky set vyhra = '.($sazka['vyhra'] == -1 ? 0 : -1).' WHERE id = '.$sazka['id']);
	$_SESSION['chyba'] = 'Auto-zrušení nastaveno';
	go($_SERVER['HTTP_REFERER'].'#sazky');
	exit;
}

$Sql->q('UPDATE postavy set penize = penize+'.$zpet.' WHERE login = '.UID);
$Sql->q('UPDATE zavody set sazky = sazky-'.$zpet.' WHERE id = '.$zavod['id']);
$Sql->q('DELETE FROM sazky WHERE id = '.$id);

finance(UID,$zpet,1,8);

$_SESSION['chyba'] = 'Sázka byla zrušena';
go('sazky.php');
?>