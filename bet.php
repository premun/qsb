<?php

include 'library.php';
is_logged();

$sazka = $_POST['sazka'];
$zavodnik = $_POST['zavodnik'];
$misto = $_POST['misto'];
$id = $_POST['zavod'];

if($misto == -1) $zavodnik = 0;

$dlg = new cDialog('Sázení na závod','alert','height: auto, width: 300px');

$page = new cPage('sazky');

if(!is_numeric($sazka) || $sazka <= 0) {
	$dlg->obody($page->ext('KLADNE_CISLO'));
	exit;
}

$result2 = $Sql->q('SELECT id FROM zavodnici WHERE login = '.UID.' AND zavod = '.$id);
if(p($result2) > 0) {
	$dlg->obody($page->ext('JEDES'));
	exit;
}

if(getPenize(UID) < $sazka) {
	$dlg->obody($page->ext('NEMAS_TOLIK',0,0,array('penize' => numF($sazka))));
	exit;
}

$result2 = $Sql->q('SELECT * from sazky WHERE login = '.UID.' AND zavod = '.$id);
if(p($result2) > 0) {
	$dlg->obody($page->ext('VICKRAT'));
	exit;
}

if(!$dlg->is_empty()) {
	$dlg->title('Nelze si vsadit');
	$dlg->button('OK','alert','betOnRace.php?id='.$id);
	$dlg->output();
	exit;
}

$nejvic = fa($Sql->q('SELECT val2 from casopis WHERE val1 = "sazka2"'));

if($sazka >= $nejvic['val2']) {
	$Sql->q('UPDATE casopis set val2 = '.$sazka.' WHERE val1 = "sazka2"');
	$Sql->q('UPDATE casopis set val2 = '.UID.' WHERE val1 = "sazka"');
}

$result = $Sql->q('INSERT into sazky(login, zavod, sazka, zavodnik, misto, vyhra) values('.UID.','.$id.','.$sazka.','.$zavodnik.','.$misto.','.($_POST['cancel'] == 'on' ? -1 : 0).')');
$Sql->q('UPDATE postavy set penize = penize-'.$sazka.' WHERE login = '.UID);
$Sql->q('UPDATE zavody set sazky = sazky+'.$sazka.' WHERE id = '.$id);

finance(UID,$sazka,0,22);

$dlg->body($page->ext('VSAZENO'));
$dlg->button('OK','refresh');
$dlg->output();
?>