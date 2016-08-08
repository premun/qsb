<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

$hotovy_useky = array(1,2,3,4,5,6,7,8,9,11,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,40,44,45,46,47,48,49,50,51,52,57,58,59,60,61,63);

if(!is_numeric($id)) {
	$_SESSION['chyba'] = "ID musí být číslo";
	go('trate.php');
	exit;
}

do_header('Tratě');

$page = new cPage('showTrat');

$barvy = Array();
$barvy[5] = "#FF0000";
$barvy[4] = "#FA6705";
$barvy[3] = "#FFFF00";
$barvy[2] = "#83AA0D";
$barvy[1] = "#02FD09";

$result = $Sql->q('SELECT motory.palivo as palivo FROM sklad LEFT JOIN motory ON sklad.zbozi = motory.id WHERE sklad.typ = 2 AND sklad.login = '.UID.' AND sklad.umisteni = 1');
$result2 = $Sql->q('SELECT id, login, popis, DATE_FORMAT(datum, "%d.%m. %Y") datum, nazev, pro, proti, mezi, trat FROM trate WHERE id = '.$id);
if(p($result2) == 0) {
	$_SESSION['chyba'] = "Trať nebyla nalezena";
	go('trate.php');
	exit;
}
$row = fa($result2);

$pro = $row['pro'];
$proti = $row['proti'];
$mezi = $row['mezi'];

$rating = (($pro == 0 && $proti == 0 && $mezi == 0) ? 'Zatím nehodnoceno' : round(100*(($pro+0.5*$mezi)/($pro+$mezi+$proti))).'%');

$kusy = explode(',',$row['trat']);
$fill['trat'] = $row['trat'];
$fill['id'] = $row['id'];
$fill['nazev'] = $row['nazev'];
$fill['login'] = $row['login'];
$fill['nick'] = getNick($row['login']);
$fill['datum'] = $row['datum'];
$fill['diff'] = round(getDiff($id),2);
$fill['rating'] = $rating;
$fill['hodnotilo'] = ($pro+$mezi+$proti);
$fill['useky'] = count($kusy);
$fill['dotace'] = numF(getDotace($fill['useky'],$fill['diff'],$row['delka']));
$fill['popis'] = $row['popis'];
$fill['koupit'] = ' style="display: none"';
$fill['hodnotit'] = ' style="display: none"';

if(p($result) > 0) {
	$row2 = fa($result);
	$fill['koupit'] = '';
	$fill['palivo'] = $row2['palivo'];
}

$rat = fa($Sql->q('SELECT trate FROM hraci WHERE id = '.UID));
if(!ereg(','.$row['id'].',',$rat['trate'])) {
	$fill['hodnotit'] = '';
}

$usek1 = 20;
$usek2 = 40;
$usek3 = 60;
$usek4 = 80;   
	
$usek1r = 45;
$usek2r = 60;
$usek3r = 75;
$usek4r = 90; 

$result = $Sql->q('SELECT * FROM trate_druhy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$useky_info[$row['id']] = $row;
}

$flash_ok = true;

foreach($kusy as $i=>$value) {	
	$danger = $useky_info[$value]['nebezpeci'];
	$rychlost = $useky_info[$value]['rychlost'];
	
	if(!in_array($value,$hotovy_useky) && $value != 3) $flash_ok = false;
	
	$barva = 1;
	if($danger > $usek1) $barva = 2;
	if($danger > $usek2) $barva = 3;
	if($danger > $usek3) $barva = 4;
	if($danger > $usek4) $barva = 5;
		
	$barva2 = 1;
	if($rychlost < $usek4r) $barva2 = 2;
	if($rychlost < $usek3r) $barva2 = 3;
	if($rychlost < $usek2r) $barva2 = 4;
	if($rychlost < $usek1r) $barva2 = 5;
	
	$line['nazev'] = $useky_info[$value]['nazev'];
	$line['barva1'] = $barvy[$barva];
	$line['barva2'] = $barvy[$barva2];
	$line['nebezpeci'] = $danger.'%';
	$line['rychlost'] = $rychlost.'%';
	
	$celkem_d += $danger;
	$celkem_r += $rychlost;
	
	if($kusy[0] == $value) {
		$line['nebezpeci'] = '<strong>Nebezpečí</strong>';
		$line['rychlost'] = '<strong>Rychlost</strong>';	
		$line['barva1'] = "#FFFFFF";
		$line['barva2'] = $line['barva1'];
	}
	
	if(!isset($kusy[$i+1])) {
		$line['nebezpeci'] = '<strong>'.numFP($celkem_d/($i+1)).'%</strong>';
		$line['rychlost'] = '<strong>'.numFP($celkem_r/($i+1)).'%</strong>';	
		$line['barva1'] = "#FFFFFF";
		$line['barva2'] = $line['barva1'];
	}
	
	$data[] = $line;
}

$page->getTable('USEKY',$data,'USEKY2');

if($flash_ok) {
	$params = 'nazev='.$fill['nazev']
			. '&autor='.$fill['nick']
			. '&date='.$fill['datum']
			. '&obsah='.$fill['trat']
			. '&diff='.$fill['diff'];
			
	$fill['params'] = $params;
	$page->misc('FLASH','FLASH');
} else {
	$fill['flash'] = 'Na vizualizaci se pořád pracuje a proto některé tratě zatím nejsou rekonstruovatelné';	
}

$page->fill($fill);

$page->finish();

do_footer();
?>