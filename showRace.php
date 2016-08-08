<?php

/*
ZAVODY TYPY
-----------
0 - normalni
1 - normalni pro stajovniky
2 - pohar
*/

include 'library.php';
is_logged();
do_header('Závody');

$page = new cPage('showRace');

$id = $_GET['id'];
if($id == '' || !ereg('^[0-9]+$',$id)) {
	$page->ext('EXIST',1);
	exit;
}

$result = $Sql->q('SELECT id, login, nazev, popis, vklad, dotace, sazky, cas, prestiz, prestiz2, divaci, heslo, typ, cena, minimum, DATE_FORMAT(datum, "%d.%m. %Y") datum, pocet, trat, vitez, predmet FROM zavody WHERE id = '.$id);

if(p($result) == 0) {
	$page->ext('EXIST',1);
	exit;
}

$zavod = fa($result);

$fill = $zavod;

# MENU
	if($zavod['vitez'] == 0) $page->misc('NEODJETO_INFO', 'INFO');
		else $page->misc('ODJETO_INFO', 'INFO');

	$fill['vstup_b'] = '';
	$fill['editace_b'] = '';
	$fill['help_b'] = '';
	$fill['help'] = '';
	$fill['sazky_b'] = '';
	
	$fill['vsadit'] = '';
	$fill['editace'] = '';
	$fill['vstup'] = '';
		
	if($zavod['predmet']) {
		$predmet = fa($Sql->q(($zavod['login'] && !$zavod['vitez'] ? 'SELECT id, zbozi, typ, cena, vydrz FROM sklad WHERE id = '.$zavod['predmet'] : 'SELECT zbozi, typ, cena FROM zbozi WHERE id = '.$zavod['predmet'])));
		
		if(!$predmet['typ']) {
			$predmet = '';
		} else {
			$predmet = array_merge($predmet, fa($Sql->q('SELECT nazev, vydrz as max_vydrz FROM '.$tabs[$predmet['typ']].' WHERE id = '.$predmet['zbozi'])));	
			
			if(!$zavod['login']) $predmet['vydrz'] = $predmet['max_vydrz'];
		}
	}
	$fill['predmet'] = ($predmet['nazev'] ? '<a href="showItem.php?id='.$predmet['zbozi'].'&typ='.$predmet['typ'].'">'.$predmet['nazev'].'</a>'.($zavod['vitez'] == 1 ? '' : '&nbsp;&nbsp;<em>(výdrž - '.round($predmet['vydrz']/$predmet['max_vydrz']*100).'%)</em>') : ($zavod['predmet'] ? '<em>předmět nenalezen</em>' : '<em>žádný předmět</em>'));

	if($zavod['vitez'] == 0) {  
	
		$v_poharu = false;
		$v_staji = false;
		$v_zavodu = false;
		$predem = true;
		$vsazeno = false;
		
		$pocet = p($Sql->q('SELECT zavod FROM zavodnici WHERE zavod = '.$id.' AND login > 0 ORDER BY poradi ASC'));
		$pocet1 = $pocet + p($Sql->q('SELECT zavod FROM zavodnici WHERE zavod = '.$id.' AND login < 0 ORDER BY poradi ASC'))/2;
		
		if(p($Sql->q('SELECT login FROM zavodnici WHERE zavod = '.$id.' AND login = '.UID)) > 0) $v_zavodu = true;
		if(p($Sql->q('SELECT login FROM pohar WHERE login = '.UID)) > 0) $v_poharu = true;
		$soucet = fa($Sql->q('SELECT SUM(cena) as cen FROM sklad WHERE login = '.UID.' AND umisteni = 1'));

		$result = $Sql->q('SELECT staj FROM stajovnici WHERE login = '.UID);
		if(p($result) > 0) {
			$row = fa($result);
			$v_staji = $row['staj'];
		}

		$result = $Sql->q('SELECT id FROM sazky WHERE zavod = '.$id.' AND login = '.UID);
		if(p($result) > 0) {
			$row = fa($result);
			$sazka_id = $row['id'];
			$vsazeno = true;
		}
		
		$cas = ($zavod['cas'] == 0 ? 23 : $zavod['cas']);
		
		if(date('i') > 49 && $pocet1 >= $zavod['minimum']) {	# je xx:50- xx:59 	a	je tam dost lidi 
			if(date('H')+1 == $cas && $zavod['datum'] == date('d.m. Y')) # bude je odlozenej, nebo je tesne pred prepoctem
				$predem = false;
			
			
			if(in_array(date('H'), array(12,15,18,22)) && $zavod['datum'] == '24.12. 4200') # byl odlozenej a je tesne pred jakymkoli prepoctem
				$predem = false; 
		}
		
		$cenova_kategorie = false;
		if($zavod['cena'] == -1) {
			$cenova_kategorie = true;
		} else {
			if(($soucet['cen'] > $ceny_kluzaky[$zavod['cena']-2] && ($soucet['cen'] < $ceny_kluzaky[$zavod['cena']] || !isset($ceny_kluzaky[$zavod['cena']])))) $cenova_kategorie = true;		
		}
		
		if($zavod['login'] == UID) {
			$fill['editace_b'] = '<li><a href="#editace">Editovat závod</a></li>';
			ob_start();
			include 'editRace.php';
			$fill['editace'] = ob_get_contents();
			ob_end_clean();
		}
		
		if($zavod['typ'] == 2) {
			if ($zavod['login'] != UID 				&& # neni to tvuj zavod
				!$v_zavodu			   				&& # uz tam nejsi
				$v_poharu			   				&& # si v poharu
				!$vsazeno							   # tovizejo, vsadit si a pak tam vlizt
			) {
				$fill['vstup_b'] = '<li><a href="#vstup" onclick="jHadr(\'enterRace.php?id='.$id.'\', {})">Vstoupit do závodu</a></li>';
			}
		} else {
			if ($zavod['login'] != UID 				&& # neni to tvuj zavod
				!$v_zavodu			   				&& # uz tam nejsi
				!$vsazeno							&& # tovizejo, vsadit si a pak tam vlizt
				(($zavod['typ'] == 1 && $v_staji) 
				|| $zavod['typ'] != 1) 				&& # stajovej zavod
				$predem								&& # neni casovej limit
				$pocet < $zavod['pocet']			&& # je tam jeste misto
				$cenova_kategorie
			) {
				$fill['vstup_b'] = '<li><a href="#vstup" onclick="jHadr(\'enterRace.php?id='.$id.'\', {})">Vstoupit do závodu</a></li>';
			}
		
		}
		
		if(!$v_zavodu && !$vsazeno) {
			$fill['sazky_b'] = '<li><a href="#sazky" onclick="jHadr(\'betOnRace.php?id='.$id.'\', {})">Vsadit si</a>';
		}
		
		if($vsazeno) {
			$fill['sazky_b'] = '<li><a href="#sazky">Ukaž sázku</a>';
			ob_start();
			$showRace_id = $sazka_id;
			include 'showBet.php';
			$fill['vsadit'] = ob_get_contents();
			ob_end_clean();
		}
		
		if($v_zavodu) {
			$fill['sazky_b'] = '<li><a href="#sazky">Styl jízdy</a>';
			$fill['vstup_b'] = '<li><a href="#vse" onclick="jHadr(\'enterRace.php?id='.$id.'&action=leave\', {})">Odstoupit ze závodu</a>';
			$fill['help_b'] = $page->misc('HELP_B');
			
			$zavodnik = fa($Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$id.' AND login = '.UID));
			
			$fill['vsadit'] = $page->misc('STYL_JIZDY');
			$fill['agresivita'] = $zavodnik['agresivita'];
			$fill['opatrnost'] = $zavodnik['opatrnost'];
			$fill['id_zavodnika'] = $zavodnik['id'];
			
			foreach($jizdni_styly[1] as $styl_id => $styl) {
				if($zavodnik['agresivita'] > -1 || $styl_id != $zavodnik['postoj']) {
					$jizdni_styly[1][$styl_id]['checked'] = '';
				} elseif($styl_id == $zavodnik['postoj']) {
					$jizdni_styly[1][$styl_id]['checked'] = ' selected="selected"';
				}
			}
			
			foreach($jizdni_styly[3] as $styl_id => $styl) {
				if($zavodnik['agresivita'] < 1 || $styl_id != $zavodnik['postoj']) {
					$jizdni_styly[3][$styl_id]['checked'] = '';
				} elseif($styl_id == $zavodnik['postoj']) {
					$jizdni_styly[3][$styl_id]['checked'] = ' selected="selected"';
				}
			}
			
			$fill['postoj1'] = $page->getTable('POSTOJ1', $jizdni_styly[1]);
			$fill['postoj2'] = $page->getTable('POSTOJ2', $jizdni_styly[3]);
			
			$taktika1_data = array();
			foreach($taktiky[1] as $tid => $taktika) {
				$line = array();
				$line['id'] = $tid;
				$line['nazev'] = $taktika;
				$line['checked'] = ($zavodnik['agresivita'] < 0 && $zavodnik['taktika'] == $tid ? ' selected="selected"' : '');
				
				$taktika1_data[] = $line;
			}
			
			$taktika2_data = array();
			foreach($taktiky[3] as $tid => $taktika) {
				$line = array();
				$line['id'] = $tid;
				$line['nazev'] = $taktika;
				$line['checked'] = ($zavodnik['agresivita'] > 0 && $zavodnik['taktika'] == $tid ? ' selected="selected"' : '');
				
				$taktika2_data[] = $line;
			}
			
			$fill['taktika1'] = $page->getTable('TAKTIKA1', $taktika1_data);
			$fill['taktika2'] = $page->getTable('TAKTIKA2', $taktika2_data);
			
			$result = $Sql->q('SELECT z.login as id, h.login as login FROM zavodnici as z LEFT JOIN hraci as h ON h.id = z.login WHERE z.login != '.UID.' AND z.zavod = '.$id);
			if(!p($result)) {
				$fill['obet'] = '';
			} else {
				$data = array();
				for($i=0;$i<p($result);$i++) {
					$row = fa($result);
					if($row['id'] < 0) $row['login'] = getNick($row['id']);
					$row['checked'] = ($zavodnik['obet'] == $row['id'] ? ' selected="selected"' : '');
					$data[] = $row;
				}
				
				$fill['obet'] = $page->getTable('OBET', $data);
			}
			
			$fill['ulozit'] = ($predem ? '<input type="button" value="Uložit změny" class="submit" onclick="jHadr(\'zmenStyl.php?id='.$zavodnik['id'].'\', \'form_zmenStyl\')" style="width: 360px; text-align: center" />' : 'Změnit styl je 10 minut před odjetím nemožné');

			$fill['help'] = $page->misc('HELP');

			$obrazky[0] = 'prohra';
			$obrazky[1] = 'remiza';
			$obrazky[2] = 'vyhra';
		
			$vyraz[0] = 'je v nevýhodě proti';
			$vyraz[1] = 'nemá žádný bonus proti';
			$vyraz[2] = 'má výhodu proti';
		
			$styly1 = '<tr class="zahlavi"><td class="prvni">Ofenzivní styly proti sobě</td>';
			
			foreach($jizdni_styly[3] as $styl) $styly1 .= '<td'.($styl['id'] == 3 ? ' style="border-right-color: #FF9900"' : '').'>'.$styl['nazev'].'<span>('.$styl['nazev2'].')</span></td>';
			
			$styly1 .= '</tr>';
			
			foreach($jizdni_styly[3] as $styl) {
			
				$styly1 .= '<tr class="telo"><td class="prvni">'.$styl['nazev'].'<span>('.$styl['nazev2'].')</span></td>';
					
				foreach($styl['vztahy'] as $ids2 => $bonus) {
					$styly1 .= '<td><img src="skin/img/'.$obrazky[$bonus].'.png" alt="'.$styl['nazev'].' '.$vyraz[$bonus].' '.$jizdni_styly[3][$ids2]['nazev'].'" /></td>';	
				}
				
				$styly1 .= '</tr>';
			}
		
			####################################################
		
			$styly2 = '<tr class="zahlavi"><td class="prvni">Ofenzivní styly proti defenziv.</td>';
			
			foreach($jizdni_styly[1] as $styl) $styly2 .= '<td'.($styl['id'] == 3 ? ' style="border-right-color: #FF9900"' : '').'>'.$styl['nazev'].'<span>('.$styl['nazev2'].')</span></td>';
			
			$styly2 .= '</tr>';
			
			foreach($jizdni_styly[3] as $styl) {
			
				$styly2 .= '<tr class="telo"><td class="prvni">'.$styl['nazev'].'<span>('.$styl['nazev2'].')</span></td>';
					
				foreach($styl['vztahy'] as $ids2 => $bonus) {
					$styly2 .= '<td><img src="skin/img/'.$obrazky[$jizdni_styly[1][$ids2]['vztahy'][$styl['id']]].'.png" alt="'.$styl['nazev'].' '.$vyraz[$jizdni_styly[1][$ids2]['vztahy'][$styl['id']]].' '.$jizdni_styly[1][$ids2]['nazev'].'" /></td>';	
				}
				
				$styly2 .= '</tr>';
			}
			
			$fill['styly1'] = $styly1;
			$fill['styly2'] = $styly2;
		}	  
	}

# Obecne info      -------------------------------

	$z_typy[0] = "Klasický závod";
	$z_typy[1] = "Stájový závod";
	$z_typy[2] = POHAR_NAZEV;

	$casy[0] = '23:00';
	$casy[13] = '13:00';
	$casy[16] = '16:00';
	$casy[19] = '19:00';
	
	$casy[-42] = $casy[13];
	if(date('H') < 23) $casy[-42] = $casy[0];
	if(date('H') < 19) $casy[-42] = $casy[19];
	if(date('H') < 16) $casy[-42] = $casy[16];
	if(date('H') < 13) $casy[-42] = $casy[13];

	
	$fill['p_uid'] = $zavod['login'];
	$fill['poradatel'] = getNick($zavod['login']);
	$fill['typ'] = $z_typy[$zavod['typ']];
	$fill['dotace'] = numF($zavod['dotace']).' Is';
	$fill['sazky'] = numF($zavod['sazky']).' Is';
	$fill['vklad'] = numF($zavod['vklad']).' Is';
	$fill['divaci'] = numF($zavod['divaci']);
	
	$fill['ceny'] = ($zavod['cena'] == -1 ? 
						'Neomezeno'
					  	: (isset($ceny_kluzaky[$zavod['cena']-2]) ? 
					  		numF($ceny_kluzaky[$zavod['cena']-2]) : '0')
							
							.' - '.numF($ceny_kluzaky[$zavod['cena']]));
	if($zavod['cena'] == count($ceny_kluzaky)) 
		$fill['ceny'] = numF($ceny_kluzaky[count($ceny_kluzaky)-1]).'+';

	$fill['barva'] = $ceny_barvy[$zavod['cena']];

	if($zavod['prestiz'] == 0) {
		if($zavod['prestiz2'] == 0) {
			$prestiz = '---';
		} else {
			$prestiz = $zavod['prestiz2'].' a méně';
		}
	} else {
		if($zavod['prestiz2'] == 0) {
			$prestiz = $zavod['prestiz'].' a více';
		} else {
			$prestiz = $zavod['prestiz'].' - '.$zavod['prestiz2'];
		}	
		
		if($zavod['prestiz'] == $zavod['prestiz2']) $prestiz = $zavod['prestiz'];
	}	
	$fill['prestiz'] = $prestiz;
	
	$trat = fa($Sql->q('SELECT id, nazev FROM trate WHERE id = '.$zavod['trat']));
	$fill['trat_id'] = $trat['id'];
	$fill['trat_nazev'] = $trat['nazev'];

	$fill['datum'] = ($zavod['datum'] == date('d.m. Y') ? 'Dnes' : $zavod['datum']);
	if($fill['datum'] == '24.12. 4200') {
		$fill['datum'] = 'Dnes <span class="ultra">(odloženo)</span>';
		$zavod['cas'] = -42;
	}	
	
	$fill['cas'] = $casy[$zavod['cas']];
	
	$result = $Sql->q('SELECT id, login FROM zavodnici WHERE zavod = '.$id.' ORDER BY poradi ASC');
	$fill['pocet2'] = p($result);

	if($zavod['heslo'] != "") $fill['heslo'] = '<span class="extra">vstup chráněn heslem</span>';

# Konec - Obecne info -------------------------------


# Zavodnici			  -------------------------------
	$zavodnici = array();
	for($i=0;$i<$fill['pocet2'];$i++) {
		$row = fa($result);
		$zavodnici[] = $row['login'];
		$zav_id[$row['login']] = $row['id'];
	}
	
	$typy[1] = 'Sport';
	$typy[2] = 'Combi';
	$typy[3] = 'Wrecker';
	
	$data3 = array();	
	foreach($zavodnici as $misto=>$zavodnik) {
	
		if(!$zavodnik) continue;
		
		if($zavodnik > 0) {
			$hrac = fa($Sql->q('SELECT prestiz, rasa, zavody, prvni, druhy, treti FROM postavy WHERE login = '.$zavodnik));	
		} else {
			$hrac = fa($Sql->q('SELECT prestiz, rasa, vyhry FROM boti WHERE id = '.abs($zavodnik)));
			$kusy = explode('-', $hrac['vyhry']);
			$hrac['zavody'] = $kusy[0];
			$hrac['prvni'] = $kusy[1];
			$hrac['druhy'] = $kusy[2];	
			$hrac['treti'] = $kusy[3];
		}
		
		$kluzak = new cKluzak($zavodnik);
		
		$data['nick'] = getFlag($zavodnik).getNick($zavodnik);
	
		$spion = '';
		if($zavod['vitez'] == 0 && $zavodnik != UID) {
			$spioni = $Sql->q('SELECT spolehlivost FROM spioni WHERE login = '.UID.' AND zavodnik = '.$zav_id[$zavodnik]);
			if(p($spioni)) {
				$spion = fa($spioni);
				$spion = '<strong><a class="submit" onclick="jHadr(\'spion.php\', {zavod: \''.$id.'\', login: \''.$zavodnik.'\', action: \'show\'})">[tohoto hráče špehuješ - '.$spion['spolehlivost'].'%]</a></strong>';			
			} else {
				$spion = '<strong><a class="submit" onclick="jHadr(\'spion.php\', {zavod: \''.$id.'\', login: \''.$zavodnik.'\'})">[najmout špióna]</a></strong>';
			}
		}
	
		$data2 = array();
		if($zavod['vitez'] == 0) $data2[] = array('nazev' => '<a href="showProfile.php?id='.$zavodnik.'"><strong class="extra">[profil]</strong></a>', 
													'val' => $spion);
		$data2[] = array('nazev' => 'Rasa',
						 'val' => getRasaNazev($hrac['rasa']));
		$data2[] = array('nazev' => 'Prestiž',
						 'val' => numF($hrac['prestiz']));
		$data2[] = array('nazev' => 'Závody',
						 'val' => $hrac['zavody'].'-'.$hrac['prvni'].'-'.$hrac['druhy'].'-'.$hrac['treti']);
	
		if($zavod['vitez'] == 0) {
			$data2[] = array('nazev' => '<strong class="extra">Kluzák</strong>',
							 'val' => '');
			$data2[] = array('nazev' => 'Typ',
							 'val' => $typy[$kluzak->podvozek['typ']]);
			$data2[] = array('nazev' => 'Cena',
							 'val' => numF($kluzak->cena).' Is');
			$data2[] = array('nazev' => 'Rychlost',
							 'val' => $kluzak->rychlost.' km/h');
			$data2[] = array('nazev' => 'Váha',
							 'val' => $kluzak->vaha.' kg');
			$data2[] = array('nazev' => 'Ovladatelnost',
							 'val' => round($kluzak->ovladatelnost).'%');
			$data2[] = array('nazev' => 'Odolnost',
							 'val' => $kluzak->odolnost.'%');
			$data2[] = array('nazev' => 'Zrychlení',
							 'val' => $kluzak->zrychleni.'%');
		}
						 
		$data['kluzak'] = $page->getTable('KLUZAK', $data2);					 
		$data['id'] = $zavodnik;
		
		$data3[] = $data;
	}
	
	$fill['zavodnici'] = (count($zavodnici) ? $page->getTable('ZAVODNICI',$data3) : 'V tomto závodě nejsou žádní závodníci');	
	$fill['vice_info'] = (count($zavodnici) > 2 && $zavod['vitez'] != 1 ? ' style="display: none"' : '');
	$fill['shown'] = (count($zavodnici) > 2 && $zavod['vitez'] != 1 ? 'false' : 'true');
# Konec - Zavodnici   -------------------------------

# Vyhry   			  -------------------------------

	if($zavod['vitez'] != 0) {
		$result = $Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$id.' ORDER BY poradi ASC');
	
		$data = array();
		$nedojeti = array();
		
		for($i=0;$i<p($result);$i++) {
			$zavod2 = fa($result);
			if($zavod2['poradi'] == 0) {
				$poradi = '<span class="error">Nedojel</span>';
			} else {
				$poradi = $zavod2['poradi'].'.';
			}
			$line['id'] = $zavod2['login'];
			$line['login'] = getNick($zavod2['login']);
			$line['vyhra'] = numF($zavod2['vyhra']);
			$line['poradi'] = $poradi;
	
			if($zavod['vitez'] != 0 && $poradi == 0) {
				$nedojeti[] = $line;
			} else {
				$data[] = $line;
			}
		} 
	
		if(count($nedojeti)) {
			foreach($nedojeti as $radek) {
				$data[] = $radek;
			}
		}
		
		$fill['vyhry'] = $page->getTable('VYHRY',$data);
	}

# Konec - Vyhry  	 -------------------------------

# Sazky 			 -------------------------------

	if($zavod['vitez'] != 0) {
	
		$result = $Sql->q('SELECT * from sazky WHERE zavod = '.$id.' ORDER BY penize DESC, sazka DESC');

		$data = array();
		for($i=0;$i<p($result);$i++) {
			$sazka = fa($result);
			
			if($sazka['vyhra'] == 1) {
				$win = '<span style="color: #02FD09">Výhra</span>';
				$vyhra = $sazka['penize'];
			} else {
				$win = '<span style="color: #FF0000">Prohra</span>';	
				$vyhra = '';  
			}
			
			$line['id'] = $sazka['login'];
			$line['sazka'] = str_replace(' ', '&nbsp;', numF($sazka['sazka']));
			$line['zavodnik'] = getNick($sazka['zavodnik']);
			$line['misto'] = ($sazka['misto'] ? $sazka['misto'].'.' : 'Nedojede');
			$line['login'] = getNick($sazka['login']);
			$line['vyhra'] = str_replace(' ', '&nbsp;', numF($vyhra)).'&nbsp;Is';
			$line['stav'] = $win;
			
			$data[] = $line;
		}
		 
		$fill['sazky2'] = (count($data) ? $page->getTable('SAZKY',$data) : 'Žádné sázky na tento závod');
	}
	
# Konec - Sazky 	 -------------------------------


$page->fill($fill);
$page->finish();

do_footer();
exit;
?>