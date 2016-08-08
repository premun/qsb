<?php

include 'library.php';
is_logged();

$dlg = new cDialog('Odesílání pošty', 'alert');
$dlg->button('OK','close');

$n = $_POST['prijemci'];
$msg = $_POST['posta_msg'];

$nicky = array();
for($i=1;$i<$n+1;$i++) {
	if($_POST['nick_'.$i] != "" && !in_array($_POST['nick_'.$i], $nicky)) $nicky[] = $_POST['nick_'.$i];
}

if(!count($nicky)) {
	$_SESSION['chyba'] = 'Žádní příjemci';
	$dlg->obody('Žádní příjemci');
	go('posta.php');
	konec();
}

if($msg == '') {
	$_SESSION['chyba'] = 'Není vyplněna zpráva';
	$dlg->obody('Není vyplněna zpráva');
	go('posta.php');
	konec();
}

$seznam = '"'.implode('","', $nicky).'"';

$result = $Sql->q('SELECT id FROM hraci WHERE login IN('.$seznam.')');

if(!p($result)) {
	$_SESSION['chyba'] = 'Příjemci nebyli nalezeni';
	$dlg->obody('Příjemci nebyli nalezeni');
	go('posta.php');
	konec();
}

if(!$dlg->is_empty()) $dlg->output();

$msg = str_replace('<','&lt;',$msg);
$msg = str_replace('>','&gt;',$msg);
$odeslano = 0;

for($i=0;$i<p($result);$i++) {
	$hrac = fa($result);
	sendPosta(UID, $hrac['id'], $msg);
}

$_SESSION['chyba'] = 'Pošta byla úspěšně odeslána';
$dlg->obody('Pošta byla úspěšně odeslána');
go('posta.php');
konec();

unset($_SESSION['chyba']);
$dlg->output();
?>