<?php

include 'library.php';
include './cls/cMultaci.php';

$login = $_POST['login'];
$heslo = $_POST['heslo'];

if($login == '' || $heslo == '') {
	$_SESSION['chyba'] = 'Nevyplnil jsi všechny požadované údaje';
	go('index.php');
	exit;
}

$result2 = $Sql->q('SELECT id,status FROM hraci WHERE login = "'.$login.'"');
if(p($result2) == 1) {
	$row = fa($result2);
	if($row['status'] == 0) {
		$_SESSION['chyba'] = 'Tento login je blokovaný';
		go('index.php');
		exit;  
	}
	if($row['status'] == -2) {
		$_SESSION['chyba'] = 'Nejdříve dokonči registraci';
		go('index.php');
		exit;  
	}
	
	$result = $Sql->q('SELECT id,login,status,skin,menu,rychle_info FROM hraci WHERE heslo = "'.md5($salt.$heslo).'" AND login = "'.$login.'"');
		
	if(!p($result)) {
		$result = $Sql->q('SELECT id,login,status,skin,menu,rychle_info FROM hraci WHERE heslo = "'.md5($heslo).'" AND login = "'.$login.'"');
		
		if(!p($result)) {
			$_SESSION['chyba'] = 'Špatné heslo nebo login';
			go('index.php');
			exit;
		}
		
		$Sql->q('UPDATE hraci set heslo = "'.md5($salt.$heslo).'" WHERE heslo = "'.md5($heslo).'" AND login = "'.$login.'"');
	}

	if(p($result)) {
		$row = fa($result);
		$stav = fa($Sql->q('SELECT val from sys WHERE entity = "stav_hry"'));
		if($stav['val'] == 0 && $row['status'] != 42) {
			$_SESSION['chyba'] = 'Hra je dočasně zablokována';
			go('index.php');
			exit;
		}
		
		$_SESSION['id_hrace'] = $row['id'];
		$_SESSION['status'] = $row['status'];
		$_SESSION['nick'] = $row['login'];
		$_SESSION['rychle_info'] = $row['rychle_info'];
		$_SESSION['menu'] = ($row['menu'] == '' ? $default_menu : $row['menu']);
		$_SESSION['aktivita'] = time();
		$rasa = getRasa($row['id']);
		$_SESSION['rasa_nazev'] = $rasa['nazev'];
		$_SESSION['skin'] = $row['skin'];
		$Sql->q('UPDATE hraci SET cas = '.time().', logged = 1, IP = "'.$_SERVER['REMOTE_ADDR'].'" WHERE id = '.$row['id']);
		
		if($row['status'] != 42) {
			$multaci = new cMultaci();
			$multaci->compare($row['id'], $row['login'], $_SERVER['REMOTE_ADDR']);
		}
		
	} else {
		$_SESSION['chyba'] = 'Špatné heslo nebo login';
		go('index.php');
		exit;
	}
} else {
	$_SESSION['chyba'] = 'Špatné heslo nebo login';
	go('index.php');
	exit;
}

if($_POST['autologin'] == 'on') {
	setcookie('autologin',$row['id'],time()+60*60*24*365*2); # 2 roky staci
	setcookie('autopsw',md5($salt.$heslo),time()+60*60*24*365*2); # 2 roky staci
	setcookie('autodate',time().rand(1,9),time()+60*60*24*365*2); # 2 roky staci
} else {
	unset($_COOKIE['autologin']);
	unset($_COOKIE['autopsw']);
	unset($_COOKIE['autodate']);
}

do_file('Přihlašování','empty','home.php');
echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<strong>Probíhá přihlašování...</strong><br />Vyčkejte prosím';
do_footer2();
?>