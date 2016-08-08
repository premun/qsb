<?php

include 'library.php';
is_logged();
do_header('Tratě');

$page = new cPage('trate');

define("LIMIT",30);
$dotace = $_GET['dotace'];
$dotace2 = $_GET['dotace2'];

if($dotace2 <= $dotace) $dotace2 = 0;

$start = $_GET['start'];
if($start == '' || $start < 0) $start = 0;

$order = $_GET['by'].' '.$_GET['order'];

if($order == ' ') $order = 'id DESC';

$sc['id'] = 'asc';
$sc['nazev'] = 'asc';
$sc['diff'] = 'asc';
$sc['rating'] = 'asc';
$sc['delka'] = 'asc';
$sc['login'] = 'asc';
$sc['dotace'] = 'asc';

$ook = false;
foreach($sc as $key=>$val) {
	$fill['sc'.$key] = $val;
	if($_GET['by'] == $key) {
		if($_GET['order'] == 'asc') $fill['sc'.$key] = 'desc';
		$ook = true;
		$fill['s'.$key] = ' style="text-decoration: underline"';
	}
}

if($ook == false) $order = 'id DESC';

if($_GET['action'] == "all") {
$result = $Sql->q('SELECT * FROM trate WHERE useky BETWEEN '.TRAT_USEKY_MIN.' AND '.TRAT_USEKY_MAX);
if(p($result) == 0) {
	$page->misc('ZADNE','TRATE');
	$page->finish();
	do_footer();
	exit;
}

for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	
	$pro = $row['pro'];
	$proti = $row['proti'];
	$mezi = $row['mezi'];
	
	if($pro == 0 && $proti == 0 && $mezi == 0) $rating = 0;
	else $rating = round(100*(($pro+0.5*$mezi)/($pro+$mezi+$proti)));  
	
	if(($pro+$mezi+$proti) < 3) $rating = '-';
	
	$diff = getDiffOpt($row['trat']);
		
	$trate[$row['id']]['nazev'] = str_replace(' ','&nbsp;',str_replace('_',' ',$row['nazev']));
	$trate[$row['id']]['uid'] = $row['login'];
	$trate[$row['id']]['login'] = getNick($row['login']);
	$trate[$row['id']]['diff'] = $diff;
	$trate[$row['id']]['rating'] = $rating;
	$trate[$row['id']]['delka'] = $row['useky'];
	$trate[$row['id']]['id'] = $row['id'];
	$trate[$row['id']]['dotace'] = getDotace($row['useky'],$diff,$row['delka']);
	
	if($trate[$row['id']]['dotace'] > $max_dotace) $max_dotace = $trate[$row['id']]['dotace'];	
	if($dotace > 0 && $trate[$row['id']]['dotace'] <= $dotace) unset($trate[$row['id']]);
	if($dotace2 > 0 && $trate[$row['id']]['dotace'] > $dotace2 && $dotace2 != $dotace) unset($trate[$row['id']]);
}

$offset = 5000;
$g = 0;

for($j=$offset;$j<$max_dotace;$j += $offset*$g) {
	$g++;
	$dotace_select[] = array('nazev' => numF($j), 'value' => $j, 'selected' => ($dotace == $j ? ' selected="selected"' : ''));
}

$g = 0;
for($j=$offset;$j<$max_dotace+$offset*$g+1;$j += $offset*$g) {
	$g++;
	$dotace_select2[] = array('nazev' => numF($j), 'value' => $j, 'selected' => ($dotace2 == $j ? ' selected="selected"' : ''));
}

$page->getTable('DOTACE_SELECT',$dotace_select,'DOTACE_SELECT');
$page->getTable('DOTACE_SELECT2',$dotace_select2,'DOTACE_SELECT2');

if(count($trate) == 0) {
	$page->misc('ZADNE','TRATE');
}

$by = $_GET['by'];
if($by == '') $by = 'id';

function serad($a, $b) {
	global $sc,$by;
	$second = 'id';
	
	$sc1 = 1;
	$sc2 = -1;
	
	if($_GET['order'] == 'asc') {
		$sc1 = -1;
		$sc2 = 1;
	}
	
	if($a[$by] > $b[$by]) return $sc1;
	if($a[$by] < $b[$by]) return $sc2;
	if($a[$by] == $b[$by]) {
		if($a[$second] > $b[$second]) {
			return $sc1;
		} elseif($a[$second] < $b[$second]) {
			return $sc2;
		} elseif($a[$second] == $b[$second]) {
			return 0;
		}
	}
}

uasort($trate, "serad");

$g = 0;
while(list($k, $v) = each($trate)) {
	$g++;
	if($g >= $start && $g <= ($start+LIMIT)) {
  		$v['diff'] = round($v['diff']);
  		$v['dotace'] = str_replace(' ','&nbsp;',numF($v['dotace']));
		$data[] = $v;
	}
}

$page->getTable('TRATE',$data,'TRATE');

#------------ SIPECKY!---------------#
if($start > 0) {
	$dil1 = '<a href="trate.php?order='.$_GET['order'].'&dotace='.$_GET['dotace'].'&dotace2='.$_GET['dotace2'].'&by='.$_GET['by'].'&action=all">&lt;&lt;</a> | <a href="trate.php?order='.$_GET['order'].'&dotace='.$_GET['dotace'].'&dotace2='.$_GET['dotace2'].'&by='.$_GET['by'].'&action=all&start='.($start-LIMIT-1).'">&lt;</a>';
}
$all = count($trate);
if($all > ($start+LIMIT)) {
	$dil2 = '<a href="trate.php?order='.$_GET['order'].'&dotace='.$_GET['dotace'].'&dotace2='.$_GET['dotace2'].'&by='.$_GET['by'].'&action=all&start='.($start+LIMIT+1).'">&gt;</a> | <a href="trate.php?order='.$_GET['order'].'&dotace='.$_GET['dotace'].'&dotace2='.$_GET['dotace2'].'&by='.$_GET['by'].'&action=all&start='.($all-LIMIT).'">&gt;&gt;</a>';
}

if($dil1 != '' || $dil2 != '') {
	$sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
}
#------------ SIPECKY!---------------#
}

$fill['sipky'] = $sipky;
$fill['start'] = $start;
$fill['dotace'] = $dotace;
$fill['dotace2'] = $dotace2;

$page->fill($fill);

$page->finish();
do_footer();
?>