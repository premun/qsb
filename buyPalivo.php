<?php

include 'library.php';
is_logged();

$id = $_GET['id'];

if($id == "" || (!is_numeric($id) && $id > 0)) $id = 1;

$palivo = getPalivoAll($id);

if(!$palivo) {
	$_SESSION['chyba'] = 'Toto palivo neexistuje';
	go('obchod.php?action=paliva');
	exit;
}

do_header('Obchod');

$page = new cPage('palivo');

$typ = fa($Sql->q('SELECT * from paliva WHERE id = '.$palivo['palivo']));

if($_GET['trat'] != '') $_POST['trat'] = $_GET['trat'];
if($_POST['trat'] == '') {
	$trat1 = fa($Sql->q('SELECT * from trate WHERE useky BETWEEN '.TRAT_USEKY_MIN.' AND '.TRAT_USEKY_MAX.' ORDER BY nazev ASC'));
	$_POST['trat'] = $trat1['id'];
}

$res = $Sql->q('SELECT * FROM paliva_sklad WHERE login = '.UID.' AND staj = 0 AND palivo = '.$id);

$ma_motor = false;
$res2 = $Sql->q('SELECT zbozi FROM sklad WHERE umisteni = 1 AND login = '.UID.' AND typ = 2');
if(p($res2) > 0) {
	$motor = fa($res2);
	$motor = new cItem($motor['zbozi'],2);
	if($motor->palivo == $id) $ma_motor = true;
}

if($ma_motor == true) {
	if(p($res) != 0) {
		$row2 = fa($res);
		$zbytek = (getSpotreba($_POST['trat'],$motor->spotreba)-$row2['mnozstvi']);
		$mas = $row2['mnozstvi'];
	} else {
		$zbytek = getSpotreba($_POST['trat'],$motor->spotreba);
	}
	
} else {
	if(p($res) != 0) {
		$row2 = fa($res);
		$mas = $row2['mnozstvi'];	
	}
	$zbytek = 0;
}
	
$jednotky = getJednotky();
$jed = $jednotky[$id];

$page->swap('NAZEV',$palivo['nazev']);

$fill['id'] = $id;
$fill['nazev'] = $palivo['nazev'];
$fill['jednotka'] = $jed;
$fill['cena'] = numFP($palivo['cena']);
$fill['cena2'] = $palivo['cena'];
$fill['stala'] = numFP($palivo['stala_cena']);
$fill['mas'] = numF($mas);
$fill['typ'] = $typ['nazev'];
$fill['popis'] = $typ['popis'];
$fill['spotreba'] = '';

$velikost = fa($Sql->q('SELECT sklad FROM postavy WHERE login = '.UID));
$fill['velikost'] = numF($velikost['sklad']);

if($ma_motor == true) {

	$result = $Sql->q('SELECT * from trate WHERE useky BETWEEN '.TRAT_USEKY_MIN.' AND '.TRAT_USEKY_MAX.' ORDER BY nazev ASC');
	for($i=0;$i<p($result);$i++) {
		$trate = fa($result);
		
		$data[] = array('id' => $trate['id'], 'nazev' => $trate['nazev'], 'checked' => ($_POST['trat'] == $trate['id'] ? ' selected="selected"' : ''));
	}

	$page->getTable('SPOTREBA',$data,'SPOTREBA');
	$fill['spotreba2'] = round($zbytek);
	$fill['cena_na_trat'] = numF($palivo['cena']*ceil($zbytek)).' Is';
	
	if($zbytek < $spotreba && $zbytek > 0) {
		$fill['zbytek2'] = '';
		$fill['zbytek'] = $zbytek;
	} else {
		$fill['zbytek2'] = ' style="display: none"';	
	}
}  

$fill['penize'] = round(getPenize(UID));
$fill['max'] = numF(getPenize(UID)/$palivo['cena']);
$fill['staj'] = '';
$fill['prodej'] = '';
$fill['prodej_staj'] = '';

$result = $Sql->q('SELECT staj FROM stajovnici WHERE login = '.UID.' AND stav = 3');

if(p($result) > 0) {
	$st = fa($result);
	
	$staj = fa($Sql->q('SELECT id,kasa FROM staje WHERE id = '.$st['staj']));
	
	$page->misc('STAJ','STAJ');
	
	$fill['kasa'] = numF($staj['kasa']);
	
	$sklad = (p($Sql->q('SELECT id FROM budovy WHERE budova = 3 AND staveni = 0 AND staj = '.$staj['id']))*SKLAD_MALY+p($Sql->q('SELECT id FROM budovy WHERE budova = 7 AND staveni = 0 AND staj = '.$staj['id']))*SKLAD_VELKY);
	
	$res = $Sql->q('SELECT palivo, mnozstvi FROM paliva_sklad WHERE staj = 1 AND login = '.$staj['id']);
	$obsazeno = 0;
	for($i=0;$i<p($res);$i++) {
		$palivo2 = fa($res);
		$obsazeno += $palivo2['mnozstvi'];
		if($palivo2['palivo'] == $id) {
			$mas2 = $palivo2['mnozstvi'];
		}
	}
	
	$koupit = $staj['kasa']/$palivo['cena'];
	if($koupit > ($sklad-$obsazeno)) $koupit = ($sklad-$obsazeno);
	
	$koupit = floor($koupit);
	
	$fill['staj_ma'] = numF($mas2);
	$fill['staj_obsazeno'] = numF($obsazeno);
	$fill['staj_sklad'] = numF($sklad);
	$fill['staj_koupit'] = numF($koupit);
}

if($mas > 0) {
	$page->misc('PRODEJ','PRODEJ');
}

if($mas2 > 0) {
	$page->misc('PRODEJ_STAJ','PRODEJ_STAJ');
}

$page->fill($fill);
$page->finish();
do_footer();
?>