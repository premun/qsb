<?php
include_once 'library.php';
if($_SESSION['status'] < 2) exit;

$action = $_GET['action'];

if($action == 'novinka') {
	$Sql->q('INSERT into novinky(cas, novinka, titulek) values('.time().',"'.$_POST['novinka'].'","'.$_POST['titulek'].'")');
	
	sendPosta(0, 1, getNick(UID)." přidal novinku.");
}

if($action == 'anketa') {
	$Sql->q('INSERT into ankety(otazka,odpovedi) values("'.$_POST['otazka'].'","'.$_POST['odpovedi'].'")');
	
	sendPosta(0, 1, getNick(UID)." přidal anketu.");
}

if($action == 'posta') {
	$msg = $_POST['zprava'];
	$result = $Sql->q("SELECT id FROM hraci WHERE status > -2");
	for($i=0;$i<p($result);$i++) {
		$hrac = fa($result);
		sendPosta(0,$hrac['id'],$msg);
	}
	
	sendPosta(0, 1, getNick(UID)." rozeslal poštu.");
}

if($action == 'nastenka') {
	$Sql->q('INSERT into nastenka(login, sekce, cas, titulek, obsah) values('.UID.', 1, '.time().', "'.$_POST['titulek'].'", "'.textFormat($_POST['obsah']).'")');
	
	sendPosta(0, 1, getNick(UID)." upravil nástěnku.");
}

if($action == 'blokace_hrace') {
	$Sql->q('UPDATE hraci set status = -2 WHERE login = "'.$_POST['login'].'"');
}

########################################################################################################################
########################################################################################################################
########################################################################################################################

if($action == 'forum') {
	if($_GET['povolit'] == 'ano') $_SESSION['mazani_fora'] = 'yeah';
	else unset($_SESSION['mazani_fora']);
}

if($action == 'sablona') {
	$row = array();
	array_pop($tabs);
	
	foreach($_POST['sablona'] as $id) {
		$sablona = fa($Sql->q('SELECT * FROM sablony WHERE id = '.$id));
		
		$kusy = explode(' - ', $sablona['nazev']);
		
		$scw = 3;
		switch(strtolower($kusy[0])) {
			case 's':
			case 'sport':
				$scw = 1;
				break;

			case 'c':				
			case 'combi':
				$scw = 2;
				break;
			
			case 'w':
			case 'wrecker':
				$scw = 3;
				break;
		}
		
		foreach(explode(',', $kusy[1]) as $cena) {
		
			$row = array('typ' => $scw, 'cena' => $cena, 'odolnost' => $kusy[3], 'ovladatelnost' => $kusy[4], 'kategorie' => $kusy[2]);
		
			foreach($tabs as $i => $typ) {
				$zbozi = fa($Sql->q('SELECT typ, zbozi FROM sklad WHERE id = '.$sablona[$typ]));
				$row[$typ] = numF($zbozi['zbozi']);
			}
			
			$Sql->q('INSERT into boti_kluzaky('.implode(',', array_keys($row)).') values('.implode(',', $row).')');		
		}
	}
	
	sendPosta(0, 1, getNick(UID)." přidal bota.");
	go('konzulove.php');
	exit;
}

if($action == 'add_bot') {
	$bot = fa($Sql->q('SELECT * FROM boti_jmena ORDER BY RAND() ASC'));
	$sablona = fa($Sql->q('SELECT * FROM boti_kluzaky WHERE id = '.$_POST['sablona']));
	$cena = $sablona['cena'];
	
	$prestiz = rand(700+50*$cena, 1150+70*$cena);
	$celkem = rand(3*$cena, 8*$cena);
	$treti = rand(0, ceil($celkem*0.7));
	$druhy = rand(0, min(ceil($celkem*0.35), $celkem-$treti, 0));
	$prvni = rand(0, min(ceil($celkem*0.15), $celkem-$treti-$druhy, 0));
	
	$vyhry = $celkem.'-'.$prvni.'-'.$druhy.'-'.$treti;
	
	$Sql->q('INSERT into boti(login, rasa, kluzak, prestiz, vyhry) values('.$bot['id'].', '.$_POST['rasa'].','.$_POST['sablona'].','.$prestiz.',"'.$vyhry.'")');
	
	$bot = fa($Sql->q('SELECT * FROM boti ORDER BY id DESC LIMIT 0,1'));
	$id = -1*$bot['id'];
	
	array_pop($tabs);
	foreach($tabs as $i => $tab) {
		if(!$sablona[$tab]) continue;
		
		$predmet = fa($Sql->q('SELECT vydrz FROM '.$tab.' WHERE id = '.$sablona[$tab]));
		$predmet2 = fa($Sql->q('SELECT cena FROM zbozi WHERE typ = '.$i.' AND zbozi = '.$sablona[$tab]));
		
		$Sql->q('INSERT into sklad(login, typ, zbozi, vydrz, cena, cena2, umisteni)
							values('.$id.', '.$i.', '.$sablona[$tab].', '.$predmet['vydrz'].', '.$predmet2['cena'].', 0, 1)');
	}

	$opatrnost = $_POST['opatrnost'];
	if(!is_numeric($opatrnost)) $opatrnost = 50;
	$opatrnost = max(15,$opatrnost);
	$opatrnost = min(85,$opatrnost);
	
	$agresivita = $_POST['agresivita'];
	if(!is_numeric($agresivita)) $agresivita = 50;
	$agresivita = max(-100,$agresivita);
	$agresivita = min(100,$agresivita);
	
	$postoj = 0;
	if($agresivita < 0) $postoj = $_POST['postoj1'];
	if($agresivita > 0) $postoj = $_POST['postoj2'];

	$taktika = 3;
	if($agresivita < 0) $taktika = $_POST['taktika1'];
	if($agresivita > 0) $taktika = $_POST['taktika2'];
	
	$Sql->q('INSERT into zavodnici(login,zavod,opatrnost,agresivita,postoj,taktika,obet) values('.$id.', '.$_POST['zavod'].', '.$opatrnost.', '.$agresivita.', '.$postoj.', '.$taktika.', 0)');
	
	sendPosta(0, 1, getNick(UID)." přidal bota.");
	
	$dlg = new cDialog('Přidání bota', 'alert');
	$dlg->set('width', '250px');
	$dlg->body('Bot přidán.');
	$dlg->button('K závodu', 'location', 'showRace.php?id='.$_POST['zavod']);
	$dlg->button('Zavřít', 'close');
	$dlg->output();
}
?>