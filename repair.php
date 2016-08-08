<?php

include 'library.php';

is_logged();

$id = $_GET['id'];
$action = $_GET['action'];
$action2 = $_GET['action2'];

if($action == 'all') {
	$rasa = getRasa(UID);

	$kategorie[1] = "Podvozek";
	$kategorie[2] = "Motor";
	$kategorie[3] = "Energodržáky";
	$kategorie[4] = "Chladič";
	$kategorie[5] = "Palubní deska";
	$kategorie[6] = "Brzdy";
	$kategorie[7] = "Zdroj";
	$kategorie[8] = "Pancéřování";
	$kategorie[9] = "Suspenzory";
	$kategorie[10] = "Přídavný motor";
	
	$result = $Sql->q('SELECT id,zbozi,typ,cena,vydrz FROM sklad WHERE login = '.UID.' AND umisteni = 1 ORDER BY typ ASC');
	
	$data = array();
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$predmet = fa($Sql->q('SELECT vydrz FROM '.$tabs[$row['typ']].' WHERE id = '.$row['zbozi']));
		
		if($predmet['vydrz'] > $row['vydrz']) {
			$vydrz = 100-round($row['vydrz']/$predmet['vydrz']*100);
			$b = 0.85;
			$a = (100*(1-$a))/10000;
			$y = $a*$vydrz*$vydrz+$b*$vydrz;
			$cena2 = $row['cena']/100*$y;
			$cena2 = $cena2/(1+($rasa['o']/300))/2;	
			if($cena2 > $row['cena']) $cena2 = ($cena2+2*$row['cena'])/3;	
			
			$predmety[$row['id']] = $predmet['vydrz'];
			
			$puvodni[$row['id']] = $row['vydrz'];
			
			$cas = getOpravaCas($row['vydrz']/$predmet['vydrz']*100,$rasa['o']);
			if($max_cas < $cas) $max_cas = $cas;
			$data[] = array('typ' => $kategorie[$row['typ']], 'cena' => numF($cena2), 'cas' => date('H:i',$cas));
			
			$cena += $cena2;	
			$n++;
		}
	}
	
	if($n) $data[] = array('typ' => '<strong style="color: #FFF">Celkem</strong>', 'cas' => '<strong style="color: #FFF">'.date('H:i',$max_cas).'</strong>', 'cena' => '<strong style="color: #FFF">'.numF($cena).'</strong>');
	
	$penize = getPenize(UID);
	
	if(!$n) {
		$_SESSION['chyba'] = "Nemáš žádný rozbitý předmět";
		go('obchod.php?action=sklad');
		exit;
	}
	
	if($penize <= $cena) {
		$_SESSION['chyba'] = "Nemáš dostatek peněz (".numF($cena)." Is)";
		go('obchod.php?action=sklad');
		exit;
	}
	
	if(p($Sql->q('SELECT zavody.id FROM zavodnici LEFT JOIN zavody ON zavodnici.zavod = zavody.id WHERE zavody.vitez = 0 AND zavodnici.login = '.UID))) {
		$_SESSION['chyba'] = 'Nemůžeš opravit díly, protože se účastníš nějakého závodu';
		go('obchod.php?action=sklad');
		exit;    
	}
	
	if($_GET['sub'] != 'sure') {
		$page = new cPage('obchod');
		$page->ext('OPRAVA_VSEHO',1,'Obchod',array('seznam' => $page->getTable('OPRAVA_VSEHO',$data)));
		exit;
	}
	
	foreach($predmety as $id => $vydrz) {
		$Sql->q('UPDATE sklad SET vydrz = '.$vydrz.', umisteni = '.getOpravaCas($puvodni[$id]/$vydrz*100,$rasa['o']).' WHERE id = '.$id);
	}
	
	$Sql->q('UPDATE postavy set penize = ('.ceil($penize-$cena).') WHERE login = '.UID);
	$Sql->q('UPDATE stats set opravy1 = opravy1+'.count($predmety).' WHERE login = '.UID);
	finance(UID,$cena,0,19);

	if($cena > 15000) addQuest(UID,59,0);

	$_SESSION['chyba'] = 'Předměty ('.$n.') opraveny za '.numF($cena).' Is';
	go('obchod.php?action=sklad');
	exit;
}

if(!is_numeric($id) || $id <= 0) {
	$_SESSION['chyba'] = "Nebyl vybrán žádný předmět";
	go('obchod.php?action=sklad');
	exit;
}

$result = $Sql->q('SELECT * from sklad WHERE id = '.$id);
if(p($result) == 0) {
	$_SESSION['chyba'] = "Předmět nebyl nalezen";
	go('obchod.php?action=sklad');
	exit;
}

$row = fa($result);
$p = new cItem($row['zbozi'],$row['typ']);

if($row['login'] != UID && $action2 != 'cizi') {
	$_SESSION['chyba'] = "Předmět není tvůj";
	go('obchod.php?action=sklad');
	exit;
}

if($row['umisteni'] != UID*-1 && $action2 == 'cizi') {
	$_SESSION['chyba'] = "Předmět není ve tvé smlouvě";
	go('obchod.php?action=sklad');
	exit;
}

if($row['umisteni'] == 1) {
	$_SESSION['chyba'] = "Předmět je součást kluzáku";
	go('obchod.php?action=sklad');
	exit;
}

if($action == 'cancel') {	
	if($row['umisteni'] < 10000) {
		$_SESSION['chyba'] = "Předmět není opravován";
		go('obchod.php?action=sklad');
		exit;
	}
	
	if($p->typ == 11) {
		$_SESSION['chyba'] = "Droid se prostě nechce odtrhnout";
		go('obchod.php?action=sklad');
		exit;
	}
	
	$rasa = getRasa(UID);
	
	$cas = time();
	$zbyva = $row['umisteni']-$cas;
	$max_delka = getOpravaCas(0,$rasa['o'])-$cas;
	$procenta = 1-$zbyva/$max_delka;
	$vydrz = round($p->vydrz*$procenta);
	
	$Sql->q('UPDATE sklad set vydrz = '.$vydrz.', umisteni = 0, cena2 = 0 WHERE id = '.$id);
	
	if($row['cena2']) {
		$Sql->q('UPDATE sklad set umisteni = 0 WHERE umisteni = '.$row['umisteni'].' AND typ = 11');	
	} else {
		$Sql->q('UPDATE sklad set umisteni = 0 WHERE umisteni = '.$row['umisteni'].' AND typ = 11 AND login = '.UID);	
	}
	$_SESSION['chyba'] = "Oprava předmětu přerušena";
	go('obchod.php?action=sklad');
	exit;	
}

do_header('Obchod');

$page = new cPage('obchod');

$cena = $row['cena'];

$vydrz = 100-round($row['vydrz']/$p->vydrz*100);

if($row['vydrz'] == $p->vydrz) {
	$_SESSION['chyba'] = "Předmět není opotřeben";
	go('obchod.php?action=sklad','js');
	exit;
}

$b = 0.85;
$a = (100*(1-$a))/10000;
$y = $a*$vydrz*$vydrz+$b*$vydrz;
$cena = $cena/100*$y;
$rasa = getRasa(UID);
$cena = $cena/(1+($rasa['o']/300))/2;

if($cena > $row['cena']) $cena = ($cena+2*$row['cena'])/3;

$penize = getPenize(UID);

if($_GET['sure'] == 'sure2') {
	
	if($_POST['droid1'] != '') {
		$droid1 = $_POST['droid1'];
		$result = $Sql->q('SELECT s.id as id, s.vydrz as vydrz, d.urychleni as u, d.sleva as s FROM sklad as s LEFT JOIN droidi as d ON d.id = s.zbozi WHERE s.typ = 11 AND s.umisteni < '.time().' AND s.login = '.UID.' AND s.id = '.$droid1);
		if(!p($result) || p($Sql->q('SELECT vitez FROM zavody WHERE login != 0 AND vitez = 0 AND predmet = '.$droid1))) {
			$_SESSION['chyba'] = "Vybraného droida (1) nelze použít";
			go('repair.php?id='.$id,'js');
			exit;		
		}
		$droid1 = fa($result);
	}
	
	if($_POST['droid2'] != '') {
		$droid2 = $_POST['droid2'];
		$result = $Sql->q('SELECT s.id as id, s.vydrz as vydrz, d.urychleni as u, d.sleva as s FROM sklad as s LEFT JOIN droidi as d ON d.id = s.zbozi WHERE s.typ = 11 AND s.umisteni < '.time().' AND s.login = '.UID.' AND s.id = '.$droid2);
		if(!p($result) || p($Sql->q('SELECT vitez FROM zavody WHERE login != 0 AND vitez = 0 AND predmet = '.$droid2))) {
			$_SESSION['chyba'] = "Vybraného droida (2) nelze použít";
			go('repair.php?id='.$id,'js');
			exit;		
		}
		$droid2 = fa($result);
	}
	
	if($droid1['id'] != '' && $droid1['id'] == $droid2['id']) {
		unset($droid2);
	}
	
	if($droid1['id'] == '' && $droid2['id'] != '') {
		$droid1 = $droid2;
		unset($droid2);
	}	
	
	$cas = 0;
	
	$dmg = round(($p->vydrz-$row['vydrz'])/10);
	
	if(isset($droid1['id'])) {
		$cas += $droid1['u'];
		$cena -= $droid1['s']/100*$cena;
	}
	
	if(isset($droid2['id'])) {
		$cas += $droid2['u'];
		$cena -= $droid2['s']/100*$cena;
		$dmg = round($dmg/2);
	}
	
	if($penize < floor($cena-$row['cena2'])) {
		$_SESSION['chyba'] = "Nemáš dostatek peněz";
		go('obchod.php?action=sklad','js');
		exit;
	}
	
	$dest = getOpravaCas(round($row['vydrz']/$p->vydrz*100),$rasa['o'],$cas);
	
	$pouzil_droida = 1;
	
	if(isset($droid1['id'])) {
		$pouzil_droida = 2;
		if($droid1['vydrz'] > $dmg) {
			$Sql->q('UPDATE sklad set vydrz = vydrz-'.$dmg.', umisteni = '.$dest.' WHERE id = '.$droid1['id']);
		} else {
			$Sql->q('DELETE FROM sklad WHERE id = '.$droid1['id']);	
			$Sql->q('UPDATE stats set droidi = droidi+1 WHERE login = '.UID);	
		}
	}
	
	if(isset($droid2['id'])) {
		$pouzil_droida = 2;
		if($droid2['vydrz'] > $dmg) {
			$Sql->q('UPDATE sklad set vydrz = vydrz-'.$dmg.', umisteni = '.$dest.' WHERE id = '.$droid2['id']);
		} else {
			$Sql->q('DELETE FROM sklad WHERE id = '.$droid2['id']);	
			$Sql->q('UPDATE stats set droidi = droidi+1 WHERE login = '.UID);		
		}
	}
	
	if($action2 == 'cizi') {
		$Sql->q('UPDATE postavy set prestiz = prestiz+5 WHERE login = '.UID);
		$msg = 'Hráč '.$_SESSION['nick'].' s tebou uzavřel smlouvu a předmět se začal opravovat.

SYSTEM';
		sendPosta(0,$row['login'],$msg);
		
		$Sql->q('UPDATE stats set opravy3 = opravy3+1 WHERE login = '.UID);
		$Sql->q('UPDATE stats set opravy4 = opravy4+1 WHERE login = '.$row['login']);
	}
	
	$Sql->q('UPDATE sklad set cena2 = 0, vydrz = '.$p->vydrz.', umisteni = '.$dest.' WHERE id = '.$id);
	$Sql->q('UPDATE postavy set penize = ('.ceil($penize-$cena+$row['cena2']).') WHERE login = '.UID);
	$Sql->q('UPDATE stats set opravy'.$pouzil_droida.' = opravy'.$pouzil_droida.'+1 WHERE login = '.UID);	
	finance(UID,abs($cena-$row['cena2']),($cena-$row['cena2'] > 0 ? 0 : 1),19);
	$_SESSION['chyba'] = "Předmět opraven";
	
	if($action2 == 'cizi') {
		go('obchod.php?action=opravari','js');
	} else {
		go('obchod.php?action=sklad','js');
	}
	
	exit;
}

$cas = getOpravaCas(round($row['vydrz']/$p->vydrz*100),$rasa['o']);
$delka = $cas-time();

$fill['delka'] = ($delka/60 > 59 ? floor($delka/3600).'h ' : '').round($delka/60-floor($delka/3600)*60).'min '.($delka%60).'s';
$fill['cas'] = date('H:i j.n.',$cas);
$fill['nazev'] = $p->nazev;
$fill['cena'] = numF($cena);
$fill['vydrz'] = ceil($row['vydrz']/$p->vydrz*100);
$fill['tlacitko'] = $page->misc('TLACITKO');
$fill['id'] = $id;
$fill['droidi'] = '';

$result = $Sql->q('SELECT s.id as id, d.urychleni as u, d.vydrz as vydrz_max, s.vydrz as vydrz, d.nazev as nazev, d.sleva as s, s.umisteni as umisteni FROM sklad as s LEFT JOIN droidi as d ON d.id = s.zbozi WHERE s.typ = 11 AND s.umisteni < '.time().' AND s.login = '.UID.' ORDER by s.zbozi ASC');

$data = array();
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	if(p($Sql->q('SELECT vitez FROM zavody WHERE login != 0 AND vitez = 0 AND predmet = '.$row['id']))) continue;
	$row['nazev'] = ($i+1).'. '.$row['nazev'];
	$row['v'] = numF($row['vydrz']/$row['vydrz_max']*100);
	$data[] = $row;
}

if(count($data) == 1) {
	$fill['droidi'] = $page->misc('DROIDI1');
	$fill['droidi_select'] = $page->getTable('DROIDI_SELECT',$data);
}

if(count($data) > 1) {
	$fill['droidi'] = $page->misc('DROIDI2');
	$fill['droidi_select'] = $page->getTable('DROIDI_SELECT',$data);
}

$fill['action2'] = '';
if($action2 == 'cizi') $fill['action2'] = 'cizi';

if($action2 == 'cizi') {
	$fill['opravari'] = '';
	$page->ext('OPRAVA',1,0,$fill);
	exit;
}

$result = $Sql->q('SELECT h.login as nick, h.id as login, h.cas as cas, o.procenta as procenta FROM opravari as o LEFT JOIN hraci as h ON h.id = o.login WHERE o.minimum <= '.$cena.' AND o.login != '.UID.' ORDER BY h.cas DESC');

if(!p($result)) {
	$fill['opravari'] = '';
} else {
	$data = array();
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$line = $row;
		
		$last = time()-$row['cas'];
		
		$cas = 'Právě online';
		
		if($last > 60*15) $cas = 'Před '.floor($last/60).' minutami';
		if($last > 60*60) $cas = 'Před '.floor($last/3600).' hodinami';
		if($last > 60*60*24) $cas = 'Před '.floor($last/3600/24).' dny';
		
		$line['droidi1'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.$row['login'].' AND typ = 11 AND umisteni < '.time()));
		$line['droidi2'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.$row['login'].' AND typ = 11'));
		$line['online'] = $cas;
		$line['cena'] = numF(floor($cena*$row['procenta']/100));
		$data[] = $line;
	}
	
	$fill['opravari'] = $page->getTable('OPRAVARI2',$data);
	$fill['zid'] = $id;
}

$page->ext('OPRAVA',1,0,$fill);
?>