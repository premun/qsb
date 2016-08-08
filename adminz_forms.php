<?php
include_once 'library.php';
is_logged();

$row = fa($Sql->q('SELECT status FROM hraci WHERE id = '.UID));
if($row['status'] != 42) {
	exit;
}

$action = $_GET['action'];
$title = $_POST['title'];

$page = new cPage('adminz');
$dlg = new cDialog(($title ? $title : 'All hail to Adminz!'), 'alert', 'width: 477px, height: auto');

$simple = array('novinka', 'posta', 'anketa', 'spion', 'restart_zavodu', 'nastenka');

if(in_array($action, $simple)) {
	$dlg->body($page->misc(strtoupper($action)));
	$dlg->button('Zrušit','close');
	$dlg->button('OK','submit','form_'.$action);

	if($action == 'spion' || $action == 'restart_zavodu') {
		$dlg->set('width','250px');
	}

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
	$dlg->button('Ne','location','adminz.php?action=forum&povolit=ne');
	$dlg->button('Ano','location','adminz.php?action=forum&povolit=ano');
	$dlg->output();
}

if($action == 'blokace') {
	$dlg->set('width','250px');
	$dlg->body('Zablokovat hru?');
	$dlg->button('Ne','location','adminz.php?action=blokace&povolit=ne');
	$dlg->button('Ano','location','adminz.php?action=blokace&povolit=ano');
	$dlg->output();
}

if($action == 'pohar') {
	$dlg->set('width','250px');
	$dlg->body('Odstartovat pohár?');
	$dlg->button('Zrušit','close');
	$dlg->button('K přihlašování jezdců','location','adminz.php?action=pohar&sub=sign');
	$dlg->button('Úplně','location','adminz.php?action=pohar&sub=start');
	$dlg->output();
}

if($action == 'prepocet') {
	$dlg->set('width','250px');
	$dlg->body('Hlavní přepočet bys chtěl, jo?');
	$dlg->button('Zrušit','close');
	$dlg->button('Spustit','location','./prepocet/prepocet.php?key1='.RegKey(15).'&extraz=adminz&key2='.RegKey(15).'&auth=ok&key3='.RegKey(15));
	$dlg->output();
}

if($action == "sqll") {
	if($_SESSION['adminz_heslo'] == '******') {
		$action = 'sql';
	} else {
		$dlg->set('width','250px');
		$dlg->body($page->misc('SQLL'));
		$dlg->button('Zrušit','close');
		$dlg->button('OK','jHadr_submit','form_sqll');
		$dlg->output();
	}
}

if($action == "sql") {
	$dotaz = $_POST['dotaz'];

	if($dotaz) {
		$dlg->set('height','auto');

        ob_start();

		$result = $Sql->q(stripslashes($dotaz));

		if(!$result) echo '<br /><span class="error">Invalid query</span><br />';

		if(strtoupper(substr($dotaz,0,6)) == 'SELECT' && $result) {
			echo '<br />
			<pre>
Počet výsledků: '.p($result)."\n\n";
			for($i=0;$i<p($result);$i++) {
				$row = fa($result);
				print_r($row);
				echo "\n";
			}

			echo '</pre><br />';
		}

        $dlg->body(ob_get_contents());

        ob_end_clean();

		$dlg->title($dotaz);
		$dlg->button('OK','alert','adminz_forms.php?action=sql');
		$dlg->output();
	}

	if($_SESSION['adminz_heslo']) $_POST['heslo'] = $_SESSION['adminz_heslo'];

	if($_POST['heslo'] != '******' && !$dotaz) {
		$dlg->set('width','250px');
		$dlg->body('Špatné heslo.');
		$dlg->button('OK','alert','adminz_forms.php?action=sqll');
		$dlg->output();
	}

	$_SESSION['adminz_heslo'] = $_POST['heslo'];

	$dlg->body($page->misc('SQL'));
	$dlg->button('Zrušit','close');
	$dlg->button('Odeslat','jHadr_submit','form_sql');
	$dlg->output();
}

if($action == "scriptyl") {
	if($_SESSION['adminz_heslo'] == '******') {
		$action = 'scripty';
	} else {
		$dlg->set('width','250px');
		$dlg->body($page->misc('SCRIPTYL'));
		$dlg->button('Zrušit','close');
		$dlg->button('OK','jHadr_submit','form_scriptyl');
		$dlg->output();
	}
}

if($action == "scripty") {
	$fn = $_POST['filename'];

	if($fn == 'index') $fn = 'vypisy/index.txt';
	if($fn == 'error log') $fn = 'vypisy/error_log.txt';
	if($fn == 'prepocet error log') $fn = 'prepocet/vypisy/error_log.txt';

	if($fn) {
		$dlg->set('height','800');
		$dlg->set('width','668px');

        $dlg->body($page->ext('EDITACE_SCRIPTU',0,0,array('filename' => $fn, 'obsah' => stripslashes(file_get_contents($fn)))));

		$dlg->title($dotaz);
		$dlg->button('Zrušit','close');
		$dlg->button('OK','jHadr_submit','form_script');
		$dlg->output();
	}

	if($_SESSION['adminz_heslo']) $_POST['heslo'] = $_SESSION['adminz_heslo'];

	if($_POST['heslo'] != '******' && !$dotaz) {
		$dlg->set('width','250px');
		$dlg->body('Špatné heslo.');
		$dlg->button('OK','alert','adminz_forms.php?action=scriptyl');
		$dlg->output();
	}

	$_SESSION['adminz_heslo'] = $_POST['heslo'];

	$dlg->body($page->misc('SCRIPTY'));
	$dlg->button('Zrušit','close');
	$dlg->button('Načíst soubor','jHadr_submit','form_scripty');
	$dlg->output();
}

if($action == "edit_script") {
	$fp = fopen($_POST['filename'],'w');
	fwrite($fp, stripslashes($_POST['obsah']));
	fclose($fp);
	$dlg->set('width','250px');
	$dlg->body('Soubor uložen.');
	$dlg->button('OK','close');
	$dlg->output();
}

if($action == "zalohyl") {
	if($_SESSION['adminz_heslo'] == '******') {
		$action = 'zalohy';
	} else {
		$dlg->set('width','250px');
		$dlg->body($page->misc('ZALOHYL'));
		$dlg->button('Zrušit','close');
		$dlg->button('OK','jHadr_submit','form_zalohyl');
		$dlg->output();
	}
}

if($action == "zalohy") {
	if($_SESSION['adminz_heslo']) $_POST['heslo'] = $_SESSION['adminz_heslo'];

	if($_POST['heslo'] != '******') {
		$dlg->set('width','250px');
		$dlg->body('Špatné heslo.');
		$dlg->button('OK','alert','adminz_forms.php?action=zalohyl');
		$dlg->output();
	}

	$_SESSION['adminz_heslo'] = $_POST['heslo'];

	$dlg->set('height','auto');
	$dlg->set('width','auto');

	$folder = './vypisy/db/';
	$slozka = opendir($folder);
	while($soubor = readdir($slozka)) {
		if(ereg('.rec$',$soubor)) {
			$nazvy[] = $soubor;
		}
	}

	if(count($nazvy) > 0) {
		sort($nazvy);
		$nazvy = array_reverse($nazvy);
		$data = array();
		foreach($nazvy as $nazev) {
			$kusy = explode('__',str_replace('.rec','',$nazev));
			$casti = explode('-',$kusy[2]);
			$casti2 = explode('-',$kusy[1]);
			$datum = $casti2[0].'-'.$casti2[1].'-'.$casti2[2].' <span class="ultra">'.$casti[0].':'.$casti[1].'</span>';

			$nazev2 = str_replace('.rec','',$nazev);

			$velikost = number_format(filesize('./vypisy/db/'.$nazev)/1000000, 2, '.', ' ');

			$data[] = array('nazev' => $nazev, 'nazev2' => $nazev2, 'datum' => $datum, 'velikost' => $velikost);
		}
	}

	$dlg->body($page->getTable('ZALOHY', $data));
	$dlg->title('Zálohy databáze');
	$dlg->button('OK','close');
	$dlg->output();
}

$dlg->output();
?>