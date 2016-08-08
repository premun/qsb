<?php

include 'library.php';
is_logged();
do_header('Předměty');
$id = $_GET['id'];
$typ = $_GET['typ'];

$page = new cPage('item');

if($id == '' || !ereg('^[0-9]+$',$id) || $typ == '' || !ereg('^[0-9]+$',$typ)) {
	$page->ext('EXIST',1);
	exit;
}

$p = new cItem($id,$typ);

if($p->id == 'not_found') {
	$page->ext('EXIST',1);
	exit;
}

$pod[0] = "Všechny";
$pod[1] = "Sport";
$pod[2] = "Combi";
$pod[3] = "Wrecker";

$chlad[1] = "Vodní";
$chlad[2] = "Vdušné";
$chlad[3] = "Dusíkové";
$chlad[4] = "Pohlcovače tepla";

$fill['nazev'] = $p->nazev;
$fill['typ'] = $typ;
$fill['kategorie'] = $p->kat;
 
if($typ == 1) {
	$row['ent'] = 'Typ:';
	$row['val'] = $pod[$p->typ];
	$data[] = $row;
	$row['ent'] = 'Nosnost:';
	$row['val'] = $p->nosnost.' kg';
	$data[] = $row;
}

if(isset($p->rychlost)) {
	$row['ent'] = 'Maximální&nbsp;rychlost:&nbsp;&nbsp;&nbsp;';
	$row['val'] = $p->rychlost.' km/h';
	$data[] = $row;
}

if(isset($p->vykon)) {
	$row['ent'] = 'Výkon:';
	$row['val'] = $p->vykon.' kW';
	$data[] = $row;
}

if(isset($p->typ) && $typ == 2) {
	$moturek = fa($Sql->q('SELECT nazev FROM motory_typy WHERE id = '.$p->typ));
	$row['ent'] = 'Typ motoru:';
	$row['val'] = $moturek['nazev'];
	$data[] = $row;
}

if(isset($p->ovladat)) {
	$row['ent'] = 'Ovladatelnost:';
	$row['val'] = drawBar($p->ovladat);
	$data[] = $row;
}

if(isset($p->zrychleni) && ($typ == 1 || $typ == 2 || $typ == 10)) { 
	$row['ent'] = 'Zrychlení:';
	$row['val'] = drawBar($p->zrychleni);
	$data[] = $row;
}

if(isset($p->ochrana)) { 
	$row['ent'] = 'Ochrana:';
	$row['val'] = drawBar($p->ochrana);
	$data[] = $row;
}

if(isset($p->vaha) && $typ != 9) {
	$row['ent'] = 'Váha:';
	$row['val'] = $p->vaha.' kg';
	$data[] = $row;
}

if(isset($p->vaha) && $typ == 9) {
	$row['ent'] = 'Nadlehčení:';
	$row['val'] = $p->vaha.' kg';
	$data[] = $row;
}

if(isset($p->chlazeni)) {
	$row['ent'] = 'Potřebné&nbsp;chlazení:&nbsp;&nbsp;&nbsp;';
	$row['val'] = $p->chlazeni.' kW';
	$data[] = $row;
}

if(isset($p->zdroj)) {
	$row['ent'] = 'Potřebné&nbsp;napájení:&nbsp;&nbsp;&nbsp;';
	$row['val'] = $p->zdroj.' kW';
	$data[] = $row;
}

if($typ == 2) {
	$palivo = fa($Sql->q('SELECT nazev FROM paliva_ceny WHERE id = '.$p->palivo));

	$row['ent'] = 'Palivo:';
	$row['val'] = '<a href="buyPalivo.php?id='.$p->palivo.'">'.$palivo['nazev'].'</a>';
	$data[] = $row;
	$row['ent'] = 'Spotřeba:';
	$row['val'] = $p->spotreba.' l/úsek';
	$data[] = $row;
}

if($typ == 4) {
	$row['ent'] = 'Typ:';
	$row['val'] = $chlad[$p->typ];
	$data[] = $row;
}

if(isset($p->urychleni)) {
	$row['ent'] = ($p->urychleni >= 0 ? 'Urychlení&nbsp;opravy:' : '<span class="error">Zpomalení&nbsp;opravy:</span>');
	$row['val'] = drawBar(abs($p->urychleni));
	$data[] = $row;
}

if(isset($p->sleva)) {
	$row['ent'] = ($p->sleva >= 0 ? 'Sleva&nbsp;opravy:' : '<span class="error">Zdražení&nbsp;opravy:</span>');
	$row['val'] = drawBar(abs($p->sleva));
	$data[] = $row;
}

if(isset($p->vydrz)) {
	$row['ent'] = 'Výdrž:';
	$row['val'] = drawBar($p->vydrz/10);
	$data[] = $row;
}

if($typ != 1 && $typ != 11) {
	$row['ent'] = 'Pro podvozek:';
	$row['val'] = $pod[$p->podvozek];
	$data[] = $row;
}

$page->getTable('DETAILY',$data,'DETAILY');
$page->fill($fill); 

$hrac_m = getPenize(UID);

$result = $Sql->q('SELECT id, login, cena2 as cena, vydrz from sklad WHERE umisteni = 2 AND typ = '.$typ.' AND zbozi = '.$id.' AND login != '.UID);
if(p($result) > 0) {
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$cena = $row['cena'];

		$row2['login'] = $row['login'];
		$row2['loginn'] = getNick($row['login']);
		$row2['vydrz'] = drawBarMini(($row['vydrz']/$p->vydrz)*100);
		$row2['cena'] = numF($cena);
		$row2['koupit'] = ($cena <= $hrac_m ? '<a class="submit" onclick="jHadr(\'buyItem.php?id='.$row['id'].'\', {})">Koupit</a>' : '<span class="ultra">Koupit</span>');
		$data2[] = $row2;
	}

	$hraci = $page->getTable('HRACI',$data2);
} 

$page->swap('HRACI',$hraci);

$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
$etapa = $result['val'];
$result = fa($Sql->q('SELECT etapa FROM zbozi WHERE typ = '.$typ.' AND zbozi = '.$id));
$zbozi_etapa = $result['etapa'];

if($etapa-1 < $zbozi_etapa) {
	$page->misc('ETAPA','OBCHODNICI','ETAPA');
	$page->swap('ETAPA_DATUM',etapa($zbozi_etapa+1));
} else {
	
	$result = $Sql->q('SELECT z.id as id, o.nazev as name, z.cena as cena, z.obchodnik as obchodnik, o.rasa as rasa FROM zbozi as z LEFT JOIN obchodnici as o ON o.id = z.obchodnik WHERE z.typ = '.$typ.' AND z.zbozi = '.$id.' AND z.kusy > 0');
	if(p($result) > 0) {
		$rasa = getRasa(UID);
	
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			$cena = getCost($row['cena'],$rasa,$row['obchodnik']);
			$obch_name = explode(' - ',$row['name']);
			
			$row3['obchodnik_id'] = $row['obchodnik'];
			$row3['obchodnik_nazev'] = $obch_name[0];
			$row3['rasa'] = getRasaNazev($row['rasa']);
			$row3['cena'] = str_replace(' ','&nbsp;',numF($cena));
			$row3['koupit'] = ($cena <= $hrac_m ? '<a class="submit" onclick="jHadr(\'buy.php?id='.$row['id'].'\', {})">Koupit</a>' : '<span class="ultra">Koupit</span>');
			$data3[] = $row3;
		}
		$obchodnici = $page->getTable('OBCHODNICI',$data3);
	}
	  
	$page->swap('OBCHODNICI',$obchodnici);
}

$page->finish();

do_footer();
?>