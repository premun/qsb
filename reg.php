<?php

include 'library.php';
$login = $_POST['login'];
$heslo = $_POST['heslo'];
$heslo2 = $_POST['heslo2'];
$email = $_POST['e-mail'];
$icq = $_POST['icq'];
$postava = $_POST['postava'];
$kluzak = $_POST['kluzak'];

if($_GET['action'] == 'com') {
	$login = $_POST['login'];
	$heslo = $_POST['heslo'];
	#-----OVEROVANI
	$result2 = $Sql->q('SELECT id FROM hraci WHERE login = "'.$login.'" AND heslo = "'.md5($salt.$heslo).'"');
	if(p($result2) == 0) {
		$_SESSION['chyba'] = 'Špatné heslo';
		back();
		exit;
	}
	$row = fa($result2);
	#-----OVEROVANI
	
	#-----dokonceni registrace
	$result = $Sql->q('DELETE FROM registrace WHERE login = '.$row['id']);
	$result2 = $Sql->q('UPDATE hraci SET status = -1 WHERE login = "'.$login.'"');
	if(!$result || !$result2) {
		$_SESSION['chyba'] = 'Registraci se nepodařilo dokončit, kontaktuj prosím admina';
		back();
		exit;
	}
	#-----dokonceni registrace
	do_header('Registrace');
	echo '
	<h3>Registrace</h3>
	Registrace proběhla úspěšně. Pokračuj prosím přihlášením do hry
	';
	do_footer();
	exit;
}


#------- OVEROVANI PLATNOSTI UDAJU --------
$reg = new cReg(LOGIN);

$dlg = new cDialog('Registrace','alert');
$dlg->button('OK','location','#top');

if($login == '' || $heslo == '' || $heslo2 == '' || $email == '') {
	$dlg->obody('Nevyplnil jsi všechny požadované údaje');
	$_SESSION['chyba'] = 'Nevyplnil jsi všechny požadované údaje';
	go('registrace');
	konec();
}

if(!$reg->test($login)) {
	$dlg->obody('V nicknamu byly použity nepovolené znaky');
	$_SESSION['chyba'] = 'V nicknamu byly použity nepovolené znaky';
	go('registrace');
	konec();
}

if($login == "SYSTEM") {
	$dlg->obody('Nepovolený nickname');
	$_SESSION['chyba'] = 'Nepovolený nickname';
	go('registrace');
	konec();
}

if(!$reg->test($heslo) || !$reg->test($heslo2)) {
	$dlg->obody('V hesle byly použity nepovolené znaky');
	$_SESSION['chyba'] = 'V hesle byly použity nepovolené znaky';
	go('registrace');
	konec();
}

$reg->change(EMAIL);

if(!$reg->test($email)) {
	$dlg->obody('E-mail neodpovídá formátu');
	$_SESSION['chyba'] = 'E-mail neodpovídá formátu';
	go('registrace');
	konec();
}

$reg->change(ICQ);

$icq = str_replace(' ','',$icq);
if(!$reg->test($icq) && $icq != '') {
	$dlg->obody('ICQ neodpovídá formátu 123456789');
	$_SESSION['chyba'] = 'ICQ neodpovídá formátu 123456789';
	go('registrace');
	konec();
}

if($heslo != $heslo2) {
	$dlg->obody('Hesla nejsou stejná');
	$_SESSION['chyba'] = 'Hesla nejsou stejná';
	go('registrace');
	konec();
}

$result = $Sql->q('SELECT id FROM hraci WHERE login = "'.$login.'"');
if(p($result) > 0) {
	$dlg->obody('Takový nickname už existuje');
	$_SESSION['chyba'] = 'Takový nickname už existuje';
	go('registrace');
	konec();
}

$result = $Sql->q('SELECT id FROM hraci WHERE email = "'.$email.'"');
if(p($result) > 0) {
	$dlg->obody('Na takový email již registrace proběhla');
	$_SESSION['chyba'] = 'Na takový email již registrace proběhla';
	go('registrace');
	konec();
}
#------- OVEROVANI PLATNOSTI UDAJU --------

if($dlg->is_empty()) $dlg->type('submit','form_registrace');
$dlg->output();

# MULTACI
$result = $Sql->q('SELECT id,login,IP FROM hraci WHERE IP = "'.$_SERVER['REMOTE_ADDR'].'"');
if(p($result) > 0) {
	$row = fa($result);
	$fp = fopen('./vypisy/multaci.txt','r');
	$obsah = fread($fp,4096*1000);
	fclose($fp);
	$fp = fopen('./vypisy/multaci.txt','w');
	fwrite($fp,$obsah.'
Nick: '.$login.' se regnul s IP ('.$row['id'].' '.$row['login'].')');
	fclose($fp);
}

#------- VKLADANI UDAJU -----
$result1 = $Sql->q('INSERT into hraci(login,heslo,email,icq,IP,status) values("'.$login.'","'.md5($salt.$heslo).'","'.$email.'","'.$icq.'","'.$_SERVER['REMOTE_ADDR'].'",0)');
$result = $Sql->q('SELECT id FROM hraci WHERE login = "'.$login.'"');
$row = fa($result);
$key = RegKey(42);
$result1 = $Sql->q('INSERT into stats(login) values("'.$row['id'].'")');
$result3 = $Sql->q('INSERT into postavy(login,rasa) values('.$row['id'].','.$postava.')');
$result3 = $Sql->q('INSERT into new_rasy(login,kluzak,rasa) values('.$row['id'].','.$kluzak.','.$postava.')');
$result2 = $Sql->q('INSERT into registrace values(NULL,"'.$key.'",'.$row['id'].',"'.date("Y-m-d").'")');

#------- VKLADANI UDAJU -----

$headers = "From: registrace@qsb.cz \r\n";
$headers.= "Content-Type: text/plain; charset=utf8 ";
#$headers .= "MIME-Version: 1.0 "; 

mail($email,'Registrace','Registrace do hry QSB
Toto je potvrzovaci e-mail registrace do hry Quadra Speed Boosters.

Pokud jste se do zadne takove hry neregistroval, nekdo jen pouzil vasi adresu a tento e-mail je omyl. Byl odeslan a vygenerovan automaticky. Neodpovidejte prosim. Pro dokonceni registrace kliknete na nize uvedenou internetovou adresu.
http://www.qsb.cz/registrace?action=regkey&login='.$row['id'].'&key='.$key.'
Registrovany nickname: '.$login.'
Vas registracni klic: '.$key.'
Nikomu neposilejte svuj registracni klic. Nikdo ho po vas vyzadovat nebude, s vyjimkou dokoncovani registrace.
Je mozne, ze po uplynuti 3 dnu bude bez aktivace registrace neplatna a budete muset projit registraci znovu.

                                                    QSB
													
-------------------------
Email byl vygenerovan automaticky. Prosim neodpovidejte
',$headers);

if(!$result1 || !$result2 || !$result3) {
  $_SESSION['chyba'] = 'Registrace neproběhla úspěšně';
  go('registrace');
  konec();
}

go('registraces.php');
konec();
?>