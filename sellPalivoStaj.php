<?php

include 'library.php';
is_logged();

$id = max($_GET['id'], $_POST['id']);

$dlg = new cDialog('Prodej paliva', 'alert', 'width: 350px, height: 170');

$result = $Sql->q('SELECT * FROM stajovnici WHERE login = '.UID.' AND stav = 3');
if(p($result) == 0) {
	$dlg->obody('Nejsi stájový obchodník');
	konec();
}

$st = fa($result);
$staj = fa($Sql->q('SELECT * FROM staje WHERE id = '.$st['staj']));

$result = $Sql->q('SELECT * FROM paliva_sklad WHERE staj = 1 AND login = '.$staj['id'].' AND palivo = '.$id);
if(p($result) == 0) {
	$dlg->obody('Toto palivo na stájovém skladu nemáš');
	konec();
}

if(!$dlg->is_empty()) {
	$dlg->button('OK','close');
	$dlg->output();
	konec();
}

if($_POST['action'] == 'sure') {
	$kolik = $_POST['kolik'];
	
	// KONSTANTA - PRIRAZKA, KTEROU MA STAJ PRI NAKUPU PALIVA! 
	
	if(!eregi('^[0-9]+$',$kolik) || $kolik < 1) {
		$dlg->obody('Objem prodávaného paliva musí být v celých číslech a musí to být nejméně litr');
		konec();
	}
	
	if($kolik <= 0) {
		$dlg->obody('Nezadal jsi kladné číslo');
		konec();
	}
	
	$result = $Sql->q('SELECT * FROM stajovnici WHERE login = '.UID.' AND stav = 3'); //
	if(p($result) == 0) {
		$dlg->obody('Nejsi stájový obchodník');
		konec();
	}
	
	$st = fa($result);
	
	$result = $Sql->q('SELECT * FROM paliva_sklad WHERE staj = 1 AND login = '.$st['staj'].' AND palivo = '.$id);
	$sklad = fa($result);
	$mas = $sklad['mnozstvi'];
	
	if($mas < $kolik) {
		$dlg->obody('Tolik paliva nemáš');
		konec();
	}

	if(!$dlg->is_empty()) {
		$dlg->button('OK','alert','sellPalivoStaj.php?id='.$id);
		$dlg->output();
		konec();
	}
	
	$palivo = getPalivoAll($id);	
	
	if($dlg->is_empty()) $dlg->title('Prodej paliva - '.$palivo['nazev']);
	
	// zjistime cenu daneho paliva snizenou o prirazku
	$cena = $kolik*$palivo['cena']*PRIRAZKA;
	
	// vyprazdnime sklad a pricteme penize
	$Sql->q('UPDATE paliva_sklad set mnozstvi = '.($mas-$kolik).' WHERE login = '.$st['staj'].' AND staj = 1 AND palivo = '.$id);
	$Sql->q('UPDATE staje set kasa = kasa+'.$cena.' WHERE id = '.$st['staj']);

	$dlg->body('Palivo prodáno');
	$dlg->button('OK','refresh');
	$dlg->output();
	konec();
}

$row = fa($result);
$palivo = getPalivoAll($id);

if($dlg->is_empty()) $dlg->title('Prodej paliva - '.$palivo['nazev']);

$page = new cPage('palivo');

$jednotky = getJednotky();
$jed = $jednotky[$id];

$fill['nazev'] = $palivo['nazev'];
$fill['mnozstvi'] = numF(floor($row['mnozstvi']));
$fill['jednotka'] = $jed;
$fill['id'] = $id;

$dlg->body($page->ext('SELLPALIVOSTAJ',1,'Obchod',$fill));
$dlg->button('Zrušit','close');
$dlg->button('Prodat','jHadr_submit','form_palivos');

$dlg->output();
?>