<?php

include 'library.php';

$nick = $_POST['nick'];

do_header('Zapomenuté heslo');

$page = new cPage('zapomenute_heslo');

$dlg = new cDialog('Chybné údaje','alert');
$dlg->button('OK','close');

if($nick == "") {
	$dlg->obody($page->ext('NO_LOGIN'));
	konec();
}

$result = $Sql->q('SELECT * from hraci WHERE login = "'.$nick.'"');

if(p($result) == 0) {
	$dlg->obody($page->ext('LOGIN',0,0,$_POST));
	konec();
}

$hrac = fa($result);

if($_POST['mail'] != $hrac['email']) {
	$dlg->obody($page->ext('EMAIL',0,0,$_POST));
	konec();
}

if($dlg->is_empty()) $dlg->type('submit','form_forget');

$dlg->output();

$klic = RegKey(8);

$Sql->q('UPDATE hraci set heslo = "'.md5($salt.$klic).'" WHERE login = "'.$nick.'"');

$obsah = 'Quadra Speed Boosters
Zapomenute heslo

Zmena hesla k nicknamu "'.$nick.'" probehla uspesne. Nove heslo je "'.$klic.'" (bez uvozovek).

-------------------------
Email byl vygenerovan automaticky. Prosim neodpovidejte';

mail($hrac['email'],'Zmena hesla',$obsah);

$page->ext('USPESNA',1,0,$_POST);
exit;
?>