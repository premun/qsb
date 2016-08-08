<?php

session_start();

if($_POST['request_method'] == 'jhadr') define("REQUEST_METHOD","jhadr");

if($_SESSION['id_hrace'] > 0 && $_SESSION['aktivita'] < time()-30*60 && !ereg('odhlas.php',$_SERVER['REQUEST_URI']) && !isset($_COOKIE['autologin'])) {
	$_SESSION['chyba2'] = 'Odhlášen z důvodu neaktivity delší než 30 min';
	header('Location: odhlas.php');
	exit;
}

include 'functions.php';
include 'header.php';
include 'footer.php';
include './cls/cSql.php';
include './cls/cErr.php';
include 'config.php';
include './cls/cPage.php';
include './cls/cDialog.php';
//include './cls/cTime.php';
include './cls/cBanky.php';
include './cls/cKluzak.php';
include './cls/cItem.php';
include './cls/cHrac.php';
include './cls/cReg.php';
include './cls/cInfobox.php';

if(!$_SESSION['id_hrace'] && $_COOKIE['autologin'] && !ereg('odhlas\.php$',$_SERVER['SCRIPT_NAME'])) {
	$result = $Sql->q('SELECT id, login, status, skin, menu, rychle_info FROM hraci WHERE heslo = "'.$_COOKIE['autopsw'].'" AND id = '.$_COOKIE['autologin']);
	if(!p($result)) {
		$_SESSION['chyba2'] = 'Odhlášen - neplatné cookies';
		header('Location: odhlas.php');
		exit;
	}

	$cas = fa($Sql->q('SELECT val FROM sys WHERE entity = "restart"'));
	if($cas['val'] > floor($_COOKIE['autodate']/10)) {
		$_SESSION['chyba2'] = 'Odhlášen - proběhl restart';
		header('Location: odhlas.php');
		exit;
	}

	$row = fa($result);
	$_SESSION['id_hrace'] = $row['id'];
	$_SESSION['status'] = $row['status'];
	if($row['status'] == -1 && !ereg('home\.php$',$_SERVER['SCRIPT_NAME'])) {
		header('Location: home.php');
		exit;
	}
	$_SESSION['nick'] = $row['login'];
	$_SESSION['rychle_info'] = $row['rychle_info'];
	$_SESSION['menu'] = ($row['menu'] == '' ? $default_menu : $row['menu']);
	$_SESSION['aktivita'] = time();
	$rasa = getRasa($row['id']);
	$_SESSION['rasa_nazev'] = $rasa['nazev'];
	$_SESSION['skin'] = $row['skin'];
	$Sql->q('UPDATE hraci SET cas = '.time().', logged = 1, IP = "'.$_SERVER['REMOTE_ADDR'].'" WHERE id = '.$row['id']);
}

define("UID",$_SESSION['id_hrace']);

if(UID) $_SESSION['aktivita'] = time();

//if(UID != 1) include 'probiha_restart.php';

if(UID) $cInfobox = new cInfobox();
?>