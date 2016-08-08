<?php

function do_header($title) {
	global $Sql,$menu;
	
	if(jhadr()) return false;
	
	if(UID == "") {
		$page = new cPage('index');
		$page->swap('TITLE','- '.$title);		
		$page->swap('LOGO',getLogoId($title));
		$page->swap('ERROR',$_SESSION['chyba']);
		$page->finish();
		return true;
	}
	
	$Sql->q('UPDATE hraci set cas = '.time().' WHERE id = '.UID);
	
	define("TIP_SEKCE",strtolower(fuckDia($title).($_GET['action'] ? '-'.$_GET['action'] : '')));
	
	$args = func_get_args();

	$page = new cPage('header'.($args[1] == 'empty' ? '_empty' : ''));		
	
	$fill['title'] = '- '.$title;
	$fill['logo'] = getLogoId($title);
	$fill['tip_sekce'] = TIP_SEKCE;
	$fill['cas'] = date('H:i:s');
	$fill['sekce'] = '<span class="orange">'.substr($title,0,1).'</span>'.substr($title,1);
	$fill['hrac'] = $_SESSION['nick'];
	$fill['i_hrac'] = UID;
	$fill['timestamp'] = time()*1000;
	$fill['rasa'] = $_SESSION['rasa_nazev'];
	$fill['penize'] = numF(floor(getPenize(UID)));
	$fill['prestiz'] = getPrestiz(UID);
	$fill['error'] = $_SESSION['chyba'];
	
	$pole = explode(',',$_SESSION['menu']);
	$pohar = fa($Sql->q('SELECT val FROM sys WHERE entity = "pohar"'));
	
	foreach($pole as $id) {	
		if($id == 0) {
			$nabidka .= '<br />';	
			continue;
		}
		
		if($id == 39 && $_SESSION['status'] != 42) continue;
		if($id == 5 && $pohar['val'] < -1 && $pohar['val'] != -2) continue;
		
		$menu[$id]['nazev'] = str_replace('Ž','^',$menu[$id]['nazev']);
		$nabidka .= '<a href="'.str_replace('&','&amp;',$menu[$id]['url']).'">'.$menu[$id]['nazev'].'</a>';
		$nabidka = str_replace('^','Ž',$nabidka);
		$menu[$id]['nazev'] = str_replace('^','Ž',$menu[$id]['nazev']);
	}
	
	$result = $Sql->q('SELECT id FROM posta WHERE komu = '.UID.' AND (status = 4 OR status = 0)');
	
	$fill['posta'] = '';
	if(p($result) > 0 && $_GET['action'] != "new")
		$fill['posta'] = '<img src="{SKINDIR}img/posta.jpg" alt="Nová pošta" onclick="location=\'posta.php?action=new\'" class="posta_a" style="vertical-align: bottom; position: absolute" />';
	
	$fill['menu'] = $nabidka;
	
	$page->fill($fill);
	
	$page->finish();
}

function getLogoId($sekce) {	
	$sekce = strtolower(fuckDia($sekce));

	switch($sekce) {
		case 'obchod':
		case 'predmety':
		case 'paliva':
		case 'vyloha':
		case 'client':
		case 'zapomenute heslo':
			return 2;
			break;
			
		case 'zavody':
		case 'pohar':
		case 'registrace':
		case 'tutorial':
		case 'tvorba trati':
			return 3;
			break;
			
		case 'depo':
		case 'staje':
		case 'brigady':
		case 'obrazky ze hry':
			return 4;
			break;
			
		case 'prehledy':
		case 'forum':
		case 'posta':
		case 'podporte qsb':
			return 5;
			break;
			
		case 'sazky':
		case 'banky':
		case 'nastaveni':
			return 6;
			break;
			
		default: 
			return 1;
			break;
	}
}
?>