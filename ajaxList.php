<?php

include 'library.php';
is_logged();

$char = $_POST['char'];

$result = $Sql->q('SELECT login FROM hraci WHERE status > 0 AND login LIKE "'.$char.'%" ORDER BY login');

if(!p($result)) die($char);

$jmena = array();

for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$jmena[] = $row['login'];
}

echo implode('|', $jmena);
?>