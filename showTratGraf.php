<?php

include 'library.php';
is_logged();

header ("Content-type: image/jpeg");

$id = $_GET['id'];
$action = $_GET['action'];

$result = $Sql->q('SELECT id, nazev, trat FROM trate WHERE id = '.$id);

if(p($result) == 0) die($im);

$trat = fa($result);

$path = './vypisy/grafy_trate'.($action == 'rychlost' ? '1' : '2').'/'.strtolower(str_replace(' ','_',fuckDia($trat['nazev']))).'.png';

if(file_exists($path)) {
	readfile($path);
	exit;
}

$im = imagecreatefromjpeg('./skin/img/trat_graf.jpg');
$bar = imagecreatefromjpeg('./skin/img/spectrum_trate'.($action == 'rychlost' ? '' : '2').'.jpg');

$kusy = explode(',',$trat['trat']);

$width = 400;
$height = 160;

$result = $Sql->q('SELECT nebezpeci FROM trate_druhy ORDER BY nebezpeci DESC LIMIT 0,1');
$row = fa($result);
$max = $row['nebezpeci'];

$result = $Sql->q('SELECT * FROM trate_druhy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$useky_info[$row['id']] = $row;
}

$aktualni = 28;

foreach($kusy as $i => $id) {
	if($i > 399) break;
	
	if($action == 'rychlost') {
		$h = ceil($useky_info[$id]['rychlost']*$height/100);
	} else {
		$h = ceil(($useky_info[$id]['nebezpeci']/$max*100)*$height/100);
	}
	
	$y = 3+$height-$h;
	
	imagecopy($im, $bar, $aktualni, $y, 0, $height-$h, min(ceil($width/count($kusy)),5), $h); 
	
	$aktualni += min($width/count($kusy),5)+(count($kusy) > 399 ? 0 : 1);
}

imagepng($im,$path);
imagedestroy($im);
readfile($path);
?>