<?php
include 'library.php';

is_logged();

$action = $_POST['action'];
$zavod = $_POST['zavod'];
$login = $_POST['login'];
$spolehlivost = $_POST['spolehlivost'];

$dlg = new cDialog('Špión','alert','width: 300px, height: 180');

if(!is_numeric($zavod) || !is_numeric($login)) {
	$dlg->obody('Nebyly předány všechny potřebné informace');
	konec();
}

if($login == UID) {
	$dlg->obody('Špiónovat sám sebe?');
	konec(); 
}

$result = $Sql->q('SELECT id, nazev, vitez FROM zavody WHERE id = '.$zavod);

if(!p($result)) {
	$dlg->obody('Závod nebyl nalezen');
	konec(); 
}

$zavod = fa($result);

if($zavod['vitez'] == 1) {
	$dlg->obody('Tento závod již byl odjet');
	konec(); 
}

$result = $Sql->q('SELECT * FROM zavodnici WHERE login = '.$login.' AND zavod = '.$zavod['id']);

if(!p($result)) {
	$dlg->obody('Závodník nebyl nalezen');
	konec(); 
}

$zavodnik = fa($result);
$zavodnik['nick'] = getNick($login);
$zavodnik['prestiz'] = getPrestiz($login);

$fill['login'] = $login;
$fill['zavod'] = $zavod['id'];

$dlg->title('Špehování hráče '.$zavodnik['nick']);

$page = new cPage('spion');

if($action == 'show') {
	$spion = fa($Sql->q('SELECT * FROM spioni WHERE login = '.UID.' AND zavodnik = '.$zavodnik['id']));
	$fill['spolehlivost'] = $spion['spolehlivost'];
	$dlg->obody($page->ext('SHOW',0,0,$fill));
	$dlg->button('Zavřít', 'close');
	$dlg->button('Najmout nového špióna', 'jHadr_submit', 'form_spion');
	$dlg->output();
	konec();
}

$result = $Sql->q('SELECT id, spolehlivost FROM spioni WHERE login = '.UID.' AND zavodnik = '.$zavodnik['id']);
if(p($result) && $action != 'zrusit') {
	$spion = fa($result);
	
	$fill['spolehlivost'] = $spion['spolehlivost'];
	
	$dlg->obody($page->ext('ZRUSIT',0,0,$fill));
	$dlg->button('Ne', 'close');
	$dlg->button('Ano', 'jHadr_submit', 'form_spion');
	$dlg->output();
	konec(); 
}

if($action == 'zrusit') {
	$Sql->q('DELETE FROM spioni WHERE login = '.UID.' AND zavodnik = '.$zavodnik['id']);
}

$penize = getPenize(UID);

$rasa = getRasa(UID);
$mod_rasa = 1-($rasa['o']+4)/21; /* 0 - Mel, 1 - Kent */
$mod_rasa = 0.8 * $mod_rasa - 0.4; /* -0.4 Mel, 0.4 Kent */
$mod_rasa += 1; /* 0.6x az 1.4x */

$zaklad = max(500,$zavodnik['prestiz']*2);
$zaklad *= 1+ceil($kluzak['celkem']/35000)/10;
$zaklad *= $mod_rasa;

$fill['zaklad'] = $zaklad;
$fill['penize'] = $penize;

if(!is_numeric($spolehlivost) || !$spolehlivost) {
	$dlg->body($page->ext('NAJMOUT', 0, 0, $fill));
	$dlg->button('Zrušit', 'close');
	$dlg->button('Najmout špióna', 'jHadr_submit', 'form_spion');
	$dlg->output();
	konec();
}

$cena = $zaklad*$spolehlivost/100;
if($_POST['aktualizace'] == 'on') $cena *= 1.7;

$cena = round($cena);

if($cena > $penize) {
	$dlg->obody('Nemáš tolik peněz');
	konec(); 	
}

if(!$dlg->is_empty()) {
	$dlg->button('OK', 'close');
	$dlg->output();
	konec();
}

$kluzak = fa($Sql->q('SELECT SUM(cena) as celkem FROM sklad WHERE umisteni = 1 AND login = '.$login));

if($_POST['aktualizace'] == 'on' && $spolehlivost > 9) $Sql->q('INSERT into spioni(login, zavodnik, spolehlivost) values('.UID.', '.$zavodnik['id'].', '.$spolehlivost.')');
$Sql->q('UPDATE postavy set penize = penize - '.$cena.' WHERE login = '.UID);
if($spolehlivost > 9) $Sql->q('UPDATE stats set spion = spion+1 WHERE login = '.UID);

finance(UID,$cena,0,24);

$msg = spion($spolehlivost, $zavodnik['id']);
sendPosta(0, UID, $msg);

$dlg->set('height', '140');
$dlg->obody('Špión na hráče <strong>'.$zavodnik['nick'].'</strong> najat. Podrobnosti o zjištěných informacích budeš nacházet v poště.');
$dlg->button('OK', 'location', 'posta.php?&action=new');

$dlg->output();
?>