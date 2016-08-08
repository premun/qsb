<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

do_header('Stáje');

$page = new cPage('showStaj');

if($id == '' || !ereg('^[0-9]+$',$id)) {
	$page->ext('EXIST',1);
	exit;
}

$result = $Sql->q('SELECT * from staje_stavy');
for($i=0;$i<p($result);$i++) {
	$stavy = fa($result);
	$stav[$stavy['id']] = $stavy['stav'];
}

$result = $Sql->q('SELECT * from budovy_typy');
for($i=0;$i<p($result);$i++) {
	$budovy = fa($result);
	$budova[$budovy['id']] = $budovy['nazev'];
	$staveni[$budovy['id']] = $budovy['staveni'];
	$misto[$budovy['id']] = $budovy['misto'];
}

$result = $Sql->q('SELECT * from staje WHERE id = '.$id);

if(p($result) == 0) {
	$page->ext('EXIST',1);
	exit;
}

$row = fa($result);

$b = explode(',',$row['vlajka']);

$res = $Sql->q('SELECT login, stav FROM stajovnici WHERE staj = '.$id);
for($i=0;$i<p($res);$i++) {
	$row2 = fa($res);
	$hraci[] = array('login' => $row2['login'], 'nick' => getNick($row2['login']), 'stav' => $stav[$row2['stav']]);
}
  
$res3 = $Sql->q('SELECT * FROM budovy WHERE staj = '.$id);
$obsazeno = 0;
for($i=0;$i<p($res3);$i++) {
	$bud = fa($res3);
	$obsazeno += $misto[$bud['budova']];
}

$row['popis'] = str_replace('[B]','<strong>',$row['popis']);
$row['popis'] = str_replace('[/B]','</strong>',$row['popis']);
$row['popis'] = str_replace('[I]','<em>',$row['popis']);
$row['popis'] = str_replace('[/I]','</em>',$row['popis']);
$row['popis'] = str_replace('[O]','<span class="extra">',$row['popis']);
$row['popis'] = str_replace('[/O]','</span>',$row['popis']);
$row['popis'] = str_replace('[S]','<span class="ultra">',$row['popis']);
$row['popis'] = str_replace('[/S]','</span>',$row['popis']);
$row['popis'] = str_replace('[U]','<span style="text-decoration: underline">',$row['popis']);
$row['popis'] = str_replace('[/U]','</span>',$row['popis']);

for($j=1;$j<15;$j++) {
	$row['popis'] = str_replace('[SM'.$j.']','<img src="./smiles/'.$j.'.gif" style="vertical-align: middle" alt="">',$row['popis']);
}

$fill['id'] = $row['id'];
$fill['nazev'] = $row['nazev'];
$fill['vlajka'] = drawFlag($b[0],$b[1],$b[2]);
$fill['zkratka'] = $row['zkratka'];
$fill['vlastnik'] = getNick($row['login']);
$fill['prestiz'] = numF($row['prestiz']);
$fill['hraci'] = $page->getTable('HRACI',$hraci);
$fill['popis'] = nl2br($row['popis']);
$fill['obsazeno'] = $obsazeno;
$fill['pozemek'] = $row['pozemek'];
  
$page->fill($fill);

$page->finish();  

do_footer();
?>