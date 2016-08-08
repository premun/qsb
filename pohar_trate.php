<?php

include 'library.php';

$page = new cPage('pohar');

$trate = $pohar_trate;

$delka = Array();
$barva[0] = '#02FD09';
$barva[1] = '#FFFF00';
$barva[2] = '#FF0000';

$delka[0] = 'krátká';
$delka[1] = 'střední';
$delka[2] = 'dlouhá';

foreach($trate as $ind=>$val) {
	$row = fa($Sql->q('SELECT nazev, delka FROM trate WHERE id = '.$val));
	
	$diff = getDiff($val);
	if($diff < 21) $line['diff1'] = $barva[0];
	if($diff >= 21) $line['diff1'] = $barva[1];
	if($diff >= 38) $line['diff1'] = $barva[2];
	
	$line['diff2']  = numF($diff);
	
	$line['id'] = $val;
	$line['poradi'] = ($ind+1);
	$line['nazev'] = $row['nazev'];
	
	$line['delka1'] = $barva[$row['delka']];
	$line['delka2'] = $delka[$row['delka']];
	
	$data[] = $line;
}

$fill['trate'] = $page->getTable('TRATE',$data);

$fill['nazev'] = POHAR_NAZEV;

$page->ext('TRATE',1,'Pohár',$fill);
?>