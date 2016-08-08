<?php

include 'library.php';
is_logged();

$disabled = array(35);

if($_GET['action'] == 'zrusit') {
	unset($_SESSION['zmena_menu']);
	unset($_SESSION['edit_kat']);
	$_SESSION['chyba'] = 'Změny zrušeny';
	go('nastaveni.php?action=menu');
	exit;
}

if($_GET['action'] == 'ulozit') {
	$Sql->q('UPDATE hraci set menu = "'.$_SESSION['zmena_menu'].'" WHERE id = '.UID);
	$_SESSION['menu'] = $_SESSION['zmena_menu'];
	unset($_SESSION['zmena_menu']);
	
	$_SESSION['chyba'] = 'Nastavení uloženo';
	go('nastaveni.php?action=menu');
	exit;
}

if($_GET['action'] == 'add') {
	if($_GET['id'] == "") $_GET['id'] = 0;

	if($_SESSION['zmena_menu'] != ""){
		$_SESSION['zmena_menu'] = $_GET['id'].','.$_SESSION['zmena_menu'];
	} else {
		$hrac = fa($Sql->q('SELECT menu FROM hraci WHERE id = '.UID));
		if($hrac['menu'] == '') $hrac['menu'] = $default_menu;
		$_SESSION['zmena_menu'] = $_GET['id'].','.$hrac['menu'];
	}
	
	$_SESSION['edit_kat'] = 0;
	
	go('nastaveni.php?action=menu');
	exit;
}

if($_GET['action'] == 'delete') {	
	if($_GET['id'] == "") $_GET['id'] = 0;

	if($_SESSION['zmena_menu'] == "") {
		$hrac = fa($Sql->q('SELECT menu FROM hraci WHERE id = '.UID));
		if($hrac['menu'] == '') $hrac['menu'] = $default_menu;
	} else {
		$hrac['menu'] = $_SESSION['zmena_menu'];
	}
	
	$pole = explode(',',$hrac['menu']);
	
	if(in_array($pole[$_GET['id']],$disabled)) {
		$_SESSION['chyba'] = 'Tato položka nemůže být odstraněna';
		go('nastaveni.php?action=menu');
		exit;		
	}

	unset($pole[$_GET['id']]);
	
	$_SESSION['zmena_menu'] = implode(',',$pole);
	unset($_SESSION['edit_kat']);

	go('nastaveni.php?action=menu');
	exit;	
}

if($_GET['action'] == 'move') {
	if($_GET['id'] == "") $_GET['id'] = 0;
	
	$dir = $_GET['dir'];
	$id = $_GET['id'];
	
	if($dir == 'up' && $id < 1) {
		go('nastaveni.php?action=menu');
		exit;
	}

	if($_SESSION['zmena_menu'] == ""){
		$hrac = fa($Sql->q('SELECT menu FROM hraci WHERE id = '.UID));
		if($hrac['menu'] == '') $hrac['menu'] = $default_menu;
	} else {
		$hrac['menu'] = $_SESSION['zmena_menu'];
	}
	$pole = explode(',',$hrac['menu']);
	
	if($dir == 'down' && $id > count($pole)-2) {
		go('nastaveni.php?action=menu');
		exit;
	}
	
	$temp = $pole[$id];

	if($dir == 'down') {
		$pole[$id] = $pole[$id+1];
		$pole[$id+1] = $temp;
		$_SESSION['edit_kat'] = $_GET['id']+1;
	}

	if($dir == 'up') {
		$pole[$id] = $pole[$id-1];
		$pole[$id-1] = $temp;
		$_SESSION['edit_kat'] = $_GET['id']-1;
	}
	
	$_SESSION['zmena_menu'] = implode(',',$pole);	
	
	go('nastaveni.php?action=menu');
	exit;
}

do_header('Nastavení');

if($_GET['action'] == 'menu') {

	if($_SESSION['edit_kat'] != '') {
		echo '<script type="text/javascript">setTimeout("choose('.$_SESSION['edit_kat'].')",100)</script>';
	}

	if($_SESSION['zmena_menu'] != ""){
		$hrac['menu'] = $_SESSION['zmena_menu'];
	} else {
		$hrac = fa($Sql->q('SELECT menu FROM hraci WHERE id = '.UID));
	}

	if($_SESSION['status'] != 42) unset($menu[39]);
	if($_SESSION['status'] < 2) unset($menu[43]);

	if($hrac['menu'] == "") $hrac['menu'] = $default_menu;

	$page = new cPage('nastaveni');
	
	foreach($menu as $id=>$pole) $menu[$id]['id'] = $id;
	
	$hrac['menu'] = explode(',',$hrac['menu']);
	
	foreach($hrac['menu'] as $poradi=>$pole) {
		$vypis[] = array('nazev' => $menu[$pole]['nazev'], 'id' => $poradi);
	}
	
	$page->ext('MENU',1,'',array('sekce' => $page->getTable('SEKCE',$menu), 'menu' => $page->getTable('MENU',$vypis), 'ulozit' => ($_SESSION['zmena_menu'] != "" ? '<a href="nastaveni.php?action=ulozit"><strong>Uložit změny</strong></a><br /><a href="nastaveni.php?action=zrusit"><strong>Zrušit změny</strong></a><br /><br />' : '')));	
	exit;
}

$data = array();
$cInfobox->getItems();
$i = 0;
foreach($cInfobox->items as $nazev => $pole) {
	$data[] = array('nazev' => $nazev, 'popis' => $pole['nazev'], 'checked' => ($_SESSION['rychle_info'][$i] ? ' checked="checked"' : ''));
	$i++;
}

$hrac = fa($Sql->q('SELECT email, icq, popis, posta_zavody, posta_zavody2 FROM hraci WHERE id = '.UID));
if($hrac['skin'] == 2) $selected2 = " selected";
if($hrac['posta_zavody'] == 1) $checked = "checked";
if($hrac['posta_zavody2'] == 1) $checked2 = "checked";

$fill['popis'] = stripslashes($hrac['popis']);
$fill['icq'] = $hrac['icq'];
$fill['email'] = $hrac['email'];
$fill['skin'] = $selected2;
$fill['checked'] = $checked;
$fill['checked2'] = $checked2;

$page = new cPage('nastaveni');
$page->getTable('INFO',$data,'INFO');
$page->fill($fill);
$page->finish();

do_footer();
?>