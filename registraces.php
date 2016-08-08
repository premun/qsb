<?php

include 'library.php';
$row = fa($Sql->q('SELECT email FROM hraci ORDER BY id DESC LIMIT 0,1'));

$page = new cPage('registrace');
$page->ext('USPESNA',1,'Registrace',$row);

?>