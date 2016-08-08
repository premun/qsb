<?php

include 'library.php';
is_logged();
$action = $_GET['action'];

if($action == 'zvetsit_sklad') {
	$row = fa($Sql->q('SELECT sklad FROM postavy WHERE login = '.UID));
	
	$velikost = 0;
	$cena2 = 0;
	
	foreach($sklady_paliv as $vel => $cena) {
		if($vel > $row['sklad']) {
			$velikost = $vel;
			$cena2 = $cena;
			break;
		}
	}
	
	if($velikost == 0) {
		$_SESSION['chyba'] = 'Už máš největší možnou licenci';
		go('obchod.php?action=paliva');
		exit;
	}
	
	if(getPenize(UID) > $cena2) {
		$Sql->q('UPDATE postavy set penize = penize-'.$cena2.', sklad = '.$velikost.' WHERE login = '.UID);	
		finance(UID,$cena2,0,41);	
		$_SESSION['chyba'] = 'Licence zakoupena';
		go('obchod.php?action=paliva');
		exit;		
	} else {
		$_SESSION['chyba'] = 'Nemáš dostatek peněz';
		go('obchod.php?action=paliva');
		exit;	
	}
}

if($_GET['soucastka'] != '') {
	$soucastka = $_GET['soucastka'];
} else {
	$soucastka = 0;
}

do_header('Obchod');

$page = new cPage('obchod');
$page->setCommon('MAIN');

$fill['vyloha_min'] = MIN_VYLOHA_CENA;
$fill['vyloha_max'] = MAX_VYLOHA_CENA;

if($action == 'casti') {
	$page->misc('CASTI','OBSAH');

	$result = $Sql->q('SELECT * FROM obchodnici ORDER BY ID ASC');
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
	
		$obch_name = explode(' - ',$row['nazev']);
	
		$line['id'] = $row['id'];
		$line['nazev'] = $obch_name[0];
		$line['typ'] = $obch_name[1];
		$line['rasa'] = getRasaNazev($row['rasa']);

		$data[] = $line;
	}
	
	$page->getTable('OBCHODNICI',$data,'OBCHODNICI');
	
	$fill['action'] = $_GET['action'];
	
    $kategorie[1] = "Podvozky";
    $kategorie[2] = "Motory";
    $kategorie[3] = "Energodržáky";
    $kategorie[4] = "Chladiče";
    $kategorie[5] = "Palubní desky";
    $kategorie[6] = "Brzdy";
    $kategorie[7] = "Zdroje";
    $kategorie[8] = "Pancéřování";
    $kategorie[9] = "Suspenzory";
    $kategorie[10] = "Přídavné motory";
    $kategorie[11] = "Opravní droidi";
	
	$data = array();
	
	for($i=1;$i<12;$i++)
		$data[] = array('value' => $i, 'checked' => ($soucastka == $i ? ' selected="selected"' : ''), 'nazev' => $kategorie[$i]);
	
	$page->getTable('FILTER',$data,'FILTER');
	
	$result = $Sql->q('SELECT DISTINCT s.login as login, h.login as nick, s.typ as typ, p.rasa as rasa, COUNT(s.zbozi) as pocet FROM sklad as s LEFT JOIN hraci as h ON h.id = s.login LEFT JOIN postavy as p ON p.login = s.login WHERE umisteni = 2'.($soucastka == 0 ? '' : ' AND s.typ = '.$soucastka).' AND s.login != '.UID.' GROUP BY s.login ORDER BY pocet DESC, p.rasa DESC');

	if(p($result) == 0) {
		$page->misc('ZADNI_HRACI','HRACI');
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}
	
	$data = array();
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$row['rasa'] = getRasaNazev($row['rasa']);
		$row['nick'] = str_replace(' ','&nbsp;',$row['nick']);
		$row['cena'] = numF($row['cena']);
		$row['typ'] = $soucastka;
		
		$data[] = $row;
	}
	
	$page->getTable('HRACI',$data,'HRACI');
	$page->fill($fill);
	$page->finish();
	do_footer();
	exit; 
}

if($action == 'paliva') {	
	$page->misc('PALIVA','OBSAH');
	
	$velikost = fa($Sql->q('SELECT sklad FROM postavy WHERE login = '.UID));
	$fill['zvetsit'] = '';
	$fill['zvetseni'] = '';
	$fill['zvetseni2'] = '';
	$fill['velikost'] = numF($velikost['sklad']);
	
	foreach($sklady_paliv as $vel => $cena) {
		if($vel > $velikost['sklad']) {
			$page->misc('ZVETSIT','ZVETSIT');
			$fill['zvetseni'] = numF($vel);
			$fill['zvetseni2'] = numF($cena);
			break;
		}
	}
	
	$res48 = $Sql->q('SELECT * FROM sklad WHERE umisteni = 1 AND login = '.UID.' AND typ = 2');
	
	$fill['muj_motor'] = '';
	
	if(p($res48) != 0) {
		$row = fa($res48);
		
		$row = fa($Sql->q('SELECT * from motory WHERE id = '.$row['zbozi']));
		$result = $Sql->q('SELECT * from paliva_ceny WHERE id = '.$row['palivo']);
		$row = fa($result);
		$zmena = $row['stala_cena']-$row['cena'];
		if($zmena < 0) {
			$zmena2 = $page->misc('ZMENA1',0,array('zmena' => numFP(abs($zmena))));
		} elseif($zmena > 0) {
			$zmena2 = $page->misc('ZMENA2',0,array('zmena' => numFP($zmena)));
		} elseif($zmena == 0) {
			$zmena2 = numFP($zmena);
		}
		
		$fill1['id'] = $row['id'];
		$fill1['zmena'] = $zmena2;
		$fill1['nazev'] = $row['nazev'];
		$fill1['cena'] = numFP($row['cena']);
		
		$page->misc('MUJ_MOTOR','MUJ_MOTOR',$fill1);
	}
	
	$result = $Sql->q('SELECT * from paliva_ceny ORDER BY id ASC');	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$zmena = $row['stala_cena']-$row['cena'];
		if($zmena < 0) {
			$zmena2 = $page->misc('ZMENA1',0,array('zmena' => numFP(abs($zmena))));
		} elseif($zmena > 0) {
			$zmena2 = $page->misc('ZMENA2',0,array('zmena' => numFP($zmena)));
		} elseif($zmena == 0) {
			$zmena2 = numFP($zmena);
		}
		
		$line['id'] = $row['id'];
		$line['nazev'] = $row['nazev'];
		$line['cena'] = numFP($row['cena']);
		$line['zmena'] = $zmena2;
		
		$data[] = $line;
	
	}
	
	$page->getTable('PALIVA2',$data,'PALIVA');
	
	$page->fill($fill);
	$page->finish();
	do_footer();
	exit;
}

if($action == 'sklad' || $action == 'vyloha') {

	if($action == 'vyloha') {	
		$and = 'AND umisteni = 2 ';
		$star = "login, cena2 as cena, cena2 as cena3, umisteni, id, typ, zbozi, vydrz";
	} else {
		$Sql->q('UPDATE sklad set umisteni = 0, cena2 = 0 WHERE login = '.UID.' AND umisteni > 10000 AND umisteni < '.time());
		$star = "login, cena as cena, cena2 as cena3, umisteni, id, typ, zbozi, vydrz";
	}
	$result = $Sql->q('SELECT * from sklad WHERE login = '.UID);
	if(p($result) == 0) {
		$result2 = $Sql->q('SELECT * from paliva_sklad WHERE login = '.UID);
		$nothing1 = true;
		if(p($result2) == 0) {
			$page->swap('OBSAH','');
			$page->ext('PRAZDNY_SKLAD',1,0,array('obsah' => ''));
			exit;
		}
	}
	
	$page->misc(($action == 'sklad' ? 'SKLAD' : 'VYLOHA'),'OBSAH');

	$fill['predmety'] = '';
	
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
    $names[11] = "Opravní droidi";

	$rasa = getRasa(UID);
	
	for($j=1;$j<12;$j++) {  
		$result = $Sql->q('SELECT '.$star.' FROM sklad WHERE login = '.UID.' '.$and.'AND typ = '.$j);
	
		if(p($result) > 0) {
		
			$line['pic'] = str_replace(' ','_',strtolower(trim(fuckDia($names[$j]))));
			$line['j'] = $j;
			$line['nazev'] = $names[$j];
			
			$data2 = array();
			
			for($i=0;$i<p($result);$i++) {
				$zbozi = fa($result);
				$p = new cItem($zbozi['zbozi'],$zbozi['typ']);
				
				$line2['id'] = $p->id;
				$line2['typ'] = $p->typ2;
				
				if($zbozi['typ'] == 1) {
					$line2['typ2'] = ($p->typ ? '('.substr('SCW', $p->typ-1, 1).')' : '');
				} else {
					$line2['typ2'] = ($p->podvozek ? '('.substr('SCW', $p->podvozek-1, 1).')' : '');				
				}
				
				$line2['nazev'] = str_replace(' ','&nbsp;',$p->nazev);
				
				if($zbozi['umisteni'] > 10000 && $p->typ != 11) {
					$zbyva = $zbozi['umisteni']-time();
					$max_delka = getOpravaCas(0,$rasa['o'])-time();
					$line2['vydrz'] = drawBarMini(100-$zbyva/$max_delka*100);
				} else {
					$line2['vydrz'] = drawBarMini($zbozi['vydrz']/$p->vydrz*100);				
				}	
				
				$line2['cena'] = numF($zbozi['cena']);
						
				if($zbozi['umisteni'] == 0) {
				
					$line2['akce'] = '<td style="text-align: right; padding-right: 8px;"><span id="status_'.$zbozi['id'].'"><a><span class="submit" onclick="jHadr(\'vyloha.php\', {id: \''.$zbozi['id'].'\', vyloha: \'true\', action: \'nastav_cenu\', cena: \''.round($zbozi['cena']*($zbozi['vydrz']/$p->vydrz)).'\'})">Výloha</span></a>'.($j != 11 ? '&nbsp;/&nbsp;<a class="submit" onclick="predmet('.$zbozi['id'].',\'in\')">Kluzák</a>' : '');
					
					if($zbozi['vydrz'] < $p->vydrz && $j != 11) {			
						$cas = getOpravaCas(round($zbozi['vydrz']/$p->vydrz*100),$rasa['o']);
						$cas = max($cas, 0);
						$delka = $cas-time();
						$box = 'Oprava potrvá '.($delka/60 > 59 ? floor($delka/3600).'h ' : '').round($delka/60-floor($delka/3600)*60).'min '.($delka%60).'s<br /><span>('.date('H:i j.n.',$cas).')</span>';
						
						$line2['akce'] .= '&nbsp;/&nbsp;<a href="repair.php?id='.$zbozi['id'].'" onmousemove="showBox(\''.$box.'\',event)" onmouseout="hideBox()">Oprav</a>';
					}
				
					$line2['akce'] .= '&nbsp;/&nbsp;<a class="submit" onclick="jHadr(\'srot.php?id='.$zbozi['id'].'\', {})">Šrot</a></span></td>';
				} elseif($zbozi['umisteni'] == 2) {
				
					$line2['akce'] = '<td style="text-align: right; padding-right: 8px;"><span id="status_'.$zbozi['id'].'"><a><span class="submit" onclick="jHadr(\'vyloha.php\', {id: \''.$zbozi['id'].'\', vyloha: \'false\', action: \''.$_GET['action'].'\', cena: \''.round($zbozi['cena']*($zbozi['vydrz']/$p->vydrz)).'\'})">Pryč z výlohy('.numF($zbozi['cena3']).' Is)</a></span></td>';  
				} elseif($zbozi['umisteni'] == 1) {
				
					$line2['akce'] = '<td style="text-align: right; padding-right: 8px; color: #656565; cursor: default"><span id="status_'.$zbozi['id'].'">Část kluzáku&nbsp;/&nbsp;<a class="submit" onclick="predmet('.$zbozi['id'].',\'out\')">Vyndat</a></span></td>';
				} elseif($zbozi['umisteni'] < 0) {
				
					$line2['akce'] = '<td style="text-align: right; padding-right: 8px; color: #656565; cursor: default"><span id="status_'.$zbozi['id'].'"><a href="opravar.php?id='.$zbozi['id'].'&action=zrusit">Zrušit&nbsp;smlouvu</a></span></td>';
				} elseif($zbozi['umisteni'] > 10000) {
					$delka = $zbozi['umisteni']-time();
					
					$hodiny = ($delka/60 > 59 ? (floor($delka/3600) < 10 ? '0'.floor($delka/3600) : floor($delka/3600)).':' : '');
					$minuty = (round($delka/60-floor($delka/3600)*60) < 10 ? '0'.floor($delka/60-floor($delka/3600)*60) : floor($delka/60-floor($delka/3600)*60));
					$sekundy = ($delka%60 < 10 ? '0'.$delka%60 : $delka%60);
					
					if($p->typ != 11) {
						$line2['akce'] = '<td style="text-align: right; padding-right: 8px; cursor: pointer" onmouseover="this.innerHTML=\'<a href=\\\'repair.php?action=cancel&id='.$zbozi['id'].'\\\'>Zrušit&nbsp;opravu</a>&nbsp;&nbsp;'.$hodiny.$minuty.':'.$sekundy.'\'" onclick="location=\'repair.php?action=cancel&id='.$zbozi['id'].'\'"><span class="ultra">Probíhá&nbsp;oprava&nbsp;</span><span class="casovac" rel="'.$delka.'">'.$hodiny.$minuty.':'.$sekundy.'</span></td>';
					} else {
						$line2['akce'] = '<td style="text-align: right; padding-right: 8px"><span class="ultra">Droid&nbsp;opravuje&nbsp;</span>'.$hodiny.$minuty.':'.$sekundy.'</td>';					
					}
				}
				
				$vyherni = $Sql->q('SELECT id FROM zavody WHERE vitez = 0 AND login = '.UID.' AND predmet = '.$zbozi['id']);
				if(p($vyherni)) {
					$zavod = fa($vyherni);
					$line2['akce'] = '<td style="text-align: right; padding-right: 8px"><a href="showRace.php?id='.$zavod['id'].'" class="ultra">-výherní předmět-</a></td>';
				}				
				
				$data2[] = $line2;				
			}
						
			$line['predmety'] = $page->getTable('PREDMETY',$data2);			
			$data[] = $line;
		}
	}
	
	$page->getTable('TYP',$data,'PREDMETY');
	
	if($action == 'vyloha') {
		$page->swap('PALIVA','');
		$page->misc('PRAZDNA_VYLOHA','PREDMETY');
		
		$zmena = fa($Sql->q('SELECT vyloha FROM postavy WHERE login = '.UID));
		
		$page->misc(($zmena['vyloha'] ? 'SKRYT_VYLOHU' : 'ZOBRAZIT_VYLOHU'),'ZMENA');
		
		$page->fill($fill);
		$page->finish();
		do_footer();
		exit;
	}	
	
	$result = $Sql->q('SELECT palivo,mnozstvi FROM paliva_sklad WHERE staj = 0 AND login = '.UID.' AND mnozstvi >= 1 ORDER BY palivo ASC');
			
	if(p($result) > 0) {
		$jednotky = getJednotky();
		
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			$palivo = getPalivoAll($row['palivo']);
			
			$line3['id'] = $row['palivo'];
			$line3['nazev'] = $palivo['nazev'];
			$line3['mnozstvi'] = numF($row['mnozstvi']);
			$line3['jednotka'] = $jednotky[$row['palivo']];
			$line3['cena'] = numFP($palivo['cena']);

			$data3[] = $line3;
		}
	} else {
		if($nothing1) {
			$page->swap('PREDMETY','');
			$page->swap('PALIVA','');
			$page->ext('PRAZDNY_SKLAD',1,0,array('obsah' => ''));
			exit;
		}
	}
	
	$page->getTable('PALIVA',$data3,'PALIVA');

	$page->swap('PALIVA','');

	$page->fill($fill);
	$page->finish();
	do_footer();
}

if($action == 'opravari') {
	$page->misc('OPRAVARI','OBSAH');
	
	$result = $Sql->q('SELECT h.login as nick, h.id as login, h.cas as cas, o.procenta as procenta, o.minimum as minimum FROM opravari as o LEFT JOIN hraci as h ON h.id = o.login ORDER BY h.cas DESC');
	
	if(!p($result)) {
		$fill['opravari'] = '<br />Zatím žádní registrovaní opraváři<br /><br />';
	} else {
	
		$data = array();
		$opravar = false;
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			$line = $row;
			
			if($row['login'] == UID) {
				$opravar = true;
				$fill['procenta'] = $row['procenta'];
				$fill['minimum'] = $row['minimum'];
			}
			
			$last = time()-$row['cas'];
			
			$cas = 'Právě online';
			
			if($last > 60*15) $cas = 'Před '.floor($last/60).' minutami';
			if($last > 60*60) $cas = 'Před '.floor($last/3600).' hodinami';
			if($last > 60*60*24) $cas = 'Před '.floor($last/3600/24).' dny';
			
			$line['droidi1'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.$row['login'].' AND typ = 11 AND umisteni < '.time()));
			$line['droidi2'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.$row['login'].' AND typ = 11'));
			
			$line['minimum'] = ($line['minimum'] == 0 ? '<div style="text-align: center">žádné</div>' : numF($line['minimum']).' Is');
			$line['online'] = $cas;
			$data[] = $line;
		}
		
		$page->getTable('OPRAVARI',$data,'OPRAVARI');
	}
	
	$fill['opravar_registrace'] = numF(OPRAVAR_REGISTRACE);
	$fill['opravar_zmena'] = numF(OPRAVAR_ZMENA);
	$fill['opravar_denne'] = numF(OPRAVAR_DENNE);
	
	if($opravar) {
		$page->misc('ZMENA_REGISTRACE','REGISTRACE');
		
		$result = $Sql->q('SELECT h.login as nick, s.login as login, s.id as id, s.cena2 as penize FROM sklad as s LEFT JOIN hraci as h ON h.id = s.login WHERE s.umisteni = '.(-1*UID));
		
		if(!p($result)) {
			$fill['smlouvy'] = '<br />Nemáš žádné otevřené smlouvy';
		} else {		
			$data = array();
			for($i=0;$i<p($result);$i++) {
				$row = fa($result);
				$line = $row;
				$line['penize'] = numF($row['penize']);
				$data[] = $line;
			}	
			$page->getTable('SMLOUVY',$data,'SMLOUVY');
		}		
	} else {
		$page->misc('REGISTRACE','REGISTRACE');	
	}
	
	$page->fill($fill);
	$page->finish();
	do_footer();
}

if($action == 'sablony') {
	$page->append('sablony');
	$page->misc('OBCHOD','OBSAH');
	
	$Sql->q('UPDATE sklad set umisteni = 0, cena2 = 0 WHERE login = '.UID.' AND umisteni > 10000 AND umisteni < '.time());
	
	$result = $Sql->q('SELECT id, nazev FROM sablony WHERE login = '.UID.' ORDER BY nazev ASC');
	
	if(p($result)) {
		$data = array();
		for($i=0;$i<p($result);$i++) {
			$data[] = fa($result);
		}		
		$page->getTable('SABLONY', $data, 'SABLONY');
		
	} else {
		$page->misc('ZADNE_SABLONY', 'SABLONY');		
	}
	
	$page->fill($fill);
	$page->finish();
	do_footer();
}
?>