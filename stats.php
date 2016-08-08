<?php

include 'library.php';

do_header('Statistiky');

$celkem = p($Sql->q('SELECT id FROM hraci'));
$dnes   = p($Sql->q('SELECT id FROM hraci WHERE cas > '.mktime(0,0,0,date('n'),date('j'),date('Y'))));
$online = p($Sql->q('SELECT id FROM hraci WHERE logged = 1 AND cas > '.(time()-60*15)));
$active = p($Sql->q('SELECT id FROM hraci WHERE status > 0'));

$page = new cPage('stats');

$page->fill(array('celkem' => $celkem, 'dnes' => $dnes, 'online' => $online, 'active' => $active));

/*$result = $Sql->q('SELECT id,nazev from rasy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$rasa[$row['id']] = $row['nazev'];
	$rasa2[$row['nazev']] = p($Sql->q('SELECT postavy.login FROM postavy,hraci WHERE hraci.status > 0 AND hraci.id = postavy.login AND postavy.rasa = '.$row['id']));
}

asort($rasa2,SORT_NUMERIC);

$rasa2 = array_reverse($rasa2);

foreach($rasa2 as $id=>$nazev) {
	$data2['nazev'] = $id;
	$data2['pocet'] = $nazev;
	$data[] = $data2;
}*/

$result = $Sql->q('SELECT r.nazev as nazev, COUNT(p.id) as pocet FROM rasy as r LEFT JOIN postavy as p ON p.rasa = r.id GROUP BY p.rasa ORDER BY pocet DESC');

for($i=0;$i<p($result);$i++) {
	$data[] = fa($result);
}

$page->getTable('RASY',$data,'RASY2');

$page->finish();

do_footer();
?>