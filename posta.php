<?php

/*
STATUSY:
0 - cista netknuta zprava
1 - prectena nesmazana obema stranama
3 - smazana odesilatelem, ale ctena prijemcem
4 - smazana odesilatelem, ale nectena prijemcem
5 - nesmazana jen odesilatelem
6 - smazana kompletne
*/

include 'library.php';
include 'cls/cLink.php';
is_logged();

if(jhadr()) {	

	if($_POST['action'] == 'nahled') {
		$msg = findLink::transform($_POST['msg']);
		$msg = textFormat($msg);
		$msg = nl2br($msg);
	
		$page = new cPage('posta');
	
		$dlg = new cDialog('Náhled zprávy', 'alert', 'height: auto, width: 440px');
		$dlg->body($page->ext('NAHLED', 0, 0, array('text' => $msg)));
		$dlg->button('Zavřít', 'close');
		$dlg->button('Odeslat', 'submit', 'posta_send');
		$dlg->output();
		exit;
	}

	if($_POST['no_send'] == 'true') {	
		$page = new cPage('posta');
			
		$dlg = new cDialog('Náhled zprávy', 'alert');
		$dlg->body($page->ext('NO_SEND', 0, 0, array('nick' => $_POST['id'])));
		$dlg->button('OK', 'close');
		$dlg->output();
		
	}

	$dlg = new cDialog('Odesílání pošty', 'alert', 'height: 335, width: 477px');
	$page = new cPage('posta');
	
	for($j=1;$j<15;$j++)
		$smilies[]['x'] = $j;
	
	$dlg->body($page->ext('POSLAT_JHADR',0,0,array('nick' => (is_numeric($_POST['id']) ? getNick($_POST['id']) : $_POST['id']), 'smilici' => $page->getTable('SMILICI_POPUP',$smilies))));
	
	$dlg->button('Zrušit','close');
	$dlg->button('Odeslat','jHadr_submit','posta_send');
	$dlg->output();
	exit;
}

do_header('Pošta');

$page = new cPage('posta');

$start = $_GET['start'];
if($start == '' || $start < 0) {
	$start = 0;
}
define('LIMIT',($_GET['action'] == 'new' ? 60 : 5));

$fill['nova1'] = ' style="display: none"';
$fill['nova2'] = '';

$result = $Sql->q('SELECT id FROM posta WHERE (status = 0 OR status = 4) AND komu = '.UID);
if(p($result) > 0) {
	$fill['nova2'] = p($result);
	$fill['nova1'] = '';
}  

if($_GET['action'] == '') {

	for($j=1;$j<15;$j++) {
		$data[]['x'] = $j;
	}
	
	$fill['add'] = ($_GET['add'] ? getNick($_GET['add']) : '');
	$fill['smilici'] = $page->getTable('SMILICI',$data);
	
	$page->misc('POSLAT','OBSAH');

} elseif($_GET['action'] == 'odeslana') {
	
	$result = $Sql->q('SELECT * FROM posta WHERE kdo = '.UID.' AND status != 3 AND status != 4 AND status != 6 ORDER BY id DESC LIMIT '.$start.','.LIMIT);
	
	if(p($result) == 0) {
		$fill['obsah'] = '';
		$page->setCommon('MAIN');
		$page->ext('ZADNA_ODESLANA',1,0,$fill);
		exit;
	}
	
	$data = array();
	
	for($i=0;$i<p($result);$i++) {
		$msg = fa($result);

		$zprava = $msg['msg'];
	
		$zprava = findLink::transform($zprava);
		
		$zprava = textFormat($zprava); 
		
		$line['id'] = $msg['id'];
		$line['datum'] = date('H:i j.n.',$msg['cas']);
		$line['zprava'] = nl2br($zprava);
		$line['komu'] = $msg['komu'];
		$line['vlajka'] = getFlag($msg['komu']);
		$line['komu2'] = getNick($msg['komu']);
		$data[] = $line;
	}

#------------ SIPECKY!---------------#

	if($start > 0) {
		$dil1 = '<a href="posta.php?action=odeslana">&lt;&lt;</a> | <a href="posta.php?action=odeslana&start='.($start-LIMIT).'">&lt;</a>';
	}
	$result = $Sql->q('SELECT * from posta WHERE kdo = '.UID.' AND status != 3 AND status != 4 AND status != 6');
	$all = p($result);
	if($all > ($start+LIMIT)) {
		$dil2 = '<a href="posta.php?action=odeslana&start='.($start+LIMIT).'">&gt;</a>';
	}
	
	if($dil1 != '' || $dil2 != '') {
		$sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
	}
#------------ SIPECKY!---------------#

	$fill['sipky'] = $sipky;
	$fill['zpravy'] = $page->getTable('ODESLANA',$data);
	$fill['header'] = $page->misc('ODESLANA_HEADER');
	$fill['delete_start'] = $start+LIMIT;	
	
	$page->misc('ODESLANA','OBSAH');

} 

if($_GET['action'] == 'prijata' || $_GET['action'] == 'new') {

	$new = ($_GET['action'] == 'new' ? true : false);

	$result = $Sql->q('SELECT * FROM posta WHERE komu = '.UID.' AND (status = '.($new ? 0 : 1).' OR status = '.($new ? 4 : 3).') AND status != 6 AND status != 5 '.($new ? '' : ($_GET['sys'] == 'true' ? 'AND kdo != 0' : '')).' ORDER BY id DESC LIMIT '.$start.','.LIMIT);
	
	if(p($result) == 0) {
		$fill['obsah'] = '';
		$fill['start'] = $start;	
		$fill['checked'] = ($_GET['sys'] == 'true' ? ' checked="checked" ' : '');
		$page->setCommon('MAIN');
		$page->ext('ZADNA_PRIJATA',1,0,$fill);
		exit;
	}
	
	for($i=0;$i<p($result);$i++) {
		$msg = fa($result);

		$zprava = $msg['msg'];
		
		/*if(ereg('http\:\/\/[^[:space:]]+(\[|[[:space:]])*',$zprava,$https)) {
			foreach($https as $http) {
				$http = trim($http);
				$zprava = str_replace($http,'<a href="'.$http.'" target="_blank">'.$http.'</a>',$zprava);
			}
		}*/
	
		$zprava = findLink::transform($zprava);
		
		$zprava = textFormat($zprava);  
		
		if($new) {
			$val = ($msg['status'] == 4 ? 3 : 1);
			$result2 = $Sql->q('UPDATE posta set status = '.$val.' WHERE id = '.$msg['id']);
		}
		
		$line['id'] = $msg['id'];
		$line['datum'] = date('H:i j.n.',$msg['cas']);
		$line['zprava'] = nl2br($zprava);
		$line['vlajka'] = getFlag($msg['kdo']);
		$line['kdo'] = $msg['kdo'];
		$line['kdo2'] = getNick($msg['kdo']);
		$line['odpovedet'] = ($msg['kdo'] == 0 ? ' style="display: none"' : '');
		$data[] = $line;		
	}
	
	#------------ SIPECKY!---------------#
	
	if($start > 0) {
		$dil1 = '<a href="posta.php?action=prijata&sys='.$_GET['sys'].'">&lt;&lt;</a> | <a href="posta.php?action=prijata&start='.($start-LIMIT).'&sys='.$_GET['sys'].'">&lt;</a>';
	}
	$result = $Sql->q('SELECT * from posta WHERE komu = '.UID.' AND (status = 3 OR status = 1) AND status != 6 AND status != 5 ');
	$all = p($result);
	if($all > ($start+LIMIT)) {
		$dil2 = '<a href="posta.php?action=prijata&start='.($start+LIMIT).'&sys='.$_GET['sys'].'">&gt;</a> | <a href="posta.php?action=prijata&start='.($all-LIMIT).'&sys='.$_GET['sys'].'">&gt;&gt;</a>';
	}
	
	if($dil1 != '' || $dil2 != '') {
		$sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
	}
	#------------ SIPECKY!---------------#
	
	$fill['sipky'] = ($new ? '' : $sipky);
	$fill['zpravy'] = $page->getTable('PRIJATA',$data);
	$fill['header'] = $page->misc('PRIJATA_HEADER');	
	$fill['start'] = $start;	
	$fill['checked'] = ($_GET['sys'] == 'true' ? ' checked="checked" ' : '');
	$fill['delete_start'] = $start+LIMIT;	
	$fill['delete_action'] = ($new ? 'nova' : 'prijate');		
	$fill['sys'] = ($_GET['sys'] == 'true' ? 'true' : 'false');
	
	$page->misc('ODESLANA','OBSAH');
}

if($_GET['action'] == 'konverzace') {
	$page->misc('KONVERZACE', 'OBSAH');
	
	$result = $Sql->q('SELECT DISTINCT(p.kdo) as login, h.login as nick 
					   		FROM posta as p LEFT JOIN hraci as h ON h.id = p.kdo 
							WHERE p.komu = '.UID.' AND p.kdo != 0
							GROUP BY p.kdo
					   UNION DISTINCT
					   SELECT DISTINCT(p.komu) as login, h.login as nick 
					   		FROM posta as p LEFT JOIN hraci as h ON h.id = p.komu 
							WHERE p.kdo = '.UID.' 
							GROUP BY p.komu 
						ORDER BY nick ASC');
						
	$data = array();
	$data[] = array('nick' => 'SYSTEM', 'login' => 0, 'selected' => ($_GET['login'] == 0 && $_GET['login'] != '' ? ' selected="selected"' : ''));	
	
	while($row = fa($result)) {
		if($row['nick'] != "") {
			$row['selected'] = ($_GET['login'] == $row['login'] ? ' selected="selected"' : '');
			$data[] = $row;
		}
	}
	
	$page->getTable('KONVERZACE_HRACI', $data, 'HRACI');
	$page->swap('ORDER', ($_GET['order'] == 'asc' ? ' selected="selected"' : ''));
	
	$order = ($_GET['order'] == 'asc' ? 'asc' : 'desc');
	$login = $_GET['login'];
	
	if($login == "") {
		$page->swap('KONVERZACE', 'Vyberte prosím některého z hráčů');
	} else {		
		$result = $Sql->q('SELECT * FROM posta WHERE (kdo = '.UID.' AND komu = '.$login.') OR (komu = '.UID.' AND kdo = '.$login.') ORDER BY cas '.$order);
		
		$data = array();
		while($msg = fa($result)) {	
		
			$zprava = findLink::transform($msg['msg']);		
			$zprava = textFormat($zprava); 
					
			$line['id'] = $msg['id'];
			$line['datum'] = date('H:i j.n.', $msg['cas']);
			$line['zprava'] = nl2br($zprava);
			$line['kdo'] = $msg['kdo'];
			$line['vlajka'] = getFlag($msg['kdo']);
			$line['kdo2'] = getNick($msg['kdo']);
			$line['float'] = ($msg['kdo'] == UID ? 'right' : 'left');
			
			$data[] = $line;		
		}
		
		$page->getTable('KONVERZACE', $data, 'KONVERZACE');
	}
	
	$fill['login'] = $_GET['login'];
}

$page->fill($fill);
$page->finish();

if($_GET['action'] == '')
	define("NO_SEND", 'true');
do_footer();
?>
