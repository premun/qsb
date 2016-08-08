<?php

include 'getfunctions.php';

function is_logged() {
	global $Sql;
	
	if(UID == "") {
		do_header('Quadra Speed Boosters');
		$_SESSION['chyba'] = "Nejsi přihlášen";
		echo '<h3>Nejsi přihlášen</h3>';
		do_footer();
		exit;
	} else {
		$blokace = fa($Sql->q('SELECT * from sys WHERE entity = "stav_hry"'));
		if($blokace['val'] == 0 && $_SESSION['status'] != 42) {
			$_SESSION['chyba'] = 'Hra zablokována - probíhají úpravy';
			go('odhlas.php');
			exit;	
		}
	}
}

function db_down() {
	@include_once './cls/cPage.php';
	@$page = new cPage('index');
	@$page->swap('TITLE','- '.'Mysql is down');
	@$page->swap('ERROR','Mysql databáze mimo provoz');
	@$page->finish();
	
	echo 'Nepodařilo se navázat spojení a zdá se, že databáze je mimo provoz. Zkuste prosím znovu za pár minut. Omlouvám se za způsobené potíže.';
	
	@do_footer();
}

function do_file($title,$file) {	
	$page = new cPage($file);
	$page->swap('TITLE','- '.$title);		
	$page->swap('LOGO',getLogoId($title));		
	$page->swap('ERROR',$_SESSION['chyba']);
	
	$redirect = '';
	if(func_num_args() == 3) {
		$args = func_get_args();
		
		$redirect = '<meta http-equiv="refresh" content="0; URL='.$args[2].'" />';
	}
	$page->swap('REDIRECT',$redirect);
	
	$page->finish();
}

function RegKey($delka) {
	$znaky = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
	$key = '';
	for($i=0;$i<$delka;$i++) 
		$key .= $znaky[rand(1,strlen($znaky))];
		
	return $key;
}

function numF($number) {
	return number_format(floor($number), 0 , '.' , ' ');
}

function numFP($number) {
	return number_format($number, 2 , ',' , ' ');
}

function fuckDia($obsah) {
	$zameny = array('ě' => 'e', 'š' => 's', 'č' => 'c', 'ř' => 'r', 'ž' => 'z', 'ý' => 'y', 'á' => 'a', 'í' => 'i', 'é' => 'e', 'ď' => 'd', 'ť' => 't', 'ň' => 'n', 'ú' => 'u', 'ů' => 'u', 'ó' => 'o', 
					'Ě' => 'E', 'Š' => 'S', 'Č' => 'C', 'Ř' => 'R', 'Ž' => 'Z', 'Ý' => 'Y', 'Á' => 'A', 'Í' => 'I', 'É' => 'E', 'Ď' => 'D', 'Ť' => 'T', 'Ň' => 'N', 'Ú' => 'U', 'Ů' => 'U', 'Ó' => 'O');

	foreach($zameny as $puvodni => $novy)
		$obsah = str_replace($puvodni, $novy, $obsah);
	
	return $obsah;
}

function getQuestBar($proc) {
	return '<div style="width: 200px; height: 13px; background-color: #111; border: 1px solid #444; margin-top: 2px" title="'.$proc.'%"><div style="width: '.($proc*2).'px; height: 13px; background-color: #66CC00" title="'.$proc.'%"></div></div>';
}

function drawBar($proc) {
	global $id_baru;
	$popisek = $proc;
	if($proc > 100) $proc = 100;
	$proc = 100-$proc;
	if(!isset($id_baru)) $id_baru = 0;
	$id_baru++;
	return '<div title="'.round($popisek).'%" style="border: 1px solid #444444; font-size: 7px; height: 13px; width: 100px; background-image: url(skin/img/spectrum.jpg); background-repeat: no-repeat; text-align: right"><img alt="" src="skin/img/black.jpg" height="13" width="100" id="bar'.$id_baru.'" onload="fill('.round($proc).',\'bar'.$id_baru.'\')" /></div>';
}

function drawBarMini($proc) {
	$proc2 = $proc;
	$min = 0.65;
	if($proc*$min > 100*$min) $proc = 100*$min;
	$proc = 100*$min-$proc*$min;
	return '<div title="'.round($proc2).'%" class="minibar" style="width: '.(100*$min).'px"><img alt="'.round($proc2).'%" src="skin/img/black.jpg" style="width: '.round($proc).'px" /></div>';
}

function drawFlag($j,$d,$t) {
	$vlajka = '<span style="font-size: 11px;"><span style="background-color: '.$j.'">&nbsp;&nbsp;</span><span style="background-color: '.$d.'">&nbsp;&nbsp;</span><span style="background-color: '.$t.'">&nbsp;&nbsp;</span></span>';
	return $vlajka;
}

function drawFlag2($all) {
	$barvy = explode(',',$all);
	$j = $barvy[0];
	$d = $barvy[1];
	$t = $barvy[2];
	$vlajka = '<span style="font-size: 11px;"><span style="background-color: '.$j.'">&nbsp;&nbsp;</span><span style="background-color: '.$d.'">&nbsp;&nbsp;</span><span style="background-color: '.$t.'">&nbsp;&nbsp;</span></span>';
	return $vlajka;
}

function lastChange($datum) {
	$casti = explode('-',$datum);
	
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
	
	if(($today-$last) >= (3*86400)) {
		return true;
	} else {
		return false;
	}
}

function go($url) {
	if(jhadr()) return false;

	if(!headers_sent()) {
		header('Location: '.$url);
	} else {
		echo '
		<script language="JavaScript">
			<!--
				location = "'.$url.'";
			//-->
		</script>';
	}
}

function back() {
	if(headers_sent()) {
		echo '
			<script language="JavaScript">
			  history.back();
			</script>';
	} else {
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
}

function alert($msg) {
	echo '
	<script language="JavaScript">
	  alert("'.$msg.'");
	</script>';
}

function drawBack() {
	echo '<a onclick="history.back()" class="submit">Zpět</a>';
}

function noTags($str) {
	return str_replace('<','&lt;',str_replace('>','&gt;',$str));
}

function sendPosta($kdo,$komu,$msg) {
	if($komu < 0) return false;
	
	global $Sql;	
	$result = $Sql->q('INSERT into posta(kdo,komu,msg,cas,status) values('.$kdo.','.$komu.',"'.addslashes($msg).'",'.time().',0)');
	if($kdo && $kdo != $komu) $Sql->q('UPDATE stats set posta = posta+1 WHERE login = '.$komu);
	if(!result) return false;
	return true;
}

function finance($kdo,$kolik,$zmena,$typ) {
	global $Sql;
	$Sql->q('INSERT into finance(login,penize,zmena,typ,cas) values('.$kdo.','.$kolik.','.$zmena.','.$typ.','.time().')');
}


function fileName($text) {
	$text = fuckDia($text);
	$text = strtolower($text);
    
	$text = str_replace(' ','_',$text);
	
	$banned = ',./;"[]{}()?><:*-+!@#$%^&*|\'®';
	
    for($i=0;$i<strlen($banned);$i++)
  		$text = str_replace(substr($banned,$i,1),'',$text);
	
	while(strpos($text,'__')) $text = str_replace('__','_',$text);
	
	return $text;
}

function addQuest($login,$id,$questy) {
	global $Sql;
	
	if($login < 0) return;
	
	if(!is_array($questy)) {
		$hrac = fa($Sql->q('SELECT questy FROM stats WHERE login = '.$login));
		$questy = $hrac['questy'];
	}
	
	
	$kusy = @explode(',',$questy);
	if(!is_array($kusy)) {
		$Sql->q('UPDATE stats SET questy = "'.$id.'" WHERE login = '.$login);
		$Sql->q('UPDATE postavy set penize = penize + '.QUEST_ODMENA.' WHERE login = '.$login);
		finance($login,QUEST_ODMENA,1,42);
		return $questy;
	} 
	
	if(!in_array($id,$kusy)) {
		$questy .= ','.$id;
		$Sql->q('UPDATE stats SET questy = "'.$questy.'" WHERE login = '.$login);
		$Sql->q('UPDATE postavy set penize = penize + '.QUEST_ODMENA.' WHERE login = '.$login);
		finance($login,QUEST_ODMENA,1,42);
		return $questy;
	}
	
	return $questy;
}

function etapa($action) {
	global $Sql,$etapy;

	$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "restart"'));
	$restart = $result['val'];
	
	if($action == 'next') {
		$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
		$etapa = $result['val'];
	
		if($etapa > 4) return 0;
	
		return date('j.n.',$restart+$etapy[$etapa+1]*60*60*24);
	} else {
		return date('j.n.',$restart+$etapy[$action]*60*60*24);
	}
}

function spion($s, $zavodnik) {	
	global $Sql, $jizdni_styly, $taktiky;
	
	if($s < 10) {
		$spion_vety = array();
		$spion_vety[] = "Buď mi nabídni víc, nebo táhni!";
		$spion_vety[] = "Když někdo chce mé služby, měl by počítat s tím, že budou drahé. Když někdo chce mé služby a nechce mi dost zaplatit - měl by počítat s tím, že pošlu psy!";
		$spion_vety[] = "Hele, jestli na to nemáš a proto mi nabízíš tak málo, tak si příště ty peníze nech a radši si kup něco hezkýho na sebe.";
		$spion_vety[] = "Za takovou almužnu by s tebou nešla ani nejlevnější Myriada strávit noc plnou lásky - tak proč já bych měl?";
		$spion_vety[] = "Podívej, vysvětlím ti jak to tady chodí - ty mi ty peníze dáš a budeš rád, že tě nestřelím do zad až budeš odcházet - příště nabídni víc!";
		$spion_vety[] = "Sorry, pro chudý nedělám - buď mi k tomu přidej aspoň jednu tvoji hnátu, nebo to nepůjde.";
		$spion_vety[] = "Nenene, tak takhle by to nešlo... Přidej!";
		$spion_vety[] = "Tak s tímhle na mě nechoď - prodej třeba orgán, ale vrať se s prachama a ne s drobákama!";
		$spion_vety[] = "Tak málo? Za koho mě máš? Za dobráka? Já sem elita ty šušňo - VYPADNI! VYPADNI ODTUD!";
		$spion_vety[] = "Myslím, že by is zasloužil vylískat když neumíš číst můj ceník - je tam jenom jedna položka - HODNĚ!";
		$spion_vety[] = "Řeknu ti to na rovinu - nemám tě rád - takže pro tebe dělat nebudu. A nebo dej příště víc.";
		$spion_vety[] = "Radši nenabízej tak málo lidem, kteří chtějí mít dobře zaplaceno - mohl by si je naštvat.";
		$spion_vety[] = "Za ty peníze co mi tu nabízíš chceš vanilkovou nebo citronovou?";
		$spion_vety[] = "Teď zavřu oči a až je otevřu, tak ať je tu na stole víc peněz!";
		$spion_vety[] = "Promiň, ve škole mě neučili počítat tak malá čísla - přidej!";
		$spion_vety[] = "Zahrajame si hru - ty nabídneš víc a já ti řeknu, jestli to beru nebo ne - začni.";
		$spion_vety[] = "Otevři pusu prosím - pokud máš zlaté zuby, dorovnáme pravou cenu mých služeb jima - nebo mužeš odejít.";
		$spion_vety[] = "Nemám teď čas na blbé žerty.";
		$spion_vety[] = "I když nerad, ale musím přiznat, že si mě rozesmál svojí nabídkou. I za kefír dám v obchodě víc než mi tu nabízíš ty!";
		$spion_vety[] = "Já riskuji svůj žiota abych ty informace získal a ty mi tu teda tvrdíš že můj život je tak levný? Chceš vědět jak je drahý ten tvůj život?";
		$spion_vety[] = "Dobře, dobře. Za těch pár šušňů ti prozradím tuhle tajnou informaci. Ten závod se pojede. Příště nabídni víc.";
		
		$msg = "Nezaplatil si dostatečnou sumu a špión ti vzkazuje:\n\n[I]\"".$spion_vety[rand(0,count($spion_vety))]."\"[/I]";
		$msg .= "\n\nSYSTEM";
	
		return $msg;
	}

	$zavodnik = fa($Sql->q('SELECT * FROM zavodnici WHERE id = '.$zavodnik));
	$zavod = fa($Sql->q('SELECT * FROM zavody WHERE id = '.$zavodnik['zavod']));
	
	$opatrnost = $zavodnik['opatrnost'];
	$opatrnost *= 1+(rand(0,10)/10-0.5)*(100-$s)/100;
	$opatrnost = min(round($opatrnost), 100);
	
	$agresivita = $zavodnik['agresivita'];
	$agresivita *= 1+(rand(0,8)/10-0.4)*(100-$s)/100;					
	$agresivita = min(round($agresivita), 100);
	$agresivita = max(round($agresivita),-100);
	
	$msg = "Špión ti posílá aktualizaci informací, které se mu podařilo vypátrat.\n\n";
	$msg .= "[O]Závod:[/O] <a href=\"showRace.php?id=".$zavodnik['zavod']."\">".$zavod['nazev']."</a>\n";
	$msg .= "[O]Závodník:[/O] <a href=\"showProfile.php?id=".$zavodnik['login']."\">".getNick($zavodnik['login'])."</a>\n";
	$msg .= "[S]-----------------------------[/S]\n";
	$msg .= "[O]Opatrnost:[/O]  ".(rand(25,63) < $s ? $opatrnost."%"  : 'nezjištěno')."\n";
	$msg .= "[O]Agresivita:[/O] ".(rand(20,52) < $s ? $agresivita."%" : 'nezjištěno')."\n";
	$msg .= "[S]-----------------------------[/S]\n";
	$msg .= "[O]Postoj:[/O] ".(rand(45,86) < $s ? ($agresivita == 0 ? '---' : $jizdni_styly[($agresivita < 0 ? 1 : 3)][$zavodnik['postoj']]['nazev']) : 'nezjištěno')."\n";
	$msg .= "[O]Taktika:[/O] ".(rand(35,77) < $s ? ($agresivita == 0 ? '---' : $taktiky[($agresivita < 0 ? 1 : 3)][$zavodnik['taktika']]) : 'nezjištěno')."\n";
	$msg .= "[O]".($agresivita < 0 ? 'Očekávaný útočník' : 'Preferovaný cíl').":[/O] ".($agresivita == 0 ? '---' : (rand(52,91) < $s ? ($zavodnik['obet'] == 0 ? 'nespecifikováno' : getNick($zavodnik['obet'])) : 'nezjištěno'));

	$msg .= "\n\nSYSTEM";
	
	return $msg;
}

function textFormat($zprava) {
	global $ascii_smiles;

	foreach(array('B' => '<strong>',
				  '/B' => '</strong>',
				  'I' => '<span style="font-style: italic">',
				  'O' => '<span class="extra">',
				  'S' => '<span class="ultra">',
				  'U' => '<span style="text-decoration: underline">',
				  'R' => '<span style="color: #CA0B0B">',
				  'G' => '<span style="color: #00CC00">',
				  'M' => '<span style="color: #224AEA">') as $char => $sub) {
		$zprava = str_replace('['.$char.']', $sub, $zprava);		
	}
	
	foreach(explode(',', 'I,O,S,U,R,G,M') as $char) {
		$zprava = str_replace('[/'.$char.']', '</span>', $zprava);
	}
	
	for($j=1;$j<15;$j++) {
		$zprava = str_replace('[SM'.$j.']','<img src="./skin/img/smiles/'.$j.'.gif" style="vertical-align: middle" height="20" alt="[SM'.$j.']" onclick="vlozTagy(\'[SM'.$j.']\',\'\')" >',$zprava);
		
		foreach($ascii_smiles[$j] as $smile) 
			$zprava = str_replace($smile, '<img src="./skin/img/smiles/'.$j.'.gif" style="vertical-align: middle" height="20" alt="[SM'.$j.']" onclick="vlozTagy(\'[SM'.$j.']\',\'\')" >',$zprava);
	}
	
	return $zprava;
}

function konec() {
	if(!jhadr()) exit;
}


	
function pridatBota($zavod, $sablona, $rasa, $agresivita, $opatrnost, $postoj, $taktika) {
	global $Sql, $tabs;
	
	$bot = fa($Sql->q('SELECT * FROM boti_jmena ORDER BY RAND() ASC'));
	$sablona = fa($Sql->q('SELECT * FROM boti_kluzaky WHERE id = '.$sablona));
	$cena = $sablona['cena'];
	
	$prestiz = rand(700+50*$cena, 1150+70*$cena);
	$celkem = rand(3*$cena, 8*$cena);
	$treti = rand(0, ceil($celkem*0.6));
	$druhy = max(0, rand(0, min(ceil($celkem*0.5), $celkem-$treti)));
	$prvni = max(0, rand(0, min(ceil($celkem*0.3), $celkem-$treti-$druhy)));
	
	$vyhry = $celkem.'-'.$prvni.'-'.$druhy.'-'.$treti;
	
	$Sql->q('INSERT into boti(login, rasa, kluzak, prestiz, vyhry) values('.$bot['id'].', '.$rasa.','.$sablona['id'].','.$prestiz.',"'.$vyhry.'")');
	
	$bot = fa($Sql->q('SELECT * FROM boti ORDER BY id DESC LIMIT 0,1'));
	$id = -1*$bot['id'];
	
	if(count($tabs) == 11) array_pop($tabs);
	foreach($tabs as $i => $tab) {
		if(!$sablona[$tab]) continue;
		
		$predmet = fa($Sql->q('SELECT vydrz FROM '.$tab.' WHERE id = '.$sablona[$tab]));
		$predmet2 = fa($Sql->q('SELECT cena FROM zbozi WHERE typ = '.$i.' AND zbozi = '.$sablona[$tab]));
		
		$Sql->q('INSERT into sklad(login, typ, zbozi, vydrz, cena, cena2, umisteni)
							values('.$id.', '.$i.', '.$sablona[$tab].', '.$predmet['vydrz'].', '.$predmet2['cena'].', 0, 1)');
	}	
	
	$Sql->q('INSERT into zavodnici(login,zavod,opatrnost,agresivita,postoj,taktika,obet) values('.$id.', '.$zavod.', '.$opatrnost.', '.$agresivita.', '.$postoj.', '.$taktika.', 0)');
	
	$res = $Sql->q('SELECT * FROM sazky WHERE zavod = '.$zavod.' AND vyhra = -1');
	while($sazka = fa($res)) {
		$sazka['sazka'] = round(0.9*$sazka['sazka']);
		$Sql->q('UPDATE postavy set penize = penize+'.$sazka['sazka'].' WHERE login = '.$sazka['login']);
		finance($sazka['login'],$sazka['sazka'],1,8);
		$Sql->q('DELETE FROM sazky WHERE id = '.$sazka['id']);
		$msg = 'Závod [B][O]'.$zavod_nazev.'[/O][/B], ve kterém sis vsadil na [B][O]'.($sazka['zavodnik'] == -1 ? 'nedojetí všech' : getNick($sazka['zavodnik']).'a').'[/O][/B], změnil sestavu a sázka byla zrušena.
		
Zpět si dostal 90% vsazené částky ('.numF($sazka['sazka']).' Is).';
		sendPosta(0,$sazka['login'],$msg);
		$Sql->q('UPDATE zavody set sazky = sazky-'.$sazka['sazka'].' WHERE id = '.$zavod);
	}
}
?>