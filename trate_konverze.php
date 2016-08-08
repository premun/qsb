<?php
include 'library.php';
is_logged();

$result = $Sql->q('SELECT id, nazev, trat FROM trate');

while($trat = fa($result)) {
	$txt = './trate/'.strtolower(str_replace(' ','_',fuckDia($trat['nazev']))).'.txt';
	$fp = fopen($txt,'r');
	$obsah = fread($fp, 42000);
	fclose($fp);
	
	$Sql->q('UPDATE trate SET trat = "'.$obsah.'" WHERE id = '.$trat['id']);
}
?>