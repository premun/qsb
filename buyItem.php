<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

$dlg = new cDialog('Nákup předmětu', 'alert', 'width: 300px');

if($id == '' || !ereg('^[0-9]+$',$id)) {
	$dlg->obody('Hledaný předmět neexistuje');
	konec();
}

$result = $Sql->q("SELECT id,login,cena2 as cena, cena as cena3,zbozi,umisteni,typ,vydrz from sklad WHERE id = ".$id);

if(p($result) == 0) {
	$dlg->obody('Hledaný předmět neexistuje');
	konec();
}

$zbozi = fa($result);

if($zbozi['umisteni'] != 2) {
	$dlg->obody('Předmět není ve výloze');
	konec();
}

if($zbozi['login'] == UID) {
	$dlg->obody('Předmět už je tvůj');
	konec();
}

$result2 = $Sql->q('SELECT staj from stajovnici WHERE login = '.UID);
if(p($result2) > 0) {
	$staj = fa($result2);
	$result2 = $Sql->q('SELECT staj from stajovnici WHERE login = '.$zbozi['login']);
	if(p($result2) > 0) {
		$staj2 = fa($result2);
		if($staj['staj'] == $staj2['staj']) {
			$dlg->obody('Obchodník je ze tvé stáje. Použij předání předmětu v rámci stáje');
			konec();	
		}
	}
}

$cena = $zbozi['cena'];
$penize = getPenize(UID);

if($penize < $cena) {
	$dlg->obody('Nemáš dostatek peněz');
	konec();
}

if(!$dlg->is_empty()) {
	$dlg->button('OK','close');
	$dlg->output();
	konec();
}

$names[1] = "podvozek";
$names[2] = "motor";
$names[3] = "energodržáky";
$names[4] = "chladič";
$names[5] = "palubní desku";
$names[6] = "brzdy";
$names[7] = "zdroj";
$names[8] = "pancéřování";
$names[9] = "suspenzory";
$names[10] = "přídavné motory";

if($_GET['action'] != "sure") {
	$dlg->body('Chystáš se nakoupit <strong>'.$names[$zbozi['typ']].'</strong> za <strong class="extra">'.str_replace(' ','&nbsp;',numF($cena)).' Is</strong>.');
	$dlg->button('Zrušit','close');
	$dlg->button('Koupit','alert','buyItem.php?id='.$id.'&action=sure');
	$dlg->output();
	konec();
}

$prestiz = 150;
if($cena < 70000) $prestiz = 125;
if($cena < 40000) $prestiz = 100;
if($cena < 20000) $prestiz = 80;
if($cena < 15000) $prestiz = 60;
if($cena < 10000) $prestiz = 30;
if($cena < 5000) $prestiz = 10;

$vec = new cItem($zbozi['zbozi'],$zbozi['typ']);
$Sql->q('UPDATE sklad SET login = '.UID.', umisteni = 0, cena2 = 0 WHERE id = '.$id);
$Sql->q('UPDATE postavy set penize = '.($penize-$cena).' WHERE login = '.UID);
$Sql->q('UPDATE postavy set penize = penize+'.$cena.' WHERE login = '.$zbozi['login']);
$Sql->q('DELETE FROM sablony WHERE login = '.$zbozi['login'].' AND '.$tabs[$zbozi['typ']].' = '.$id);

finance($zbozi['login'],$cena,1,10);
finance(UID,$cena,0,18);

$Sql->q('UPDATE stats set prodej1 = prodej1+1 WHERE login = '.$zbozi['login']);	
if($zbozi['vydrz']/$vec->vydrz*100 < 75) $Sql->q('UPDATE stats set prodej3 = prodej3+1 WHERE login = '.$zbozi['login']);	
if($zbozi['cena3'] < $cena) $Sql->q('UPDATE stats set prodej4 = prodej4+1 WHERE login = '.$zbozi['login']);	


$msg = "Hráč [B][O]".getNick(UID)."[/O][/B] koupil [O]".date('j.n.')." v ".date('H:i')."[/O] předmět z tvé výlohy. 
Jednalo se o [B][O]".$vec->nazev."[/O][/B] a prodal jsi ho za [O][B]".numF($cena)." Is[/O][/B]. 
SYSTEM";

sendPosta(0,$zbozi['login'],$msg);

$dlg->obody('Předmět zakoupen');
$dlg->button('Nakupovat dál','refresh');
$dlg->button('Do skladu','location','obchod.php?action=sklad');
$dlg->output();
?>