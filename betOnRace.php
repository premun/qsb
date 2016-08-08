<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

do_header('Sázky');

$dlg = new cDialog('Sázení na závod','alert','height: auto, width: 477px');

$page = new cPage('sazky');

$result = $Sql->q('SELECT nazev, pocet, typ FROM zavody WHERE id = '.$id.' AND vitez = 0');
if(p($result) == 0) {
	$dlg->obody($page->ext('ODJET'));
}

$zavod = fa($result);

$dlg->title($page->ext('COMMON_BETONRACE',0,0,$zavod));

$result2 = $Sql->q('SELECT id FROM sazky WHERE login = '.UID.' AND zavod = '.$id);
if(p($result2) > 0) {
	$dlg->obody($page->ext('VICKRAT'));
}

$result2 = $Sql->q('SELECT * FROM zavodnici WHERE login = '.UID.' AND zavod = '.$id);
if(p($result2) > 0) {
	$dlg->obody($page->ext('JEDES'));
}

$res = $Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$id.' ORDER BY id ASC');
$pocet = p($res);
$zavodnici = Array();
for($i=0;$i<$pocet;$i++) {
	$row4 = fa($res);
	$zavodnici[] = $row4['login'];
}

$fill['nazev'] = $zavod['nazev'];

if(count($zavodnici) == 0) {
	$dlg->obody($page->ext('ZAVODNICI'));
}

$fill['id'] = $id;

foreach($zavodnici as $zavodnik) {
	$fill['zavodnici'] .= '<option value="'.$zavodnik.'">'.getNick($zavodnik).'</option>';
}

if($zavod['typ'] == 2) $zavod['pocet'] = 20;

for($i=0;$i<$zavod['pocet'];$i++) {
	$fill['mista'] .= '<option value="'.($i+1).'"> bude '.($i+1).'. </option>';
}

if($dlg->is_empty()) {
	$dlg->obody($page->ext('BETONRACE',0,0,$fill));
	$dlg->button('Zrušit','close');
	$dlg->button('Vsadit na závod','jHadr_submit','form_vsadit');
} else {
	$dlg->set('width','300px');
	$dlg->button('OK','close');
}

$dlg->output();

do_footer();
?>