<?php

include 'library.php';
is_logged();

$hotovy_useky = array(1,2,3,4,5,6,7,8,9,11,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,40,44,45,46,47,48,49,50,51,52,57,58,59,60,61,63);

do_header('UTILITY!!!!!!');

echo '<br /><ul>';

$result = $Sql->q('SELECT * FROM trate ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	
	$txt = './trate/'.strtolower(str_replace(' ','_',fuckDia($row['nazev']))).'.txt';
	$fp = fopen($txt,'r');
	$obsah = fread($fp, 42000);
	fclose($fp);
	$kusy = explode(',',$obsah);
  
	$flash_ok = true;

	foreach($kusy as $value) {	
		if(!in_array($value,$hotovy_useky) && $value != 3) $flash_ok = false;
	}
	
	if($flash_ok) echo '<li><a href="showTrat.php?id='.$row['id'].'#flash">'.$row['nazev'].'</a> '.count($kusy).'</li>';
}

echo '</ul>';

do_footer('notip');
?>