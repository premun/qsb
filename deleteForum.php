<?php

include 'library.php';
is_logged();

$id = $_GET['id'];

if(!is_numeric($id)) {
	$_SESSION['chyba'] = 'Mazání nebylo úspěšné';
	back();
	exit;
}

$row = fa($Sql->q('SELECT status from hraci WHERE id = '.UID));
if($row['status'] > 1) {
	$_SESSION['chyba'] = 'Příspěvek smazán';
	$Sql->q('DELETE FROM forum WHERE id = '.$id.' LIMIT 1');
	back();
	exit;
}

$result = $Sql->q('SELECT place FROM forum WHERE id = '.$id.' AND login = '.UID);

if(!p($result)) {
	$_SESSION['chyba'] = 'Příspěvek není tvůj';
	back();
	exit;
}

$row = fa($result);

if(p($Sql->q('SELECT id FROM forum WHERE place = "'.$row['place'].'" AND id > '.$id))) {
	$_SESSION['chyba'] = 'Příspěvek není aktuální';
	back();
	exit;
}

$_SESSION['chyba'] = 'Příspěvek smazán';
$Sql->q('DELETE FROM forum WHERE id = '.$id.' LIMIT 1');

back();
?>