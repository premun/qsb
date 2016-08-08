<?php

header("HTTP/1.0 404 Not Found");

include 'library.php';
do_header('Stránka nenalezena');

$page = new cPage('e404');

$page->finish();

do_footer();
?>