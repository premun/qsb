<?php

include 'library.php';
$action = $_GET['action'];

$page = new cPage('nastaveni');

if($action == "popis") {
	$popis = str_replace('<','&lt;',$_POST['popis']);
	$popis = str_replace('>','&gt;',$popis);
	$result = $Sql->q('UPDATE hraci set popis = "'.addslashes($popis).'" WHERE id = '.UID);
	if($result) {
		$page->ext('POPIS1',1,'Nastavení');
	} else {
		$page->ext('POPIS2',1,'Nastavení');
	}
	exit;
}

if($action == "smazat") {
	if(!p($Sql->q('SELECT id FROM hraci WHERE id = '.UID.' AND heslo = "'.md5($salt.$_POST['heslo']).'"'))) {
		$_SESSION['chyba'] = 'Špatné heslo';
		go('nastaveni.php');
		exit;
	}

	$Sql->q('UPDATE hraci set status = -2 WHERE id = '.UID);
	$Sql->q('DELETE FROM stats WHERE login = '.UID);
	$Sql->q('INSERT into stats(login) values('.UID.')');
	$_SESSION['chyba'] = 'Účet zablokován';
	go('odhlas.php');
	exit;
}

if($action == "posta_zavody") {
	$val = 0;
	if($_POST['posta'] == 'on') $val = 1;
	$result = $Sql->q('UPDATE hraci set posta_zavody = '.$val.' WHERE id = '.UID);
	
	if($result) {
		$page->setCommon('ZAVODY');
		if($val == 1) $page->ext('EXTRA1',1,'Nastavení');
			else $page->ext('ZPET',1,'Nastavení');
	} else {
		$page->ext('ZAVODY2',1,'Nastavení');
	}
	exit;
}

if($action == "posta_zavody2") {
	$val = 0;
	if($_POST['posta'] == 'on') $val = 1;
	$result = $Sql->q('UPDATE hraci set posta_zavody2 = '.$val.' WHERE id = '.UID);

	if($result) {
		$page->setCommon('ZAVODY');
		if($val == 1) $page->ext('EXTRA2',1,'Nastavení');
			else $page->ext('ZPET',1,'Nastavení');
	} else {
		$page->ext('ZAVODY2',1,'Nastavení');
	}
	exit;
}

if($action == "skin") {
	$skin = $_POST['skin'];
	if($skin == "") {
		$_SESSION['chyba'] = "Nebyl vybrán žádný skin";
		go('nastaveni.php');
		exit;
	}
	$result = $Sql->q('UPDATE hraci set skin = '.$skin.' WHERE id = '.UID);
	$_SESSION['skin'] = $skin;

	if($result) {
		$page->ext('SKIN1',1,'Nastavení');
	} else {
		$page->ext('SKIN2',1,'Nastavení');
	}
	exit;
}

if($action == "password") {
	$new = $_POST['new'];
	$new2 = $_POST['new2'];
	$old = $_POST['old'];
	if($old == '' || $new == '' || $new2 == '') {
		$_SESSION['chyba'] = $errors->getErr(5);
		go('nastaveni.php');
		exit;
	}

	$result = $Sql->q('SELECT * from hraci WHERE id = '.UID.' AND heslo = "'.md5($salt.$old).'"');
	if(p($result) == 0) {
		$_SESSION['chyba'] = 'Zadané staré heslo není správné';
		go('nastaveni.php');
		exit;  
	}

	if($new != $new2) {
		$_SESSION['chyba'] = 'Zadaná nová hesla nejsou stejná';
		go('nastaveni.php');
		exit;     
	}
	
	if(!ereg('^[A-Za-z0-9_]+$',$new)) {
		$_SESSION['chyba'] = 'Zadaná nová hesla obsahují nepovolené znaky';
		go('nastaveni.php');
		exit;  
	}

	$result = $Sql->q('UPDATE hraci set heslo = "'.md5($salt.$new).'" WHERE id = '.UID);
	
	if($result) {
		$page->ext('HESLO1',1,'Nastavení');
	} else {
		$page->ext('HESLO2',1,'Nastavení');
	}
	exit; 
}

if($action == "irc_password") {
	$new = $_POST['new'];
	
	if($new == '') {
		$_SESSION['chyba'] = $errors->getErr(5);
		go('nastaveni.php');
		exit;
	}
	
	if(!ereg('^[A-Za-z0-9_]+$',$new)) {
		$_SESSION['chyba'] = 'Zadané heslo obsahuje nepovolené znaky';
		go('nastaveni.php');
		exit;  
	}

	$result = $Sql->q('UPDATE hraci set irc_heslo = "'.md5($salt.$new).'" WHERE id = '.UID);
	
	if($result) {
		$page->ext('HESLO1',1,'Nastavení');
	} else {
		$page->ext('HESLO2',1,'Nastavení');
	}
	exit; 
}

if($action == 'icq') {
$icq = $_POST['icq'];
if(!ereg('^[0-9]{9}$',$icq) || $icq == '') {
	$_SESSION['chyba'] = 'Zadané ICQ obsahuje nepovolené znaky';
		go('nastaveni.php');
		exit;    
	}
	$result = $Sql->q('UPDATE hraci set icq = "'.$icq.'" WHERE id = '.UID);
	
	if($result) {
		$page->ext('ICQ1',1,'Nastavení');
	} else {
		$page->ext('ICQ2',1,'Nastavení');
	}
	exit; 
}

if($action == 'email') {
	$email = $_POST['email'];
	
	if($email == '') {
		$_SESSION['chyba'] = 'E-mail je prázdný';
		go('nastaveni.php');
		exit;    
	}
	
	if(!ereg('^[_a-zA-Z0-9+\-\.]+@[_a-zA-Z0-9+\-]+(\.)[a-zA-Z]{2,4}$',$email)) {
		$_SESSION['chyba'] = 'Zadaný e-mail není v platném formátu nebo obsahuje nepovolené znaky';
		go('nastaveni.php');
		exit;    
	}
	$result = $Sql->q('UPDATE hraci set email = "'.$email.'" WHERE id = '.UID);
	
	if($result) {
		$page->ext('EMAIL1',1,'Nastavení');
	} else {
		$page->ext('EMAIL2',1,'Nastavení');
	}
	exit; 
}

if($action == 'rychle_info') {

	$cInfobox->getItems();
	$i = 0;
	foreach($cInfobox->items as $nazev => $pole) {
		$info .= ($_POST[$nazev] == 'on' ? '1' : '0');
		$i++;
	}
	
	$result = $Sql->q('UPDATE hraci set rychle_info = "'.$info.'" WHERE id = '.UID);
	$_SESSION['rychle_info'] = $info;
	
	if($result) {
		$_SESSION['chyba'] = 'Rychlé info nastaveno';
		go('nastaveni.php');	
	}
	exit; 
}

if($action == 'avatar') {	
	$id = UID;
	
	while(strlen($id) < 5) $id = '0'.$id;
	
	$name = 'avatar_'.$id.'.jpg';
	
	if(!ereg('image',$HTTP_POST_FILES['obr']['type'])) {
		$_SESSION['chyba'] = 'Špatný formát obrázku';
		go('nastaveni.php');		
		exit;
	}
	
	$img = $HTTP_POST_FILES['obr']['tmp_name'];
	$percent = 0;
	$constrain = 1;
	$w = 150;
	$h = 230;
	
	$x = @getimagesize($img);
	
	$sw = $x[0];	
	$sh = $x[1];
	
	if ($percent > 0) {
		$percent = $percent * 0.01;
		$w = $sw * $percent;
		$h = $sh * $percent;
	} else {
		if (isset ($w) && !isset ($h)) {
			$h = (100 / ($sw / $w)) * .01;
			$h = @round ($sh * $h);
		} elseif (isset ($h) && !isset ($w)) {
			$w = (100 / ($sh / $h)) * .01;
			$w = @round ($sw * $w);
		} elseif (isset ($h) && isset ($w) && isset ($constrain)) {
	
			$hx = (100 / ($sw / $w)) * .01;
			$hx = @round ($sh * $hx);
	
			$wx = (100 / ($sh / $h)) * .01;
			$wx = @round ($sw * $wx);
	
			if ($hx < $h) {
				$h = (100 / ($sw / $w)) * .01;
				$h = @round ($sh * $h);
			} else {
				$w = (100 / ($sh / $h)) * .01;
				$w = @round ($sw * $w);
			}
		}
		
		if($w > $sw && $h > $sh) {
			$w = $sw;
			$h = $sh;
		}
	}
	
	$im = @imagecreatefromjpeg ($img) or 
	$im = @imagecreatefrompng ($img) or
	$im = @imagecreatefromgif ($img) or
	$im = false;
	if (!$im) {
		$_SESSION['chyba'] = 'Špatný formát obrázku';
		go('nastaveni.php');		
		exit;		
	} else {
		$thumb = imagecreatetruecolor ($w, $h);
		imagecopyresampled ($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);
		
		imagejpeg ($thumb,'./avatars/'.$name);
	}
	
	$_SESSION['chyba'] = 'Avatar nahrán';
	go('showProfile.php?id='.UID);		
	exit;
}
?>