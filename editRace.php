<?php
include_once 'library.php';
is_logged();

$page2 = new cPage('editRace');

if($_GET['action'] == 'edit' || $_GET['action'] == 'cancel') $id = $_GET['id'];

if($id == '' || !ereg('^[0-9]+$',$id)) {
	$page2->ext('EXIST',1,'Závody');
	exit;
}

$result = $Sql->q('SELECT id, login, nazev, popis, vklad, dotace, sazky, cas, prestiz, prestiz2, divaci, cena, minimum, DATE_FORMAT(datum, "%d.%m. %Y") datum, pocet, trat, vitez, predmet FROM zavody WHERE id = '.$id);
if(!p($result)) {
	$page2->ext('EXIST',1,'Závody');
	exit;
}

$zavod2 = fa($result);

if($zavod2['login'] != UID) {
	$page2->ext('ZAKLADAL',1,'Závody');
	exit;
}

if($zavod2['vitez'] != 0) {
	$page2->ext('ODJET',1,'Závody');
	exit;
}

if($zavod2['datum'] == "24.12. 4200") $zavod2['datum'] = date('d.m. Y');

if($_GET['action'] == 'cancel') {
	if(p($Sql->q('SELECT login FROM zavodnici WHERE zavod = '.$id))) {
		$page2->ext('FULL',1,'Závody');
		exit;
	}
	$penize = $zavod2['dotace']+$zavod2['vklady']+$zavod2['sazky'];
	$Sql->q('UPDATE postavy set penize = penize+'.$penize.' WHERE login = '.UID);
	finance(UID,$penize,1,17);
	$Sql->q('DELETE from zavody WHERE id = '.$id);
	$_SESSION['chyba'] = 'Závod zrušen';
	go('zavody.php?action=neodjete&empty=on');
	exit;    
}

if($_GET['action'] == 'edit') {
	if(p($Sql->q('SELECT * from zavodnici WHERE zavod = '.$id))) {
		if($_POST['heslo'] != "") $heslo = md5($_POST['heslo']);
		$Sql->q('UPDATE zavody set popis = "'.$_POST['popis'].'", heslo = "'.$heslo.'", minimum = "'.$_POST['minimum'].'" WHERE id = '.$id);
		$_SESSION['chyba'] = 'Údaje změněny';
		go('showRace.php?id='.$id);
		exit;
	}

	$vklad = $_POST['vklad'];
	$pocet = $_POST['pocet'];
	$datum = $_POST['datum'];
	$trat = $_POST['trat'];
	$cena = $_POST['cena'];
	$popis = $_POST['popis'];
	$cas = $_POST['cas'];
	$pr = $_POST['prestiz'];
	$pr2 = $_POST['prestiz2'];
	$minimum = $_POST['minimum'];
	
	$reg_num = '^[0-9]+$';
	
	if(!ereg($reg_num,$vklad)) {
		$_SESSION['chyba'] = 'Vklad není číslo';
		go('showRace.php?id='.$id.'#editace');
		exit;
	}

	if($pr == "" || !ereg($reg_num,$pr)) $pr = 0;
	if($pr2 == "" || !ereg($reg_num,$pr2)) $pr2 = 0;
	
	if($pr > $pr2 && $pr2 != 0) {
		$_SESSION['chyba'] = 'Minimální prestiž je větší než maximální';
		go('showRace.php?id='.$id.'#editace');
		exit;
	}

	if($minimum > $pocet || $minimum < 2) {
		$_SESSION['chyba'] = 'Minimální počet jezdců je větší než maximální';
		go('showRace.php?id='.$id.'#editace');
		exit;
	}

	$heslo = '';
	if($_POST['heslo'] != "") $heslo = md5($_POST['heslo']);
	$Sql->q('UPDATE zavody set popis = "'.$popis.'", vklad = '.$vklad.', cena = '.$cena.',pocet = '.$pocet.', datum = "'.$datum.'", trat = '.$trat.', cas = '.$cas.', prestiz = '.$pr.', prestiz2 = '.$pr2.', heslo = "'.$heslo.'", minimum = '.$minimum.' WHERE id = '.$id);
	
	$_SESSION['chyba'] = 'Závod upraven';
	go('showRace.php?id='.$id);
	exit;
}

$fill2['id'] = $id;
$fill2['nazev'] = $zavod2['nazev'];
$fill2['heslo'] = $zavod2['heslo'];
$fill2['popis'] = $zavod2['popis'];
$fill2['predmet'] = $fill['predmet'];

if(p($Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$id))) {
	$page2->misc('S_LIDMA','OBSAH');
	
	for($i=2;$i<11;$i++) {
	$selected = "";
	if($i == $zavod2['minimum']) $selected = " selected"; 
		$data_lidi2[$i]['pocet'] = $i;
		$data_lidi2[$i]['checked'] = $selected;
	}

	$fill2['lidi2'] = $page2->getTable('LIDI2',$data_lidi2);
	
	$page2->fill($fill2);
	$page2->finish();
} else {

	$fill2['vklad'] = $zavod2['vklad'];
	$fill2['prestiz1'] = $zavod2['prestiz'];
	$fill2['prestiz2'] = $zavod2['prestiz2'];
	$fill2['dotace'] = numF($zavod2['dotace']);
	$fill2['sazky'] = numF($zavod2['sazky']);
	$fill2['popis'] = $zavod2['popis'];
	
	if(date('H') != "23") {
		$data_datum[0]['cas'] = date('Y-m-d');
		$data_datum[0]['datum'] = 'Dnes';
	}
	
	for($i=1;$i<8;$i++) {
		$data_datum[$i]['cas'] = date('Y-m-d',time()+86400*$i);
		$data_datum[$i]['datum'] = date('j.n.',time()+86400*$i);
		$data_datum[$i]['checked'] = (date('d.m. Y',time()+86400*$i) == $zavod2['datum'] ? ' selected="selected"' : '');
	}
	
	$fill2['datum'] = $page2->getTable('DATUM',$data_datum);
	
	$result = $Sql->q('SELECT id,nazev,useky,delka,trat FROM trate WHERE useky BETWEEN '.TRAT_USEKY_MIN.' AND '.TRAT_USEKY_MAX.' ORDER BY nazev ASC');
	for($i=0;$i<p($result);$i++) {
		$trat = fa($result);
		$trat['checked'] = ($trat['id'] == $zavod2['trat'] ? ' selected="selected"' : '');
		$diff = getDiffOpt($trat['trat']);
		if(getDotace($trat['useky'],$diff,$trat['delka']) >= $zavod2['dotace']+$predmet['cena']/2) $data_trate[] = $trat;
	}
	
	$fill2['trate'] = $page2->getTable('TRATE',$data_trate);
	  
	
	$data = array();
	foreach($ceny_kluzaky as $idc=>$value) {
		if($idc && $idc < 6) $data[] = array('id' => $idc, 'checked' => ($idc == $zavod2['cena'] ? ' selected="selected"' : ''), 'value' => numF($ceny_kluzaky[$idc-1]).' - '.numF($ceny_kluzaky[$idc]));
	}
		
	$fill2['ceny'] = $page2->getTable('CENY',$data);
	
	for($i=2;$i<11;$i++) {
		$selected = "";
		if($i == $zavod2['pocet']) $selected = " selected"; 
		$data_lidi[$i]['pocet'] = $i;
		$data_lidi[$i]['checked'] = $selected;
	}
	
	$fill2['lidi'] = $page2->getTable('LIDI',$data_lidi);
	
	for($i=2;$i<11;$i++) {
		$selected = "";
		if($i == $zavod2['minimum']) $selected = " selected"; 
		$data_lidi2[$i]['pocet'] = $i;
		$data_lidi2[$i]['checked'] = $selected;
	}
	
	$fill2['lidi2'] = $page2->getTable('LIDI2',$data_lidi2);
	
	$page2->misc('BEZ','OBSAH');
	$page2->fill($fill2);
	$page2->finish();
}
?>