<?php

function do_footer($option = '') {
	global $cInfobox, $Sql;

	$page = new cPage('footer'.(UID ? '1' : ''));
	$page->swap('SQL',$_SESSION['sql']);
	$page->swap('ERROR',$_SESSION['chyba']);
	$page->swap('TIP_SEKCE',TIP_SEKCE);
	$page->swap('NOTIP', ($option == 'notip' ? ' style="display: none"' : ''));	
	
	$kusy = explode('-', TIP_SEKCE);
	$prvni = fa($Sql->q('SELECT tip FROM tipy WHERE '.(count($kusy) > 1 ? 'sekce = "'.$kusy[0].'" OR ' : '').'sekce = "'.TIP_SEKCE.'" ORDER BY rand() LIMIT 1'));
	if(!$prvni['tip']) $prvni = fa($Sql->q('SELECT tip FROM tipy ORDER BY rand() LIMIT 1'));
	
	$page->swap('TIP',$prvni['tip']);
	
	if(UID) {
		$page->swap('INFOBOX', $cInfobox->draw());
	
		if(!($nastenka = $_COOKIE['nastenka'])) $nastenka = 1;
	
		$_POST['nastenka_id'] = $nastenka;
	
		ob_start();
		include 'nastenka.php';
	
		$page->swap('NASTENKA', ob_get_contents());
        
    	ob_end_clean();
	
		for($i=1;$i<7;$i++) $page->swap('NASTENKA_'.$i, ($nastenka == $i  ? '_active' : ''));
	}
	
	if($_POST['method'] == 'jhadr') return false;
	$page->finish();
	unset($_SESSION['chyba']);
}

function do_footer2() {
	$page = new cPage('footer2');
	$page->swap('SQL',$_SESSION['sql']);
	$page->swap('ERROR',$_SESSION['chyba']);
	if($_POST['method'] == 'jhadr') return false;
	$page->finish();
	unset($_SESSION['chyba']);
}
?>