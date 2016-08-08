<?php

include 'library.php';
is_logged();
$id = $_GET['id'];
$kolik = $_POST['kolik'];

// KONSTANTA - SLEVA, KTEROU MA STAJ PRI NAKUPU PALIVA! 
define('SLEVA', 0.9);

if($id == '' || !ereg('^[0-9]+$',$id) || $kolik == '' || !ereg('^[0-9]+$',$kolik)) {
	$_SESSION['chyba'] = "Nevyplnil jsi všechny požadované údaje";
	back();
	exit;
}

if($kolik <= 0) {
	$_SESSION['chyba'] = 'Nezadal jsi kladné číslo';
	go('buyPalivo.php?id='.$id);
	exit;  
}

$palivo = getPalivoAll($id);

$cena = $kolik*$palivo['cena']*SLEVA;

$result = $Sql->q('SELECT * from stajovnici WHERE login = '.UID.' AND stav = 3');
if(p($result) == 0) {
	$_SESSION['chyba'] = "Nejsi stájový obchodník";
	go('buyPalivo.php?id='.$id);
	exit;
}

$st = fa($result);

$staj = fa($Sql->q('SELECT * from staje WHERE id = '.$st['staj']));

$sklad = (p($Sql->q('SELECT * from budovy WHERE budova = 3 AND staveni = 0 AND staj = '.$staj['id']))*SKLAD_MALY+p($Sql->q('SELECT * from budovy WHERE budova = 7 AND staveni = 0 AND staj = '.$staj['id']))*SKLAD_VELKY);

$res = $Sql->q('SELECT * from paliva_sklad WHERE staj = 1 AND login = '.$staj['id']);
$obsazeno = 0;
for($i=0;$i<p($res);$i++) {
	$palivo2 = fa($res);
	$obsazeno += $palivo2['mnozstvi'];
}
$volno = ($sklad-$obsazeno);

if($kolik > $volno) {
	$_SESSION['chyba'] = 'Ve stájových skladech není dost místa';
	go('buyPalivo.php?id='.$id);
	exit;  
}

if($staj['kasa'] < $cena) {
	$_SESSION['chyba'] = 'Ve stájové kase není dostatek peněz';
	go('buyPalivo.php?id='.$id);
	exit;
}  

$res = $Sql->q('SELECT * FROM paliva_sklad WHERE login = '.$staj['id'].' AND staj = 1 AND palivo = '.$id);
if(p($res) != 0) {
	$row2 = fa($res);
	$mas = $row2['mnozstvi'];
} else {
	$Sql->q('INSERT into paliva_sklad(login,staj,palivo,mnozstvi) values('.$staj['id'].',1,'.$id.',0)');
	$mas = 0;
}
$Sql->q('UPDATE paliva_sklad set mnozstvi = '.($mas+$kolik).' WHERE login = '.$staj['id'].' AND staj = 1 AND palivo = '.$id);
$Sql->q('UPDATE staje set kasa = '.($staj['kasa']-$cena).' WHERE id = '.$staj['id']);

$_SESSION['chyba'] = 'Úspěšně jsi nakoupil palivo';
go('buyPalivo.php?id='.$id);
?>