<?php

include 'library.php';
do_header('QSB Client v'.CLIENT);

$page = new cPage('client');

$page->swap("VERZE",CLIENT);

$page->finish();

do_footer();
?>