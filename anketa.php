<?php

include 'library.php';
is_logged();
do_header('Anketa');

$page = new cPage('anketa');

/*$Sql->q('DELETE FROM sklad');
$result = $Sql->q('SELECT * FROM hraci WHERE status > 0');
for($i=0;$i<p($result);$i++) {
	$hrac = fa($result);
	$uid = $hrac['id'];
	
	foreach($tabs as $id => $tab) {
		if($id < 11) {
			$result2 = $Sql->q('SELECT id, vydrz FROM '.$tab.' ORDER BY id ASC');
			$result2 = $Sql->q('SELECT id, vydrz FROM '.$tab.' ORDER BY id ASC');
			for($j=0;$j<p($result2);$j++) {
				$row = fa($result2);
				$Sql->q('INSERT into sklad(login, zbozi, typ, cena, vydrz) VALUES('.$uid.', '.$row['id'].', '.$id.', 0, '.$row['vydrz'].')');	
			}
		}
	}
}*/

/*$result = $Sql->q('SELECT * FROM sklad');
for($i=0;$i<p($result);$i++) {
	$sklad = fa($result);
	$zbozi = fa($Sql->q('SELECT cena FROM zbozi WHERE typ = '.$sklad['typ'].' AND zbozi = '.$sklad['zbozi']));
	$Sql->q('UPDATE sklad set cena = '.$zbozi['cena'].' WHERE id = '.$sklad['id']);
}*/
	

/*$max = fa($Sql->q('SELECT MAX(nebezpeci) as n FROM trate_druhy'));
$result = $Sql->q('SELECT id, nebezpeci FROM  trate_druhy');
for($i=0;$i<p($result);$i++) {
    $usek = fa($result);
    $nebezpeci = round(($usek['nebezpeci']/$max['n']*2000+50*3)/23);
    $Sql->q('UPDATE trate_druhy set nebezpeci = '.$nebezpeci.' WHERE id = '.$usek['id']);
}*/
//exit;

$result = $Sql->q('SELECT * from ankety ORDER BY id DESC');

for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$ans = explode('|||',$row['odpovedi']);
	$id = $row['id'];
	
	$celkem = p($Sql->q('SELECT * from hlasovani WHERE anketa = '.$id));
	
	$res = $Sql->q('SELECT * FROM hlasovani WHERE login = '.UID.' AND anketa = '.$id);
	$muze = p($res);
	
	$data1['id'] = $id;
	$data1['otazka'] = $row['otazka'];
	
	if(!$muze) {
		$inner = array();
		foreach($ans as $ind=>$val) {
			$inner[] = array('checked' => ($ind == 0 ? $checked = ' checked' : ''), 'idv' => ($ind+1), 'answer' => $val);
		}
		$data1['obsah'] = $page->getTable('ROW_OPEN',$inner);
		$data_open[] = $data1;
	} else {
		$volba = fa($res);
		$inner2 = array();
		foreach($ans as $ind=>$val) {
			$pocet = p($Sql->q('SELECT login FROM hlasovani WHERE odpoved = '.($ind+1).' AND anketa = '.$id));
			$inner2[] = array('answer' => $val, 'procenta' => round($pocet*100/$celkem), 'pocet' => $pocet, 'minibar' => drawBarMini(round($pocet*100/$celkem)));
		}
		$data1['celkem'] = $celkem;
		$data1['obsah'] = $page->getTable('ROW_DONE',$inner2);
		$data_done[] = $data1;
	}
}

$page->getTable('ANKETA_OPEN',$data_open,'ANKETY1');
$page->getTable('ANKETA_DONE',$data_done,'ANKETY2');

$page->swap('ANKETY1','');
$page->swap('ANKETY2','');

$page->finish();

do_footer();
?>