<?php

include 'library.php';
is_logged();
go('depo.php?id='.$_GET['id']);
exit;
?>