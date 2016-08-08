<?php

include 'library.php';

is_logged();

$action = $_GET['action'];

if($action == 'registrace') {
	$sleva = $_POST['sleva'];
	$minimum = $_POST['minimum'];
	
	if($sleva < 50 || $sleva > 130 || !is_numeric($sleva)) {
		$_SESSION['chyba'] = "Rozmezí slev musí být číslo 50-130";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	if($minimum < 0 || !is_numeric($minimum)) {
		$_SESSION['chyba'] = "Minimální cena musí být kladné číslo";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	if(p($Sql->q('SELECT login FROM opravari WHERE login = '.UID))) {
		$_SESSION['chyba'] = "Už jsi jako opravář registrován";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	if(getPenize(UID) < OPRAVAR_REGISTRACE) {
		$_SESSION['chyba'] = "Nemáš dostatek peněz na registraci (".numF(OPRAVAR_REGISTRACE).")";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	$Sql->q('INSERT INTO opravari(login,procenta,minimum) values('.UID.','.$sleva.', '.$minimum.')');
	$Sql->q('UPDATE postavy set penize = penize-'.OPRAVAR_REGISTRACE.' WHERE login = '.UID);
	
	finance(UID,OPRAVAR_REGISTRACE,0,37);
	
	$_SESSION['chyba'] = "Byl jsi úspěšně registrován";
	go('obchod.php?action=opravari');
	exit;	
}

if($action == 'zmena') {
	$sleva = $_POST['sleva'];
	if($sleva < 50 || $sleva > 130 || !is_numeric($sleva)) {
		$_SESSION['chyba'] = "Rozmezí slev musí být číslo 50-130";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	if(!p($Sql->q('SELECT login FROM opravari WHERE login = '.UID))) {
		$_SESSION['chyba'] = "Nejsi jako opravář registrován";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	if(getPenize(UID) < OPRAVAR_ZMENA) {
		$_SESSION['chyba'] = "Nemáš dostatek peněz na zmenu (".numF(OPRAVAR_ZMENA).")";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	$Sql->q('UPDATE opravari set procenta = '.$sleva.' WHERE login = '.UID);
	$Sql->q('UPDATE postavy set penize = penize-'.OPRAVAR_ZMENA.' WHERE login = '.UID);

	finance(UID,OPRAVAR_ZMENA,0,38);	
	
	$_SESSION['chyba'] = "Údaje úspěšně změněny";
	go('obchod.php?action=opravari');
	exit;	
}

if($action == 'minimum') {
	$minimum = $_POST['minimum'];
	
	if($minimum < 0 || !is_numeric($minimum)) {
		$_SESSION['chyba'] = "Minimální cena musí být kladné číslo";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	$Sql->q('UPDATE opravari set minimum = '.$minimum.' WHERE login = '.UID);
	
	$_SESSION['chyba'] = "Údaje úspěšně změněny";
	go('obchod.php?action=opravari');
	exit;	
}

if($action == 'zrusit_registraci') {
	
	if(!p($Sql->q('SELECT login FROM opravari WHERE login = '.UID))) {
		$_SESSION['chyba'] = "Nejsi jako opravář registrován";
		go('obchod.php?action=opravari');
		exit;	
	}
	
	$Sql->q('DELETE FROM opravari WHERE login = '.UID);
	
	$_SESSION['chyba'] = "Opravářská registrace zrušena";
	go('obchod.php?action=opravari');
	exit;	
}

if($action == 'zrusit') {
	$id = $_GET['id'];

	$result = $Sql->q('SELECT * from sklad WHERE id = '.$id);
	if(p($result) == 0) {
		$_SESSION['chyba'] = "Předmět nebyl nalezen";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	$row = fa($result);
	
	if($row['login'] != UID) {
		$_SESSION['chyba'] = "Předmět není tvůj";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	if($row['umisteni'] > 0) {
		$_SESSION['chyba'] = "Předmět není ve smlouvě";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}

	$result2 = $Sql->q('SELECT procenta FROM opravari WHERE login = '.(-1*$row['umisteni']));
	$opravar = fa($result2);

	$Sql->q('UPDATE sklad SET cena2 = 0, umisteni = 0 WHERE id = '.$id);
	$Sql->q('UPDATE postavy SET penize = penize+'.$row['cena2'].' WHERE login = '.UID);
	finance(UID,$row['cena2'],1,40);
	
	$msg = 'Opravářská smlouva s hráčem [B][O]'.$_SESSION['nick'].'[/O][/B] byla tímto hráčem zrušena.

SYSTEM';

	sendPosta(0,(-1*$row['umisteni']),$msg);

	$_SESSION['chyba'] = "Opravářská smlouva zrušena";
	go('obchod.php?action=sklad');
	exit;
}

if($action == 'odmitnout') {
	$id = $_GET['zbozi'];

	$result = $Sql->q('SELECT * FROM sklad WHERE id = '.$id);
	if(p($result) == 0) {
		$_SESSION['chyba'] = "Předmět nebyl nalezen";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	$row = fa($result);
	
	if($row['umisteni'] > 0) {
		$_SESSION['chyba'] = "Předmět není ve smlouvě";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	if($row['umisteni'] != -1*UID) {
		$_SESSION['chyba'] = "Předmět není ve tvé smlouvě";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}

	$Sql->q('UPDATE sklad SET cena2 = 0, umisteni = 0 WHERE id = '.$id);
	$Sql->q('UPDATE postavy SET penize = penize+'.$row['cena2'].' WHERE login = '.$row['login']);
	finance($row['login'],$row['cena2'],1,40);
	
	$msg = 'Opravářská smlouva s hráčem [B][O]'.$_SESSION['nick'].'[/O][/B] byla odmítnuta.

SYSTEM';

	sendPosta(0,$row['login'],$msg);

	$_SESSION['chyba'] = "Opravářská smlouva odmítnuta";
	go('obchod.php?action=opravari');
	exit;
}

if($action == 'opravit') {
	$id = $_GET['zbozi'];
	$login = $_GET['login'];

	if($login == UID) {
		$_SESSION['chyba'] = "Nemůžeš nabídnout smlouvu sám sobě";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}

	$result = $Sql->q('SELECT * from sklad WHERE id = '.$id);
	if(p($result) == 0) {
		$_SESSION['chyba'] = "Předmět nebyl nalezen";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	$row = fa($result);
	
	if($row['login'] != UID) {
		$_SESSION['chyba'] = "Předmět není tvůj";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	if($row['umisteni'] != 0) {
		$_SESSION['chyba'] = "Předmět není volně ve skladu";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}

	$result2 = $Sql->q('SELECT procenta FROM opravari WHERE login = '.$login);

	if(!p($result2)) {
		$_SESSION['chyba'] = "Vybraný hráč není registrovaný opravář";
		go($_SERVER['HTTP_REFERER']);
		exit;	
	}

	$opravar = fa($result2);

	$p = new cItem($row['zbozi'],$row['typ']);

	$cena = $row['cena'];
	
	$vydrz = 100-round($row['vydrz']/$p->vydrz*100);
	
	if($row['vydrz'] == $p->vydrz) {
		$_SESSION['chyba'] = "Předmět není opotřeben";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}

	$b = 0.85;
	$a = (100*(1-$a))/10000;
	$y = $a*$vydrz*$vydrz+$b*$vydrz;
	$cena = $cena/100*$y;
	$rasa = getRasa(UID);
	$cena = $cena/(1+($rasa['o']/300))/2;
	
	if($cena > $row['cena']) $cena = ($cena+2*$row['cena'])/3;
	
	$cena = floor($cena*$opravar['procenta']/100);
	
	$penize = getPenize(UID);
	
	if($penize < $cena) {
		$_SESSION['chyba'] = "Nemáš dostatek peněz";
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	
	$Sql->q('UPDATE sklad SET cena2 = '.$cena.', umisteni = '.(-1*$login).' WHERE id = '.$id);
	$Sql->q('UPDATE postavy SET penize = penize-'.$cena.' WHERE login = '.UID);
	finance(UID,$cena,0,40);
	
	$msg = 'Byla ti nabídnuta nová opravářská smlouva od hráče [B][O]'.$_SESSION['nick'].'[/O][/B]. Více detailů najdeš v <a href="obchod.php?action=opravari">opravářské sekci</a>.

Peníze na opravu obdržíš až přímo při opravě předmětu.

SYSTEM';

	sendPosta(0,$login,$msg);

	$_SESSION['chyba'] = "Opravářská smlouva nabídnuta";
	go('obchod.php?action=sklad');
	exit;
}
?>