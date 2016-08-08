<?php

include 'library.php';
is_logged();
$start = $_GET['start'];
if($start == '' || $start < 0) $start = 0;
define("LIMIT",45);
define("LIMIT2",30);
define("LIMIT3",70);
do_header('Přehledy');

$page = new cPage('prehledy');

if($_GET['action'] == 'hraci') {
	
	$page->misc('HRACI','OBSAH');

	$sc = $_GET['sc'];
	if($sc == '') {
		$sc = 'asc';
		$sc2 = 'desc';
	} elseif($sc == 'desc') {
		$sc2 = 'asc';
	}
	$by = $_GET['by'];
	if($by == '') $by = 'id';
	$by = 'hraci.'.$by;
	$res2 = $Sql->q('SELECT id, nazev FROM rasy ORDER BY id ASC');
	
	for($i=0;$i<p($res2);$i++) {
		$row3 = fa($res2);
		$rasy[$row3['id']] = $row3['nazev'];
	}
	
	$result = $Sql->q('SELECT hraci.id as id, hraci.login as login, postavy.rasa as rasa, hraci.cas as cas FROM hraci,postavy WHERE hraci.status > 0 AND postavy.login = hraci.id ORDER BY '.$by.' '.$sc.' LIMIT '.$start.','.LIMIT);
	if(p($result) == 0) {
		$page->misc('ZADNI','PREHLED');
		$page->swap('SIPKY','');
		$page->finish();
		do_footer();
		konec();
	}
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$row['login'] = str_replace(' ','&nbsp;',$row['login']);
		$row['rasa'] = $rasy[$row['rasa']];
		$row['casik'] = date('H:i',$row['cas']).',&nbsp;'.str_replace(date('j.n.',time()-60*60*24),'Včera',str_replace(date('j.n.'),'Dnes',date('j.n.',$row['cas'])));
		$row['poradi'] = $start+$i+1;
		$data[] = $row;
	}
	
	$page->getTable('HRACI',$data,'PREHLED');
	
	#------------ SIPECKY!---------------#
	if($start > 0) {
		$dil1 = '<a href="prehledy.php?action=hraci&sc='.$_GET['sc'].'&by='.$_GET['by'].'">&lt;&lt;</a> | <a href="prehledy.php?action=hraci&sc='.$_GET['sc'].'&by='.$_GET['by'].'&start='.($start-LIMIT).'">&lt;</a>';
	}
	$result = $Sql->q('SELECT * from hraci WHERE status > 0');
	$all = p($result);
	if($all > ($start+LIMIT)) {
		$dil2 = '<a href="prehledy.php?action=hraci&sc='.$_GET['sc'].'&by='.$_GET['by'].'&start='.($start+LIMIT).'">&gt;</a> | <a href="prehledy.php?action=hraci&sc='.$_GET['sc'].'&by='.$_GET['by'].'&start='.($all-LIMIT).'">&gt;&gt;</a>';
	}
	
	if($dil1 != '' || $dil2 != '') {
		$sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
	}
	#------------ SIPECKY!---------------#
	
	$page->swap('SC',$sc2);
	$page->swap('SIPKY',$sipky);
}


if($_GET['action'] == 'ladder') {
	$page->misc('ZEBRICEK','OBSAH');

	if($_GET['order'] != 'prestiz') {
		$result = $Sql->q('SELECT p.login, p.prvni as prvni, p.druhy, p.treti, p.zavody, p.prestiz, h.login as jmeno, h.id as id FROM postavy as p LEFT JOIN hraci as h ON h.id = p.login WHERE h.status > 0 ORDER BY p.prvni DESC, p.druhy DESC, p.treti DESC, p.zavody DESC, p.prestiz DESC LIMIT '.$start.','.LIMIT2);
		$prestiz = "&order=prestiz";
	} else {
		$result = $Sql->q('SELECT p.login, p.prvni, p.druhy, p.treti, p.zavody, p.prestiz, h.login as jmeno, h.id as id FROM postavy as p LEFT JOIN hraci as h ON h.id = p.login WHERE h.status > 0 ORDER BY p.prestiz DESC, p.prvni DESC, p.druhy DESC, p.treti DESC, p.zavody DESC LIMIT '.$start.','.LIMIT2);
		$prestiz2 = "&order=prestiz";
	}
	
	if(p($result) == 0) {
		$page->misc('ZADNI','PREHLED');
		$page->swap('SIPKY','');
		$page->finish();
		do_footer();
		konec();
	}	

	for($i=0;$i<p($result);$i++) {
		$hrac = fa($result);
		$vlajka = getFlag($hrac['id']);
		$hrac['jmeno'] = ($vlajka == '' ? str_repeat('&nbsp;', 6) : $vlajka).str_replace(' ', '&nbsp;', $hrac['jmeno']);
		$hrac['misto'] = ($i+$start+1);
		$data[] = $hrac;
	}
	
	$page->getTable('ZEBRICEK',$data,'PREHLED');
	$page->swap('START',$start);
	$page->swap('PRESTIZ',$prestiz);
	
	#------------ SIPECKY!---------------#
	if($start > 0) {
		$dil1 = '<a href="prehledy.php?action=ladder&start='.($start-LIMIT2).$prestiz2.'">&lt;</a>';
	}
	$result = $Sql->q('SELECT id from hraci WHERE status > 0');
	$all = p($result);
	if($all > ($start+LIMIT2)) {
	  	$dil2 = '<a href="prehledy.php?action=ladder&start='.($start+LIMIT2).$prestiz2.'">&gt;</a>';
	}
	
	if($dil1 != '' || $dil2 != '') {
	  	$sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
	}
	#------------ SIPECKY!---------------#

	$page->swap('SIPKY',$sipky);
}


if($_GET['action'] == "staje") {
	$page->misc('STAJE','OBSAH');

	$result = $Sql->q('SELECT * FROM staje ORDER BY nazev ASC');
	if(p($result) == 0) {
		$page->misc('ZADNE','PREHLED');
		$page->finish();
		do_footer();
		konec();
	}
	
	for($i=0;$i<p($result);$i++) {
		$staj = fa($result);
		$b = explode(',',$staj['vlajka']);
		
		$staj['vlajka'] = drawFlag($b[0],$b[1],$b[2]);
		$staj['vlastnik'] = getNick($staj['login']);
		$staj['lidi'] = p($Sql->q('SELECT staj FROM stajovnici WHERE staj = '.$staj['id']));
		
		$data[] = $staj;
	}
	
	$page->getTable('STAJE',$data,'PREHLED');
}


if($_GET['action'] == 'online') {
	$page->misc('ONLINE','OBSAH');

	$sc = $_GET['sc'];
	if($sc == '') {
		$sc = 'asc';
		$sc2 = 'desc';
	} elseif($sc == 'desc') {
		$sc2 = 'asc';
	}
	$by = $_GET['by'];
	if($by == '') $by = 'id';
	
	$res2 = $Sql->q('SELECT id, nazev FROM rasy ORDER BY id ASC');
	
	for($i=0;$i<p($res2);$i++) {
		$row3 = fa($res2);
		$rasy[$row3['id']] = $row3['nazev'];
	}

	$result = $Sql->q('SELECT id, login, icq, cas FROM hraci WHERE logged = 1 AND cas > '.(time()-60*15).' ORDER BY '.$by.' '.$sc);
	
	if(p($result) == 0) {
		$page->misc('ZADNI','PREHLED');
		$page->swap('SIPKY','');
		$page->finish();
		do_footer();
		konec();
	}
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$row['rasa'] = $rasy[$row['rasa']];
		
		$sekundy = ((time()-$row['cas'])%60);
		if($sekundy < 10) $sekundy = '0'.$sekundy;
		
		$minuty = floor((time()-$row['cas'])/60);
		if($minuty < 10) $minuty = '0'.$minuty;
		
		$row['cas'] = $minuty.':'.$sekundy;
		
		$data[] = $row;
	}
	
	$page->getTable('ONLINE',$data,'PREHLED');

	$page->swap('HRACU',p($result));
	$page->swap('SC',$sc2);
}

if($_GET['action'] == "casopis") {
	$page->misc('TIMES','OBSAH');
	
	$folder = './vypisy/casopis/';
	$slozka = opendir($folder);
	$limit = 15;
	
	while(($soubor = readdir($slozka))!==false) {
		if(ereg('casak',$soubor)) {
			$nazvy[] = $soubor;
		}
	}
	
	if(count($nazvy) > 0) sort($nazvy);
	
	if(count($nazvy) == 0) {
		$page->misc('ZADNY','PREHLED');
		$page->finish();
		do_footer();
		konec();
	}
	
	for($i=(count($nazvy)-1);$i>(count($nazvy) <= $limit ? -1 : count($nazvy)-$limit);$i--) {
		$file = $nazvy[$i];
		$kusy = explode('_',$file);
		$kusy = explode('.',$kusy[1]);
		$cislo = $kusy[0];
		$cislo2 = $cislo;
		if(substr($cislo,0,1) == '0') $cislo2 = substr($cislo,1);
		$line['c1'] = $cislo2;
		$line['c2'] = $cislo;
		
		$data[] = $line;
	}
	
	$page->getTable('TIMES',$data,'PREHLED');
	
}	

if($_GET['action'] == 'questy') {

	$typy[0] = 'Závody';
	$typy[1] = 'Obchod';
	$typy[2] = 'Stáje';
	$typy[3] = 'Sázky';
	$typy[4] = 'Ostatní';
	$typy[5] = 'Pohár';

	$poradi = array(0,1,2,3,4);

	if($_GET['typ'] == '') $_GET['typ'] = 0;

	$page->misc('QUESTY','OBSAH');
	
	$data = array();
	foreach($poradi as $id) {
		$data[] = array('id' => $id, 'nazev' => $typy[$id], 'checked' => ($_GET['typ'] == $id && $_GET['typ'] != 'all' ? ' selected="selected"' : ''));
	}
	
	$page->getTable('FILTR QUESTY',$data,'FILTR');
	
	$stats = fa($Sql->q('SELECT * FROM stats WHERE login = '.UID));
	
	$done = explode(',',$stats['questy']);
	
	$result = $Sql->q('SELECT * FROM questy WHERE typ '.(is_numeric($_GET['typ']) ? '= '.$_GET['typ'] : '!= 5').' ORDER BY id ASC');
	while($quest = fa($result)) {
		
		$quest['typ2'] = $typy[$quest['typ']];
		
		if($quest['max']) {
			
			if(ereg('\+',$quest['sloupec'])) {
				$kusy = explode('+',$quest['sloupec']);
				$stav = $stats[$kusy[0]]+$stats[$kusy[1]];
			} else {
				$stav = $stats[$quest['sloupec']];
			}
			
			if($stav >= $quest['max']) {
				addQuest(UID,$quest['id'],$stats['questy']);
				$stav = $quest['max'];
			}
			
			$quest['typ2'] .= '<br /><div style="float: left" class="ultra">Stav: '.numF($stav).'/'.numF($quest['max']).'</div><div style="float: right">'.getQuestBar(round($stav/$quest['max']*100)).'</div><br /><div style="clear: both"></div>';
			
		}
			
		$questy[$quest['id']] = $quest;
	}
	
	if(is_array($done)) {
		foreach($done as $q) {
			if($q) {
				if($questy[$q]['typ'] == $_GET['typ'] || !is_numeric($_GET['typ'])) {
					$splnene[] = $questy[$q];
				}
			}
		}
		
		@$splnene = array_reverse($splnene);
		
		$page->getTable('SPLNENE',$splnene,'SPLNENE');
	}
	
	foreach($questy as $id => $q) {
		if(!in_array($id,$done)) {
			$ostatni[] = $q;
		}
	}
	
	$page->getTable('SPLNENE',$ostatni,'OSTATNI');
	
	$fill['splnenych'] = count($splnene);
	$fill['celkem'] = count($ostatni)+count($splnene);
	$fill['splnene'] = '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Žádné splněné questy';
	$fill['ostatni'] = '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Žádné zbývající questy';
	
	$page->fill($fill);	
}

if($_GET['action'] == 'finance') {
	$page->misc('FINANCE','OBSAH');
	
	$result = $Sql->q('SELECT * FROM finance_typy ORDER BY id ASC');
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$typy[$row['id']] = $row['nazev'];
	}
	
	$typy2[0] = array('id' => 'mezi', 'nazev' => 'Mezisoučty', 'checked' => ($_GET['typ'] == 'mezi' ? ' selected="selected"' : ''));
		
	$result = $Sql->q('SELECT * FROM finance_typy ORDER BY nazev ASC');
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$row['checked'] = ($_GET['typ'] == $row['id'] ? ' selected="selected"' : '');
		$typy2[] = $row;
	}
	
	$page->getTable('TYPY',$typy2,'TYPY');
		
	$kategorie = array();
	$kategorie[0] = array('nazev' => 'Vše');
	$kategorie[1] = array('nazev' => 'Závody', 'typy' => array(3,4,5,6,9,17,23,29));
	$kategorie[2] = array('nazev' => 'Sázky', 'typy' => array(7,8,22));
	$kategorie[3] = array('nazev' => 'Předměty', 'typy' => array(10,11,18,19,20));
	$kategorie[4] = array('nazev' => 'Paliva', 'typy' => array(12,21,35));
	$kategorie[5] = array('nazev' => 'Ostatní', 'typy' => array(1,2,14,15,16,24,25,26,27,28,30,31,32,33,34));
		
	for($i=0;$i<6;$i++) {		
		$line2['nazev'] = $kategorie[$i]['nazev'];
		$line2['id'] = $i;
		$line2['checked'] = ($_GET['kategorie'] == $i ? ' selected="selected"' : '');
		
		$kategorie2[] = $line2;
	}
	
	$page->getTable('KATEGORIE',$kategorie2,'KATEGORIE');
	
	if(is_numeric($_GET['kategorie']) && $_GET['kategorie'] > 0) {
		foreach($kategorie[$_GET['kategorie']]['typy'] as $idt) {
			$katz .= ','.$idt;
		}
		$and = ' AND typ IN('.substr($katz,1).')';
	}
	
	$hrac = fa($Sql->q('SELECT start FROM hraci WHERE id = '.UID));
	$result = $Sql->q('SELECT * FROM finance WHERE (login = '.UID.' OR login = 0) AND cas > '.($hrac['start']-10).$and.' ORDER BY id DESC');

	$penize = getPenize(UID);
	$penize_max = $penize;
	$penize_cas = time();

	for($i=0;$i<p($result);$i++) {
		$row = fa($result);	
		
		$line['cas'] = str_replace(' ','&nbsp;',date('H:i d.m.',$row['cas']));
		$line['akce'] = $typy[$row['typ']];
		$line['typ'] = $row['typ'];
		$line['login'] = $row['login'];
		$line['penize'] = str_replace(' ','&nbsp;',numF($row['penize']));
		$line['barva'] = ($row['zmena'] ? '#02FD09' : '#CC0000');
		$line['oddelovac'] = '';
		
		if((($data[count($data)-1]['login'] == 0 && $data[count($data)-1]['typ'] == 2)) && $i > 0) $line['oddelovac'] = ' class="oddelovac"';
		
		if($row['zmena'] == 0) $penize += $row['penize'];
			else $penize -= $row['penize'];
		
		if($penize > $penize_max) {
			$penize_max = $penize;
			$penize_cas = $row['cas'];
		}
		
		if($line['login'] == 0 && $line['typ'] == 2) {
			$line2['oddelovac'] = ' class="oddelovac"';
			$line2['akce'] = '<strong>Mezisoučet</strong>';
			$line2['penize'] = str_replace(' ','&nbsp;',numF($penize+$row['penize']));
			$line2['barva'] = '#FFF';
			$line2['cas'] = '<span class="extra">'.$line['cas'].'</span>';
			
			$data[] = $line2;
		}
		if($_GET['typ'] != 'mezi' && ($_GET['typ'] == '' || $_GET['typ'] == 0 || $_GET['typ'] == $row['typ'])) $data[] = $line;
	}		
	
	$fill['nejvic'] = numF($penize_max);
	$fill['kdy'] = ($penize_cas != time() ? ' což bylo '.date('H:i d.m.',$penize_cas) : ' a máš je teď');

	
	if(!$_GET['kategorie']) {
		$fill['skryti'] = '';
	} else {
		$fill['skryti'] = ' style="display: none"';
	}
	
	$page->getTable('FINANCE',$data,'FINANCE');
	$page->fill($fill);
}

if($_GET['action'] == 'quest_info') {
	$dlg = new cDialog('Quest','alert','width: 350px, height: auto');
	$dlg->button('OK','close');
	
	$quest = fa($Sql->q('SELECT nazev, popis FROM questy WHERE id = '.$_POST['id']));
	
	$dlg->title('Info o questu <strong>'.$quest['nazev'].'</strong>');
	$dlg->body($quest['popis']);
	$dlg->output();
}

if($_GET['action'] == 'stats') {
	$page->misc('STATS','OBSAH');
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.zavody as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.zavody DESC LIMIT 0,1'));
	$hrac['name'] = 'Odjeté závody';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.vitezstvi as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.vitezstvi DESC LIMIT 0,1'));
	$hrac['name'] = 'Vítězství';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.nedojeti as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.nedojeti DESC LIMIT 0,1'));
	$hrac['name'] = 'Nedojetí';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.vyrazeni as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.vyrazeni DESC LIMIT 0,1'));
	$hrac['name'] = 'Vyřazených soupeřů';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.useky as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.useky DESC LIMIT 0,1'));
	$hrac['name'] = 'Odjetých úseků';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.total_vyvolane as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.total_vyvolane DESC LIMIT 0,1'));
	$hrac['name'] = 'Vyvolaných soubojů celkem';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.max_vyvolane as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.max_vyvolane DESC LIMIT 0,1'));
	$hrac['name'] = 'Vyvolaných soubojů v 1 závodu';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.total_nevyvolane as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.total_nevyvolane DESC LIMIT 0,1'));
	$hrac['name'] = 'Nevyvolaných soubojů celkem';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.max_nevyvolane as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.max_nevyvolane DESC LIMIT 0,1'));
	$hrac['name'] = 'Nevyvolaných&nbsp;soubojů&nbsp;v&nbsp;1&nbsp;závodu';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.total_dmg as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.total_dmg DESC LIMIT 0,1'));
	$hrac['name'] = 'Udělených škod';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.max_dmg as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.max_dmg DESC LIMIT 0,1'));
	$hrac['name'] = 'Udělených škod v 1 závodu';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.total_skody as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.total_skody DESC LIMIT 0,1'));
	$hrac['name'] = 'Obdržených škod';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.max_skody as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.max_skody DESC LIMIT 0,1'));
	$hrac['name'] = 'Obdržených škod v 1 závodu';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.total_uhyby as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.total_uhyby DESC LIMIT 0,1'));
	$hrac['name'] = 'Úhyby celkem';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.max_uhyby as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.max_uhyby DESC LIMIT 0,1'));
	$hrac['name'] = 'Úhyby během 1 závodu';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.prosazeno as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.prosazeno DESC LIMIT 0,1'));
	$hrac['name'] = 'Prosázeno';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.sazky as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.sazky DESC LIMIT 0,1'));
	$hrac['name'] = 'Vyhráno sázek';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.brigady1 as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.brigady1 DESC LIMIT 0,1'));
	$hrac['name'] = 'Peněz na brigádách';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.brigady2 as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.brigady2 DESC LIMIT 0,1'));
	$hrac['name'] = 'Ztraceno prestiže na brigádách';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.srot as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.srot DESC LIMIT 0,1'));
	$hrac['name'] = 'Sešrotováno předmětů';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.spion as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.spion DESC LIMIT 0,1'));
	$hrac['name'] = 'Použito špiónů';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.opravy3 as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.opravy3 DESC LIMIT 0,1'));
	$hrac['name'] = 'Nejlepší opravář';
	$data[] = $hrac;
	
	$hrac = fa($Sql->q('SELECT h.login as login, s.login as id, s.zalozeni as value FROM stats as s LEFT JOIN hraci as h ON h.id = s.login ORDER BY s.zalozeni DESC LIMIT 0,1'));
	$hrac['name'] = 'Nejvíce založených závodů';
	$data[] = $hrac;
	
	$page->getTable('STATS1',$data,'ZEBRICEK');
	
	/*$result = $Sql->q('SELECT login, questy FROM stats WHERE questy != ""');
	
	$nejvic = array();
	$login = 0;

	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$kusy = explode(',',$row['questy']);
		
		$kusy = array_unique($kusy);
		
		if(count($kusy) > count($nejvic)) {
			$nejvic = $kusy;
			$login = $row['login'];
		}
	}
	
	foreach($nejvic as $nej=>$vic) if($vic == '') unset($nejvic[$nej]);
	
	$page->swap('ID',$login);
	$page->swap('QUESTU',count($nejvic));
	$page->swap('LOGIN',getNick($login));*/
	
	$result = $Sql->q('SELECT login, questy FROM stats WHERE questy != "" ORDER BY LENGTH(questy) DESC LIMIT 0,10');
	
	$data = array();
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$questy = explode(',',$row['questy']);
		$row['questu'] = count($questy)-1;
		$row['nick'] = getNick($row['login']);
		$row['i'] = $i+1;
		$row['quest_id'] = $questy[count($questy)-1];
		
		$quest = fa($Sql->q('SELECT nazev FROM questy WHERE id = '.$questy[count($questy)-1]));
		$row['quest'] = $quest['nazev'];
		
		$data[] = $row;
	}
	$page->getTable('QUESTY_LADDER',$data,'QUESTY');
}

$page->swap('FINANCE','Zvolenému filtru neodpovídá žádná manipulace');
$page->swap('OBSAH',$page->misc('PODSEKCE'));
$page->finish();
do_footer();
?>