<?php

include 'library.php';
is_logged();
$action = $_GET['action'];

$page = new cPage('pohar');

$fill['nazev'] = POHAR_NAZEV;

if($action == "kick") {
	$login = $_GET['login'];
	$staj = $_GET['staj'];
	
	if(p($Sql->q('SELECT * from staje WHERE login = '.UID.' AND id = '.$staj)) == 0) {
		$page->ext('VLASTNIK',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * FROM pohar WHERE login = '.$login)) == 0) {
		$page->ext('NENI',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from stajovnici WHERE login = '.$login.' AND staj = '.$staj)) == 0) {
		$page->ext('JINA_STAJ',1,'Pohár',$fill);
		exit;
	}
	
	if(!p($Sql->q('SELECT val FROM sys WHERE entity = "pohar" AND val = -1'))) {
		$page->ext('UZ_BEZI',1,'Pohár',$fill);
		exit;	
	}
	
	$Sql->q('DELETE FROM pohar WHERE login = '.$login.' AND staj = '.$staj);
	
	$msg = "Vlastník tvé stáje tě odhlásil z poháru ".POHAR_NAZEV."
	
	SYSTEM";
	sendPosta(0,$login,$msg);
	
	
	$_SESSION['chyba'] = 'Hráč odhlášen z turnaje';
	go('staje.php?action=pohar');
	exit;	
}

if($action == "sign") {
	$login = $_POST['login'];
	$staj = $_POST['staj'];
	
	if($login == '') {
		$page->ext('ZADNY_HRAC',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from hraci WHERE id = '.$login)) == 0) {
		$page->ext('EXIST',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from staje WHERE login = '.UID.' AND id = '.$staj)) == 0) {
		$page->ext('VLASTNIK',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from stajovnici WHERE login = '.$login.' AND staj = '.$staj)) == 0) {
		$page->ext('JINA_STAJ',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from stajovnici WHERE login = '.$login.' AND stav != 3')) == 0) {
		$page->ext('ZAVODNIK',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from pohar WHERE staj = '.$staj)) >= POHAR_MAX_JEZDCU) {
		$fill['max'] = POHAR_MAX_JEZDCU;
		$page->ext('MAX',1,'Pohár',$fill);
		exit;
	}
	
	if(p($Sql->q('SELECT * from pohar WHERE login = '.$login)) > 0) {
		$page->ext('UZ_JE',1,'Pohár',$fill);
		exit;
	}
	
	
	$Sql->q('INSERT into pohar(login,staj) values('.$login.','.$staj.')');
	
	$msg = "Vlastník tvé stáje tě přihlásil do poháru ".POHAR_NAZEV."
	
	SYSTEM";
	sendPosta(0,$login,$msg);
	
	
	$_SESSION['chyba'] = 'Hráč přihlášen do turnaje';
	go('staje.php?action=pohar');
	exit;
}

if($action == "") {
	$fill['obsah'] = '';
	
	do_header('Pohár');
	
	$pohar = fa($Sql->q('SELECT * from sys WHERE entity = "pohar"'));
	$stav = "neprobíhá";
	if($pohar['val'] > -1) {
		$fill['stav'] = 'probíhá';
	}
	if($pohar['val'] == 42) {
		$fill['stav'] = 'ukončen';
	}
	if($pohar['val'] == -1) {
		$fill['stav'] = 'zatím neodstartován - probíhá přihlášování jezdců';
	}  
	if($pohar['val'] == -2) {
		$fill['stav'] = 'ukončen';
	}  
  
	if($pohar['val'] == -1) {
		$result = $Sql->q('SELECT p.login as login, p.staj as staj, s.nazev as nazev, h.login as nick FROM pohar as p LEFT JOIN staje as s ON s.id = p.staj LEFT JOIN hraci as h ON h.id = p.login ORDER BY p.staj ASC');
		if(p($result) > 0) {
			for($i=0;$i<p($result);$i++) {
				$row = fa($result);
				$data[] = $row;
			}
			
			$page->misc('OTEVRENY','OBSAH');
			$page->getTable('JEZDCI',$data,'JEZDCI');
		
		} else {
			$page->misc('NIKDO','OBSAH');
		}
	}
  
	if($pohar['val'] > -1 || $pohar['val'] == -2) {
		
		$result = $Sql->q('SELECT p.login as login, p.staj as staj, p.body as body, p.zavody as zavody, s.nazev as nazev, h.login as nick FROM pohar as p LEFT JOIN staje as s ON s.id = p.staj LEFT JOIN hraci as h ON h.id = p.login ORDER BY p.body DESC, p.zavody DESC, p.id ASC');
		
		for($i=0;$i<p($result);$i++) {
			$hrac = fa($result);
			$hrac['misto'] = $i+1;
			$data[] = $hrac;
		}
		
		$page->getTable('JEZDCI2',$data,'OBSAH');
		
		$trate = $pohar_trate;
		$row2 = fa($Sql->q('SELECT val FROM sys WHERE entity = "pohar_zavod"'));

		$barva2[0] = '#02FD09';
		$barva2[1] = '#FFFF00';
		$barva2[2] = '#FF0000';
		
		$delka2[0] = 'krátká';
		$delka2[1] = 'střední';
		$delka2[2] = 'dlouhá';
		
		$data = array();
		
		foreach($trate as $ind=>$val) {
			$row = fa($Sql->q('SELECT nazev, trat, delka FROM trate WHERE id = '.$val));
			
			$diff = getDiffOpt($row['trat']);
			if($diff < 21) $line['diff1'] = $barva2[0];
			if($diff >= 21) $line['diff1'] = $barva2[1];
			if($diff >= 38) $line['diff1'] = $barva2[2];		
		
			$barva1 = ($ind == $row2['val']-1 ? '#FF9900' : '#666666');
			
			$line['barva1'] = $barva1;
			$line['poradi'] = ($ind+1);
			$line['id'] = $val;
			$line['nazev'] = $row['nazev'];
			$line['diff2'] = numF($diff);

			$line['delka1'] = $barva2[$row['delka']];
			$line['delka2'] = $delka2[$row['delka']];
			
			$data[] = $line;
		}
		
		$page->getTable('TRATE',$data,'TRATE');
	}

	$page->fill($fill);
	$page->finish();
	do_footer();
	exit;
}
?>