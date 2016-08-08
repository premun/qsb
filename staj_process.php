<?php

include 'library.php';
is_logged();

$action = $_GET['action'];

# predatStaj
if($action == 'predatStaj') {
	$login = $_POST['login'];
	$staj = $_POST['staj'];
	
	if($staj == "") {
		$staj = 0;
	}
	
	if(!p($Sql->q('SELECT * from stajovnici WHERE login = '.UID.' AND staj = '.$staj.' AND stav = 1'))) {
		$_SESSION['chyba'] = 'Nejsi vlastník stáje';
		go('staje.php');
		exit;
	}
	
	$result = $Sql->q('SELECT login,stav,datum,penize FROM stajovnici WHERE login = '.$login.' AND staj = '.$staj.' AND stav != 1');
	if(!p($result)) {
		$_SESSION['chyba'] = 'Vybraný hráč není členem tvé stáje';
		go('staje.php');
		exit;
	}
	
	if(p($Sql->q('SELECT login FROM pohar WHERE login = '.$login)) > 0) {
		$_SESSION['chyba'] = "Nemůžeš dát vlastníkem účastníka poháru";
		go('staje.php?action=clenove');
		exit;  
	}
	
	$hrac = fa($result);
	
	if(!lastChange($hrac['datum'])) {
		$_SESSION['chyba'] = "Smlouva hráči jde změnit jen jednou za 3 dny";
		go('staje.php');
		exit;
	}
	
	$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d").'", stav = '.$hrac['stav'].', penize = '.$hrac['penize'].' WHERE login = '.UID);
	$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d",time()-60*60*24).'", stav = 1, penize = 0, pomer = 50 WHERE login = '.$login);
	$Sql->q('UPDATE staje set login = '.$login.' WHERE id = '.$staj);
	
	
	$msg = 'Vlastník tvé stáje převedl stáj na tebe. Odteď jsi vlastník ty.
	
	SYSTEM';
	
	sendPosta(0,$login,$msg);
	
	$_SESSION['chyba'] = "Stáj převedena";
	
	go('staje.php');
}

#budovy
if($action == 'postavitBudovu' || $action == 'zboritBudovu') {
	$id = $_POST['budova'];
	$staj = $_POST['staj'];
	$obsazeno = $_POST['obsazeno'];
	$pozemek = $_POST['pozemek'];
	
	if($id == '') {
		$_SESSION['chyba'] = "Nebyla vybrána žádná budova";
		go('staje.php?action=budovy');
		exit;
	}
	
	$result2 = $Sql->q('SELECT * from staje WHERE id = '.$staj.' AND login = '.UID);
	if(p($result2) == 0) {
		$_SESSION['chyba'] = "Nejsi vlastník této stáje";
		go('staje.php?action=budovy');
		exit;
	}
	$staj = fa($result2);
	
	if($_GET['action'] == "zboritBudovu") {
		$res = $Sql->q('SELECT * from budovy WHERE staj = '.$staj['id'].' AND id = '.$id);
		if(p($res) == 0) {
			$_SESSION['chyba'] = "Tato budova nepatří tvé stáji";
			go('staje.php?action=budovy');
			exit;
		}
		if($staj['kasa'] < ZBOURANI) {
			$_SESSION['chyba'] = "Ve stájové kase není dost peněz na zbourání budovy (300 Is)";
			go('staje.php?action=budovy');
			exit;
		}
		
		$row = fa($res);
		
		if($row['budova'] == 2) {
			$budov = p($Sql->q('SELECT * from budovy WHERE staj = '.$staj['id'].' AND staveni = 0 AND budova = 2'));
			$hracu = p($Sql->q('SELECT * from stajovnici WHERE staj = '.$staj['id']));
			if(($hracu-1)-$budov == 0) {
				$_SESSION['chyba'] = "Nemůžeš zbořit ubikaci, ve které je hráč";
				go('staje.php?action=budovy');
				exit;  
			}
		}
	
		$Sql->q('UPDATE staje set kasa = '.($staj['kasa']-ZBOURANI).' WHERE id = '.$staj['id']);
		$Sql->q('DELETE from budovy WHERE id = '.$id);
		
		$_SESSION['chyba'] = "Budova zbourána";
		go('staje.php?action=budovy');
		exit;
	}
	
	
	
	$result = $Sql->q('SELECT * from budovy_typy WHERE id = '.$id);
	if(p($result) == 0) {
		$_SESSION['chyba'] = "Taková budova neexistuje";
		go('staje.php?action=budovy');
		exit;
	}
	
	$budova = fa($result);
	
	if(($budova['misto']+$obsazeno) > $pozemek) {
		$_SESSION['chyba'] = "Na pozemku není dost místa";
		go('staje.php?action=budovy');
		exit;
	}
	
	if($staj['kasa'] < $budova['penize']) {
		$_SESSION['chyba'] = "Ve stájové kase není dost peněz na tuto budovu";
		go('staje.php?action=budovy');
		exit;
	}
	
	$Sql->q('INSERT into budovy(budova,staj,staveni) values('.$budova['id'].','.$staj['id'].','.$budova['staveni'].')');
	$Sql->q('UPDATE staje set kasa = '.($staj['kasa']-$budova['cena']).', prestiz = '.($staj['prestiz']+$budova['prestiz']).' WHERE id = '.$staj['id']);
	$Sql->q('UPDATE stats set budovy = budovy+1 WHERE login = '.UID);	
	
	$budov = p($Sql->q('SELECT staj FROM budovy WHERE staj = '.$staj['id']));
	
	if($budov == 12) addQuest(UID,49,0);
	if($budov == 20) addQuest(UID,50,0);
	
	$_SESSION['chyba'] = 'Budova byla zakoupena';
	go('staje.php?action=budovy');
}

# nastenka
if($action == 'nastenka') {
	$dlg = new cDialog('Nástěnka','alert','width: 250px');
	
	$dlg->button('OK', 'close');
	
	$result = $Sql->q('SELECT staj FROM stajovnici WHERE stav = 1 AND login = '.UID);
	if(p(!$result)) {
		$dlg->obody('Nejsi vlastník této stáje');
		konec();
		$dlg->output();
	}
	
	$staj = fa($result);
	
	$obsah = str_replace('<','&lt;',$_POST['obsah']);
	$obsah = str_replace('>','&gt;',$obsah);
	
	$Sql->q('UPDATE nastenka set obsah = "'.addslashes($obsah).'" WHERE sekce = 2 AND login = '.$staj['staj']);
	 
	$page = new cPage('staje');
	$dlg->obody($page->misc('NASTENKA'));
	$dlg->output();
}

# parcely
if($action == 'parcela') {
$staj = $_GET['id'];

if($staj == '') {
	$_SESSION['chyba'] = "";
	go('staje.php');
	exit;
}

$result = $Sql->q('SELECT * from staje WHERE id = '.$staj.' AND login = '.UID);
if(p($result) == 0) {
	$_SESSION['chyba'] = "Nejsi vlastník této stáje";
	go('staje.php');
	exit;
}
$staj = fa($result);

$cena = (PARCELA+(($staj['pozemek']-5)*NEW_PARCELA));

if($staj['kasa'] < $cena) {
	$_SESSION['chyba'] = "V kase není dost peněz";
	go('staje.php');
	exit;
}

$Sql->q('UPDATE staje set kasa = '.($staj['kasa']-$cena).', pozemek = '.($staj['pozemek']+1).' WHERE id = '.$staj['id']);
$_SESSION['chyba'] = "Pozemek dokoupen";
go('staje.php?action=budovy');
}

# zmena smluv
if($action == 'smlouva') {
	$id = $_POST['id'];
	$staj = $_POST['staj'];
	
	$dlg = new cDialog('Změna smlouvy','alert','width: 400px, height: auto');
	
	if($id == '' || $staj == '') {
		$dlg->obody('Nevyplnil jsi všechny požadované údaje');
		konec();
	}
	
	$result2 = $Sql->q('SELECT * from staje WHERE id = '.$staj.' AND login = '.UID);
	if(p($result2) == 0) {
		$dlg->obody('Nejsi vlastník této stáje');
		konec();
	}
	$staj2 = fa($result2);
	
	$result = $Sql->q('SELECT login,staj,stav,penize,pomer, DATE_FORMAT(datum, "%Y-%m-%d") datum from stajovnici WHERE login = '.$id.' AND staj = '.$staj);
	if(p($result2) == 0) {
		$dlg->obody('Tento hráč není ve tvojí stáji');
		konec();
	}
	
	$hrac = fa($result);
	
	if(!lastChange($hrac['datum'])) {
		$dlg->obody('Smlouva jde změnit jen jednou za 3 dny');
		konec();
	}
	
	if($_POST['stav'] == 2 && p($Sql->q('SELECT id FROM postavy WHERE zavody > 4 AND login = '.$id)) == 0) {
		$dlg->obody('Závodník musí mít odjeto alespoň 5 závodů');
		konec();
	}
	
	if($_POST['stav'] == 3) {
		$res = fa($Sql->q('SELECT val FROM sys WHERE entity = "pohar"'));
		
		if($res['val'] != 42 && $res['val'] != -2) {
			$res = $Sql->q('SELECT login FROM pohar WHERE login = '.$id);
			if(p($res) > 0) {
				$dlg->obody('Nemůžeš dát obchodníkem účastníka poháru'); 
				konec();
			}
		}
	}
	
	if(!$dlg->is_empty()) {
		$dlg->button('OK', 'close');
		$dlg->output();
		konec();
	}	
	
	$stavy[2] = "závodník";
	$stavy[3] = "obchodník";
	
	$minule = fa($Sql->q('SELECT penize FROM stajovnici WHERE login = '.$id));
	$platy = fa($Sql->q('SELECT SUM(penize) as celkem FROM stajovnici WHERE staj = '.$staj.' AND login != '.$id));
	$kasa = fa($Sql->q('SELECT kasa from staje WHERE id = '.$staj));
	
	$max = $kasa['kasa']-$platy['celkem'];
	if($max < 0) $max = 0;
	
	
	if($_POST['penize'] == "" && $_POST['stav'] == "") {
		if($hrac['stav'] == 3) $checked = " selected";
		
		$fill['checked'] = ($hrac['stav'] == 3 ? ' selected="selected"' : '');
		$fill['nick'] = getNick($id);
		$fill['stav'] = $stavy[$hrac['stav']];
		$fill['pomer'] = $hrac['pomer'];
		$fill['penize'] = ($hrac['penize']);
		$fill['id'] = $id;
		$fill['staj'] = $staj;
		$fill['max'] = numF($max);
		$fill['pohar_nazev'] = POHAR_NAZEV;
		
		$page = new cPage('staje');
		
		$page->main = $page->misc('CHANGE_SMLOUVA');
		
		$page->fill($fill);
		
		$dlg->button('Zrušit', 'close');
		$dlg->button('Změnit', 'jHadr_submit', 'form_smlouva');
		$dlg->body($page->finish());
		$dlg->output();
		konec();
	}
	
	if($_POST['stav'] != "") {
		$platy = fa($Sql->q('SELECT SUM(penize) as celkem FROM stajovnici WHERE staj = '.$staj.' AND login != '.$id));
		$kasa = fa($Sql->q('SELECT kasa from staje WHERE id = '.$staj));
		$max = $kasa['kasa']-$platy['celkem'];
		if($max < 0) $max = 0;
		
		$pomer = $_POST['pomer'];
		
		if($pomer < 10 || $pomer > 90) {
			$dlg->obody('Poměr musí být v rozmezí 10-90');
			konec();
		}
			
		if($hrac['stav'] != $_POST['stav']) {
			$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d").'", stav = '.$_POST['stav'].', pomer = '.$pomer.' WHERE login = '.$id.' AND staj = '.$staj);
			if($_POST['penize'] != "") {
				$penize = $_POST['penize'];
				if(!ereg('^[0-9]+$',$penize)) {
					$dlg->obody('Mzda není vyjádřena čísly');
				}
		
				if(!$dlg->is_empty()) {
					$dlg->button('OK', 'close');
					$dlg->output();
					konec();
				}
		
				$dlg->obody('Smlouva byla změněna, další změna bude možná za 3 dny');
				$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d").'", penize = '.$penize.', pomer = '.$pomer.' WHERE login = '.$id.' AND staj = '.$staj);
			}
			go("staje.php?action=clenove");
		} else {
			if($_POST['penize'] != "") {
				$penize = $_POST['penize'];
				if(!ereg('^[0-9]+$',$penize)) {
					$dlg->obody('Mzda není vyjádřena čísly');
					konec();
				}
				
				if($penize > $max && $penize > $minule['penize']) {
					$dlg->obody('Mzda je moc vysoká');
					konec();
				}
		
				if(!$dlg->is_empty()) {
					$dlg->button('OK', 'close');
					$dlg->output();
					konec();
				}
				
				$dlg->obody('Smlouva byla změněna, další změna bude možná za 3 dny');
				$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d").'", penize = '.$penize.', pomer = '.$pomer.' WHERE login = '.$id.' AND staj = '.$staj);
				konec();
			}
			go('changeSmlouva.php?staj='.$staj.'&id='.$id);
		}
		
		$dlg->button('OK','refresh');
		$dlg->output();
		konec();
	}
}

# nabidka do staje
if($action == 'nabidka') {
	$dlg = new cDialog('Nabídka do stáje', 'alert', 'width: 300px');

	$id = $_POST['id'];
	
	$result2 = $Sql->q('SELECT * from smlouvy WHERE id = '.$id);
	if(p($result2) == 0) {
		$dlg->obody('Hledaná smlouva neexistuje');
		konec();
	}
	$smlouva = fa($result2);
	
	if($smlouva['login'] != UID) {
		$dlg->obody('Tato smlouva není pro tebe');
		konec();
	}
	
	$id = $smlouva['staj'];
	
	if($id == '' || !ereg('^[0-9]+$',$id)) {
		$dlg->obody('Hledaná stáj neexistuje');
		konec();
	}
	
	do_header('Stáje');
	
	$page = new cPage('staje');
	$page->setCommon('INVITE');
	
	$result = $Sql->q('SELECT * from staje_stavy');
	for($i=0;$i<p($result);$i++) {
		$stavy = fa($result);
		$stav[$stavy['id']] = $stavy['stav'];
	}
	
	$result = $Sql->q('SELECT id,nazev FROM staje WHERE id = '.$id);
	
	if(p($result) == 0) {
		$dlg->obody('Hledaná stáj neexistuje');
		konec();
	}
	
	$staj = fa($result);
	
	$fill['nazev'] = $staj['nazev'];
	$fill['penize'] = numF($smlouva['penize']);
	$fill['vstup'] = numF(STAJ_VSTUP);
	$fill['funkce'] = $stav[$smlouva['stav']];
	$fill['pomer'] = $smlouva['pomer'];
	
	$zavody = fa($Sql->q('SELECT zavody FROM postavy WHERE login = '.UID));
	if($smlouva['stav'] == 2 && $zavody['zavody'] < 5) {
		$dlg->obody($page->ext('INVITE_ODJETO',1,0,$fill));
		konec();
	}
	
	if(getPenize(UID) < STAJ_VSTUP) {
		$dlg->obody($page->ext('INVITE_PENIZE',1,0,$fill));
		konec();
	}
	
	if($dlg->is_empty()) {
		$dlg->set('width','400px');
		$dlg->body($page->ext('INVITE',1,0,$fill));
		$dlg->button('Zrušit','close');
		$dlg->button('Podepsat smlouvu','location','staj_process.php?action=podepsat&id='.$smlouva['id']);
		$dlg->output();
	}
	
	$dlg->button('OK','close');
	$dlg->output();
}

# podepsani nabidky
if($action == 'podepsat') {
	$id = $_GET['id'];
	if($id == '' || !ereg('^[0-9]+$',$id)) {
		$_SESSION['chyba'] = 'Hledaná smlouva neexistuje';
		go('staje.php');
		exit;
	}
	
	$result = $Sql->q('SELECT * from smlouvy WHERE id = '.$id);
	if(p($result) == 0) {
		$_SESSION['chyba'] = 'Hledaná smlouva neexistuje';
		go('staje.php');
		exit;
	}
	
	$smlouva = fa($result);
	
	if($smlouva['login'] != UID) {
		$_SESSION['chyba'] = 'Tato smlouva není pro tebe';
		go('staje.php');
		exit;
	}
	
	if(p($Sql->q('SELECT * from stajovnici WHERE login = '.UID)) > 0) {
		$_SESSION['chyba'] = 'Už máš stáj';
		go('staje.php');
		exit;
	}
	
	if($smlouva['stav'] != 3) {
		$zavody = fa($Sql->q('SELECT zavody FROM postavy WHERE login = '.UID));
		if($zavody['zavody'] < 5) {
			$_SESSION['chyba'] = 'Nemáš odjeto 5 závodů';
			go('staje.php');
			exit;
		}
	}
	
	if(getPenize(UID) < STAJ_VSTUP) {
		$_SESSION['chyba'] = 'Nemáš '.numF(STAJ_VSTUP).' Is jako vstupné stáje';
		go('staje.php');
		exit;
	}
	
	$nick = getNick(UID);
	$res = $Sql->q('SELECT * from smlouvy WHERE id != '.$id.' AND staj != '.$smlouva['staj'].' AND login = '.UID);
	for($i=0;$i<p($res);$i++) {
		$sm = fa($res);
		$st = fa($Sql->q('SELECT * from staje WHERE id = '.$sm['staj']));
		$msg = 'Hráč '.$nick.', kterému jsi poslal nabídku vstupu do tvojí stáje, podepsal smlouvu s jinou stájí ('.$st['nazev'].').
		
		SYSTEM';
		sendPosta(0,$st['login'],$msg);
		$Sql->q('DELETE from smlouvy WHERE id = '.$sm['id']);
	}
	
	$Sql->q('DELETE from smlouvy WHERE login = '.UID);
	
	$staj = fa($Sql->q('SELECT * from staje WHERE id = '.$smlouva['staj']));
	
	$Sql->q('DELETE from smlouvy WHERE id = '.$id);
	
	$msg = 'Hráč '.$nick.', kterému jsi poslal nabídku vstupu do tvojí stáje, smlouvu podepsal a stal se členem tvojí stáje.
	
	SYSTEM';
	  sendPosta(0,$staj['login'],$msg);
	
	$Sql->q('UPDATE staje set kasa = '.($staj['kasa']+STAJ_VSTUP_ZPET).' WHERE id = '.$smlouva['staj']);
	
	$Sql->q('UPDATE postavy set penize = penize-'.STAJ_VSTUP.' WHERE login = '.UID);
	finance(UID,STAJ_VSTUP,0,33);
	
	$hraci = $Sql->q('SELECT login FROM stajovnici WHERE staj = '.$staj['id']);
	if(p($hraci) > 3) {
		for($i=0;$i<p($hraci);$i++) {
			$hrac = fa($hraci);
			addQuest($hrac['login'],48,0);
		}
		addQuest(UID,48,0);
	}
	
	
	$Sql->q('INSERT into stajovnici(login,staj,penize,stav,datum,pomer) values('.UID.','.$smlouva['staj'].','.$smlouva['penize'].','.$smlouva['stav'].',"'.date('Y-m-d').'",'.$smlouva['pomer'].')');
	$_SESSION['chyba'] = "Smlouva podepsána";
	go('staje.php');
}

# editace popisu
if($action == 'editPopis') {
	$result = $Sql->q('SELECT * from staje WHERE id = '.$_GET['staj']);
	if(p($result) == 0) {
		$_SESSION['chyba'] = "Tato stáj nebyla nalezena";
		go('staje.php?action=detaily');
		exit;
	}
	
	$staj = fa($result);
	
	if($staj['login'] != UID) {
		$_SESSION['chyba'] = "Nejsi vlastníkem této stáje";
		go('staje.php?action=detaily');
		exit;
	}
	
	$Sql->q('UPDATE staje set popis = "'.trim(noTags($_POST['popis'])).'" WHERE id = '.$staj['id']);
	$_SESSION['chyba'] = "Popis změněn";
	go('staje.php?action=detaily');
	exit;  
}

# editace vlajky
if($action == 'editVlajka') {
	$result = $Sql->q('SELECT * from staje WHERE id = '.$_GET['staj']);
	if(p($result) == 0) {
		$_SESSION['chyba'] = "Tato stáj nebyla nalezena";
		go('staje.php?action=detaily');
		exit;
	}
	
	$staj = fa($result);
	
	if($staj['login'] != UID) {
		$_SESSION['chyba'] = "Nejsi vlastníkem této stáje";
		go('staje.php?action=detaily');
		exit;
	}

	if($staj['kasa'] < ZMENA_VLAJKY) {
		$_SESSION['chyba'] = "V kase není ".ZMENA_VLAJKY." Is potřebných na změnu";
		go('staje.php?action=detaily');
		exit;  
	}
	
	$b1 = '#'.$_POST['barva1'];
	$b2 = '#'.$_POST['barva2'];
	$b3 = '#'.$_POST['barva3'];
	
	$reg = '^(#)([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$';
	
	if(!eregi($reg,$b1) || !eregi($reg,$b2) || !eregi($reg,$b3)) {
		$_SESSION['chyba'] = 'Zadaná vlastní barva nemá formát hexadecimálního kódu RGB ('.$b1.','.$b2.','.$b3.')<br /><br />';
		go('staje.php?action=detaily');
		exit;
	}

	$vlajka = $b1.",".$b2.",".$b3;
	
	$Sql->q('UPDATE staje set vlajka = "'.$vlajka.'" WHERE id = '.$staj['id']);
	$Sql->q('UPDATE staje set kasa = "'.($staj['kasa']-ZMENA_VLAJKY).'" WHERE id = '.$staj['id']);
	$_SESSION['chyba'] = "Vlajka změněna";
	go('staje.php?action=detaily');
	exit;  	
}

# predani predmetu
if($action == 'predat_predmet') {
	$id = $_POST['predmet'];
	$staj = $_POST['staj'];
	$login = $_POST['login'];
	
	if($id == '') {
		$_SESSION['chyba'] = "Nebyl vybrán žádný předmět";
		go('staje.php?action=give');
		exit;
	}
	
	$result2 = $Sql->q('SELECT * from stajovnici WHERE staj = '.$staj.' AND login = '.UID);
	if(p($result2) == 0) {
		$_SESSION['chyba'] = "Nejsi členem této stáje";
		go('staje.php?action=give');
		exit;
	}
	
	$result2 = $Sql->q('SELECT typ FROM sklad WHERE login = '.UID.' AND (umisteni = 0 OR umisteni = 2) AND id = '.$id);
	if(p($result2) == 0) {
		$_SESSION['chyba'] = "Tento předmět nelze poslat (buď je součástí tvého kluzáku nebo není tvůj)";
		go('staje.php?action=give');
		exit;
	}
	
	$zbozi = fa($result2);
	
	$result2 = $Sql->q('SELECT * from stajovnici WHERE staj = '.$staj.' AND login = '.$login);
	if(p($result2) == 0) {
		$_SESSION['chyba'] = getNick($login)." není členem této stáje";
		go('staje.php?action=give');
		exit;
	}
	
	if(getPenize(UID) < POSLANI_PREDMETU) {
		$_SESSION['chyba'] = 'Nemáš dost ('.numF(POSLANI_PREDMETU).' Is) peněz na poslání předmětu';
		go('staje.php?action=give');
		exit;
	}
	
	$Sql->q('DELETE FROM sablony WHERE login = '.UID.' AND '.$tabs[$zbozi['typ']].' = '.$id);
	$Sql->q('UPDATE sklad set login = '.$login.', umisteni = 0 WHERE login = '.UID.' AND id = '.$id);
	$Sql->q('UPDATE postavy set penize = penize-'.POSLANI_PREDMETU.' WHERE login = '.UID);
	
	finance(UID,POSLANI_PREDMETU,0,20);
	
	$msg = "Hráč ".getNick(UID)." ze tvé stáje ti poslal předmět
	SYSTEM";
	sendPosta(0,$login,$msg);
	
	$Sql->q('UPDATE stats set posilani = posilani+1 WHERE login = '.UID);	
	
	$_SESSION['chyba'] = 'Předmět byl poslán';
	go('staje.php?action=give');
}

# odstoupeni
if($action == 'odstoupit') {
	$dialog = new cDialog('Odstupování ze stáje','alert','width: 300px');
	
	if($_GET['action2'] != 'sure') {
		$dialog->body('Opravdu si přeješ odstoupi ze stáje?');
		$dialog->button('Ne','close');
		$dialog->button('Ano','alert','staj_process.php?action=odstoupit&action2=sure&staj='.$_GET['staj']);
		$dialog->output();
		konec();
	}
	
	$staj = $_GET['staj'];
	
	if($staj == '') {
		$dialog->obody('Došlo k neznámé chybě');
		konec();
	}
	
	$result2 = $Sql->q('SELECT * from stajovnici WHERE staj = '.$staj.' AND login = '.UID);
	if(p($result2) == 0) {
		$dialog->obody('Nejsi členem této stáje');
		konec();
	}
	$stajovnik = fa($result2);
	
	$res = fa($Sql->q('SELECT val FROM sys WHERE entity = "pohar"'));
	
	if($res['val'] != 42 && $res['val'] != -2) {
		$res = $Sql->q('SELECT login FROM pohar WHERE login = '.UID);
		if(p($res) > 0) {
			$dialog->obody('Nemůžeš odstoupit - účastníš se poháru');
			konec();
		}
	}
	
	if(!$dialog->is_empty()) {
		$dialog->button('OK', 'close');
		$dialog->output();
		konec();
	}
	
	$result = $Sql->q('SELECT * from staje WHERE id = '.$stajovnik['staj']);
	
	$staj2 = fa($result);
	
	$Sql->q('DELETE from stajovnici WHERE login = '.UID.' AND staj = '.$staj);
	
	$msg = "Hráč [B][O]".getNick(UID)."[/O][/B] odstoupil ze tvé stáje.
	
	SYSTEM";
	
	sendPosta(0,$staj2['login'],$msg);
	
	$dialog->obody('Odstoupil jsi ze stáje');
	$dialog->button('OK', 'refresh');
	$dialog->output();
}

# zruseni staje
if($action == 'zrusitStaj') {

	$dialog = new cDialog('Rušení stáje','alert','width: 300px');
	
	if($_GET['action2'] != 'sure') {
		$dialog->body('Opravdu si přeješ zrušit tuto stáj?');
		$dialog->button('Ne','close');
		$dialog->button('Ano','alert','staj_process.php?action=zrusitStaj&action2=sure&id='.$_GET['id']);
		$dialog->output();
		konec();
	}
	
	$id = $_GET['id'];
	
	if($id == '') {
		$dialog->obody('Došlo k neznámé chybě');
		konec();
	}
	
	$result2 = $Sql->q('SELECT * from staje WHERE id = '.$id.' AND login = '.UID);
	if(p($result2) == 0) {
		$dialog->obody('Nejsi vlastník této stáje');
		konec();
	}
	
	$res = fa($Sql->q('SELECT val FROM sys WHERE entity = "pohar"'));
	
	if($res['val'] != 42 && $res['val'] != -2) {
		$res = $Sql->q('SELECT staj FROM pohar WHERE staj = '.$id);
		if(p($res) > 0) {
			$dialog->obody('Nemůžeš zrušit stáj účastnící se poháru');
			konec();  
		}
	}

	if(!$dialog->is_empty()) {
		$dialog->button('OK', 'close');
		$dialog->output();
		konec();
	}
	
	$staj = fa($result2);
	
	$result = $Sql->q('SELECT login from stajovnici WHERE staj = '.$id.' AND stav != 1');
	$celkem = p($result);
	$vlastnik = getNick(UID);
	
	if($staj['kasa'] > 0) {
		$dil = floor($staj['kasa']/($celkem+2));
	}
	
	$msg = $vlastnik.', vlastník stáje [B]'.$staj['nazev'].'[/B] se rozhodl stáj zrušit. Ze stájové kasy jsi dostal jako odstupné '.numF($dil).' Is.
	
	SYSTEM';
	
	for($i=0;$i<$celkem;$i++) {
		$hrac = fa($result);
		sendPosta(0,$hrac['login'],$msg);
		$Sql->q('UPDATE postavy set penize = penize+'.$dil.' WHERE login = '.$hrac['login']);
		finance($hrac['login'],$dil,1,32);
	}
	
	$Sql->q('DELETE from budovy WHERE staj = '.$id);
	$Sql->q('DELETE from stajovnici WHERE staj = '.$id);
	$Sql->q('DELETE from paliva_sklad WHERE staj = 1 AND login = '.$id);
	$Sql->q('DELETE from staje WHERE id = '.$id);
	$Sql->q('DELETE from pohar WHERE staj = '.$id);
	$Sql->q('DELETE from smlouvy WHERE staj = '.$id);
	$Sql->q('DELETE from forum WHERE place = "s'.$id.'"');
	$Sql->q('UPDATE postavy set penize = penize+'.(2*$dil).' WHERE login = '.UID);
	
	finance(UID,2*$dil,1,32);
	
	$dialog->obody('Stáj úspěšně zrušena');
	$dialog->button('OK', 'refresh');
	$dialog->output();
}

# vyhozeni
if($action == 'vyhodit') {
	$dialog = new cDialog('Vyhodit člena stáje','alert','width: 300px');
	
	if($_GET['action2'] != 'sure') {
		$dialog->body('Opravdu si přeješ vyhodit hráče <strong>'.getNick($_GET['id']).'</strong>?');
		$dialog->button('Ne','close');
		$dialog->button('Ano','alert','staj_process.php?action=vyhodit&action2=sure&staj='.$_GET['staj'].'&id='.$_GET['id']);
		$dialog->output();
		konec();
	}
	
	$id = $_GET['id'];
	$staj = $_GET['staj'];
	
	if($id == '' || $staj == '') {
		$dialog->obody('Došlo k neznámé chybě');
		konec();
	}
	
	$result = $Sql->q('SELECT login FROM staje WHERE id = '.$staj.' AND login = '.UID);
	if(!p($result)) {
		$dialog->obody('Nejsi vlastníkem této stáje');
		konec();
	}
	
	$staj2 = fa($result);
	
	$result = $Sql->q('SELECT login,staj,stav,penize, DATE_FORMAT(datum, "%Y-%m-%d") datum from stajovnici WHERE login = '.$id.' AND staj = '.$staj);
	if(!p($result)) {
		$dialog->obody('Tento hráč není ve tvojí stáji');
		konec();
	}
	
	$hrac = fa($result);
	
	if(!lastChange($hrac['datum'])) {
		$dialog->obody('Smlouva jde změnit jen jednou za 3 dny');
		konec();
	}
	
	$res = $Sql->q('SELECT login FROM pohar WHERE login = '.$id);
	if(p($res) > 0) {
		$dialog->obody('Nemůžeš vyhodit účastníka poháru');
		konec();
	}

	if(!$dialog->is_empty()) {
		$dialog->button('OK', 'close');
		$dialog->output();
		konec();
	}
	  
	$Sql->q('DELETE from stajovnici WHERE login = '.$id.' AND staj = '.$staj);
	
	$msg = "Byl jsi vyhozen ze stáje '".$staj2['nazev']."' hráčem '".getNick(UID)."'
	
	SYSTEM";
	
	sendPosta(0,$id,$msg);
	
	$dialog->obody('Člen stáje úspěšně vyhozen');
	$dialog->button('OK', 'refresh');
	$dialog->output();
}

# ruseni nabidky
if($action == 'zrusitNabidku') {
	$id = $_GET['id'];
	$staj = $_GET['staj'];
	
	$page = new cPage('staje');
	$page->setCommon('COMMON_PRIJMOUT');
	
	if($id == '' || !ereg('^[0-9]+$',$id)) {
		$page->ext('NABIDKA_EXIST',1,'Stáje');
		exit;
	}
	
	$result = $Sql->q('SELECT * from smlouvy WHERE id = '.$id);
	
	if(p($result) == 0) {
		$page->ext('SMLOUVA_EXIST',1,'Stáje');
		exit;
	}
	
	$smlouva = fa($result);
	
	if($staj == '' || !ereg('^[0-9]+$',$staj)) {
		$page->ext('STAJ_EXIST',1,'Stáje');
		exit;
	}
	
	$result = $Sql->q('SELECT * from staje WHERE id = '.$staj.' AND login = '.UID);
	
	if(p($result) == 0) {
		$page->ext('VLASTNIK',1,'Stáje');
		exit;
	}
	
	$staj = fa($result);
	
	$Sql->q('DELETE from smlouvy WHERE id = '.$id);
	
	$msg = "Nabídka na smlouvu se stájí ".$staj['nazev']." byla zrušena stájí.
	
	SYSTEM";
	
	sendPosta(0,$smlouva['login'],$msg);
	
	$_SESSION['chyba'] = "Nabídka zrušena";
	go('staje.php?action=clenove');
}

# posilani penez
if($action == 'sendMoney') {
	$penize = $_POST['penize'];
	$staj = $_POST['staj'];
	
	if($staj == "") {
		$staj = 0;
	}
	
	if(p($Sql->q('SELECT * from stajovnici WHERE login = '.UID.' AND staj = '.$staj)) == 0) {
		$_SESSION['chyba'] = 'Nejsi ani člen stáje';
		go('staje.php');
		exit;
	}
	
	if($penize == '' || !ereg('^[0-9]+$',$penize)) {
		$_SESSION['chyba'] = 'Suma peněz musí být vyjádřena v číslech';
		go('staje.php?action=finance');
		exit;
	}
	
	if($penize < 1) {
		$_SESSION['chyba'] = 'Suma peněz musí být větší než nula';
		go('staje.php?action=finance');
		exit;
	}
	
	$hp = getPenize(UID);
	
	if($penize > $hp) {
		$_SESSION['chyba'] = 'Nemáš tolik peněz';
		go('staje.php?action=finance');
		exit;
	}
	
	$staj = fa($Sql->q('SELECT * from staje WHERE id = '.$staj));
	$Sql->q('UPDATE staje set kasa = '.($staj['kasa']+$penize).' WHERE id = '.$staj['id']);
	$Sql->q('UPDATE postavy set penize = '.($hp-$penize).' WHERE login = '.UID);
	finance(UID,$penize,0,26);
	$_SESSION['chyba'] = "Peníze převedeny";
	go('staje.php?action=finance');
}

# posilani penez 2
if($action == 'sendMoney2') {
	$penize = $_POST['penize'];
	$staj = $_POST['staj'];
	
	if($staj == "") {
	  $staj = 0;
	}
	
	if(p($Sql->q('SELECT * from stajovnici WHERE login = '.UID.' AND staj = '.$staj.' AND (stav = 1)')) == 0) {
		$_SESSION['chyba'] = 'Nejsi ani vlastník stáje';
		go('staje.php');
		exit;
	}
	
	if($penize == '' || !ereg('^[0-9]+$',$penize)) {
		$_SESSION['chyba'] = 'Suma peněz musí být vyjádřena v číslech';
		go('staje.php?action=finance');
		exit;
	}
	
	if($penize < 1) {
		$_SESSION['chyba'] = 'Suma peněz musí být větší než nula';
		go('staje.php?action=finance');
		exit;
	}
	
	$stajovnici = fa($Sql->q('SELECT * from stajovnici WHERE stav = 1 AND staj = '.$staj));
	$staj = fa($Sql->q('SELECT * from staje WHERE id = '.$staj));
	
	if($penize > $staj['kasa']) {
		$_SESSION['chyba'] = 'Ve stájové kase není tolik peněz!';
		go('staje.php?action=finance');
		exit;
	}
	
	/*if($penize > $staj['kasa']*0.5) {
		$_SESSION['chyba'] = 'Můžeš vybrat najednou maximálně 50% stájové kasy!';
		go('staje.php?action=finance');
		exit;
	}
	
	if($stajovnici['datum'] == date("Y-m-d")){
		$_SESSION['chyba'] = 'Ze stájové kasy již bylo dnes vybíráno!';
		go('staje.php?action=finance');
		exit;
	}*/
	
	if($_GET['action2'] == 'login') {
		if(!p($Sql->q('SELECT login FROM stajovnici WHERE staj = '.$staj['id'].' AND login = '.UID))) {
			$_SESSION['chyba'] = 'Vybraný hráč není ze tvé stáje';
			go('staje.php?action=finance');
			exit;		
		}
		$Sql->q('UPDATE staje set kasa = kasa-'.$penize.' WHERE id = '.$staj['id']);
		$Sql->q('UPDATE postavy set penize = penize+'.$penize.' WHERE login = '.$_POST['login']);
		finance($_POST['login'],$penize,1,13);
		$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d").'" WHERE staj = '.$staj['id'].' AND stav = 1');
		$_SESSION['chyba'] = "Peníze převedeny";
		go('staje.php?action=finance');
		exit;
	}
	
	$Sql->q('UPDATE staje set kasa = kasa-'.$penize.' WHERE id = '.$staj['id']);
	$Sql->q('UPDATE postavy set penize = penize+'.$penize.' WHERE login = '.UID);
	finance(UID,$penize,1,13);
	$Sql->q('UPDATE stajovnici set datum = "'.date("Y-m-d").'" WHERE login = '.UID);
	$_SESSION['chyba'] = "Peníze převedeny";
	go('staje.php?action=finance');
}
?>