<?php

include 'library.php';
is_logged();
do_header('Brigády');

$page = new cPage('brigady');

$fill['brigada'] = '';

$res50 = $Sql->q('SELECT * from brigadnici WHERE login = '.UID);
if(p($res50) > 0) {
	$brigada = fa($res50);
	
	$page->misc('MOJE','BRIGADA');
	
	$fill['moje_nazev'] = getBrigName($brigada['brigada']);
	$fill['moje_id'] = $brigada['brigada'];
	
}

$res4 = $Sql->q('SELECT z.id FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE z.vitez = 0 AND za.login = '.UID);
if(p($res4)) $ok = true;

$result = $Sql->q('SELECT * FROM brigady ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	
	if($row['max'] == -1) {
		$volno = "Neomezeně";
	} else {
		$res = $Sql->q('SELECT login FROM brigadnici WHERE brigada = '.$row['id']);
		$volno = $row['max'] - p($res).'/'.$row['max'];
	}
	
	if($volno == 0 && $volno != "Neomezeně") {
	$volno = '<span class="extra">0</span>/'.$row['max'];
		$volno2 = 0;
	} else {
		$volno2 = 42;
	}
	
	$vstup = '<a href="brigada.php?id='.$row['id'].'">Vzít brigádu</a>';
	
	$res2 = $Sql->q('SELECT login FROM brigadnici WHERE login = '.UID);
	if(p($res2) > 0) {
		$vstup = $page->misc('UZ_MAS');
	}
	
	$res3 = $Sql->q('SELECT login FROM brigadnici WHERE login = '.UID.' AND brigada = '.$row['id']);
	if(p($res3) > 0) {
		$vstup = $page->misc('MAS_TUTO');
	}
	
	if($ok == true) {
		$vstup = $page->misc('ZAVOD');
	}
	
	if($volno == 0 && $volno != "Neomezeně") {
		$vstup = $page->misc('OBSAZENA');
	}
	
	$line['volno'] = $volno;
	$line['nazev'] = $row['nazev'];
	$line['plat'] = numF($row['penize']);
	$line['prestiz'] = $row['prestiz2'];
	$line['rasa'] = getRasaNazev($row['rasa']);
	$line['vstup'] = $vstup;

	$data[] = $line;
}

$page->getTable('BRIGADY',$data,'BRIGADY');
$page->fill($fill);

$page->finish();

do_footer();
?>