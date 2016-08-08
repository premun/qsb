<?php

include 'library.php';
is_logged();

$id = $_POST['login'];
$staj = $_POST['staj'];

if($id != '') {
	if(!ereg('^[a-zA-Z0-9 \_\.]+$',$id)) {
		$_SESSION['chyba'] = 'Hledaný hráč neexistuje';
		go('staje.php?action=clenove');
		exit;
	}

	$result = $Sql->q('SELECT * from hraci WHERE login = "'.$id.'"');
	
	if(p($result) == 0) {
		$_SESSION['chyba'] = 'Hledaný hráč neexistuje';
		go('staje.php?action=clenove');
		exit;
	}
	
	$hrac = fa($result);
	$id = $hrac['id'];
}

if($id == '' && $_SESSION['inv_id'] != '') $id = $_SESSION['inv_id'];
if($staj == '' && $_SESSION['inv_staj'] != '') $staj = $_SESSION['inv_staj'];

if(p($Sql->q('SELECT * from stajovnici WHERE login = '.$id)) > 0) {
	$_SESSION['chyba'] = 'Tento hráč už má stáj';
	go('staje.php?action=clenove');
	exit;
}

if(p($Sql->q('SELECT * from staje WHERE login = '.UID.' AND id = '.$staj)) == 0) {
	$_SESSION['chyba'] = 'Nejsi vlastníkem této stáje';
	go('staje.php?action=clenove');
	exit;
}

if((p($Sql->q('SELECT * from stajovnici WHERE staj = '.$staj))-1) >= p($Sql->q('SELECT * from budovy WHERE staj = '.$staj.' AND budova = 2 AND staveni = 0'))) {
	$_SESSION['chyba'] = 'Nemáš dost volných ubikací';
	go('staje.php?action=clenove');
	exit;
}

$_SESSION['inv_id'] = $id;
$_SESSION['inv_staj'] = $staj;

if($_GET['action'] == "confirm") {
	$penize = $_POST['penize'];
	$stav = $_POST['stav'];
	$pomer = $_POST['pomer'];
	
	if($pomer < 10 || $pomer > 90 || !ereg('^[0-9]+$',$penize)) {
		$_SESSION['chyba'] = "Poměr musí být číslo mezi 10 a 90";
		go('invite.php');
		exit;	
	}
	
	if($penize < 0 || $penize == 0 || $penize == '' || !ereg('^[0-9]+$',$penize)) {
		$_SESSION['chyba'] = "Mzda musí být kladné číslo";
		go('invite.php');
		exit;
	}
	$staj2 = fa($Sql->q('SELECT * from staje WHERE id = '.$staj));
	
	$msg = 'Byla ti nabídnuta smlouva se stájí '.$staj2['nazev'].'. Více detailů najdeš v sekci <a href=\"staje.php\"><strong class=\"extra\">Stáje</strong></a>.
	
	SYSTEM';
	
	$Sql->q('INSERT into smlouvy(login,staj,penize,stav,pomer) values('.$id.','.$staj.','.$penize.','.$stav.','.$pomer.')');
	sendPosta(0,$id,$msg);
	
	unset($_SESSION['inv_id']);
	unset($_SESSION['inv_staj']);  
	$_SESSION['chyba'] = "Nabídka odeslána";
	go('staje.php?action=clenove');
	exit;
}

do_header('Stáje');

$page = new cPage('staje');
$page->misc('MENU','OBSAH');
$page->misc('INVITATION','OBSAH');

$result = $Sql->q('SELECT * from staje_stavy WHERE id > 1');
for($i=0;$i<p($result);$i++) {
	$stavy = fa($result);
	$stav[$stavy['id']] = $stavy['stav'];
}

$page->swap('LOGIN',getNick($id));

$data = array();
foreach($stav as $sid=>$stavik) $data[] = array('id' => $sid, 'stav' => $stavik);

$page->getTable('STAVY',$data,'STAVY');

$page->swap('POHAR_NAZEV',POHAR_NAZEV);

$page->finish();
do_footer();
?>