<?php
include_once 'library.php';
is_logged();

$row = fa($Sql->q('SELECT status FROM hraci WHERE id = '.UID));
if($row['status'] < 2) {
	exit;
}

$action = $_GET['action'];
$title = $_POST['title'];

$page = new cPage('konzulove');
$dlg = new cDialog(($title ? $title : 'Konzulova konzole'), 'alert', 'width: 477px, height: auto');

$simple = array('novinka', 'posta', 'anketa', 'nastenka', 'blokace_hrace');

if(in_array($action, $simple)) {
	$dlg->body($page->misc(strtoupper($action)));
	$dlg->button('Zrušit','close');
	$dlg->button('OK','submit','form_'.$action);
	
	$dlg->output();
}

if($action == 'sablona') {
	$data = array();
	$result = $Sql->q('SELECT * FROM sablony ORDER BY login ASC, nazev ASC');
	while($row = fa($result)) {
		$row['login'] = getNick($row['login']);
		
		$data[] = $row;
	}

	$dlg->body($page->ext('SABLONA', false, false, array('sablony' => $page->getTable('SABLONY2', $data))));
	$dlg->button('Zrušit','close');
	$dlg->button('COMMENCE ZEH TRANSFORMATION!','submit','form_sablona');
	$dlg->output();
}

if($action == 'add_bot') {
	$fill = array();
	
	$typy = array('', 'Sport', 'Combi', 'Wrecker');
	
	$data = array();
	$result = $Sql->q('SELECT id, typ, cena, kategorie FROM boti_kluzaky ORDER BY cena ASC, typ ASC, kategorie ASC');
	while($row = fa($result)) {
		$row['nazev'] = $typy[$row['typ']].' - '.$row['cena'].' / '.$row['kategorie'];
		
		$data[] = $row;
	}	
	$fill['sablony'] = $page->getTable('SELECT', $data);
	
	$data = array();
	$result = $Sql->q('SELECT id, nazev FROM zavody WHERE vitez = 0 ORDER BY cena ASC, nazev ASC');
	while($row = fa($result)) {		
		$data[] = $row;
	}	
	$fill['zavody'] = $page->getTable('SELECT', $data);
	
	$data = array();
	$result = $Sql->q('SELECT id, nazev FROM rasy ORDER BY id ASC');
	while($row = fa($result)) {		
		$data[] = $row;
	}	
	$fill['rasy'] = $page->getTable('SELECT', $data);

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

	$dlg->body($page->ext('ADD_BOT', false, false, $fill));
	$dlg->set('width', '420px');
	$dlg->set('height', 'auto');	
	$dlg->button('Zrušit','close');
	$dlg->button('Přidat bota', 'jHadr_submit', 'form_add_bot');
}

if($action == 'add_bot2') {
	$fill = array();
	
	$typy = array('', 'Sport', 'Combi', 'Wrecker');
	
	$data = array();
	$result = $Sql->q('SELECT id, typ, cena, kategorie FROM boti_kluzaky ORDER BY cena ASC, typ ASC, kategorie ASC');
	while($row = fa($result)) {
		$row['nazev'] = $typy[$row['typ']].' - '.$row['cena'].' / '.$row['kategorie'];
		
		$data[] = $row;
	}	
	$fill['sablony'] = $page->getTable('SELECT', $data);
	
	$data = array();
	$result = $Sql->q('SELECT id, nazev FROM zavody WHERE vitez = 0 ORDER BY cena ASC, nazev ASC');
	while($row = fa($result)) {		
		$data[] = $row;
	}	
	$fill['zavody'] = $page->getTable('SELECT', $data);
	
	$data = array();
	$result = $Sql->q('SELECT id, nazev FROM rasy ORDER BY id ASC');
	while($row = fa($result)) {		
		$data[] = $row;
	}	
	$fill['rasy'] = $page->getTable('SELECT', $data);

	$dlg->body($page->ext('ADD_BOT2', false, false, $fill));
	$dlg->set('width', '420px');
	$dlg->set('height', 'auto');	
	$dlg->button('Zrušit','close');
	$dlg->button('Přidat bota', 'jHadr_submit', 'form_add_bot');
}

if($action == 'forum') {
	$dlg->set('width','250px');
	$dlg->body('Povolit mazání fóra?');
	$dlg->button('Ne','location','konzulove.php?action=forum&povolit=ne');
	$dlg->button('Ano','location','konzulove.php?action=forum&povolit=ano');
	$dlg->output();
}

if($action == "index") {
	$fn = 'vypisy/index.txt';

	$dlg->set('height','800');
	$dlg->set('width','668px');
        
    $dlg->body($page->ext('EDITACE_SCRIPTU',0,0,array('filename' => $fn, 'obsah' => stripslashes(file_get_contents($fn)))));
        		
	$dlg->title($dotaz);
	$dlg->button('Zrušit','close');
	$dlg->button('OK','jHadr_submit','form_script');
	$dlg->output();		
}

if($action == "edit_script") {
	$fp = fopen('vypisy/index.txt','w');
	fwrite($fp, stripslashes($_POST['obsah']));
	fclose($fp);
	
	sendPosta(0, 1, getNick(UID)." upravil úvodní stránku.");
	
	$dlg->set('width','250px');
	$dlg->body('Soubor uložen.');
	$dlg->button('OK','close');
	$dlg->output();
}

$dlg->output();
?>