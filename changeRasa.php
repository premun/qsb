<?php

include 'library.php';
if($_GET['auth'] != "ok") {
	die('Unauthorized access...');
}

$result = $Sql->q('SELECT * from new_rasy');
if(p($result) == 0) die("Nothing to change");
for($i=0;$i<p($result);$i++) {
	$new = fa($result);
	$Sql->q('UPDATE postavy set rasa = '.$new['rasa'].' WHERE login = '.$new['login']);
}
$Sql->q('DELETE from new_rasy');
echo 'Succesfully changed...';
?>