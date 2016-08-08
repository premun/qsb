<?php

include 'library.php';
is_logged();

$action = $_GET['action'];

if($action == 'pujcit') {
	$kolik = $_POST['kolik'];
	$ir = $_POST['ir'];
	$spl = $_POST['spl'];
	$tempBanka = new banka($_POST['banka']);
	
	if($kolik == '' || !ereg('^[0-9]+$',$kolik)) {
		$_SESSION['chyba'] = "Nevyplnil jsi správně všechny údaje!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	if($kolik <= 0) {
		$_SESSION['chyba'] = "Nevyplnil jsi kladné číslo!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	if(p($Sql->q('SELECT hrac FROM pujcky WHERE typ = "P" AND hrac = '.UID))) {
		$_SESSION['chyba'] = "Už máš půjčku!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	$limit = getMovitost(UID,$tempBanka->id);
	
	if($kolik > $limit) {
		$_SESSION['chyba'] = "Tolik si nemůžeš půjčit! Banka ti půjčí maximálně ".numF($limit)." Is";
		go('banky.php?action=pujcky');
		exit;
	}
	
	$tempBanka->poskytnutiPujcky($kolik, UID, $spl, $ir);
	
	finance(UID,$kolik,1,14);
	
	go('banky.php?action=pujcky');
	exit;
}

if($action == 'splatit') {
	$kolik = $_POST['kolik'];
	
	@$pujcka = fa($Sql->q('SELECT vyse FROM pujcky WHERE typ = "P" AND hrac = '.UID));
	
	@$pujcka = $pujcka['vyse'];
	
	$tempBanka = new banka($_POST['banka']);
	
	$page = new cPage('banky');
	
	$page->setCommon('MAIN');
	
	if($kolik == '' || !ereg('^[0-9]+$',$kolik)) {
		$_SESSION['chyba'] = "Nevyplnil jsi správně všechny údaje!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	if($kolik <= 0) {
		$_SESSION['chyba'] = "Nevyplnil jsi kladné číslo!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	if($kolik > $pujcka) {
		$_SESSION['chyba'] = "Nemůžeš splatit víc, než máš půjčeno!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	$kolik2 = $kolik;
	
	if($kolik >= getPenize(UID)) {
		$_SESSION['chyba'] = "Nemáš tolik peněz!";
		go('banky.php?action=pujcky');
		exit;
	}
	
	$tempBanka->splaceniPujcky($kolik, UID);
	
	finance(UID,$kolik,0,27);
	
	$_SESSION['chyba'] = "Částka splacena";
	go('banky.php');
	exit;
}

if($action == 'vlozit') {
	$kolik = $_POST['kolik'];
	$tempBanka = new banka($_POST['banka']);
	
	if($kolik == '' || !ereg('^[0-9]+$',$kolik)) {
		$_SESSION['chyba'] = "Nevyplnil jsi správně všechny údaje!";
		go('banky.php?action=vklady');
		exit;
	}
	
	if($kolik <= 0) {
		$_SESSION['chyba'] = "Nevyplnil jsi kladné číslo!";
		go('banky.php?action=vklady');
		exit;
	}
	
	if($kolik > getPenize(UID)) {
		$_SESSION['chyba'] = "Nemáš tolik peněz!";
		go('banky.php?action=vklady');
		exit;
	}
	
	$tempBanka->prijetiVkladu($kolik, UID, 0);
	
	finance(UID,$kolik,0,28);
	
	go('banky.php?action=vklady');
	exit;
}

if($action == 'vybrat') {
	$kolik = $_POST['kolik'];
	$vklad = $_POST['vklad'];
	$tempBanka = new banka($_POST['banka']);
	
	if($kolik == '' || !ereg('^[0-9]+$',$kolik)) {
		$_SESSION['chyba'] = "Nevyplnil jsi správně všechny údaje!";
		go('banky.php?action=vklady');
		exit;
	}
	
	if($kolik <= 0) {
		$_SESSION['chyba'] = "Nevyplnil jsi kladné číslo!";
		go('banky.php?action=vklady');
		exit;
	}
	
	$row = fa($Sql->q('SELECT vyse FROM pujcky WHERE hrac = '.UID.' AND typ = "V"'));
	
	$vklad = $row['vyse'];
	
	if($kolik > $vklad && $vklad != 0) {
		$_SESSION['chyba'] = "Nemůžeš vybrat více peněž než máš na účtu!";
		go('banky.php?action=vklady');
		exit;
	}
	
	$tempBanka->vybraniVkladu($kolik, UID);
	
	finance(UID,$kolik,1,15);
	
	go('banky.php?action=vklady');
	exit;
}
?>