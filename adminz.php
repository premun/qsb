<?php
include_once 'library.php';

is_logged();
do_header('Adminz');

$page = new cPage('adminz');

$row = fa($Sql->q('SELECT status from hraci WHERE id = '.UID));
if($row['status'] != 42) {
	$page->ext('NEJSI',1);
	exit;
}

include 'adminz_process.php';

$fill['checked_fora'] = ($_SESSION['mazani_fora'] == 'yeah' ? 'checked' : '' );

$result = $Sql->q('SELECT id, login FROM hraci WHERE status = -2');

$data = array();
for($i=0;$i<p($result);$i++) $data[] = fa($result);

$page->getTable('ODBLOK',$data,'ODBLOK');

$result = $Sql->q('SELECT id,nazev from rasy ORDER BY id ASC');
$data = array();
for($i=0;$i<p($result);$i++) $data[] = fa($result);

$page->getTable('RASA',$data,'RASA');

$page->finish();
do_footer('notip');
?>