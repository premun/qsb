<?php

/*
ZAVODY TYPY
-----------
0 - normalni
1 - normalni pro stajovniky
2 - pohar
*/

include 'library.php';
is_logged();

if(isset($_POST['dotace'])) {
	if($_POST['dotace']+ZAVOD_ZAKLADANI > getPenize(UID)) {
		$_SESSION['chyba'] = 'Nemáš dostatek peněz - '.numF($_POST['dotace']+ZAVOD_ZAKLADANI).' Is';
		go('zavody.php?action=zalozit');
		exit;
	}
}

$kategorie[1] = "Podvozek";
$kategorie[2] = "Motor";
$kategorie[3] = "Energodržáky";
$kategorie[4] = "Chladič";
$kategorie[5] = "Palubní deska";
$kategorie[6] = "Brzdy";
$kategorie[7] = "Zdroj";
$kategorie[8] = "Pancéřování";
$kategorie[9] = "Suspenzor";
$kategorie[10] = "Přídavný motor";
$kategorie[11] = "Opravný droid";

do_header('Závody');																			################### HEADER

$page = new cPage('zavody_header');

$action = $_GET['action'];

define("LIMIT",25);
$start = $_GET['start'];
if($start == '') $start = 0;

$casy[0] = "23:00";
$casy[13] = "13:00";
$casy[16] = "16:00";
$casy[19] = "19:00";

$casy[-42] = $casy[13];
if(date('H') < 23) $casy[-42] = $casy[0];
if(date('H') < 19) $casy[-42] = $casy[19];
if(date('H') < 16) $casy[-42] = $casy[16];
if(date('H') < 13) $casy[-42] = $casy[13];

$empty = $_GET['empty'];
if($empty == "on") $fill['checkbox'] = ' checked="checked"';

$fill['kategorie'] = '';
$cena_kluzaku = '';
if($_GET['kat'] == "on") {
	$fill['checkbox2'] = ' checked="checked"';
	$cislo = count($ceny_kluzaky)-1;
	$ceny = $Sql->q('SELECT SUM(cena) as celkem FROM sklad WHERE umisteni = 1 AND login = '.UID);
	if(p($ceny)) {
		$cena = fa($ceny);
		$cena = $cena['celkem'];
		$cena_kluzaku = '<span class="ultra">('.numF($cena).' Is)</span>';
		
		for($i=count($ceny_kluzaky);$i>0;$i--) {
			if($cena < $ceny_kluzaky[$i-1]) $cislo = $i-1;
		}
	}
	if($cena > 0) {
		$and_kat = ' AND (cena = '.$cislo.' OR cena = '.($cislo+1).' OR cena = -1)';
	} else {
		$fill['kategorie'] = ' style="display: none"';
	}
	if($cena > $ceny_kluzaky[count($ceny_kluzaky)-1]) $and_kat = ' AND (cena = '.(count($ceny_kluzaky)).' OR cena = -1)';
}

$fill['cena_kluzaku'] = $cena_kluzaku;
$fill['trat2'] = $_GET['trat'];

if($action == '') {
	$page->setCommon('MAIN');
	$page->ext('PODSEKCE',1);
	exit();
}


if($action == 'zalozit') {																		################### ZALOZENE

	$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
	$etapa = $result['val'];

	if($etapa == 1) {
		$page->setCommon('MAIN');
		$page->ext('ETAPA',1,0,$fill);	
		exit;		
	}

	$fill['zavod_zakladani'] = ZAVOD_ZAKLADANI;
	$fill['dotace_min'] = numF(DOTACE_MIN);
	$fill['dotace_max'] = numF(DOTACE_MAX);
	$fill['predmet'] = '';

	if(!is_numeric($_POST['dotace'])) {
		$page->setCommon('MAIN');
		
		$result = $Sql->q('SELECT id, zbozi, typ, cena, vydrz FROM sklad WHERE umisteni = 0 AND login = '.UID.' ORDER BY typ ASC, cena ASC');
		if(p($result)) {
			$data = array();
			while($row = fa($result)) {
				if(p($Sql->q('SELECT vitez FROM zavody WHERE login != 0 AND vitez = 0 AND predmet = '.$row['id']))) continue;
				$predmet = fa($Sql->q('SELECT nazev, vydrz FROM '.$tabs[$row['typ']].' WHERE id = '.$row['zbozi']));
				$data[] = array('id' => $row['id'],
								'nazev' => $predmet['nazev'],
								'cena' => numF($row['cena']*0.5),
								'vydrz' => round($row['vydrz']/$predmet['vydrz']*100),
								'typ' => $kategorie[$row['typ']]);
			}
		
			$fill['predmet'] = $page->getTable('PREDMETY_CENY', $data);
		}
		
		$page->ext('DOTACE',1,0,$fill);			
		exit;	
	}

	$predmet = $_POST['predmet'];
	$dotace = $_POST['dotace'];

	if($predmet) {
		$predmet = fa($Sql->q('SELECT id, zbozi, typ, cena, vydrz FROM sklad WHERE umisteni = 0 AND login = '.UID.' AND id = '.$predmet));
		if(!$predmet['typ']) {
			$predmet = '';
		} else {
			$predmet = array_merge($predmet, fa($Sql->q('SELECT nazev, vydrz FROM '.$tabs[$predmet['typ']].' WHERE id = '.$predmet['zbozi'])));
		}
	}

	if(($dotace+$predmet['cena']*0.5) < DOTACE_MIN || ($dotace+$predmet['cena']*0.5) > DOTACE_MAX) {
		$page->setCommon('MAIN');
		
		$result = $Sql->q('SELECT id, zbozi, typ, cena, vydrz FROM sklad WHERE umisteni = 0 AND login = '.UID.' ORDER BY typ ASC, cena ASC');
		if(p($result)) {
			$data = array();
			while($row = fa($result)) {
				$predmet = fa($Sql->q('SELECT nazev, vydrz FROM '.$tabs[$row['typ']].' WHERE id = '.$row['zbozi']));
				$data[] = array('id' => $row['id'],
								'nazev' => $predmet['nazev'],
								'cena' => numF($row['cena']*0.5),
								'vydrz' => round($row['vydrz']/$predmet['vydrz']*100),
								'typ' => $kategorie[$row['typ']]);
			}
		
			$fill['predmet'] = $page->getTable('PREDMETY_CENY', $data);
		}
		
		$page->ext('DOTACE',1,0,$fill);			
		exit;	
	}
	
	$fill['dotace1'] = numF($dotace+$predmet['cena']/2);
	$fill['dotace2'] = $dotace;

	$fill['id_p'] = $predmet['id'];
	$fill['predmet'] = ($predmet['nazev'] ? $predmet['nazev'] : '<em>žádný předmět</em>');

	$result = $Sql->q('SELECT id,nazev,useky,delka,trat FROM trate WHERE useky BETWEEN '.TRAT_USEKY_MIN.' AND '.TRAT_USEKY_MAX.' ORDER BY nazev ASC');
	for($i=0;$i<p($result);$i++) {
		$trat = fa($result);
		$diff = getDiffOpt($trat['trat']);
		
		if(getDotace($trat['useky'],$diff,$trat['delka']) >= $dotace+$predmet['cena']/2) $data_trate[] = $trat;
	}
	
	$fill['trate'] = $page->getTable('TRATE',$data_trate);
	
	if(date('H') != "23") {
		$data_datum[0]['cas'] = date('Y-m-d');
		$data_datum[0]['datum'] = 'Dnes';
	}
	
	for($i=1;$i<8;$i++) {
		$data_datum[$i]['cas'] = date('Y-m-d',time()+86400*$i);
		$data_datum[$i]['datum'] = date('j.n.',time()+86400*$i);
	}
	
	$fill['datum'] = $page->getTable('DATUM',$data_datum);

	$data = array();
	foreach($ceny_kluzaky as $id=>$value) {
		if($id && $id < 6) $data[] = array('id' => $id, 'value' => numF($ceny_kluzaky[$id-1]).' - '.numF($ceny_kluzaky[$id]));
	}
		
	$fill['ceny'] = $page->getTable('CENY',$data);

	$page->setCommon('MAIN');
	$page->ext('ZALOZIT',1,0,$fill);
	exit;
}

$page->finish();
unset($page);

#-----------------------------------------------------------------------------------------------------------
#----------------------------------------------------------------------------------------------------------- KONEC HEADER

$page = new cPage('zavody');

if($action == 'zalozene') {
	$page->swap('NADPIS','Mnou založené závody');

	$page->misc('MOJE','OBSAH');

	if(!p($Sql->q('SELECT id FROM zavody WHERE typ = 0 AND login = '.UID))) {
		$page->ext('ZADNE',1,0);
		exit;
	}

	$zal = $Sql->q('SELECT * FROM zavody WHERE vitez = 0 AND typ = 0 AND login = '.UID.' ORDER BY datum DESC, cas ASC');
	$no = false;
	if(p($zal) == 0) {
		$no = true;
		$page->swap('NEODJETE','Žádné závody<br /><br />');
	} else {
		
		$counter = 0;
						
		$data = array();		
		
		for($i=0;$i<p($zal);$i++) {
			$row = fa($zal);
			
			$counter++;
			$res = $Sql->q('SELECT * from zavodnici WHERE zavod = '.$row['id']);
			$pocet = p($res);
			$oddelovac = "";
			if($row['login'] == 0 && $counter > 0) {
				$casti = explode('_',$row['nazev']);
				if($casti[1] != $last && $counter > 0 && $i != 0) $oddelovac = 'class="oddelovac"';
				$last = $casti[1];
			} else {
				if($last != "" && $counter > 0 && $i != 0) $oddelovac = 'class="oddelovac"';
			}
			if($row['prestiz'] == 0 && $row['prestiz2'] == 0) {
				$prestiz = "---";
			}
			if($row['prestiz'] == 0 && $row['prestiz2'] != 0) {
				$prestiz = $row['prestiz2']."-";
			}
			if($row['prestiz'] != 0 && $row['prestiz2'] == 0) {
				$prestiz = $row['prestiz']."+";
			}  
			if($row['prestiz'] != 0 && $row['prestiz2'] != 0) {
				$prestiz = $row['prestiz']."-".$row['prestiz2'];
			}    
			if($row['prestiz'] != 0 && $row['prestiz'] == $row['prestiz2']) {
				$prestiz = $row['prestiz'];
			}
			unset($locker);
			if($row['heslo'] != '') $locker = $page->misc('ZAMEK');

			unset($predmet);
			if($row['predmet']) $predmet = $page->misc('PREDMET');

			$kusy = explode('-',$row['datum']);
			if($kusy[0] == '4200') $row['cas'] = -42;
			$row['datum'] = ($kusy[0] == '4200' ? 'Dnes' : $kusy[2].'.'.$kusy[1].'.');
			
			$line['id'] = $row['id'];
			$line['barva'] = $ceny_barvy[$row['cena']];
			$line['nazev'] = $row['nazev'];
			$line['zamek'] = $locker;
			$line['predmet'] = $predmet;
			$line['cas'] = $casy[$row['cas']];
			$line['oddelovac'] = $oddelovac;
			$line['pocet'] = $row['pocet'];
			$line['pocet2'] = $pocet;
			$line['prestiz'] = $prestiz;
			$line['datum'] = str_replace(date('d.m.'),"Dnes",$row['datum']);
			$data[] = $line;
		}
		if($counter) $page->getTable('MOJE NEODJETE',$data,'NEODJETE');
	}

	$zal = $Sql->q('SELECT * FROM zavody WHERE vitez = 1 AND login = '.UID.' ORDER BY datum DESC, cas ASC');
	
	if(p($zal) == 0) {
		$page->swap('ODJETE','Žádné závody<br /><br />');
	} else {
		
		$counter = 0;
		
		$data = array();
		
		for($i=0;$i<p($zal);$i++) {
			$row = fa($zal);
			
			$counter++;
			$res = $Sql->q('SELECT * from zavodnici WHERE zavod = '.$row['id']);
			$pocet = p($res);
			$oddelovac = "";
			if($row['login'] == 0 && $counter > 0) {
				$casti = explode('_',$row['nazev']);
				if($casti[1] != $last && $counter > 0 && $i != 0) $oddelovac = 'class="oddelovac"';
				$last = $casti[1];
			} else {
				if($last != "" && $counter > 0 && $i != 0) $oddelovac = 'class="oddelovac"';
			}
			if($row['prestiz'] == 0 && $row['prestiz2'] == 0) {
				$prestiz = "---";
			}
			if($row['prestiz'] == 0 && $row['prestiz2'] != 0) {
				$prestiz = $row['prestiz2']."-";
			}
			if($row['prestiz'] != 0 && $row['prestiz2'] == 0) {
				$prestiz = $row['prestiz']."+";
			}  
			if($row['prestiz'] != 0 && $row['prestiz2'] != 0) {
				$prestiz = $row['prestiz']."-".$row['prestiz2'];
			}    
			if($row['prestiz'] != 0 && $row['prestiz'] == $row['prestiz2']) {
				$prestiz = $row['prestiz'];
			}

			$kusy = explode('-',$row['datum']);
			if($kusy[0] == '4200') $row['cas'] = -42;
			$row['datum'] = ($kusy[0] == '4200' ? 'Dnes' : $kusy[2].'.'.$kusy[1].'.');
			
			$line['id'] = $row['id'];
			$line['nazev'] = $row['nazev'];
			$line['zamek'] = ($row['heslo'] != '' ? $page->misc('ZAMEK') : '');
			$line['predmet'] = ($row['predmet'] ? $page->misc('PREDMET') : '');
			$line['barva'] = $ceny_barvy[$row['cena']];
			$line['dotace'] = str_replace(' ','&nbsp;',numF($row['dotace']));
			$line['cas'] = $casy[$row['cas']];
			$line['oddelovac'] = $oddelovac;
			$line['pocet'] = $row['pocet'];
			$line['pocet2'] = $pocet;
			$line['prestiz'] = $prestiz;
			$line['datum'] = str_replace(date('d.m.'),"Dnes",$row['datum']);
			$data[] = $line;
		}
		if($counter) $page->getTable('MOJE ODJETE',$data,'ODJETE');
	}

	$page->swap('ODJETE','');
	$page->swap('NEODJETE','');

	$page->finish();
	do_footer();
	exit;
}

#-----------------------------------------------------------------------------------------------------------	KONEC MOJE
#-----------------------------------------------------------------------------------------------------------	ZACATEK ODJETE
if(is_numeric($_GET['trat'])) $and_trat = 'AND trat = '.$_GET['trat'];

if($action == 'neodjete' || $action == 'odjete') {																		################### NE / ODJETE
	$page->misc('FILTER','OBSAH');
	
	$data = array();
	
	$result = $Sql->q('SELECT * FROM trate WHERE useky BETWEEN '.TRAT_USEKY_MIN.' AND '.TRAT_USEKY_MAX.' ORDER BY nazev ASC');
	for($i=0;$i<p($result);$i++) {
		$typ = fa($result);
		$typ['checked'] = ($typ['id'] == $_GET['trat'] ? ' selected="selected"' : '');
		$data[] = $typ;
	}
	
	$page->getTable('TRATE',$data,'TRATE');

	$fill['empty'] = ($action == 'odjete' ? ' style="display: none"' : '');
	$fill['action'] = $_GET['action'];
	$fill['empty2'] = $_GET['empty'];
	$fill['kat2'] = $_GET['kat'];
	$fill['trat2'] = $_GET['trat'];
}

if($action == 'neodjete') {																									################### NEODJETE
	$page->swap('NADPIS','Neodjeté závody');
	
	$result = $Sql->q('SELECT * FROM zavody WHERE vitez = 0 AND typ = 0 '.$and_trat.' '.$and_kat.' ORDER BY datum DESC, cas DESC, login DESC, dotace ASC, nazev ASC');
	$result3 = $Sql->q('SELECT * FROM zavody WHERE vitez = 0 AND typ = 2 '.$and_trat.' ORDER BY datum DESC, cas DESC, dotace ASC, nazev ASC');
}

if($action == 'odjete') {																									################### ODJETE
	$page->swap('NADPIS','Odjeté závody');

	$result = $Sql->q('SELECT * FROM zavody 
					   WHERE vitez = 1 AND typ = 0 '.$and_trat.' ORDER BY datum DESC, cas DESC, dotace DESC, nazev ASC LIMIT '.$start.','.LIMIT);
	$result3 = $Sql->q('SELECT * FROM zavody 
						WHERE vitez = 1 AND typ = 2 '.$and_trat.' ORDER BY datum DESC, cas DESC, dotace DESC, nazev ASC');
}

if($action == 'mojeneodjete') {																								################### MOJE NEODJETE
	$page->swap('NADPIS','Moje neodjeté závody');
	
	$result =  $Sql->q('SELECT z.id as id, z.pocet as pocet, z.minimum as minimum, z.heslo as heslo, z.trat as trat, z.login as login, z.vklad as vklad, z.dotace as dotace, z.cas as cas, z.datum as datum, z.prestiz as prestiz, z.prestiz2 as prestiz2, z.nazev as nazev, z.cena as cena, z.predmet as predmet FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE za.login = '.UID.' AND z.vitez = 0 AND z.typ = 0 ORDER BY z.datum DESC, z.cas ASC, z.dotace ASC, z.nazev ASC');
	$result3 = $Sql->q('SELECT z.id as id, z.pocet as pocet, z.minimum as minimum, z.heslo as heslo, z.trat as trat, z.login as login, z.vklad as vklad, z.dotace as dotace, z.cas as cas, z.datum as datum, z.prestiz as prestiz, z.prestiz2 as prestiz2, z.nazev as nazev, z.cena as cena, z.predmet as predmet FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE za.login = '.UID.' AND z.vitez = 0 AND z.typ = 2 ORDER BY z.datum DESC, z.cas ASC, z.dotace ASC, z.nazev ASC');
}

if($action == 'mojeodjete') {																								################### MOJE ODJETE
	$page->swap('NADPIS','Moje odjeté závody');
	
	$result =  $Sql->q('SELECT z.id as id, z.pocet as pocet, z.minimum as minimum, z.heslo as heslo, z.trat as trat, z.login as login, z.vklad as vklad, z.dotace as dotace, z.cas as cas, z.datum as datum, z.prestiz as prestiz, z.prestiz2 as prestiz2, z.nazev as nazev, z.cena as cena, z.predmet as predmet FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE za.login = '.UID.' AND z.vitez = 1 AND z.typ = 0 ORDER BY z.datum DESC, z.cas ASC, z.dotace ASC, z.nazev ASC');
	$result3 = $Sql->q('SELECT z.id as id, z.pocet as pocet, z.minimum as minimum, z.heslo as heslo, z.trat as trat, z.login as login, z.vklad as vklad, z.dotace as dotace, z.cas as cas, z.datum as datum, z.prestiz as prestiz, z.prestiz2 as prestiz2, z.nazev as nazev, z.cena as cena, z.predmet as predmet FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE za.login = '.UID.' AND z.vitez = 1 AND z.typ = 2 ORDER BY z.datum DESC, z.cas ASC, z.dotace ASC, z.nazev ASC');
}

#-----------------------------------------------------------------------------------------------------------
#------------------------------------   VYPIS --------------------------------------------------------------
#-----------------------------------------------------------------------------------------------------------

if(p($result) == 0) {
	$fill['zavody'] = 'Žádné závody';
	$fill['obsah'] = 'Žádné závody';
	$fill['sipky'] = '';
	$page->fill($fill);
} else {
	
	$counter = 0;
	
	$data = array();
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$res3 = $Sql->q('SELECT login FROM zavodnici WHERE zavod = '.$row['id']);
		$inside = false;
		for($j=0;$j<p($res3);$j++) {
			$zavodnik = fa($res3);
			if($zavodnik['login'] == UID) $inside = true;
		}
	
		$pocet1 = p($res3);
		if(($inside && ($action == "mojeodjete" || $action == "mojeneodjete")) || ($action != "mojeodjete" && $action != "mojeneodjete") && ($empty == "on" || $pocet1 > 0)) {  
			$pocet = $pocet1;
			$oddelovac = "";
			if($row['login'] == 0 && $counter > 0) {
				$casti = explode('_',$row['nazev']);
				if($casti[1] != $last && $counter > 0 && $i != 0) $oddelovac = ' class="oddelovac"';
				$last = $casti[1];
			} else {
				if($last != "" && $counter > 0 && $i != 0) $oddelovac = ' class="oddelovac"';
			}
			if($row['prestiz'] == 0 && $row['prestiz2'] == 0) {
				$prestiz = "---";
			}
			if($row['prestiz'] == 0 && $row['prestiz2'] != 0) {
				$prestiz = $row['prestiz2']."-";
			}
			if($row['prestiz'] != 0 && $row['prestiz2'] == 0) {
				$prestiz = $row['prestiz']."+";
			}  
			if($row['prestiz'] != 0 && $row['prestiz2'] != 0) {
				$prestiz = $row['prestiz']."-".$row['prestiz2'];
			}    
			if($row['prestiz'] != 0 && $row['prestiz'] == $row['prestiz2']) {
				$prestiz = $row['prestiz'];
			}
	
			$zamek = ($row['heslo'] != '' ? $page->misc('ZAMEK') : '');
			$predmet = ($row['predmet'] ? $page->misc('PREDMET') : '');
	
			$trat = fa($Sql->q('SELECT * FROM trate WHERE id = '.$row['trat']));
	
			$kusy = explode(',',$trat['trat']);
			
			$useku = count($kusy);
			$obtiznost = getDiffOpt($trat['trat']);  
	
			$box = '<strong>'.$row['nazev'].'</strong><br /><span>Pořadatel:</span> '.getNick($row['login']).'<br /><span>Min. vklad:</span> '.numF($row['vklad']).' Is<br /><span>Dotace:</span> '.numF($row['dotace']).' Is<br /><span>Trať:</span> '.str_replace("'", "\\'", $trat['nazev']).'<br /><span>&nbsp;&nbsp;&nbsp;-&nbsp;Obtížnost:</span> '.numF($obtiznost).'%<br /><span>&nbsp;&nbsp;&nbsp;-&nbsp;Počet úseků:</span> '.$useku.'<br /><span>Čas:</span> '.$casy[$row['cas']].'<br /><span>Datum:</span> '.str_replace(date('d.m.'),"Dnes",str_replace("4200-12-24","Dnes",$row['datum'])).'<br /><span>Hráči:</span> '.$pocet1.'/'.$row['pocet'].'<span> ('.$row['minimum'].')</span><br /><span>Povolená prestiž:</span> '.$prestiz.'<br /><br />Pro více informací klikni';
	
			$kusy = explode('-',$row['datum']);
			if($kusy[0] == '4200') $row['cas'] = -42;
			$row['datum'] = ($kusy[0] == '4200' ? 'Dnes' : $kusy[2].'.'.$kusy[1].'.');
			
			$line['id'] = $row['id'];
			$line['barva'] = $ceny_barvy[$row['cena']];
			$line['nazev'] = $row['nazev'];
			$line['dotace'] = str_replace(' ','&nbsp;',numF($row['dotace']));
			$line['zamek'] = $zamek;
			$line['predmet'] = $predmet;
			$line['cas'] = $casy[$row['cas']];
			$line['oddelovac'] = $oddelovac;
			$line['pocet'] = $row['pocet'];
			$line['pocet2'] = $pocet;
			$line['prestiz'] = $prestiz;
			$line['box'] = $box;
			$line['datum'] = str_replace(date('d.m.'),"Dnes",$row['datum']);
			$data[] = $line;
		}
	}
	
	if(!count($data)) {
		$page->swap('ZAVODY','');
	} else {
		$page->getTable('ZAVODY',$data,($action != 'mojeodjete' && $action != 'mojeneodjete' ? 'ZAVODY' : 'OBSAH'));
	}
	
	if($action == 'odjete') {
		#------------ SIPECKY!---------------#
		if($start > 0) {
			$dil1 = '<a href="zavody.php?action=odjete&empty='.$_GET['empty'].'">&lt;&lt;</a> | <a href="zavody.php?action=odjete&empty='.$_GET['empty'].'&start='.($start-LIMIT).'">&lt;</a>';
		}
		$result = $Sql->q('SELECT id FROM zavody WHERE vitez > 0');
		$all = p($result);
		if($all > ($start+LIMIT)) {
			$dil2 = '<a href="zavody.php?action=odjete&empty='.$_GET['empty'].'&start='.($start+LIMIT).'">&gt;</a> | <a href="zavody.php?action=odjete&empty='.$_GET['empty'].'&start='.($all-LIMIT).'">&gt;&gt;</a>';
		}
		
		if($dil1 != '' || $dil2 != '') {
			$sipky = '<br /><br /><br /><span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
		}
		#------------ SIPECKY!---------------#
	}
	
	$fill['sipky'] = $sipky;
	
	$page->fill($fill);
}

###################################################################################### POHAR ###########################

if(!p($result3)) {
	$page->swap('POHAR','');
	$page->finish();
	do_footer();
	exit;
}

$page->swap('POHAR',$page->misc('POHAR'));

$fill['pohar_nazev'] = POHAR_NAZEV;

$counter = 0;

$data = array();

for($i=0;$i<p($result3);$i++) {
	$row = fa($result3);
	
	$res3 = $Sql->q('SELECT login from zavodnici WHERE zavod = '.$row['id']);
	$inside = false;
	for($j=0;$j<p($res3);$j++) {
		$zavodnik = fa($res3);
		if($zavodnik['login'] == UID) $inside = true;
	}
	
	$pocet1 = p($res3);
	if(($inside && ($action == "mojeodjete" || $action == "mojeneodjete")) || ($action != "mojeodjete" && $action != "mojeneodjete") && ($empty == "on" || $pocet1 > 0)) {  
		$counter++;
		$res = $Sql->q('SELECT login FROM zavodnici WHERE zavod = '.$row['id']);
		$pocet = p($res);
		$oddelovac = "";
		if($row['login'] == 0 && $counter > 0) {
			$casti = explode('_',$row['nazev']);
			if($casti[1] != $last && $counter > 0 && $i != 0) $oddelovac = 'class="oddelovac"';
			$last = $casti[1];
		} else {
			if($last != "" && $counter > 0 && $i != 0) $oddelovac = 'class="oddelovac"';
		}
		if($row['prestiz'] == 0 && $row['prestiz2'] == 0) {
			$prestiz = "---";
		}
		if($row['prestiz'] == 0 && $row['prestiz2'] != 0) {
			$prestiz = $row['prestiz2']."-";
		}
		if($row['prestiz'] != 0 && $row['prestiz2'] == 0) {
			$prestiz = $row['prestiz']."+";
		}  
		if($row['prestiz'] != 0 && $row['prestiz2'] != 0) {
			$prestiz = $row['prestiz']."-".$row['prestiz2'];
		}    
		if($row['prestiz'] != 0 && $row['prestiz'] == $row['prestiz2']) {
			$prestiz = $row['prestiz'];
		}
			if($row['datum2'] != "" && $row['datum'] != '4200-12-24') $row['datum'] = $row['datum2'];

		if($row['datum'] == "4200-12-24") $row['cas'] = -42;

		$kusy = explode('-',$row['datum']);
		if($kusy[0] == '4200') $row['cas'] = -42;
		$row['datum'] = ($kusy[0] == '4200' ? 'Dnes' : $kusy[2].'.'.$kusy[1].'.');

		$line['id'] = $row['id'];
		$line['barva'] = $ceny_barvy[$row['cena']];
		$line['nazev'] = $row['nazev'];
		$line['dotace'] = str_replace(' ','&nbsp;',numF($row['dotace']));
		$line['zamek'] = '';
		$line['predmet'] = ($row['predmet'] ? $page->misc('PREDMET') : '');
		$line['cas'] = $casy[$row['cas']];
		$line['oddelovac'] = $oddelovac;
		$line['pocet'] = ($_GET['action'] == 'odjete' ? $pocet : '?');
		$line['pocet2'] = $pocet;
		$line['prestiz'] = $prestiz;
		$line['datum'] = str_replace(date('d.m.'),"Dnes",str_replace("4200-12-24","Dnes",$row['datum']));
		$data[] = $line;
	}
}

if($counter == 0) {
	$fill['pohar_zavody'] = '<br />Žádné pohárové závody';
	$page->fill($fill);
	$page->finish();
	do_footer();
	exit;
}

$page->getTable('MOJE ODJETE',$data,'POHAR_ZAVODY');

$page->fill($fill);
$page->finish();
do_footer();
?>