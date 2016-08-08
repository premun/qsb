<?php

include 'library.php';
is_logged();
$id = $_GET['id'];
$kolik = $_POST['kolik'];

if($id == '' || !ereg('^[0-9]+$',$id)) {
	$_SESSION['chyba'] = "Nevyplnil jsi všechny požadované údaje";
	go('buyPalivo.php?id='.$id);
	exit;
}

if($kolik == '') {
	$_SESSION['chyba'] = "Nevyplnil jsi všechny požadované údaje";
	go('buyPalivo.php?id='.$id);
	exit;
}

if($kolik <= 0) {
	$_SESSION['chyba'] = "Nevyplnil jsi kladné číslo!";
	go('buyPalivo.php?id='.$id);
	exit;
}

$palivo = getPalivoAll($id);

$cena = $kolik*$palivo['cena'];

if(getPenize(UID) < $cena) {
	$_SESSION['chyba'] = 'Nemáš dostatek peněz';
	go('buyPalivo.php?id='.$id);
	exit;
}

$res = $Sql->q('SELECT * FROM paliva_sklad WHERE login = '.UID.' AND staj = 0 AND palivo = '.$id);
if(p($res) != 0) {
	$row2 = fa($res);
	$mas = $row2['mnozstvi'];
} else {
	$Sql->q('INSERT into paliva_sklad(login,staj,mnozstvi,palivo) values('.UID.',0,0,'.$id.')');
	$mas = 0;
}
$Sql->q('UPDATE paliva_sklad set mnozstvi = '.($mas+$kolik).' WHERE login = '.UID.' AND staj = 0 AND palivo = '.$id);
$Sql->q('UPDATE postavy set penize = penize-'.$cena.' WHERE login = '.UID);

finance(UID,$cena,0,21);

$_SESSION['chyba'] = 'Úspěšně jsi nakoupil palivo';
go('buyPalivo.php?id='.$id);
?>