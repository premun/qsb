<?php

include 'library.php';
is_logged();

$id = max($_GET['id'], $_POST['id']);

$dlg = new cDialog('Prodej paliva', 'alert', 'width: 350px, height: 170');

$result = $Sql->q('SELECT * from paliva_sklad WHERE staj = 0 AND palivo = '.$id.' AND login = '.UID);
if(p($result) == 0) {
	$dlg->obody('Toto palivo na skladu nemáš');
	konec();
}
$row = fa($result);
$palivo = getPalivoAll($id);

if($dlg->is_empty()) $dlg->title('Prodej paliva - '.strtolower($palivo['nazev']));

if($row['mnozstvi'] < 1) {
	$dlg->obody('Toto palivo na skladu nemáš');
	konec();
}

if(!$dlg->is_empty()) {
	$dlg->button('OK','close');
	$dlg->output();
	konec();
}

if($_POST['action'] == 'sure') {
	$kolik = $_POST['kolik'];
	
	if(!eregi('^[0-9]+$',$kolik) || $kolik < 1) {
		$dlg->obody('Objem prodávaného paliva musí být v celých číslech a musí to být nejméně litr');
		konec();
	}
	
	$result = $Sql->q('SELECT * from paliva_sklad WHERE staj = 0 AND login = '.UID.' AND palivo = '.$id);
	$sklad = fa($result);
	
	if($sklad['mnozstvi'] < $kolik) {
		$dlg->obody('Tolik paliva nemáš');
		konec();
	}

	if(!$dlg->is_empty()) {
		$dlg->button('OK','alert','sellPalivo.php?id='.$id);
		$dlg->output();
		konec();
	}
	
	$palivo = getPalivoAll($id);
	
	$Sql->q('UPDATE postavy set penize = penize+'.($kolik*$palivo['cena']*0.95).' WHERE login = '.UID);
	
	finance(UID,($kolik*$palivo['cena']*0.95),1,12);
	
	if(($sklad['mnozstvi']-$kolik) < 1) {
		$Sql->q('DELETE FROM paliva_sklad WHERE staj = 0 AND login = '.UID.' AND palivo = '.$id);
	} else {
		$Sql->q('UPDATE paliva_sklad set mnozstvi = '.($sklad['mnozstvi']-$kolik).' WHERE staj = 0 AND login = '.UID.' AND palivo = '.$id);
	}
	
	$dlg->body('Palivo prodáno');
	$dlg->button('OK','refresh');
	$dlg->output();
	konec();
}

$page = new cPage('palivo');

$jednotky = getJednotky();
$jed = $jednotky[$id];

$fill['nazev'] = $palivo['nazev'];
$fill['mnozstvi'] = floor($row['mnozstvi']);
$fill['jednotka'] = $jed;
$fill['id'] = $id;

$dlg->body($page->ext('SELLPALIVO',1,'Obchod',$fill));
$dlg->button('Zrušit','close');
$dlg->button('Prodat','jHadr_submit','form_palivo');

$dlg->output();
?>