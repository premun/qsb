<?php

include 'library.php';
is_logged();
$zbozi = $_GET['id'];

$result = $Sql->q('SELECT * from sklad WHERE id = '.$zbozi);
if(p($result) == 0) {
	$_SESSION['chyba'] = 'Taková věc neexistuje';
	go('obchod.php?action=sklad');
	exit;
}
$vec = fa($result);
if($vec['login'] != UID) {
	$_SESSION['chyba'] = 'Tato součástka nepatří tobě, takže si ji ani nenamontuješ do svého kluzáku';
	go('obchod.php?action=sklad');
	exit;  
}

if(p($Sql->q('SELECT zavody.id FROM zavodnici LEFT JOIN zavody ON zavodnici.zavod = zavody.id WHERE zavody.vitez = 0 AND zavodnici.login = '.UID))) {
	$_SESSION['chyba'] = 'Nemůžeš změnit díly kluzáku, protože se účastníš nějakého závodu';
	go('obchod.php?action=sklad');
	exit;    
}

if($_GET['action'] == 'out') {
	$Sql->q('UPDATE sklad set umisteni = 0 WHERE umisteni < 10000 AND id = '.$zbozi);
	go('obchod.php?action=sklad');
	exit;
}

$predmet = new cItem($vec['zbozi'],$vec['typ']);
$kluzak = new cKluzak(UID);

if($vec['typ'] != 1) {
	if($predmet->podvozek > 0) {
		$res2 = $Sql->q('SELECT zbozi FROM sklad WHERE umisteni = 1 AND typ = 1 AND login = '.UID);
		if(p($res2) > 0) {
			$row = fa($res2);
			$p = fa($Sql->q('SELECT typ FROM podvozky WHERE id = '.$row['zbozi']));
			if($predmet->podvozek != $p['typ']) {
				$_SESSION['chyba'] = 'Tento předmět nepasuje do tvého podvozku';
				go('obchod.php?action=sklad');
				exit;  	 
			}
		}
	}
}

if($vec['typ'] == 1) {
	foreach($kluzak->tabs as $name) {
		if(isset($kluzak->{$name}['podvozek'])) {
			if($kluzak->{$name}['podvozek'] != 0 && $kluzak->{$name}['podvozek'] != $predmet->typ && isset($kluzak->{$name}['podvozek'])) {
				$_SESSION['chyba'] = $kluzak->{$name}['nazev'].' nepasuje do tohoto podvozku';
				go('obchod.php?action=sklad');
				exit; 	  
			}
		}
	}
}

$Sql->q('UPDATE sklad set umisteni = 0 WHERE login = '.UID.' AND umisteni = 1 AND typ = '.$vec['typ']);
$Sql->q('UPDATE sklad set umisteni = 1 WHERE login = '.UID.' AND umisteni < 10000 AND id = '.$zbozi);

go('obchod.php?action=sklad');
?>