<?php

include 'library.php';
is_logged();

$id = $_GET['id'];

$dlg = new cDialog('Šrotování předmětu', 'alert', 'width: 300px');

if(!is_numeric($id) || $id <= 0) {
	$dlg->obody('Nebyl vybrán žádný předmět');
	konec();
}

$result = $Sql->q('SELECT * from sklad WHERE id = '.$id);
if(p($result) == 0) {
	$dlg->obody('Předmět nebyl nalezen');
	konec();
}

$row = fa($result);
$p = new cItem($row['zbozi'],$row['typ']);

if($row['login'] != UID && $action2 != 'cizi') {
	$dlg->obody('Předmět není tvůj');
	konec();
}

if($row['umisteni'] != UID*-1 && $action2 == 'cizi') {
	$dlg->obody('Předmět není ve tvé smlouvě');
	konec();
}

if($row['umisteni'] == 1) {
	$dlg->obody('Předmět je součást kluzáku');
	konec();
}

if(!$dlg->is_empty()) {
	$dlg->button('OK','close');
	$dlg->output();
	konec();
}

$page = new cPage('obchod');

$cena = $row['cena'];
$rasa = getRasa(UID);
$bonus = (SROT+($rasa['o']/3));
$cena = $cena * ($bonus / 100);
//$bonus2 = $row['vydrz']/$p->vydrz*100;
//$cena = $cena * $bonus2 / 100;			# cena nezavisi na kondici predmetu (kdyz je zakomentovano)
$cena = $cena/2;

$sablony = p($Sql->q('SELECT id FROM sablony WHERE login = '.UID.' AND '.$tabs[$row['typ']].' = '.$id));

if($_GET['action'] == 'sure') {
	if($sablony) $Sql->q('DELETE FROM sablony WHERE login = '.UID.' AND '.$tabs[$row['typ']].' = '.$id);
	$Sql->q('DELETE FROM sklad WHERE id = '.$id);
	$Sql->q('UPDATE postavy set penize = penize+'.$cena.' WHERE login = '.UID);
	finance(UID,$cena,1,11);
	$Sql->q('UPDATE stats set srot = srot+1 WHERE login = '.UID);
	$dlg->body('Předmět rozmačkán na kousky'.($sablony ? '. Spolu s ním bylo smazáno <strong>'.$sablony.'</strong> šablon.' : ''));
	$dlg->button('OK', 'refresh');
	$dlg->output();
	konec();
}

$fill['nazev'] = $p->nazev;
$fill['id'] = $id;
$fill['cena'] = numF($cena);

if($sablony && $_GET['action3'] != 'sablona') {
	$dlg->obody('Tento předmět je použit v některé z tvých šablon <strong>('.$sablony.')</strong>. Pokud ho sešrotuješ, všechny šablony, které tento předmět používají budou smazány spolu s ním.');
	$dlg->button('Zrušit','close');
	$dlg->button('Sešrotovat','alert','srot.php?id='.$id.'&action=sure&action3=sablona');
	$dlg->output();
	konec();
}

$dlg->body($page->ext('SROT',0,0,$fill));

$dlg->button('Zrušit','close');
$dlg->button('Sešrotovat','alert','srot.php?id='.$id.'&action=sure');
$dlg->output();
konec();

?>