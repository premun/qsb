<?php

include 'library.php';
is_logged();
do_header('Sázky');

$minimum = $_GET['minimum'];

$page = new cPage('sazky');

$result =  $Sql->q('SELECT z.id as id, z.nazev as nazev, z.dotace as dotace, z.pocet as pocet, z.minimum as minimum, COUNT(za.id) as pocet2, z.typ as typ
					FROM zavody as z 
					LEFT JOIN zavodnici as za ON za.zavod = z.id 
					WHERE z.vitez = 0 GROUP BY za.zavod ORDER BY z.datum ASC, z.cas ASC');
					
if(p($result) == 0) {
	$mozne = '&nbsp;&nbsp;&nbsp;&nbsp;Žádné závody';
} else {

	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
	
		$pocet2 = fa($Sql->q('SELECT COUNT(id) as botu FROM zavodnici WHERE login < 0 AND zavod = '.$row['id']));
	
		$row['pocet2'] -= $pocet2['botu'];
	
		if(($minimum == 'off' && ($row['pocet2'] || $pocet2['botu'])) || ($minimum == '' && ($row['pocet2'] || $pocet2['botu'])) || ($minimum == 'on' && (($row['pocet2']+$pocet2['botu']/2) >= $row['minimum']))) {
			$row2['id'] = $row['id'];
			$row2['nazev'] = $row['nazev'];
			$row2['hracu'] = $row['pocet2']+$pocet2['botu'];
			$row2['max'] = $row['pocet'];
			if($row['typ'] == 2) $row2['max'] = '?';
			$row2['dotace'] = str_replace(' ','&nbsp;',numF($row['dotace']));
			$data[] = $row2;
		}
	}
	$mozne = $page->getTable('MOZNE',$data);
	if(!isset($data[0]['id'])) $mozne = '&nbsp;&nbsp;&nbsp;&nbsp;Žádné závody';
}

$page->swap('CHECKED',($minimum == 'on' ? 'checked="checked" ' : ''));
$page->swap('MOZNE',$mozne);

#######

$result = $Sql->q('SELECT s.id as ids, z.id as idz, z.vitez as vitez, s.vyhra as vyhra, s.misto as misto, h.login as jmeno, s.zavodnik as uid, s.zavodnik as zavodnik, s.sazka as sazka, s.penize as penize, z.nazev as nazev FROM sazky as s LEFT JOIN zavody as z ON z.id = s.zavod LEFT JOIN hraci as h ON h.id = s.zavodnik WHERE s.login = '.UID.' ORDER BY s.id DESC');

if(!p($result)) {
	$sazky = '&nbsp;&nbsp;&nbsp;&nbsp;Žádné sázky';
} else {

	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$row2 = array();
		
		if($row['misto'] > -1) {
			$row2['jmeno'] = '<a href="showProfile.php?id='.$row['zavodnik'].'">'.str_replace(' ','&nbsp;',$row['jmeno']).'</a>';
			$row2['misto'] = $row['misto'].'.';
		}
		
		if($row['misto'] == 0) {
			$row2['misto'] = '<span class="extra">N</span>';
			$row2['jmeno'] = '<a href="showProfile.php?id='.$row['zavodnik'].'">'.$row['jmeno'].'</a>';
		}
		
		if($row['misto'] == -1) {
			$row2['misto'] = '';
			$row2['jmeno'] = 'Nikdo nedojede';
		}
		
		if($row['vitez'] == 0) {
			$row2['barva'] = "#CCCCCC";
		} else {
			if($row['vyhra'] == 1) {
				$row2['barva'] = "#46CC2F";
			} else {
				$row2['barva'] = "#DD361E";
			}
		}
		
		if($row['uid'] < 0) $row2['jmeno'] = getNick($row['uid']);
		
		$row2['sazka'] = str_replace(' ','&nbsp;',numF($row['sazka']));
		$row2['penize'] = str_replace(' ','&nbsp;',numF($row['penize']));
		$row2['nazev'] = $row['nazev'];
		$row2['idz'] = $row['idz'];
		$row2['ids'] = $row['ids'];
	
		$data2[] = $row2;
	
	}
	
	$sazky = $page->getTable('SAZKY',$data2);

}

$page->swap('SAZKY',$sazky);

$page->finish();

do_footer();
?>
