<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

$dlg = new cDialog('Nákup předmětu', 'alert', 'width: 300px');

if($id == '' || !ereg('^[0-9]+$',$id)) {
	$dlg->obody('Předmět nebyl nalezen');
	konec();
}

$result = $Sql->q('SELECT * from zbozi WHERE id = '.$id);
if(p($result) == 0) {
	$dlg->obody('Předmět nebyl nalezen');
	konec();
}
$zbozi = fa($result);

$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
$etapa = $result['val'];

if($etapa < $zbozi['etapa']) {
	$dlg->obody('Předmět ještě není na trhu');
	konec();
}

$cena = getCost($zbozi['cena'],getRasa(UID),$zbozi['obchodnik']);
$penize = getPenize(UID);
if($penize < $cena) {
	$dlg->obody('Nemáš dostatek peněz');
	konec();
}

if($zbozi['kusy'] < 1) {
	$dlg->obody('Obchodník už nemá dnes na skladu žádné takovéto zboží');
	konec();
}

$p = new cItem($zbozi['zbozi'],$zbozi['typ']);

$names[1] = "podvozek";
$names[2] = "motor";
$names[3] = "energodržáky";
$names[4] = "chladič";
$names[5] = "palubní deska";
$names[6] = "brzdy";
$names[7] = "zdroje";
$names[8] = "pancéřování";
$names[9] = "suspenzory";
$names[10] = "přídavné motory";

if(!$dlg->is_empty()) {
	$dlg->button('OK','close');
	$dlg->output();
	konec();
}

if($_GET['action'] != "sure") {
	$dlg->body('Chystáš se nakoupit '.$names[$zbozi['typ']].' <strong>'.$p->nazev.'</strong> za <strong class="extra">'.str_replace(' ','&nbsp;',numF($cena)).' Is</strong>.');
	$dlg->button('Zrušit','close');
	$dlg->button('Koupit','alert','buy.php?id='.$id.'&action=sure');
	$dlg->output();
	konec();
}

$nakup = fa($Sql->q('SELECT val2 from casopis WHERE val1 = "nakup"'));
$veci = fa($Sql->q('SELECT val2 from casopis WHERE val1 = "veci"'));
$Sql->q('UPDATE casopis set val2 = '.($nakup['val2']+$cena).' WHERE val1 = "nakup"');
$Sql->q('UPDATE casopis set val2 = '.($veci['val2']+1).' WHERE val1 = "veci"');

$Sql->q('UPDATE zbozi SET kusy = '.($zbozi['kusy']-1).' WHERE id = '.$id);
$Sql->q('UPDATE postavy SET penize = '.($penize-$cena).' WHERE login = '.UID);
finance(UID,$cena,0,18);


$Sql->q('INSERT into sklad(login,zbozi,typ,cena,vydrz) values('.UID.','.$zbozi['zbozi'].','.$zbozi['typ'].','.$zbozi['cena'].','.$p->vydrz.')');

$prestiz = 150;
if($cena <= 70000) $prestiz = 125;
if($cena <= 40000) $prestiz = 100;
if($cena <= 20000) $prestiz = 80;
if($cena <= 15000) $prestiz = 60;
if($cena <= 10000) $prestiz = 30;
if($cena <= 5000) $prestiz = 10;

//$Sql->q('UPDATE postavy set prestiz = prestiz+'.$prestiz.' WHERE login = '.UID);

$dlg->body('Koupil jsi <strong>'.$p->nazev.'</strong> za <strong>'.numF($cena).'</strong>.');

$dlg->button('Nakupovat dál','location','obchod.php?action=casti');
$dlg->button('Do skladu','location','obchod.php?action=sklad');
$dlg->output();
?>