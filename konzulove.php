<?php
include_once 'library.php';

is_logged();
do_header('Konzulova konzole');

$page = new cPage('konzulove');

$row = fa($Sql->q('SELECT status FROM hraci WHERE id = '.UID));
if($row['status'] < 2) {
	$page->ext('NEJSI',1);
	exit;
}

include 'konzulove_process.php';

$fill['checked_fora'] = ($_SESSION['mazani_fora'] == 'yeah' ? 'checked' : '' );

$page->finish();
do_footer('notip');
?>