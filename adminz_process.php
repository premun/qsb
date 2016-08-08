<?php
include_once 'library.php';
$action = $_GET['action'];

if($action == 'novinka') {
	$Sql->q('INSERT into novinky(cas, novinka, titulek) values('.time().',"'.$_POST['novinka'].'","'.$_POST['titulek'].'")');
}

if($action == 'anketa') {
	$Sql->q('INSERT into ankety(otazka,odpovedi) values("'.$_POST['otazka'].'","'.$_POST['odpovedi'].'")');
}

if($action == 'posta') {
	$msg = $_POST['zprava'];
	$result = $Sql->q("SELECT id FROM hraci WHERE status > -2");
	for($i=0;$i<p($result);$i++) {
		$hrac = fa($result);
		sendPosta(0,$hrac['id'],$msg);
	}
}

if($action == 'nastenka') {
	$Sql->q('INSERT into nastenka(login, sekce, cas, titulek, obsah) values('.UID.', 1, '.time().', "'.$_POST['titulek'].'", "'.$_POST['obsah'].'")');
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
	go('adminz.php');
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
	
	$dlg = new cDialog('Přidání bota', 'alert');
	$dlg->set('width', '250px');
	$dlg->body('Bot přidán.');
	$dlg->button('K závodu', 'location', 'showRace.php?id='.$_POST['zavod']);
	$dlg->button('Zavřít', 'close');
	$dlg->output();
}

if($action == 'spion') {
	$obet = $_POST['ids'];
	$obet2 = $_POST['login'];
	
	if(!$obet) {
		$result2 = $Sql->q('SELECT h.login as login, h.id as id, p.rasa as rasa, h.skin as skin FROM hraci as h LEFT JOIN postavy as p ON h.id = p.login WHERE h.login = "'.$obet2.'"');
	} else {
		$result2 = $Sql->q('SELECT h.login as login, h.id as id, p.rasa as rasa, h.skin as skin FROM hraci as h LEFT JOIN postavy as p ON h.id = p.login WHERE h.id = '.$obet);
	}
	
	if(p($result2) == 1) {
		$row = fa($result2);
		$_SESSION['id_hrace'] = $row['id'];
		$_SESSION['nick'] = $row['login'];
		$_SESSION['rasa'] = $row['rasa'];
		$_SESSION['skin'] = $row['skin'];
		go('home.php');
		exit;
	}
}


########################################################################################################################
########################################################################################################################
########################################################################################################################


if($action == 'blokace') {
	$Sql->q('UPDATE sys set val = '.($_GET['povolit'] == 'ano' ? 0 : 1).' WHERE entity = "stav_hry"');
}

if($action == "pohar") {
	if($_GET['sub'] == "sign") {
		$pohar = fa($Sql->q('SELECT * from sys WHERE entity = "pohar"'));
		if($pohar['val'] < -1) $Sql->q('UPDATE sys set val = "-1" WHERE entity = "pohar"');
	}
	if($_GET['sub'] == "start") {
		$pohar = fa($Sql->q('SELECT * from sys WHERE entity = "pohar"'));
		if($pohar['val'] == -1) {
			$Sql->q('UPDATE sys set val = "7" WHERE entity = "pohar"');
			$Sql->q('UPDATE sys set val = "0" WHERE entity = "pohar_zavod"');
		}
	}
}

if($action == "restart_zavodu") {
	$Sql->q('UPDATE zavody SET vitez = 0 WHERE id = '.$_POST['zavod']);
	$Sql->q('UPDATE zavodnici SET vyhra = 0, poradi = 0 WHERE zavod = '.$_POST['zavod']); 
}

if($action == "vymazZalohu") {
	@unlink('./vypisy/db/'.$_POST['filename'].'.rec');
}

if($action == "zaloha") {
	$path = './vypisy/db/'.$_GET['file'];
	
	header("Content-Disposition: attachment; filename=qsb_zaloha_".date('Y-m-d').".sql"); 
	header("Content-Type: application/force-download");
	header("Content-Type: application/download");
	header("Content-Description: File Transfer");            
	header("Content-Length: " . filesize($path));
	
	die(file_get_contents($path));
}

########################################################################################################################
########################################################################################################################
########################################################################################################################

if($action == "blok") {
	$Sql->q('UPDATE hraci set status = -2 WHERE login = "'.$_POST['blok_login'].'"');
}

if($action == "odblok") {
	$Sql->q('UPDATE hraci set status = 1 WHERE id = '.$_POST['odblok_login']);
}

if($action == 'konzulove') {
	$konzulove = "832,969,860,6,864,14,787,15,4";
	$Sql->q('UPDATE hraci set status = 2 WHERE id IN('.$konzulove.') AND status = 1');
}

if($action == "penize") {
	$row = fa($Sql->q('SELECT id FROM hraci WHERE login = "'.$_POST['penize_login'].'"'));
	$Sql->q('UPDATE postavy set penize = penize+'.$_POST['penize'].' WHERE login = '.$row['id']);
	finance($row['id'],abs($_POST['penize']),($_POST['penize'] > 0 ? 1 : 0),31);
}

if($action == "restartHrace") {
	$row = fa($Sql->q('SELECT id FROM hraci WHERE login = "'.$_POST['restart_login'].'"'));
	$login = $row['id'];
	$rasa = $_POST['rasa'];
	if($login != '') {
		$Sql->q('UPDATE hraci set status = -1 WHERE id = '.$login);
		if($rasa != "same") {
			$Sql->q('UPDATE postavy set penize = 0, prestiz = 1000, rasa = '.$rasa.' WHERE login = '.$login);
		} else {
			$Sql->q('UPDATE postavy set penize = 0, prestiz = 1000 WHERE login = '.$login);
		}
		$Sql->q('DELETE FROM stajovnici WHERE login = '.$login);
		$Sql->q('DELETE FROM zavodnici WHERE login = '.$login);
		$Sql->q('DELETE FROM paliva_sklad WHERE login = '.$login);
		$Sql->q('DELETE FROM sklad WHERE login = '.$login);
		$Sql->q('DELETE FROM smlouvy WHERE login = '.$login);
		$Sql->q('DELETE FROM brigadnici WHERE login = '.$login);
		$Sql->q('DELETE FROM pujcky WHERE hrac = '.$login);
		$Sql->q('DELETE FROM finance WHERE hrac = '.$login);
	}
}
?>