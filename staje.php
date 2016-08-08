<?php

include 'library.php';
is_logged();
do_header('Stáje');

$page = new cPage('staje');

$fill['pohar_nazev'] = POHAR_NAZEV;

$result = $Sql->q('SELECT * from stajovnici WHERE login = '.UID);
if(!p($result)) {

	$page->misc('ZADNA_STAJ','OBSAH');
	
	$res = $Sql->q('SELECT * from smlouvy WHERE login = '.UID);
	if(p($res) > 0) {
		
		for($i=0;$i<p($res);$i++) {
			$staj2 = fa($res);
			$staj1 = fa($Sql->q('SELECT * from staje WHERE id = '.$staj2['staj']));
			$line['id'] = $staj2['id'];
			$line['nazev'] = $staj1['nazev'];
			$line['login'] = getNick($staj1['login']);
	
			$data[] = $line;
		}
		
		$page->getTable('NABIDKY',$data,'NABIDKY');
		
	} else {
		$page->misc('ZADNE_NABIDKY','NABIDKY');
	}

	$fill['cena_staje'] = numF(CENA_STAJE);
	$fill['kasa'] = numF(STAJ_KASA);

	$page->fill($fill);
	$page->finish();

	do_footer();
	exit;
}


$row = fa($result);
$result = $Sql->q('SELECT * from staje WHERE id = '.$row['staj']);
$staj = fa($result);

$fill['id'] = $staj['id'];
$fill['nazev'] = $staj['nazev'];
$fill['kasa'] = numF($staj['kasa']);

$page->misc('MENU','OBSAH');

$none = ' style="display:none"';

$page->swap((p($Sql->q('SELECT login FROM stajovnici WHERE login = '.UID.' AND staj = '.$staj['id'].' AND (stav = 1 OR stav = 3)')) > 0) ? '' : $none,'FINANCE');		# MENU
$page->swap(p($Sql->q('SELECT budova FROM budovy WHERE (budova = 3 OR budova = 7) AND staveni = 0 AND staj = '.$staj['id'])) ? '' : $none,'SKLADY');
$page->swap((p($Sql->q('SELECT id FROM staje WHERE login = '.UID.' AND id = '.$staj['id'])) > 0) ? '' : $none,'POHAR');

if($_GET['action'] == "") {
	$page->misc('DEFAULT','OBSAH');

	$fce = "člen";
	if($staj['login'] == UID) {
		$fce = "vlastník";
		$page->misc('ZRUSIT','AKCE');
		$result2 = $Sql->q('SELECT login FROM stajovnici WHERE login != '.UID.' AND staj = '.$staj['id']);
		if(p($result2)) {
			$page->misc('PREDAT','PREDAT');
			$data = array();
			for($i=0;$i<p($result2);$i++) {
				$hrac = fa($result2);
				$data[] = array('id' => $hrac['login'], 'nick' => getNick($hrac['login']));
			}
			$page->getTable('KOMU',$data,'LIDI');
		}
	} else {
		$page->misc('ODSTOUPIT','AKCE');
	}	
	
	$row = fa($Sql->q('SELECT obsah FROM nastenka WHERE sekce = 2 AND login = '.$staj['id']));
	
	$page->swap('NASTENKA',stripslashes($row['obsah']));
	$page->swap('PREDAT','');
	$fill['funkce'] = $fce;	
}

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

if($_GET['action'] == "budovy") {

	$page->misc('BUDOVY','OBSAH');

	if($staj['login'] == UID) {
		$status = 42;
	} else {
		$status = 0;
	}
	
	$res3 = $Sql->q('SELECT * from budovy WHERE staj = '.$row['staj']);
	$obsazeno = 0;
	for($i=0;$i<p($res3);$i++) {
		$bud = fa($res3);
		$res4 = fa($Sql->q('SELECT * FROM budovy_typy WHERE id = '.$bud['budova']));
		$obsazeno += $res4['misto'];
		if($bud['staveni'] == 0) {
			$seznam[$bud['id']] = $bud['budova'];
		}
	}
	
	$fill['obsazeno'] = $obsazeno;
	$fill['pozemek'] = $staj['pozemek'];
	$fill['ubikace'] = (p($Sql->q('SELECT * from budovy WHERE budova = 2 AND staj = '.$staj['id'].' AND staveni = 0'))-(p($Sql->q('SELECT * from stajovnici WHERE staj = '.$staj['id']))-1));
	$result = $Sql->q('SELECT * from budovy_typy');
	
	$data = array();	
	for($i=0;$i<p($result);$i++) {
		$budova = fa($result);
		$nazvy[$budova['id']] = $budova['nazev'];
		if($budova['penize'] < 0) {
			$barva = "#FF0000";
		} elseif($budova['penize'] > 0) {
			$barva = "#02FD09";
		} elseif($budova['penize'] === 0) {
			$barva = "#FFFFFF";
		}
	
		$pocet = p($Sql->q('SELECT * from budovy WHERE budova = '.$budova['id'].' AND staj = '.$row['staj'].' AND staveni = 0'));
		
		if(p($Sql->q('SELECT * from budovy WHERE budova = '.$budova['id'].' AND staj = '.$row['staj'].' AND staveni > 0')) > 0) {
			$pocet2 = '&nbsp;<span class="ultra">+'.p($Sql->q('SELECT * from budovy WHERE budova = '.$budova['id'].' AND staj = '.$row['staj'].' AND staveni > 0')).'</span>';
		} else {
			$pocet2 = '';
		}
	
		$barva2 = "#FFFFFF";
		if($pocet > 0) $barva2 = "#FFCC00";
		
		$vydelek += $pocet*$budova['penize'];
	
		$barva3 = ($i > 0 && $budova['cena'] <= $staj['kasa'] && ($obsazeno+$budova['misto']) <= $staj['pozemek'] ? '' : ' style="color: #969696"');
		
		$line['koupit'] = ($i > 0 && $budova['cena'] <= $staj['kasa'] && ($obsazeno+$budova['misto']) <= $staj['pozemek'] && $status == 42 ? '<input type="radio" name="budova" value="'.$budova['id'].'" />' : '');
		$line['black'] = ($i > 0 && $budova['cena'] <= $staj['kasa'] && ($obsazeno+$budova['misto']) <= $staj['pozemek'] && $status == 42 ? '' : ' style="background-color: #000000"');
		$line['barva'] = $barva;
		$line['barva2'] = $barva2;
		$line['barva3'] = $barva3;
		$line['nazev'] = $budova['nazev'];
		$line['cena'] = $budova['cena'];
		$line['misto'] = $budova['misto'];
		$line['penize'] = $budova['penize'];
		$line['staveni'] = $budova['staveni'];
		$line['prestiz'] = $budova['prestiz'];
		$line['pocet'] = $pocet;
		$line['pocet2'] = $pocet2;
		
		$data[] = $line;
	}
	
	$page->getTable('BUDOVY',$data,'BUDOVY');
	
	if($vydelek > 0) {
		$vydelek += $vydelek/100*(p($Sql->q('SELECT budova FROM budovy WHERE budova = 8 AND staj = '.$row['staj'].' AND staveni = 0'))*10);
	}
	
	$fill['vydelek'] = numF($vydelek);
	$fill['parcely'] = $none;
	$fill['zbourat'] = '';
	$fill['zbourani'] = ZBOURANI;

	if($status == 42) {
		$fill['parcely'] = '';
				
		if(count($seznam) > 1) {
			$data = array();		
			foreach($seznam as $id2=>$bud) {
				if($bud != 1) {
					$data[] = array('value' => $id2, 'nazev' => $nazvy[$bud]);
				}
			} 
			$page->getTable('BOURANI',$data,'ZBOURAT');
		}
	
		$parcela = PARCELA+(($staj['pozemek']-5)*NEW_PARCELA);
		
		$fill['parcela_cena'] = numF($parcela);
		
		if($staj['kasa'] >= $parcela) {
			$page->misc('PARCELA1','PARCELA');
		} else {
			$page->misc('PARCELA2','PARCELA');
		}
	}
	$page->misc('BLABLA','PARCELA');
}

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

if($_GET['action'] == "clenove") {
	$page->misc('CLENOVE','OBSAH');
	
	$result = $Sql->q('SELECT * from staje_stavy');
	for($i=0;$i<p($result);$i++) {
		$stav = fa($result);
		$stavy[$stav['id']] = $stav['stav'];
	}
	
	//$result = $Sql->q('SELECT login,stav,penize, DATE_FORMAT(datum, "%d.%m.") datum from stajovnici WHERE staj = '.$staj['id'].' ORDER BY stav ASC');
	$result = $Sql->q('SELECT login,staj,stav,penize,pomer, DATE_FORMAT(datum, "%Y-%m-%d") datum FROM stajovnici WHERE staj = '.$staj['id'].' ORDER BY stav ASC');
	$mzda = 0;
	
	if($staj['login'] != UID) {
		$data = array();
		
		for($i=0;$i<p($result);$i++) {
			$hrac = fa($result);
			
			$line['id'] = $hrac['login'];
			$line['login'] = getNick($hrac['login']);
			$line['stav'] = $stavy[$hrac['stav']];
			$line['pomer'] = $hrac['pomer'];
			$line['penize'] = numF($hrac['penize']);
			
			$data[] = $line;
			
			$mzda += $hrac['penize'];
		}	
		$page->getTable('CLENOVE1',$data,'SEZNAM');
		
	} else {
		$data = array();
		for($i=0;$i<p($result);$i++) {
			$hrac = fa($result);
		
			$casti = explode('-',$hrac['datum']);
			
			$mon = $casti[1];
			if(substr($mon,0,1) == "0") {
				$mon = substr($mon,1);
			}  
			$day = $casti[2];
			if(substr($day,0,1) == "0") {
				$day = substr($day,1);
			}
	
			$last = mktime(0,0,0,$mon,$day,$casti[0]);
			$today = mktime(0,0,0,date("n"),date("j"),date("Y"));
	
			$line['id'] = $hrac['login'];
			$line['login'] = getNick($hrac['login']);
			$line['stav'] = $stavy[$hrac['stav']];
			$line['pomer'] = $hrac['pomer'];
			$line['penize'] = numF($hrac['penize']);
	
			if($hrac['stav'] != 1) {
				if(lastChange($hrac['datum'])) {
					$line['zmena'] = '<td style="text-align: right; padding-right: 6px;"><a class="submit" onclick="jHadr(\'staj_process.php?action=vyhodit&id='.$hrac['login'].'&staj='.$staj['id'].'\', {})">Vyhodit</a></td>
					<td style="text-align: right; padding-right: 6px;"><a class="submit" onclick="jHadr(\'staj_process.php?action=smlouva\', {id: \''.$hrac['login'].'\', staj: \''.$staj['id'].'\'})">Změnit smlouvu</a></td>';
				} else {
					$line['zmena'] = '<td style="text-align: right; padding-right: 6px;" colspan="2">Naposled změněno '.date("d.m. Y",$last).'</td>';	
				}
			} else {
				$line['zmena'] = '<td style="text-align: right; padding-right: 6px;" colspan="2"><span class="ultra">Hráč je vlastník</span></td>';
			}
			$data[] = $line;
			
			$mzda += $hrac['penize'];
		}
		
		$page->getTable('CLENOVE2',$data,'SEZNAM');
	}
		
	$fill['mzdy'] = numF($mzda);
		
	$res3 = $Sql->q('SELECT * FROM smlouvy WHERE staj = '.$staj['id']);

	if(!p($res3)) {
		$page->misc('ZADNE_SMLOUVY','SMLOUVY');
	} else {		
		$data = array();
		for($i=0;$i<p($res3);$i++) {
			$hrac = fa($res3);
			
			$line['id'] = $hrac['login'];
			$line['login'] = getNick($hrac['login']);
			$line['stav'] = $stavy[$hrac['stav']];
			$line['pomer'] = $hrac['pomer'];
			$line['penize'] = numF($hrac['penize']);
					
			if($staj['login'] == UID) {
				$line['zrusit'] = '<a href="staj_process.php?action=zrusitNabidku&id='.$hrac['id'].'&staj='.$staj['id'].'">Zrušit nabídku</a>';
			} else {
				$line['zrusit'] = '<span class="ultra">Zrušit nabídku</span>';
			}
			$data[] = $line;
		}
		$page->getTable('NABIDKY2',$data,'SMLOUVY');
	}
			
	$page->misc(($staj['login'] == UID ? 'PRIJMOUT' : 'BLABLA'),'PRIJMOUT');
}


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


if($_GET['action'] == "detaily") {
	$page->misc('DETAILY','OBSAH');

	$id = $staj['id'];
	$result = $Sql->q('SELECT * from staje_stavy');
	for($i=0;$i<p($result);$i++) {
		$stavy = fa($result);
		$stav[$stavy['id']] = $stavy['stav'];
	}
	
	$result = $Sql->q('SELECT * from budovy_typy');
	for($i=0;$i<p($result);$i++) {
		$budovy = fa($result);
		$budova[$budovy['id']] = $budovy['nazev'];
		$staveni[$budovy['id']] = $budovy['staveni'];
		$misto[$budovy['id']] = $budovy['misto'];
	}
	
	$result = $Sql->q('SELECT * from staje WHERE id = '.$id);
	
	$row = fa($result);
	
	$b = explode(',',$row['vlajka']);
	
	$res = $Sql->q('SELECT login, stav FROM stajovnici WHERE staj = '.$id);
	for($i=0;$i<p($res);$i++) {
		$row2 = fa($res);
		$hraci[] = array('login' => $row2['login'], 'nick' => getNick($row2['login']), 'stav' => $stav[$row2['stav']]);
	}
	  
	$res3 = $Sql->q('SELECT * FROM budovy WHERE staj = '.$id);
	$obsazeno = 0;
	for($i=0;$i<p($res3);$i++) {
		$bud = fa($res3);
		$obsazeno += $misto[$bud['budova']];
	}

	$row['popis'] = str_replace('[B]','<strong>',$row['popis']);
	$row['popis'] = str_replace('[/B]','</strong>',$row['popis']);
	$row['popis'] = str_replace('[I]','<em>',$row['popis']);
	$row['popis'] = str_replace('[/I]','</em>',$row['popis']);
	$row['popis'] = str_replace('[O]','<span class="extra">',$row['popis']);
	$row['popis'] = str_replace('[/O]','</span>',$row['popis']);
	$row['popis'] = str_replace('[S]','<span class="ultra">',$row['popis']);
	$row['popis'] = str_replace('[/S]','</span>',$row['popis']);
	$row['popis'] = str_replace('[U]','<span style="text-decoration: underline">',$row['popis']);
	$row['popis'] = str_replace('[/U]','</span>',$row['popis']);
	
	for($j=1;$j<15;$j++) {
		$row['popis'] = str_replace('[SM'.$j.']','<img src="./smiles/'.$j.'.gif" style="vertical-align: middle" alt="">',$row['popis']);
	}
	
	$fill['vlajka'] = drawFlag($b[0],$b[1],$b[2]);
	$fill['barva1'] = str_replace('#','',$b[0]);
	$fill['barva2'] = str_replace('#','',$b[1]);
	$fill['barva3'] = str_replace('#','',$b[2]);
	$fill['zkratka'] = $row['zkratka'];
	$fill['vlastnik'] = getNick($row['login']);
	$fill['prestiz'] = numF($row['prestiz']);
	$fill['hraci'] = $page->getTable('HRACI',$hraci);
	$fill['popis'] = nl2br($row['popis']);
	$fill['obsazeno'] = $obsazeno;
	$fill['pozemek'] = $row['pozemek'];
	
	$res3 = $Sql->q('SELECT * from budovy WHERE staj = '.$id);
	for($i=0;$i<p($res3);$i++) {
		$row2 = fa($res3);
		$fill['budovy'] .= $budova[$row2['budova']].($row2['staveni'] != 0 ? ' <span class="ultra">(staví se, zbývá '.($row2['staveni']).')</span>' : '').'<br />';
	}

	if($staj['login'] == UID) {
	
		$page->misc('ZMENA_DETAILU','ZMENA');
	
		$fill['popis2'] = $staj['popis'];
		$fill['vlajka'] = drawFlag2($staj['vlajka']);
		$fill['penize_vlajka'] = numF(ZMENA_VLAJKY);

		$barva = Array();
		$barva[] = "#FF04F9";
		$barva[] = "#E80000";
		$barva[] = "#FF9900";
		$barva[] = "#FFFF48";
		$barva[] = "#FFFFFF";
		$barva[] = "#27DEA3";
		$barva[] = "#57D900";
		$barva[] = "#244D20";
		$barva[] = "#1B3FBA";
		$barva[] = "#BBDBFF";
		
		$barva = Array();
		$barva[] = "#FF04F9";
		$barva[] = "#E80000";
		$barva[] = "#FF9900";
		$barva[] = "#FFFF48";
		$barva[] = "#FFFFFF";
		$barva[] = "#27DEA3";
		$barva[] = "#57D900";
		$barva[] = "#244D20";
		$barva[] = "#1B3FBA";
		$barva[] = "#BBDBFF";
		
		$data = array();	
		foreach($barva as $bar)	$data[] = array('code' => $bar, 'checked' => '');
		
		$page->getTable('VLAJKY',$data,'VLAJKY1');
			
		$num = Array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
		
		$data = array();	
		for($i=0;$i<10;$i++) {
			$auto = ("#".($num[rand(0,count($num)-1)].$num[rand(0,count($num)-1)].$num[rand(0,count($num)-1)].$num[rand(0,count($num)-1)].$num[rand(0,count($num)-1)].$num[rand(0,count($num)-1)]));
			$data[] = array('code' => $auto, 'checked' => '');
		}
		
		$page->getTable('VLAJKY',$data,'VLAJKY2');
		
		$kusy = explode(',',$staj['vlajka']);
		
		$fill['vlastni1'] = $kusy[0];
		$fill['vlastni2'] = $kusy[1];
		$fill['vlastni3'] = $kusy[2];
	
	}
	$page->misc('BLABLA','ZMENA');
}


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


if($_GET['action'] == "sklady") {
	$jednotky = array();
	$jednotky[1] = 'ks';
	$jednotky[2] = 'ks';
	$jednotky[3] = 'ks';
	$jednotky[4] = 'l';
	$jednotky[5] = 'l';
	$jednotky[6] = 'l';
	$jednotky[7] = 'l';
	$jednotky[8] = 'l';
	$jednotky[9] = 'l';
	$jednotky[10] = 'l';
	$jednotky[11] = 'l';
	$jednotky[12] = 'l';
	$jednotky[13] = 'l';
	$jednotky[14] = 'kg';
	$jednotky[15] = 'kg';
	$jednotky[16] = 'kg';
	$jednotky[17] = 'kg';
	$jednotky[18] = 'kg';
	$jednotky[19] = 'kg';
	$jednotky[20] = 'kg';
	$jednotky[21] = 'kg';
	$jednotky[22] = 'kg';
	$jednotky[23] = 'ks';
	$jednotky[24] = 'ks';
	$jednotky[25] = 'ks';
	$jednotky[26] = 'kg';
	
	$result = $Sql->q('SELECT * from budovy WHERE staj = '.$staj['id'].' AND (budova = 3 OR budova = 7) AND staveni = 0');
	if(!p($result)) {
		$page->misc('ZADNY_SKLAD','OBSAH');
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}
	
	$page->misc('SKLADY2','OBSAH');
	
	$data = array();
	for($i=0;$i<p($result);$i++) {
		$budova = fa($result);
		if($budova['budova'] == 3) {
			$nazev = "Malý sklad paliva";
			$kapacita = SKLAD_MALY;
		} else {
			$nazev = "Velký sklad paliva";
			$kapacita = SKLAD_VELKY;
		}
		$data[] = array('nazev' => $nazev, 'kapacita' => $kapacita);
		$kapacita2 += $kapacita;
	}  
	
	$fill['kapacita_celkem'] = $kapacita2;
	
	$page->getTable('SKLADY2',$data,'SKLADY2');
	
	$res = $Sql->q('SELECT * from paliva_sklad WHERE staj = 1 AND mnozstvi > 0 AND login = '.$staj['id']);
	$obsazeno = 0;
	$obchodnik = p($Sql->q('SELECT * from stajovnici WHERE stav = 3 AND login = '.UID));
	$data = array();
	for($i=0;$i<p($res);$i++) {
		$palivo2 = fa($res);
		$obsazeno += $palivo2['mnozstvi'];
		if($palivo2['zbozi'] == $id) {
			$mas = $palivo2['mnozstvi'];
		}
		$palivo = getPalivoAll($palivo2['palivo']);
		$prodat = '<span class="ultra">Prodat</span>';
		if($obchodnik > 0) $prodat = '<a class="submit" onclick="jHadr(\'sellPalivoStaj.php?id='.$palivo2['palivo'].'\', {})">Prodat</a>';
		
		$line['id'] = $palivo2['palivo'];
		$line['nazev'] = $palivo['nazev'];
		$line['mnozstvi'] = numF($palivo2['mnozstvi']);
		$line['jednotka'] = $jednotky[$palivo2['palivo']];
		$line['prodat'] = $prodat;
		
		$data[] = $line;
	}
	
	if(count($data)) $page->getTable('SKLADY_PALIVO',$data,'SKLADY_PALIVO');
		else $page->swap('SKLADY_PALIVO', '<br /><br />Žádná paliva na skladu');
	
	$fill['obsazeno'] = $obsazeno;
}


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


if($_GET['action'] == "finance") {
	$page->misc('FINANCE2','OBSAH');

	if(!p($Sql->q('SELECT * from stajovnici WHERE login = '.UID.' AND staj = '.$staj['id'].' AND (stav = 1 OR stav = 3)'))) {
		$page->misc('ZAVODNIK','OBSAH');
		$fill['vlastnik'] = '';
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}
	
	$fill['id'] = $staj['id'];
	
	if(UID == $staj['login']) {
		$page->misc('POSLAT_VLASTNIKOVI','VLASTNIK');
		$result2 = $Sql->q('SELECT login FROM stajovnici WHERE staj = '.$staj['id']);
		$data = array();
		for($i=0;$i<p($result2);$i++) {
			$hrac = fa($result2);
			$data[] = array('id' => $hrac['login'], 'nick' => getNick($hrac['login']));
		}
		$page->getTable('KOMU',$data,'LIDI');
		$page->swap('PULKA',numF($staj['kasa']/2));
	} else {
		$page->swap('VLASTNIK','');
	}
}


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

	
if($_GET['action'] == "give") {
	$result = $Sql->q('SELECT * FROM sklad WHERE login = '.UID.' AND (umisteni = 0 OR umisteni = 2)');
	if(!p($result)) {
		$page->misc('NEMAS_PREDMET','OBSAH');
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}
	
	$result2 = $Sql->q('SELECT login FROM stajovnici WHERE staj = '.$staj['id'].' AND login != '.UID);
	if(!p($result2)) {
		$page->misc('NEMAS_NIKOHO','OBSAH');
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}
	
	$page->misc('PREDANI','OBSAH');
	
	$data = array();
	for($i=0;$i<p($result);$i++) {
		$zbozi = fa($result);
		$predmet = new cItem($zbozi['zbozi'],$zbozi['typ']);
		if(p($Sql->q('SELECT predmet FROM zavody WHERE vitez = 0 AND predmet = '.$zbozi['id']))) continue;
		if($zbozi['typ'] != 11) $sablony = p($Sql->q('SELECT id FROM sablony WHERE login = '.UID.' AND '.$tabs[$zbozi['typ']].' = '.$zbozi['id']));
		if($sablony) $predmet->nazev = $predmet->nazev.' ('.$sablony.')';
		$data[] = array('id' => $zbozi['id'], 'nazev' => $predmet->nazev);
	}
	$page->getTable('PREDMETY',$data,'PREDMETY');
	
	$data = array();
	for($i=0;$i<p($result2);$i++) {
		$hrac = fa($result2);
		$data[] = array('id' => $hrac['login'], 'nick' => getNick($hrac['login']));
	}
	$page->getTable('KOMU',$data,'KOMU');
	
	$fill['poslani'] = numF(POSLANI_PREDMETU);
}


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


if($_GET['action'] == "forum") {

	$start = $_GET['start'];
	if($start == '' || $start < 0) {
		$start = 0;
	}

	define('LIMIT',8);
	
	$result = $Sql->q('SELECT staj FROM stajovnici WHERE login = '.UID);
	
	if(!p($result)) {
		$page->misc('NEMAS_STAJ','OBSAH');
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;		
	}
	
	$staj = fa($result);
	
	$page->misc('FORUM','OBSAH');	
	
	$data2 = array();
	for($j=1;$j<15;$j++) {
		$data2[]['x'] = $j;
	}
	
	$page->getTable('SMILES',$data2,'SMILES');
	
	#------------ SIPECKY!---------------#
	if($start > 0) {
		$dil1 = '<a href="staje.php?action=forum">&lt;&lt;</a> | <a href="staje.php?action=forum&start='.($start-LIMIT).'">&lt;</a>';
	}
	$result = $Sql->q('SELECT * from forum WHERE place = "s'.$staj['staj'].'"');
	$all = p($result);
	if($all > ($start+LIMIT)) {
		$dil2 = '<a href="staje.php?action=forum&start='.($start+LIMIT).'">&gt;</a> | <a href="staje.php?action=forum&start='.($all-LIMIT).'">&gt;&gt;</a>';
	}
	
	if($all > LIMIT) {
		$dil3 = '
		<div style="margin: auto; text-align: center">';
		for($i=0;$i<ceil($all/LIMIT);$i++) {
			if(abs(abs($i*LIMIT)-$start) > 3*LIMIT) {
				if($i == 0 || $i == (ceil($all/LIMIT)-1)) $dil3 .= ' ... ';
			} else {
				if(($i*LIMIT) != $start) {
					$dil3 .= '<a href="staje.php?action=forum&start='.($i*LIMIT).'">['.($i+1).']</a> ';
				} else {
					$dil3 .= '['.($i+1).'] ';
				}
			}
		}
		$dil3 .= '</div><br />';
	}
	$dil1 = $dil3.$dil1;
	
	if($dil1 != '' || $dil2 != '') {
	  $sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
	}
	
	$fill['sipky'] = $sipky;
	#------------ SIPECKY!---------------#
	
	$result = $Sql->q('SELECT f.id as id, f.login as login, h.login as nick, h.status as status, f.msg as msg, f.cas as cas FROM forum as f LEFT JOIN hraci as h ON h.id = f.login WHERE f.place = "s'.$staj['staj'].'" ORDER BY f.id DESC LIMIT '.$start.','.LIMIT);
	if(p($result) == 0) {
		$page->swap('ZPRAVY','Toto fórum je prázdné');
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}
	
	for($i=0;$i<p($result);$i++) {
		$add = "";  
		
		$msg = fa($result);
		
		if($novych > $i && $last_seen < $msg['id']) {
			$add = ' style="background-color: #292929"';
		}
		
		if($stajovych && $i < $stajovych && ereg('s',$place)) {
			$add = ' style="background-color: #292929"';
		}
			
		$delete = '';
		if(($_SESSION['status'] == 42 && $_SESSION['mazani_fora'] == 'yeah') || ($i == 0 && $msg['login'] == UID)) $delete = '<a class="submit" onclick="deleteForum('.$msg['id'].')">X</a> ';
		
		$zprava = str_replace('[B]','<strong>',$msg['msg']);
		$zprava = str_replace('[/B]','</strong>',$zprava);
		$zprava = str_replace('[I]','<em>',$zprava);
		$zprava = str_replace('[/I]','</em>',$zprava);
		$zprava = str_replace('[O]','<span class="extra">',$zprava);
		$zprava = str_replace('[/O]','</span>',$zprava);
		$zprava = str_replace('[S]','<span class="ultra">',$zprava);
		$zprava = str_replace('[/S]','</span>',$zprava);
		$zprava = str_replace('[U]','<span style="text-decoration: underline">',$zprava);
		$zprava = str_replace('[/U]','</span>',$zprava);
		
		for($j=1;$j<15;$j++) {
			$zprava = str_replace('[SM'.$j.']','<img src="./skin/img/smiles/'.$j.'.gif" style="vertical-align: middle" alt="">',$zprava);
		}
		
		$line['msg'] = nl2br($zprava);
		$line['nick'] = $msg['nick'];
		$line['datum'] = date('H:i d.m.',$msg['cas']);
		$line['login'] = $msg['login'];
		$line['delete'] = $delete;
		$line['add'] = $add;
		$line['admin'] = '';
		if($msg['status'] == 2) $line['admin'] = $page->misc('KONZUL');
		if($msg['status'] == 42) $line['admin'] = $page->misc('ADMIN');	
		
		$data3[] = $line;
	}
	
	$page->getTable('ZPRAVA',$data3,'ZPRAVY');
	
	$page->swap('ZPRAVY','Toto fórum je prázdné');
	
	$Sql->q('UPDATE stajovnici set forum = '.time().' WHERE staj = '.$staj['staj'].' AND login = '.UID);
}

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


if($_GET['action'] == "pohar" && $staj['login'] == UID) {
	if(p($Sql->q('SELECT val FROM sys WHERE entity = "pohar" AND val > -2'))) {
		$page->misc('POHAR','OBSAH');
		
		$result = $Sql->q('SELECT login FROM pohar WHERE staj = '.$staj['id']);		
		
		if(p($result) < POHAR_MAX_JEZDCU) {
			$res = $Sql->q('SELECT login FROM stajovnici WHERE stav != 3 AND staj = '.$staj['id']);
			if(p($res) > 0) {
				for($j=0;$j<p($result);$j++) {
					$jezdec1 = fa($result);
					$jezdci[] = $jezdec1['login'];	
				}
			
				$data = array();			
				for($i=0;$i<p($res);$i++) {
					$vpoharu = false;
					$jezdec2 = fa($res);
					if(is_array($jezdci)) {
						foreach($jezdci as $lgn) {
							if($lgn == $jezdec2['login']) $vpoharu = true;
						}
					}
					if($vpoharu == false) {
						$data[] = array('login' => $jezdec2['login'], 'nick' => getNick($jezdec2['login']));
					}
				}
				if(count($data))$page->getTable('POHAR_HRACI',$data,'HRACI');
			}
			
			$page->misc('POHAR_NIKDO','HRACI');
		}
		
		
		$result2 = $Sql->q('SELECT login FROM pohar WHERE staj = '.$staj['id']);
		
		if(p($result2) > 0) {
			$data = array();
			for($i=0;$i<p($result2);$i++) {
				$jezdec = fa($result2);
				$data[] = array('login' => $jezdec['login'], 'nick' => getNick($jezdec['login']));
			}
			
			$page->getTable('POHAR_PRIHLASENI',$data,'PRIHLASENI');
		} else {
			$page->misc('BLABLA','PRIHLASENI');
		}
	}
}
$page->fill($fill);
$page->misc('PODSEKCE','OBSAH');
$page->finish();
do_footer();
?>