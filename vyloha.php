<?php

include 'library.php';
is_logged();

$action = $_GET['action'];
if($action == "") $action = $_POST['action'];

$page = new cPage('obchod');
$dlg = new cDialog('Vystavování předmětu', 'alert', 'width: 350px');

if($action == 'nastav_cenu' && $_POST['action2'] != 'sablony') {
	$row = fa($Sql->q('SELECT typ FROM sklad WHERE id = '.$_POST['id']));

	$sablony = p($Sql->q('SELECT id FROM sablony WHERE login = '.UID.' AND '.$tabs[$row['typ']].' = '.$_POST['id']));
	if($sablony) {
		$fill['id'] = $_POST['id'];
		$fill['vyloha'] = $_POST['vyloha'];
		$fill['cena'] = $_POST['cena'];
		$fill['sablony'] = $sablony;
		
		$dlg->body($page->ext('VYLOHA_SABLONA',0,0,$fill));
		$dlg->button('Zrušit', 'close');
		$dlg->button('Vystavit předmět', 'jHadr_submit', 'vyloha_cena');
		$dlg->output();
	} else {
		$action = 'nastav_cenu';		
	}
}

if($action == 'nastav_cenu') {	
	$fill['action'] = 'sklad';
	$fill['id'] = $_POST['id'];
	$fill['vyloha'] = $_POST['vyloha'];
	$fill['cena'] = $_POST['cena'];
	$fill['cena1'] = numF(ceil($_POST['cena']*MIN_VYLOHA_CENA));	
	$fill['cena2'] = numF(floor($_POST['cena']*MAX_VYLOHA_CENA));	
	$fill['cena3'] = ceil($_POST['cena']*MIN_VYLOHA_CENA);	
	
	$dlg->body($page->ext('VYLOHA_CENA',0,0,$fill));
	$dlg->button('Zrušit', 'close');
	$dlg->button('Vystavit předmět', 'jHadr_submit', 'vyloha_cena');
	$dlg->output();
}

if($action == 'skryt') {
	$Sql->q('UPDATE postavy set vyloha = 0 WHERE login = '.UID);
	$_SESSION['chyba'] = 'Výloha skryta';
	go('obchod.php?action=vyloha');
	exit;	
}

if($action == 'zobrazit') {
	$Sql->q('UPDATE postavy set vyloha = 1 WHERE login = '.UID);
	$_SESSION['chyba'] = 'Výloha zpřístupněna';
	go('obchod.php?action=vyloha');
	exit;	
}

$id = $_POST['id'];
$result = $Sql->q('SELECT * FROM sklad WHERE id = '.$id);
$row = fa($result);
$cena = $_POST['cena'];

$url = 'obchod.php?action='.$action;

$p = new cItem($row['zbozi'],$row['typ']);

$row['cena'] = round($row['cena']*($row['vydrz']/$p->vydrz));

if($row['login'] != UID) {
	$_SESSION['chyba'] = 'Nemáš právo dát tento předmět do výlohy, protože ho nevlastníš';
	$dlg->obody($_SESSION['chyba']);
	go($url);
	konec();
}

if(($cena == '' || !ereg('^[0-9]+$',$cena)) && $_GET['vyloha'] != 'false') {
	$_SESSION['chyba'] = 'Cena musí být číslo';
	$dlg->obody($_SESSION['chyba']);
	go($url);
	konec();
}

if(($row['cena']*MIN_VYLOHA_CENA) > $cena && $_GET['vyloha'] != 'false') {
	$_SESSION['chyba'] = 'Cena musí být větší než '.numF($row['cena']*MIN_VYLOHA_CENA).'Is';
	$dlg->obody($_SESSION['chyba']);
	go($url);
	konec();
}

if(($row['cena']*MAX_VYLOHA_CENA) < $cena && $_GET['vyloha'] != 'false') {
	$_SESSION['chyba'] = 'Cena musí být menší než '.numF($row['cena']*MAX_VYLOHA_CENA).'Is';
	$dlg->obody($_SESSION['chyba']);
	go($url);
	konec();
}

if(!$dlg->is_empty()) {
	$fill['action'] = $action;
	$fill['id'] = $_POST['id'];
	$fill['vyloha'] = $_POST['vyloha'];
	$fill['cena'] = $row['cena'];
	$fill['cena1'] = numF(ceil($row['cena']*MIN_VYLOHA_CENA));	
	$fill['cena2'] = numF(floor($row['cena']*MAX_VYLOHA_CENA));	
	$fill['cena3'] = ceil($row['cena']*MIN_VYLOHA_CENA);	
	
	$dlg->body($page->ext('VYLOHA_CENA',0,0,$fill));
	$dlg->button('Zrušit', 'close');
	$dlg->button('Vystavit předmět', 'jHadr_submit', 'vyloha_cena');
	$dlg->output();
}

if($_POST['vyloha'] == 'true') {
	$Sql->q('UPDATE sklad SET umisteni = 2, cena2 = '.$cena.' WHERE id = '.$id.' AND umisteni < 10000 AND login = '.UID);
	$_SESSION['chyba'] = 'Předmět byl vystaven za <strong>'.numF($cena).' Is</strong>.';
} else {
	$Sql->q('UPDATE sklad SET umisteni = 0, cena2 = 0 WHERE id = '.$id.' AND umisteni < 10000 AND login = '.UID);
	$_SESSION['chyba'] = 'Předmět byl stáhnut z výlohy.';
}

$dlg->obody($_SESSION['chyba']);
$dlg->button('OK','location',$url);
$dlg->output();

go($url);
?>