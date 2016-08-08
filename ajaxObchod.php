<?php

include 'library.php';
is_logged();
$zbozi = $_GET['id'];

$result = $Sql->q('SELECT * from sklad WHERE id = '.$zbozi);
if(p($result) == 0) {
	die('last');
	exit;
}

$vec = fa($result);
if($vec['login'] != UID) {
	die('last');
	exit;  
}

if(p($Sql->q('SELECT zavody.id FROM zavodnici LEFT JOIN zavody ON zavodnici.zavod = zavody.id WHERE zavody.vitez = 0 AND zavodnici.login = '.UID))) {
	if($_GET['action'] == 'out') {
		die('<span class="error">Jsi v závodě!</span>');
	} else {
		die('last');
	}
	exit;    
}

$predmet = new cItem($vec['zbozi'],$vec['typ']);

if($_GET['action'] == 'out') {
	$Sql->q('UPDATE sklad set umisteni = 0 WHERE umisteni < 10000 AND id = '.$zbozi);
	
	echo '<span class="ultra"><a><span class="submit" onclick=\'jHadr("vyloha.php", {id: "'.$zbozi.'", vyloha: "true", action: "nastav_cenu", cena: "'.round($vec['cena']*($vec['vydrz']/$predmet->vydrz)).'"})\'>Výloha</span></a>'.($j != 11 ? '&nbsp;/&nbsp;<a class="submit" onclick="predmet('.$zbozi.',\'in\')">Kluzák</a>' : '');
					
	if($vec['vydrz'] < $predmet->vydrz && $j != 11) {			
		$cas = getOpravaCas(round($vec['vydrz']/$predmet->vydrz*100),$rasa['o']);
		$delka = $cas-time();
		$box = 'Oprava potrvá '.($delka/60 > 59 ? floor($delka/3600).'h ' : '').round($delka/60-floor($delka/3600)*60).'min '.($delka%60).'s<br /><span>('.date('H:i j.n.',$cas).')</span>';
		
		echo '<span class="ultra">&nbsp;/&nbsp;<a href="repair.php?id='.$zbozi.'" onmousemove="showBox(\''.$box.'\',event)" onmouseout="hideBox()">Oprav</a>';
	}

	echo '<span class="ultra">&nbsp;/&nbsp;<a class="submit" onclick="jHadr(\'srot.php?id='.$zbozi.'\', {})">Šrot</a>';

	exit;
}

$kluzak = new cKluzak(UID);

if($vec['typ'] != 1) {
	if($predmet->podvozek > 0) {
		$res2 = $Sql->q('SELECT zbozi FROM sklad WHERE umisteni = 1 AND typ = 1 AND login = '.UID);
		if(p($res2) > 0) {
			$row = fa($res2);
			$p = fa($Sql->q('SELECT typ FROM podvozky WHERE id = '.$row['zbozi']));
			if($predmet->podvozek != $p['typ']) {
				die('last'); 	  
			}
		}
	}
}

if($vec['typ'] == 1) {
	foreach($kluzak->tabs as $name) {
		if(isset($kluzak->{$name}['podvozek'])) {
			if($kluzak->{$name}['podvozek'] != 0 && $kluzak->{$name}['podvozek'] != $predmet->typ && isset($kluzak->{$name}['podvozek'])) {
				die('last'); 	  
			}
		}
	}
}

$refresh = false;
if(p($Sql->q('SELECT id FROM sklad WHERE login = '.UID.' AND umisteni = 1 AND typ = '.$vec['typ']))) $refresh = true;

$Sql->q('UPDATE sklad set umisteni = 0 WHERE login = '.UID.' AND umisteni = 1 AND typ = '.$vec['typ']);
$Sql->q('UPDATE sklad set umisteni = 1 WHERE login = '.UID.' AND umisteni < 10000 AND id = '.$zbozi);

if($refresh) die('refresh');

echo '<span class="ultra">Část kluzáku&nbsp;/&nbsp;</span><a class="submit" onclick="predmet('.$zbozi.',\'out\')">Vyndat</a>';
				
echo '</span>';
?>