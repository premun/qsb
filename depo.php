<?php

include 'library.php';
is_logged();
do_header('Depo');

$id = $_GET['id'];
if($id == "" || !is_numeric($id) || $id < 0) $id = UID;

$kluzak = new cKluzak($id);

$hlasky = $kluzak->getHlasky();
if(count($hlasky) > 0) {
	$hlasky = '';
	foreach($kluzak->getHlasky() as $hl) {
	  $hlasky .= $hl.'<br />';
	}
}

$page = new cPage('depo');

if(UID == $id) {
	$page->misc('NADPIS1','NADPIS');
} else {
	$page->misc('NADPIS2','NADPIS');
	$page->fill(array('login' => getNick($id), 'id' => $id));
}

$kluzak_typy[1] = 'Sport';
$kluzak_typy[2] = 'Combi';
$kluzak_typy[3] = 'Wrecker';

$values[-1]['title'] = 'Typ kluzáku:';
$values[-1]['value'] = (isset($kluzak_typy[$kluzak->podvozek['typ']]) ? $kluzak_typy[$kluzak->podvozek['typ']] : (isset($kluzak_typy[$kluzak->deska['podvozek']]) ? $kluzak_typy[$kluzak->deska['podvozek']] : 'Neurčen'));

$values[0]['title'] = 'Maximální rychlost:';
$values[0]['value'] = $kluzak->rychlost.' km/h';

if(isset($kluzak->motor['rychlost'])) {
	$values[1]['title'] = '<acronym title="Rychlost kluzáku/motoru udává, kolik motor může jet za daných okolností. Tzn. že pokud má motor max. rychlost 245 km/h a je poničený, tak se s ním dá jet např. jen 180 km/h. Na max. rychlosti kluzáku se také podepisuje váha">Rychlost kluzáku/motoru:</acronym> ';
	$values[1]['value'] = drawBar($kluzak->rychlost*100/$kluzak->motor['rychlost']);
}

$values[2]['title'] = 'Váha/Nosnost:';
$values[2]['value'] = $kluzak->vaha.'/'.$kluzak->podvozek['nosnost'].' kg';
$values[3]['title'] = 'Chlazení:';
$values[3]['value'] = $kluzak->chlazeni.'/'.$kluzak->chladic['vykon'].' kW';
$values[4]['title'] = 'Spotřeba energie:';
$values[4]['value'] = $kluzak->spotreba.'/'.$kluzak->zdroj['vykon'].' kW';
$values[5]['title'] = 'Ovladatelnost:';
$values[5]['value'] = drawBar($kluzak->ovladatelnost);
$values[6]['title'] = 'Odolnost:';
$values[6]['value'] = drawBar($kluzak->odolnost);
$values[7]['title'] = 'Zrychlení:';
$values[7]['value'] = drawBar($kluzak->zrychleni);
$values[8]['title'] = 'Cena kluzáku:';
$values[8]['value'] = numF($kluzak->cena).' Is';

if($hlasky != '') {
	$values[9]['title'] = 'Varování:';
	$values[9]['value'] = $hlasky;
}

$page->getTable('INFO',$values,'INFO');

if($id != UID) {
	$result = $Sql->q('SELECT staj FROM stajovnici WHERE (login = '.UID.' OR login = '.$id.')');

	if(p($result) == 2) {
		$hrac1 = fa($result);
		$hrac2 = fa($result);
		if($hrac1['staj'] != $hrac2['staj']) {
			$page->swap('CASTI','Komponenty kluzáků ostatních hráčů nejsou viditelné');
			$page->finish();	
			do_footer();
			exit;		
		}
	} else {
		$page->swap('CASTI','Komponenty kluzáků ostatních hráčů nejsou viditelné');
		$page->finish();	
		do_footer();
		exit;
	}
}

$tabs = $kluzak->tabs;

$casti[1] = $kluzak->podvozek;
$casti[2] = $kluzak->motor;
$casti[3] = $kluzak->drzaky;
$casti[4] = $kluzak->chladic;
$casti[5] = $kluzak->deska;
$casti[6] = $kluzak->brzdy;
$casti[7] = $kluzak->zdroj;
$casti[8] = $kluzak->pancerovani;
$casti[9] = $kluzak->suspenzory;
$casti[10] = $kluzak->p_motory;

$names[1] = "Podvozek";
$names[2] = "Motor";
$names[3] = "Držáky";
$names[4] = "Chladič";
$names[5] = "Palubní deska";
$names[6] = "Brzdy";
$names[7] = "Zdroje";
$names[8] = "Pancéřování";
$names[9] = "Suspenzory";
$names[10] = "Přídavné motory";

$popisky['nazev'] = "Název";
$popisky['nosnost'] = "Nosnost";
//$popisky['vydrz'] = "Výdrž";
$popisky['rychlost'] = "Rychlost";
//$popisky['zrychleni'] = "Zrychlení";
//$popisky['podvozek'] = "Podvozek";
$popisky['vydrz'] = "Opotřebení";
$popisky['vaha'] = "Váha";
$popisky['ochrana'] = "Ochrana";
$popisky['chlazeni'] = "Potřebné&nbsp;chlazení";
$popisky['zdroj'] = "Potřebné&nbsp;napájení";
$popisky['vykon'] = "Výkon";
$popisky['ovladat'] = "Ovladatelnost";

$jed['nosnost'] = "kg";
$jed['rychlost'] = "km/h";
//$jed['podvozek'] = "";
$jed['vaha'] = "kg";
$jed['ochrana'] = "%";
$jed['chlazeni'] = "kW";
$jed['vykon'] = "kW";
$jed['ovladat'] = "%";
$jed['zdroj'] = "kW";

$proc['ovladat'] = 1;
$proc['ochrana'] = 1;

for($i=1;$i<11;$i++) {
	if(is_array($casti[$i])) {
		$row = array();
		$row['nazev'] = $names[$i];
		$row['typ'] = $i;

		foreach($casti[$i] as $ind=>$val) {
			if(isset($popisky[$ind])) {
				
				$jednotka = $val.' '.$jed[$ind];
				
				if($proc[$ind] == 1) $jednotka = drawBar($val);
				if($ind == "vydrz") $jednotka = drawBar($val/$casti[$i]['max_vydrz']*100);
				if($ind == "zrychleni") $jednotka = drawBar($val);
				
				$row['info'] .= '
				<tr class="nobg">
				<td class="nobg">'.$popisky[$ind].': </td>
				<td>'.$jednotka.'</td>
				</tr>';  
			}  
		}
		$row['info'] .= '   	<tr class="nobg">
        <td class="val"><a href="showItem.php?id='.$casti[$i]['id'].'&amp;typ='.$i.'"><strong>Detailní info</strong></a></td>
        <td></td>
		</tr>';
		$data[] = $row;
	}
}

$page->getTable('CASTI',$data,'CASTI');

$page->swap('CASTI','');

$page->finish();

do_footer();
?>