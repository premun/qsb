<?php

include 'library.php';
is_logged();

do_header('Tvorba trati');
$page = new cPage('newTrat');

if($_GET['action'] == 'new') {
	$nazev = trim($_POST['nazev']);
	$reg_login = '^[A-Za-z0-9_ěščřžýáíéďťňúůóĚŠČŘŽÝÁÍÉĎŤŇÚŮÓ ]+$';
	if(!ereg($reg_login,$nazev))
		$error = 'Název trati není v požadovaném formátu';

	
	$result = $Sql->q('SELECT * from trate WHERE nazev = "'.str_replace('_',' ',$nazev).'"');
	if(p($result) > 0) 
		$error = 'Název trati již existuje';
	
	if($error != '') {
		$dlg = new cDialog('Tvorba trati', 'alert');
		$dlg->body($error);
		$dlg->button('OK', 'close');
		$dlg->output();
	}
	
	$_SESSION['trat_popis'] = $_POST['popis'];
	
	$dlg = new cDialog('createTrack.php?nazev='.$_POST['nazev'].'&delka='.$_POST['delka'], 'location');
	
	$dlg->output();
}

if($_GET['action'] == '') {
	$fill['min'] = TRAT_USEKY_MIN;
	$fill['max'] = TRAT_USEKY_MAX;
	$fill['usek'] = TRAT_USEK;
	$fill['zaklad'] = TRAT_ZAKLAD;
	$fill['pouziti'] = POUZITI_TRATE;

	$page->fill($fill);
	$page->finish();	
	do_footer();
	exit;
}

if($_GET['action'] == 'save') {
	$nazev = trim($_GET['nazev']);
	$useky = explode(',', $_GET['trat']);
	$delka = $_GET['delka'];
	
	$reg_login = '^[A-Za-z0-9_ěščřžýáíéďťňúůóĚŠČŘŽÝÁÍÉĎŤŇÚŮÓ ]+$';
	if(!ereg($reg_login,$nazev)) {
		$_SESSION['chyba'] = 'Název trati není v požadovaném formátu';
		go('newTrack.php','js');
		exit;
	}
	
	if(count($useky) < TRAT_USEKY_MIN || count($useky) > TRAT_USEKY_MAX) {
		$_SESSION['chyba'] = 'Délka trati musí být v rozmezí '.TRAT_USEKY_MIN.'-'.TRAT_USEKY_MAX;
		go('newTrack.php','js');
		exit;
	}
	
	$result = $Sql->q('SELECT * FROM trate WHERE nazev = "'.str_replace('_',' ',$nazev).'"');
	if(p($result) > 0) {
		$_SESSION['chyba'] = 'Název trati již existuje';
		go('newTrack.php','js');
		exit;
	}
	
	$cena = TRAT_ZAKLAD+count($useky)*TRAT_USEK;
	
	if($cena > getPenize(UID)) {
		$_SESSION['chyba'] = 'Nemáš dostatek peněz';
		go('newTrack.php','js');
		exit;
	}

	foreach($useky as $i => $usek) {
		if($useky[$i-1] >= 10 && $useky[$i-1] <= 15) {
			if($usek != 16 && $usek != 17) {
				$_SESSION['chyba'] = 'Po rozdvojení cesty musí následovat ihned spojení cesty';
				go('newTrack.php','js');
				exit;
			}
		}
	}
	
	if($delka == "") $delka = 0;
	
	$Sql->q('INSERT into trate(nazev,login,datum,popis,delka,useky,trat) values("'.$nazev.'",'.UID.',"'.date('Y-m-d').'","'.$_SESSION['trat_popis'].'",'.$delka.','.count($useky).',"'.implode(',', $useky).'")');
	$Sql->q('UPDATE postavy set prestiz = prestiz+'.TRAT_PRESTIZ.', penize = penize-'.$cena.' WHERE login = '.UID);
	
	unset($_SESSION['trat_popis']);
	
	finance(UID,$cena,0,30);
	
	if($parts > 14) addQuest(UID,73,0);
	
	$nova = fa($Sql->q('SELECT id FROM trate ORDER BY id DESC LIMIT 0,1'));
	
	$_SESSION['chyba'] = 'Trať byla úspěšně vytvořena';
	go('showTrat.php?id='.$nova['id'], 'js');
}
?>