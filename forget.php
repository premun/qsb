<?php

include 'library.php';
do_header('Zapomenuté heslo');

$page = new cPage('zapomenute_heslo');

$page->finish();

do_footer();
?>