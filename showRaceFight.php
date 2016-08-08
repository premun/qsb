<?php
include 'library.php';
is_logged();

include 'prepocet/cZavodInfo.php';
include 'prepocet/cZavodEvent.php';

$id = $_GET['id'];
$moje = $_GET['moje'];

do_header('Závody');


$page = new cPage('showFightInfo');

$zavod = fa($Sql->q('SELECT nazev, trat FROM zavody WHERE id = '.$id));

$result = $Sql->q('SELECT * FROM trate_druhy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$useky_info[$row['id']] = $row;
}

$trat = fa($Sql->q('SELECT id, nazev, trat FROM trate WHERE id = '.$zavod['trat']));

$useky = explode(',',$trat['trat']);

$page->swap('NAZEV',$zavod['nazev']);
$page->swap('ID',$id);

$obsah = file_get_contents('vypisy/zavody_info/'.$id.'_'.fileName($zavod['nazev']).'.dat');
$info = unserialize($obsah);

$data = array();
$in = false;

$nazvy = array();
$nazvy['souboj'] = '<a class="submit"{EXTRA}>{NICK}</a>&nbsp;&nbsp;napadl hráče <a class="submit"{EXTRA2}>{NICK2}</a>';
$nazvy['crash'] = '<a class="submit"{EXTRA}>{NICK}</a> naboural';
$nazvy['uhyb'] = '<a class="submit"{EXTRA}>{NICK}</a>&nbsp;&nbsp;minul hráče <a class="submit"{EXTRA2}>{NICK2}</a>';

$alts = array();
$alts['souboj'] = 'Souboj';
$alts['crash'] = 'Bourání';
$alts['uhyb'] = 'Úhyb';

$predmety[1] = "Podvozek";
$predmety[2] = "Motor";
$predmety[3] = "Energodržáky";
$predmety[4] = "Chladič";
$predmety[5] = "Palubní deska";
$predmety[6] = "Brzdy";
$predmety[7] = "Zdroj";
$predmety[8] = "Pancéřování";
$predmety[9] = "Suspenzory";
$predmety[10] = "Přídavný motor";

$max_imgs = 1;

foreach($info->udalosti as $id => $udalost) {
	$line = array();
	$line['id'] = $id;
	$line['nazev'] = $nazvy[$udalost->type];
	$line['nick'] = getNick($udalost->login);
	$line['nick2'] = getNick($udalost->login2);
	$line['extra'] = ($udalost->login == UID ? ' style="color: #FF6600"' : '');
	$line['extra2'] = ($udalost->login2 == UID ? ' style="color: #FF6600"' : '');
	$line['imgs'] = '<img src="skin/img/'.$udalost->type.'.png" alt="'.$alts[$udalost->type].'" />';
	
	$imgs = 1;
	
	if($udalost->type == 'uhyb' && $udalost->skody > 0) {
		$imgs++;
		$line['imgs'] .= '<img src="skin/img/crash.png" alt="'.$alts[$udalost->type].'" />';		
	}
	
	if($udalost->fatal || $udalost->fatal1 || $udalost->fatal2) {
		$imgs++;
		$line['imgs'] .= '<img src="skin/img/fatal.png" alt="'.$alts[$udalost->type].'" />';		
	}
	
	$line['info'] = '';
	
	$cas = $info->casy[$udalost->cas]/10;
	
	$hodiny = $cas%60;
	if($hodiny < 10) $minuty = '0'.$hodiny;
	
	$minuty = floor(($cas-$hodiny)*60);
	if($minuty < 10) $minuty = '0'.$minuty;
	
	$sekundy = round((($cas-$minuty/60-$hodiny)*60*60));
	if($sekundy < 10) $sekundy = '0'.$sekundy;
	
	$line['cas'] = ($hodiny > 0 ? $hodiny.':' : '').$minuty.':'.$sekundy;
	
	if($imgs > $max_imgs) $max_imgs = $imgs;
	
	# INFO
		$line2 = array();
		
		$line2[] = array('nazev' => 'Úsek', 'value' => $useky_info[$useky[$udalost->usek]]['nazev'].' <em>('.$udalost->usek.'/'.count($useky).')</em>');
		
		$cas = $info->casy[$udalost->cas]/10;
		
		$hodiny = $cas%60;
		if($hodiny < 10) $minuty = '0'.$hodiny;
		
		$minuty = floor(($cas-$hodiny)*60);
		if($minuty < 10) $minuty = '0'.$minuty;
		
		$sekundy = round((($cas-$minuty/60-$hodiny)*60*60));
		if($sekundy < 10) $sekundy = '0'.$sekundy;
		
		$line2[] = array('nazev' => 'Čas', 'value' => ($hodiny == '00' ? '' : $hodiny.':').$minuty.':'.$sekundy);
		
		#dmg1,dmg2,predmet,pancerovani,skody_chladic
		if($udalost->predmet != 0 && $udalost->skody > 0) {
			$line2[] = array('nazev' => 'Poškozený předmět', 'value' => $predmety[$udalost->predmet]);
		}
		
		if($udalost->skody > 0) {
			$line2[] = array('nazev' => 'Škody na předmětu', 'value' => round($udalost->skody).' dmg');
		}
		
		if(($udalost->type == 'crash' || $udalost->type == 'uhyb') && $udalost->zpomaleni) {
			$line2[] = array('nazev' => 'Zpomalení', 'value' => $udalost->zpomaleni.'%');			
		}
		
		if($udalost->type == 'souboj') {
			$line2[] = array('nazev' => '<strong class="extra">'.$line['nick'].'</strong>', 'value' => '');
			$line2[] = array('nazev' => 'Obdržené škody', 'value' => round($udalost->dmg2).' dmg');
			
			$predmety1 = '';
			foreach($udalost->predmety1 as $predmet => $skoda) {
				$predmety1 .= ($predmety1 == '' ? '' : '<br />').$predmety[$predmet].' - '.round($skoda).' dmg';
			}
			$line2[] = array('nazev' => 'Poškozené předměty', 'value' => $predmety1);
			$line2[] = array('nazev' => 'Zpomalení', 'value' => round(100-$udalost->zpomaleni1).'%');
			
			$line2[] = array('nazev' => '<strong class="extra">'.$line['nick2'].'</strong>', 'value' => '');
			$line2[] = array('nazev' => 'Obdržené škody', 'value' => round($udalost->dmg1).' dmg');
			
			$predmety1 = '';
			foreach($udalost->predmety2 as $predmet => $skoda) {
				$predmety1 .= ($predmety1 == '' ? '' : '<br />').$predmety[$predmet].' - '.round($skoda).' dmg';
			}
			$line2[] = array('nazev' => 'Poškozené předměty', 'value' => $predmety1);
			$line2[] = array('nazev' => 'Zpomalení', 'value' => round(100-$udalost->zpomaleni2).'%');
		}
		
	$line['info'] = $page->getTable('INFO', $line2);
		
	switch($udalost->type) {
		case 'crash':
			$overall[$udalost->login]['narazy']++;
			$overall[$udalost->login]['skody'] += $udalost->skody;
		
			$line['popis'] = $line['nick'].' naboural do trati';
			if($udalost->fatal) $line['popis'] .= '<br />Poškozením předmětu byl poté vyřazen ze závodu';		
			break;
			
		case 'uhyb':
			$overall[$udalost->login]['narazy']++;
			$overall[$udalost->login]['skody'] += $udalost->skody;
			$overall[$udalost->login]['vyvolane']++;
			$overall[$udalost->login2]['nevyvolane']++;
			
			$line['popis'] = $line['nick2'].' se vyhnul útoku hráče '.$line['nick'];
			if($udalost->skody > 0) $line['popis'] .= '<br />'.$line['nick'].' poté naboural do trati';
			if($udalost->fatal) $line['popis'] .= '<br />'.$line['nick'].' byl tímto vyřazen ze závodu';						
			break;
			
		case 'souboj':
			$overall[$udalost->login]['dmg'] += $udalost->dmg1;
			$overall[$udalost->login2]['dmg'] += $udalost->dmg2;
			$overall[$udalost->login]['skody'] += $udalost->dmg2;
			$overall[$udalost->login2]['skody'] += $udalost->dmg1;
			$overall[$udalost->login]['vyvolane']++;
			$overall[$udalost->login2]['nevyvolane']++;
			
			$line['popis'] = $line['nick'].' napadl hráče '.$line['nick2'];	
			if($udalost->fatal1) $line['popis'] .= '<br />'.$line['nick'].' byl tímto vyřazen ze závodu';	
			if($udalost->fatal2) $line['popis'] .= '<br />'.$line['nick2'].' byl tímto vyřazen ze závodu';	
			break;
	}
	
	if($udalost->login == UID || $udalost->login2 == UID) $in = true;
	else if($moje == 'true') continue;
	
	$data[] = $line;
}

$page->getTable('UDALOSTI', $data, 'UDALOSTI');
$page->swap('IMGS_WIDTH', ($max_imgs == 1 ? 24 : ($max_imgs == 2 ? 56 : 84)));

$data = array();
foreach($overall as $uid => $row) {
	$line = array();
	$line['uid'] = $uid;
	$line['login'] = getNick($uid);
	$line['narazy'] = numF($row['narazy']);
	$line['dmg'] = numF($row['dmg']);
	$line['skody'] = numF($row['skody']);
	$line['vyvolane'] = numF($row['vyvolane']);
	$line['nevyvolane'] = numF($row['nevyvolane']);
	
	$data[] = $line;
}

$page->getTable('OVERALL', $data, 'OVERALL');

if($in && count($data)) $page->misc('MOJE','MOJE');
$page->swap('MOJE','');
$page->swap('CHECKED',($moje == 'true' ? ' checked="checked"' : ''));
$page->swap('ID', $_GET['id']);

$page->finish();
do_footer();
?>