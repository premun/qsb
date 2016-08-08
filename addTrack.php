<?php

include 'library.php';
is_logged();

$dlg = new cDialog('Stavba trati','alert');

$parts = $_POST['parts'];
$nazev = $_POST['nazev'];
$delka = $_POST['delka'];

$url = 'newTrack.php?parts='.$parts.'&delka='.$delka.'&nazev='.$nazev;
$reg_login = '^[A-Za-z0-9_ěščřžýáíéďťňúůóĚŠČŘŽÝÁÍÉĎŤŇÚŮÓ ]+$';

if(!ereg($reg_login,$nazev)) 
	$dlg->obody('Název trati není v požadovaném formátu');

if(getPenize(UID) < (TRAT_ZAKLAD+$_POST['parts']*TRAT_USEK)) 
	$dlg->obody('Nemáš dostatek peněz');

if($parts < TRAT_USEKY_MIN || $parts > TRAT_USEKY_MAX) 
	$dlg->obody('Délka trati musí být v rozmezí '.TRAT_USEKY_MIN.'-'.TRAT_USEKY_MAX);

if(p($Sql->q('SELECT nazev FROM trate WHERE nazev = "'.$nazev.'"')))
	$dlg->obody('Název trati již existuje');

$part = Array();
for($i=1;$i<$parts+1;$i++) {
	if($_POST['part_'.$i.'a'] == 'nic' && $_POST['part_'.$i.'b'] == 'nic' && $_POST['part_'.$i.'c'] == 'nic') {
		$_SESSION['casti2'] = $obsah;
		$dlg->obody($i.'. část je prázdná');
	}
	if($_POST['part_'.$i.'a'] != 'nic') {
		$part[] = $_POST['part_'.$i.'a'];
	} elseif($_POST['part_'.$i.'b'] != 'nic') {
		$part[] = $_POST['part_'.$i.'b'];
	} elseif($_POST['part_'.$i.'c'] != 'nic') {
		$part[] = $_POST['part_'.$i.'c'];
	}
	$obsah = $obsah.$part[count($part)-1].',';
}
$obsah = '';

foreach($part as $index=>$value) {
	if($part[$index-1] >= 10 && $part[$index-1] <= 15) {
		if($value != 16 && $value != 17) {
			$_SESSION['casti2'] = $obsah;
			$dlg->obody('Po rozdvojení cesty musí následovat ihned spojení cesty');
		}
	}
	if($value >= 44 && $value <= 46) {
		if(!($part[$index-1] >= 38 && $part[$index-1] <= 43)) {
			$dlg->obody('Před propastí musí být práh nebo skok');
		}
	}
	$obsah = $obsah.$value.',';
}

if(!$dlg->is_empty()) {
	$dlg->button('OK', 'close');
	$dlg->output();
	exit;
}

$Sql->q('INSERT into trate(nazev,login,datum,popis,delka,useky,trat) values("'.$nazev.'",'.UID.',"'.date('Y-m-d').'","'.$_POST['popis'].'",'.$delka.','.$parts.',"'.'1,'.$obsah.',3'.'")');
$Sql->q('UPDATE postavy set prestiz = prestiz+'.TRAT_PRESTIZ.', penize = penize-'.(TRAT_ZAKLAD+$parts*TRAT_USEK).' WHERE login = '.UID);

finance(UID,(TRAT_ZAKLAD+$parts*TRAT_USEK),0,30);

if($parts > 14) addQuest(UID,73,0);

$nova = fa($Sql->q('SELECT id FROM trate ORDER BY id DESC LIMIT 0,1'));

$dlg->button('OK', 'location', 'showTrat.php?id='.$nova['id']);
$dlg->body('Trať byla úspěšně vytvořena');
unset($_SESSION['casti2']);
$dlg->output();
?>