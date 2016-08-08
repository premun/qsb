<?php
include 'library.php';

//is_logged();

if(defined(UID))
	$Sql->q('UPDATE hraci SET logged = 0 WHERE id = '.UID);

foreach($_SESSION as $key => $val)
	if($key != 'chyba')
		unset($_SESSION[$key]);

setcookie('autologin');
setcookie('autopsw');
setcookie('autodate');

$chyba = 'Odhlášen';

if($_SESSION['chyba2'] == '') $_SESSION['chyba'] = 'Odhlášen';
	else $chyba = $_SESSION['chyba2'];

do_file('Odhlašování','empty','index.php');
echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<strong>Probíhá odhlašování...</strong><br />Vyčkejte prosím';
do_footer2();

unset($_SESSION['chyba2']);
$_SESSION['chyba'] = $chyba;
?>