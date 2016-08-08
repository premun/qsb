<?php

include 'library.php';
is_logged();

$result2 = $Sql->q('SELECT * FROM trate_druhy ORDER BY nebezpeci DESC LIMIT 0,1');
$row2 = fa($result2);
$max = $row2['nebezpeci'];

if($max > 50) exit;

$result = $Sql->q('SELECT id, nebezpeci FROM trate_druhy');
while($row = fa($result)) {
	$Sql->q('UPDATE trate_druhy set nebezpeci = '.ceil(($row['nebezpeci']/$max)*100).' WHERE id = '.$row['id']);
}


?>