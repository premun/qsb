<?php

if($_GET['auth'] != "ook") {
	die('Not authorized to use this script');
}
include 'library.php';

$Sql->q('UPDATE sys set val = "'.time().'" WHERE entity = "restart"');

$result = $Sql->q('SELECT id FROM hraci WHERE status = -2');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$Sql->q('DELETE FROM stats WHERE login = '.$row['id']);
}

$Sql->q('DELETE FROM hraci WHERE status = -2');
$Sql->q('UPDATE hraci set status = -1');
$Sql->q('UPDATE postavy set prestiz = 1000, prvni = 0, druhy = 0, treti = 0, zavody = 0, penize = 14000, sklad = 300');
$Sql->q('DELETE from forum WHERE place LIKE "s%"');
$Sql->q('DELETE from posta WHERE kdo = 0');

$Sql->q('TRUNCATE boti');
$Sql->q('TRUNCATE brigadnici');
$Sql->q('TRUNCATE budovy');
$Sql->q('TRUNCATE finance');
$Sql->q('TRUNCATE opravari');
$Sql->q('TRUNCATE paliva_sklad');
$Sql->q('TRUNCATE pohar');
$Sql->q('TRUNCATE pujcky');
$Sql->q('TRUNCATE sablony');
$Sql->q('TRUNCATE sazky');
$Sql->q('TRUNCATE sklad');
$Sql->q('TRUNCATE smlouvy');
$Sql->q('TRUNCATE spioni');
$Sql->q('TRUNCATE staje');
$Sql->q('TRUNCATE stajovnici');
$Sql->q('TRUNCATE zavodnici');
$Sql->q('TRUNCATE zavody');

$Sql->q('DELETE from nastenka WHERE sekce = 2');

$Sql->q('DELETE from forum WHERE place = 4');
$Sql->q('DELETE from forum WHERE place = 6');
$Sql->q('UPDATE sys set val = 1 WHERE entity = "zavody"');
$Sql->q('UPDATE sys set val = -3 WHERE entity = "pohar"');
$Sql->q('UPDATE sys set val = 1 WHERE entity = "etapa"');
$Sql->q('UPDATE zbozi set kusy = 2*celkem');
$Sql->q('UPDATE casopis set val2 = 1 WHERE val1 = "cislo"');

?>