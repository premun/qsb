<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

$dlg = new cDialog('Vstupování do závodu','alert');

do_header('Závody');
$result = $Sql->q('SELECT * FROM postavy WHERE login = '.UID);
$row = fa($result);
$penize = $row['penize'];
$result = $Sql->q('SELECT * FROM zavody WHERE id = '.$id);
$row = fa($result);
$zavod_nazev = $row['nazev'];
$vklad = $row['vklad'];
$prestiz = getPrestiz(UID);
$pr = $row['prestiz'];
$pr2 = $row['prestiz2'];

$page = new cPage('zavody');

$page->setCommon('VSTUP');

if($row['vitez'] != 0) {
	$dlg->obody($page->ext('ODJET'));
	konec();
}

if($_GET['action'] != 'leave' && $_GET['action'] != 'leave2') {

	$result = $Sql->q('SELECT z1.login FROM zavodnici as z1 LEFT JOIN zavody as z2 ON z1.zavod = z2.id
	WHERE z1.login = '.UID.' AND z2.vitez = 0 AND z2.cas = '.$row['cas'].' AND 
	'.($row['datum'] == '4200-12-24' || $row['datum'] == date('Y-m-d') ? '(z2.datum = "'.$row['datum'].'" OR z2.datum = "4200-12-24")' : 'z2.datum = "'.$row['datum'].'"'));
	
	if(p($result) > 0) {
		$dlg->obody($page->ext('NAJEDNOU'));
		konec();
	}
	
	if($row['login'] == UID) {
		$dlg->obody($page->ext('ZAKLADATEL'));
		konec();
	}
	
	if($row['pocet'] == p($Sql->q('SELECT zavod FROM zavodnici WHERE zavod = '.$id)) && $row['typ'] != 2) {
		$dlg->obody($page->ext('PLNY'));
		konec();
	}
	
	if($row['login'] == UID) {
		$dlg->obody($page->ext('ZAKLADATEL'));
		konec();
	}
	
	if(p($Sql->q('SELECT login FROM zavodnici WHERE zavod = '.$id.' AND login = '.UID)) > 0) {
		$dlg->obody($page->ext('JSI'));
		konec();
	}
	
	$zav_staj = getStaj(UID);
	if($zav_staj != false && $row['typ'] != 2) {
		$ze_staje = p($Sql->q('SELECT z.login FROM zavodnici as z LEFT JOIN stajovnici as s ON s.login = z.login WHERE z.zavod = '.$id.' AND s.staj = '.$zav_staj));
		if($ze_staje == 2 || (p($Sql->q('SELECT login FROM zavodnici WHERE zavod = '.$id)) < 3 && $ze_staje == 1)) {
			$dlg->obody($page->ext('STAJ'));
			konec();			
		}
	}
	
	$pohar = false;
	$stajovy = false;
	$in_staj = false;
	if(p($Sql->q('SELECT * FROM pohar WHERE login = '.UID)) > 0) $vpoharu = true;
	if($row['typ'] == 1) $stajovy = true;
	if($row['typ'] == 2) $pohar = true;
	if($zav_staj) $in_staj = true;
	  
	if(!$in_staj && $stajovy) {
		$dlg->obody($page->ext('STAJ2'));
		konec();  
	}
	
	if($vpoharu == false && $pohar == true) {
	  $dlg->obody($page->ext('POHAR'));
	  konec();  
	}
	
	$kluzak = new cKluzak(UID);
	
	if($kluzak->ok_zavod == false) {
		$dlg->obody($page->ext('KOMPLET'));
		konec();
	}

	if(!($row['cena'] == -1 || ($kluzak->cena > $ceny_kluzaky[$row['cena']-2] && ($kluzak->cena < $ceny_kluzaky[$row['cena']] || !isset($ceny_kluzaky[$row['cena']]))))) {
		$dlg->obody($page->ext('CENA'));
		konec();		
	}
	
	if($pr != 0 && $prestiz < $pr) {
		$dlg->obody($page->ext('PRESTIZ1'));
		konec();
	}
	
	if($pr2 != 0 && $prestiz > $pr2) {
		$dlg->obody($page->ext('PRESTIZ2'));
		konec();
	}
	
	if(p($Sql->q('SELECT login FROM brigadnici WHERE login = '.UID)) > 0) {
		$dlg->obody($page->ext('BRIGADA'));
		konec();
	}
	
	$palivo2 = getPalivoAll($kluzak->motor['palivo']);
	
	$result = $Sql->q('SELECT * FROM paliva_sklad WHERE login = '.UID.' AND staj = 0 AND palivo = '.$kluzak->motor['palivo']);
	if(p($result) > 0) {
		$neco = fa($result);
		$skladp = $neco['mnozstvi'];
	} else {
		$skladp = 0;
	}
	
	$result = $Sql->q('SELECT * FROM stajovnici WHERE login = '.UID);
	if(p($result) > 0) {
		$stajovnik = fa($result);
		$result2 = $Sql->q('SELECT * FROM paliva_sklad WHERE staj = 1 AND login = '.$stajovnik['staj'].' AND palivo = '.$kluzak->motor['palivo']);
		if(p($result2) > 0) {
			$neco = fa($result2);
			$skladp2 = $neco['mnozstvi'];
		}
	} else {
		$skladp2 = 0;
	}
	
	$spotreba = floor(getSpotreba($row['trat'],$kluzak->motor['spotreba']));
	
	if($palivo['mnozstvi'] == '') $palivo['mnozstvi'] = 0;
	
	if(($skladp+$skladp2) < $spotreba && $_GET['action'] != 'palivo') {
		$fill['mas'] = floor($skladp+$skladp2);
		$fill['palivo'] = $palivo2['nazev'];
		$fill['spotreba'] = numF($spotreba-$skladp-$skladp2);
		$fill['palivo2'] = $palivo2['id'];
		$fill['trat'] = $row['trat'];
		
		$cena = fa($Sql->q('SELECT cena FROM paliva_ceny WHERE id = '.$palivo2['id']));
		
		$fill['cena'] = numF(ceil($spotreba*$cena['cena']));
		
		$dlg->button('Zrušit','close');
		
		if($dlg->is_empty()) {
			$dlg->button('Nakoupit palivo', 'location', 'buyPalivo.php?id='.$palivo2['id'].'&trat='.$row['trat']);
			$dlg->button('Auto-nákup + vstoupit', 'alert', 'enterRace.php?id='.$id.'&action=palivo&palivo='.$palivo2['id'].'&mnozstvi='.$spotreba);
		}
		
		$dlg->obody($page->ext('PALIVO'.(jhadr() ? '2' : ''),1,0,$fill));
		$dlg->set('width', '497px');
		$dlg->set('height', '210');
		
		$dlg->output();
		
		konec();
	} elseif($_GET['action'] == 'palivo') {
		$spotreba -= floor($skladp+$skladp2);
	
		$cena = fa($Sql->q('SELECT cena FROM paliva_ceny WHERE id = '.$palivo2['id']));
		
		$cena = ceil($spotreba*$cena['cena']);

		if(getPenize(UID) < $cena) {
			$dlg->obody($page->ext('PALIVO_NAKUP_PENIZE'));
			$dlg->button('OK','close');
			$dlg->output();			
			konec();
		}
	
		$res = $Sql->q('SELECT * FROM paliva_sklad WHERE login = '.UID.' AND staj = 0 AND palivo = '.$palivo2['id']);
		if(p($res) != 0) {
			$row2 = fa($res);
			$mas = $row2['mnozstvi'];
		} else {
			$Sql->q('INSERT into paliva_sklad(login,staj,mnozstvi,palivo) values('.UID.',0,0,'.$palivo2['id'].')');
			$mas = 0;
		}
		$Sql->q('UPDATE paliva_sklad set mnozstvi = '.($mas+$spotreba).' WHERE login = '.UID.' AND staj = 0 AND palivo = '.$palivo2['id']);
		$Sql->q('UPDATE postavy set penize = penize-'.$cena.' WHERE login = '.UID);
		
		finance(UID,$cena,0,21);
	}
	
	
	if(!$dlg->is_empty()) {
		$dlg->button('OK','close');
		$dlg->output();
	}
	
	$dlg->type('location', 'enterRace.php?id='.$id);
	$dlg->output();
}

$result = $Sql->q('SELECT * FROM sazky WHERE login = '.UID.' AND zavod = '.$id);
if(p($result)) {
	$sazka = fa($result);
	
	$fill['sazka'] = $sazka['id'];
	
	$page->ext('SAZKA',1,0,$fill);
	konec();
}

$result = $Sql->q('SELECT * FROM zavodnici WHERE login = '.UID.' AND zavod = '.$id);

if(p($result) == 0 && ($_GET['action'] == 'leave' || $_GET['action'] == 'leave2')) {
	$dlg->title('Odstupování ze závodu');
	$dlg->obody($page->ext('NEJSI'));
	konec();
}

if($_GET['action'] == 'leave2') {
	$result8 = fa($Sql->q('SELECT zbozi FROM sklad WHERE login = '.UID.' AND typ = 2 AND umisteni = 1'));
	$motor2 = new cItem($result8['zbozi'],2);
	$motor['palivo'] = $motor2->palivo;

	$dlg->title('Odstupování ze závodu');

	if(!$dlg->is_empty()) {
		$dlg->button('OK','close');
		$dlg->output();
	}
	
	$res4 = $Sql->q('SELECT * FROM sazky WHERE zavod = '.$id.' AND zavodnik = '.UID);
	if(p($res4) > 0) {
		for($h=0;$h<p($res4);$h++) {
			$sazka = fa($res4);
			$Sql->q('UPDATE postavy set penize = penize+'.$sazka['sazka'].' WHERE login = '.$sazka['login']);
			finance($sazka['login'],$sazka['sazka'],1,8);
			$Sql->q('DELETE FROM sazky WHERE zavod = '.$id.' AND zavodnik = '.UID.' AND login = '.$sazka['login']);
			$msg = 'Hráč '.getNick(UID).', na kterého sis vsadil v závodě '.$zavod_nazev.' odstoupil a tvá sázka byla zrušena. Zpět si dostal 100% vsazené částky ('.numF($sazka['sazka']).' Is).';
			sendPosta(0,$sazka['login'],$msg);
			$Sql->q('UPDATE zavody set sazky = '.($row['sazky']-$sazka['sazka']).' WHERE id = '.$id);
		}
	}
	
	$res4 = $Sql->q('SELECT * FROM sazky WHERE zavod = '.$id.' AND vyhra = -1');
	if(p($res4) > 0) {
		for($h=0;$h<p($res4);$h++) {
			$sazka = fa($res4);
			$sazka['sazka'] = round(0.9*$sazka['sazka']);
			$Sql->q('UPDATE postavy set penize = penize+'.$sazka['sazka'].' WHERE login = '.$sazka['login']);
			finance($sazka['login'],$sazka['sazka'],1,8);
			$Sql->q('DELETE FROM sazky WHERE id = '.$sazka['id']);
			$msg = 'Závod [B][O]'.$zavod_nazev.'[/O][/B], ve kterém sis vsadil na [B][O]'.($sazka['zavodnik'] == -1 ? 'nedojetí všech' : getNick($sazka['zavodnik']).'a').'[/O][/B], změnil sestavu a sázka byla zrušena.
			
Zpět si dostal 90% vsazené částky ('.numF($sazka['sazka']).' Is).';
			sendPosta(0,$sazka['login'],$msg);
			$Sql->q('UPDATE zavody set sazky = '.($row['sazky']-$sazka['sazka']).' WHERE id = '.$id);
		}
	}
	
	$result = $Sql->q('SELECT palivo FROM paliva_sklad WHERE login = '.UID.' AND palivo = '.$motor['palivo'].' AND staj = 0');
	if(p($result)) {
		$result = $Sql->q('UPDATE paliva_sklad set mnozstvi = mnozstvi+'.floor(getSpotreba($row['trat'],$motor2->spotreba)).' WHERE login = '.UID.' AND palivo = '.$motor['palivo'].' AND staj = 0');
	} else {
		$result = $Sql->q('INSERT into paliva_sklad(mnozstvi, login, palivo, staj) values('.floor(getSpotreba($row['trat'],$motor2->spotreba)).', '.UID.', '.$motor['palivo'].', 0)');	
	}
	
	$result = $Sql->q('SELECT * FROM zavody WHERE id = '.$id);
	$zavod2 = fa($result);
	
	if($zavod2['login'] != 0 && $zavod2['login'] != UID) {
		$row4 = fa($Sql->q('SELECT posta_zavody2 FROM hraci WHERE id = '.$zavod2['login']));
		if($row4['posta_zavody2'] == 1) {
			$msg = 'Hráč [B]'.getNick(UID).'[/B] odstoupil ze tvého závodu [B]'.$zavod2['nazev'].'[/B]
			
			SYSTEM';
			sendPosta(0,$zavod2['login'],$msg);
		}
	}
	
	$msg = "Hráč [O][B]".getNick(UID)."[/B][/O] odstoupil ze závodu [O][B]".$zavod2['nazev']."[/B][/O] a tvůj špión byl zrušen.\n\nSYSTEM";
	
	$zavodnik = fa($Sql->q('SELECT id FROM zavodnici WHERE zavod = '.$id.' AND login = '.UID));
	
	$result = $Sql->q('SELECT * FROM spioni WHERE zavodnik = '.$zavodnik['id']);
	for($i=0;$i<p($result);$i++) {
		$spion = fa($result);
		sendPosta(0, $spion['login'], $msg);
	}
	
	$Sql->q('DELETE FROM spioni WHERE zavodnik = '.$zavodnik['id']);
	
	$result = $Sql->q('UPDATE zavody set vklady = '.($zavod2['vklady']-$vklad*0.75).' WHERE id = '.$id);
	$result = $Sql->q('DELETE FROM zavodnici WHERE login = '.UID.' AND zavod = '.$id);
	// navrat penez odstoupivsimu zavodnikovi.. vraci se nove plna castka!
	$result = $Sql->q('UPDATE postavy set prestiz = prestiz-'.ODSTUP_PRESTIZ.', penize = '.($penize+$vklad*0.75).' WHERE login = '.UID);
	finance(UID,$vklad*0.75,1,9);
	
	$dlg->body($page->ext('ODSTOUPIL'));
	$dlg->button('OK','location','showRace.php?id='.$id);
	$dlg->output();
	
	konec();
}

if($_GET['action'] == 'leave') {

	$fill['id'] = $id;
	$fill['vklad'] = numF($vklad);
	$fill['zpet'] = numF(0.75*$vklad);
	$fill['nakonec'] = numF(($penize+($vklad*0.75)));

	$dlg->title('Odstupování ze závodu');	
	
	if(!$dlg->is_empty()) {
		$dlg->button('OK','close');
		$dlg->output();
	}
	
	$dlg->body($page->ext('ORLY',1,0,$fill));
	$dlg->button('Zrušit','close');
	$dlg->button('Odstoupit','alert','enterRace.php?id='.$id.'&action=leave2');
	$dlg->output();
	
	konec();
}

$page->setCommon('VSTUP');

$result = $Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$id);
if(p($result) >= $row['pocet'] && $row['typ'] != 2) {
	$page->ext('OBSAZEN');
	konec();
}

$cas2 = ($row['cas'] == 0 ? 23 : $row['cas']);
if((date('H')+1 == $cas2 || $row['datum'] == '4200-12-24') && date('i') > 49 && p($result) > $row['minimum'] && ($zavod['datum'] == date('Y-m-d') || $zavod['datum'] == '4200-12-24')) {
	$page->ext('PREDEM');
	konec();
}

if($_GET['action'] == 'sure') {
	if($vklad < $penize) {
		$result = $Sql->q('SELECT * FROM zavody WHERE id = '.$id);
		$zavod2 = fa($result);
		if($zavod2['heslo'] != "" && $zavod2['heslo'] != md5($_POST['heslo'])) {
			$page->ext('HESLO',1,0,array('id' => $id));
			konec();
		}
		
		$result = $Sql->q('UPDATE zavody set vklady = '.($zavod2['vklady']+$vklad).' WHERE id = '.$id);
		$motor['palivo'] = $kluzak->motor['palivo'];
		if($skladp >= $spotreba) {
			$result = $Sql->q('UPDATE paliva_sklad set mnozstvi = '.floor($skladp-$spotreba).' WHERE staj = 0 AND login = '.UID.' AND palivo = '.$motor['palivo']);
		} else {
			$result = $Sql->q('UPDATE paliva_sklad set mnozstvi = 0 WHERE staj = 0 AND login = '.UID.' AND palivo = '.$motor['palivo']); 
			$result = $Sql->q('UPDATE paliva_sklad set mnozstvi = '.floor($skladp2-($spotreba-$skladp)).' WHERE staj = 1 AND login = '.$stajovnik['staj'].' AND palivo = '.$motor['palivo']); 
		}
        
        $opatrnost = $_POST['opatrnost'];
        if(!is_numeric($opatrnost)) $opatrnost = 50;
        $opatrnost = max(15,$opatrnost);
        $opatrnost = min(85,$opatrnost);
        
        $agresivita = $_POST['agresivita'];
        if(!is_numeric($agresivita)) $agresivita = 50;
        $agresivita = max(-100,$agresivita);
        $agresivita = min(100,$agresivita);
        
        $postoj = 0;
        if($agresivita < 0) $postoj = $_POST['postoj1'];
        if($agresivita > 0) $postoj = $_POST['postoj2'];
 
		$taktika = 3;
		if($agresivita < 0) $taktika = $_POST['taktika1'];
		if($agresivita > 0) $taktika = $_POST['taktika2'];
       
		if(!$_POST['obet']) $_POST['obet'] = 0;
		
		$result = $Sql->q('INSERT into zavodnici(login,zavod,opatrnost,agresivita,postoj,taktika,obet) values('.UID.','.$id.','.$opatrnost.','.$agresivita.','.$postoj.','.$taktika.','.$_POST['obet'].')');
		$result = $Sql->q('UPDATE postavy set penize = '.($penize-$vklad).' WHERE login = '.UID);
		finance(UID,$vklad,0,23);
		
		if($zavod2['login'] != 0 && $zavod2['login'] != UID) {
			$row4 = fa($Sql->q('SELECT posta_zavody2 FROM hraci WHERE id = '.$zavod2['login']));
			if($row4['posta_zavody2'] == 1) {
				$msg = 'Hráč [B]'.getNick(UID).'[/B] vstoupil do tvého závodu [B]'.$zavod2['nazev'].'[/B]
				
		SYSTEM';
				sendPosta(0,$zavod2['login'],$msg);
			}
		}
	
		$res4 = $Sql->q('SELECT * FROM sazky WHERE zavod = '.$id.' AND vyhra = -1');
		if(p($res4) > 0) {
			for($h=0;$h<p($res4);$h++) {
				$sazka = fa($res4);
				$sazka['sazka'] = round(0.9*$sazka['sazka']);
				$Sql->q('UPDATE postavy set penize = penize+'.$sazka['sazka'].' WHERE login = '.$sazka['login']);
				finance($sazka['login'],$sazka['sazka'],1,8);
				$Sql->q('DELETE FROM sazky WHERE id = '.$sazka['id']);
				$msg = 'Závod [B][O]'.$zavod_nazev.'[/O][/B], ve kterém sis vsadil na [B][O]'.($sazka['zavodnik'] == -1 ? 'nedojetí všech' : getNick($sazka['zavodnik']).'a').'[/O][/B], změnil sestavu a sázka byla zrušena. 
				
Zpět si dostal 90% vsazené částky ('.numF($sazka['sazka']).' Is).';
				sendPosta(0,$sazka['login'],$msg);
				$Sql->q('UPDATE zavody set sazky = '.($row['sazky']-$sazka['sazka']).' WHERE id = '.$id);
			}
		}

		$page->ext('USPESNE',1,0,array('id' => $id));
		konec();
	}
}
if($vklad > $penize) {
  	$fill['penize'] = numF($penize);
  	$fill['vklad'] = numF($vklad);
  	$page->ext('PENIZE',1,0,$fill);
	konec();
} else {
  	$fill['vklad'] = numF($vklad);
  	$fill['zbyde'] = numF($penize-$vklad);
	$fill['id'] = $id;
	$fill['heslo'] = ($row['heslo'] != "" ? $page->misc('HESLO') : '');
	
	$page->append('showTrat');

	$row = fa($Sql->q('SELECT trat FROM trate WHERE id = '.$row['trat']));
	$kusy = explode(',',$row['trat']);

	$usek1 = 20;
	$usek2 = 40;
	$usek3 = 60;
	$usek4 = 80;    
	
	$usek1r = 45;
	$usek2r = 60;
	$usek3r = 75;
	$usek4r = 90;  
	
	$result = $Sql->q('SELECT * FROM trate_druhy ORDER BY id ASC');
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$useky_info[$row['id']] = $row;
	}
	
	$barvy = Array();
	$barvy[5] = "#FF0000";
	$barvy[4] = "#FA6705";
	$barvy[3] = "#FFFF00";
	$barvy[2] = "#83AA0D";
	$barvy[1] = "#02FD09";	
	
	foreach($kusy as $i => $value) { 
		$danger = round($useky_info[$value]['nebezpeci']);
		$rychlost = $useky_info[$value]['rychlost'];
		
		$barva = 1;
		if($danger > $usek1) $barva = 2;
		if($danger > $usek2) $barva = 3;
		if($danger > $usek3) $barva = 4;
		if($danger > $usek4) $barva = 5;
		
		$barva2 = 1;
		if($rychlost < $usek4r) $barva2 = 2;
		if($rychlost < $usek3r) $barva2 = 3;
		if($rychlost < $usek2r) $barva2 = 4;
		if($rychlost < $usek1r) $barva2 = 5;
		
		$line['nazev'] = $useky_info[$value]['nazev'];
		$line['barva1'] = $barvy[$barva];
		$line['barva2'] = $barvy[$barva2];
		$line['nebezpeci'] = $danger.'%';
		$line['rychlost'] = $rychlost.'%';
	
		$celkem_d += $danger;
		$celkem_r += $rychlost;
		
		if(!$i) {
			$line['nebezpeci'] = '<strong>Nebezpečí</strong>';
			$line['rychlost'] = '<strong>Rychlost</strong>';	
			$line['barva1'] = "#FFFFFF";
			$line['barva2'] = $line['barva1'];
		}
		
		if(!isset($kusy[$i+1])) {
			$line['nebezpeci'] = '<strong>'.numFP($celkem_d/($i+1)).'%</strong>';
			$line['rychlost'] = '<strong>'.numFP($celkem_r/($i+1)).'%</strong>';	
			$line['barva1'] = "#FFFFFF";
			$line['barva2'] = $line['barva1'];
		}
		
		$data[] = $line;
	}
	
	$fill['trat'] = $page->getTable('USEKY2',$data);
			
	$taktika1_data = array();
	foreach($taktiky[1] as $tid => $taktika) {
		$line = array();
		$line['id'] = $tid;
		$line['nazev'] = $taktika;
		
		$taktika1_data[] = $line;
	}
	
	$taktika2_data = array();
	foreach($taktiky[3] as $tid => $taktika) {
		$line = array();
		$line['id'] = $tid;
		$line['nazev'] = $taktika;
		
		$taktika2_data[] = $line;
	}
	
	$fill['postoj1'] = $page->getTable('POSTOJ1', $jizdni_styly[1]);
	$fill['postoj2'] = $page->getTable('POSTOJ2', $jizdni_styly[3]);
			
	$fill['taktika1'] = $page->getTable('TAKTIKA1', $taktika1_data);
	$fill['taktika2'] = $page->getTable('TAKTIKA2', $taktika2_data);

	$result = $Sql->q('SELECT z.login as id, h.login as login FROM zavodnici as z LEFT JOIN hraci as h ON h.id = z.login WHERE z.zavod = '.$id);
	if(!p($result)) {
		$fill['obet'] = '';
	} else {
		$data = array();
		while($row = fa($result)) {
			if($row['id'] < 0) $row['login'] = getNick($row['id']);
			$data[] = $row;
		}
		
		$fill['obet'] = $page->getTable('OBET', $data);
	}

	####################################################

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
	
  	$page->ext('ORLY2',1,0,$fill);
	konec();
}
?>