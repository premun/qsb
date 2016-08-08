<?php

include 'library.php';
is_logged();
$nazev = $_POST['nazev'];
$vklad = $_POST['vklad'];
$pocet = $_POST['pocet'];
$datum = $_POST['datum'];
$dotace = $_POST['dotace'];
$predmet = $_POST['predmet'];
$trat = $_POST['trat'];
$popis = $_POST['popis'];
$cas = $_POST['cas'];
$pr = $_POST['prestiz'];
$pr2 = $_POST['prestiz2'];
$minimum = $_POST['minimum'];

if($predmet) {
	$predmet = fa($Sql->q('SELECT id, zbozi, typ, cena, vydrz FROM sklad WHERE umisteni = 0 AND login = '.UID.' AND id = '.$predmet));
	if(!$predmet['typ']) {
		$predmet = '';
	} else {
		$predmet = array_merge($predmet, fa($Sql->q('SELECT nazev, vydrz FROM '.$tabs[$predmet['typ']].' WHERE id = '.$predmet['zbozi'])));
	}
}

$dlg = new cDialog('Zakládání závodu','alert');

$reg_nazev = '^[A-Za-z0-9_ěščřžýáíéďťňúůóĚŠČŘŽÝÁÍÉĎŤŇÚŮÓ \.\#]+$';
$reg_num = '^[0-9]+$';
if(!ereg($reg_nazev,$nazev)) {
	$dlg->obody('Název závodu není v požadovaném formátu');
}

if(p($Sql->q('SELECT nazev FROM zavody WHERE nazev = "'.$nazev.'"'))) {
	$dlg->obody('Takto pojmenovaný závod již existuje');
}

if(!is_numeric($dotace) || $dotace <= 0) {
	$dlg->obody('Dotace musí být kladné číslo');
}

if(getPenize(UID) < (ZAVOD_ZAKLADANI+$dotace)) {
	$dlg->obody('Nemáš dostatek peněz');
}

if(!ereg($reg_num,$dotace)) {
	$dlg->obody('Dotace není číslo');
}

if(($dotace+$predmet['cena']*0.5) < DOTACE_MIN || ($dotace+$predmet['cena']*0.5) > DOTACE_MAX) {
	$dlg->obody('Dotace není v požadovaném rozmezí');
}

if(!ereg($reg_num,$vklad)) {
	$dlg->obody('Vklad není číslo');
}

if($pr == "" || !ereg($reg_num,$pr)) $pr = 0;
if($pr2 == "" || !ereg($reg_num,$pr2)) $pr2 = 0;

if($pr > $pr2 && $pr2 != 0) {
	$dlg->obody('Minimální prestiž je větší než maximální');
}

if($minimum > $pocet || $minimum < 2) {
	$dlg->obody('Minimální počet jezdců je větší než maximální');
}

if(p($Sql->q('SELECT id FROM zavody WHERE login = '.UID.' AND cas = '.$_POST['cas'].' AND datum = "'.$_POST['datum'].'"'))) {
	$dlg->obody('Na tento čas už závod založený máš');
}

$trat = fa($Sql->q('SELECT * FROM trate WHERE id = '.$trat));

$kusy = explode(',',$trat['trat']);

if(getDotace(count($kusy),getDiff($trat['id']),$trat['delka']) < $dotace) {
	$dlg->obody('Trať neodpovídá dotaci');
}

if(!$dlg->is_empty()) {
	$dlg->button('OK', 'close');
	$dlg->output();
	exit;
}

$Sql->q('INSERT into zavody(login,nazev,popis,vklad,pocet,datum,dotace,trat,cas,prestiz,prestiz2,heslo,cena,minimum,predmet) values('.UID.',"'.$nazev.'","'.$popis.'",'.$vklad.','.$pocet.',"'.$datum.'",'.$dotace.','.$trat['id'].','.$cas.','.$pr.','.$pr2.',"'.$heslo.'",'.$_POST['cena'].','.$minimum.','.($predmet['id'] ? $predmet['id'] : 0).')');
$Sql->q('UPDATE postavy set penize = penize-'.(ZAVOD_ZAKLADANI+$dotace).' WHERE login = '.UID);
finance(UID,(ZAVOD_ZAKLADANI+$dotace),0,29);

$nove = fa($Sql->q('SELECT id FROM zavody WHERE login = '.UID.' ORDER BY id DESC LIMIT 0,1'));

$dlg->body('Závod <strong>'.$nazev.'</strong> založen');
$dlg->button('OK','location','showRace.php?id='.$nove['id']);
$dlg->output();
?>