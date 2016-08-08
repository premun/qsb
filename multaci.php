<?php

include 'library.php';
include './cls/cMultaci.php';
is_logged();

/*$row = fa($Sql->q('SELECT status from hraci WHERE id = '.UID));
if($row['status'] != 42) {
	go('sfdkljfnsdklfds');
}*/

do_header('Multivitamín');

?>
<h3>Mulťáci</h3>
<script type="text/javascript">
<!--
	function toggle(name) {
		$(('#'+name)).slideToggle("normal");
	}
//-->
</script>

<?php

$multaci = new cMultaci();

$multaci->data = $multaci->data;

$offset = 60*5;

foreach($multaci->data as $ip => $row) {
	$historie = array();

	$ipn = str_replace('.', '_', $ip);

	echo '<br /><br />
		  <strong class="submit" onclick="toggle(\''.$ipn.'\')" style="font-size: 16px"><strong class="extra">+</strong> '.implode(', ',$row['nicky']).'</strong>
		  <div id="'.$ipn.'" style="display: none; padding: 6px; color: #EEEEEE; background-color: #111; border: 1px dashed #A4A4A4">Poslední přihlášení:<br />';
	
	$last = 0;
	foreach($row as $id => $time) {
		if($id == 'nicky') continue;
		
		echo '<strong style="margin-left: 35px" class="extra">'.$row['nicky'][$id].':</strong> '.($time[count($time)-1] ? date('H:i j.n.',$time[count($time)-1]) : 'Neaktivní').($last && round(abs($last-$time[count($time)-1])/60) < $offset/60 ? ' <span class="ultra">-'.round(abs($last-$time[count($time)-1])/60).' min</span>' : '').'<br />';
		if($time[count($time)-1] > $last) $last = $time[count($time)-1];
		
		foreach($time as $cas) $historie[$cas] = $id;
	}
	
	ksort($historie);
	
	echo '<br />Podezřelé přihlášení:<br />';
	
	$aktualni = 0;
	$casy = array_keys($historie);
	
	foreach($casy as $i => $cas) {
		$vypis = false;
		if(!$i) {
			if(abs($casy[1]-$casy[0]) < $offset) $vypis = true;
		} else {
			if(abs($cas-$casy[$i-1]) < $offset && $historie[$cas] != $historie[$casy[$i-1]]) {
				$vypis = true;
			}
			
			if(abs($cas-$casy[$i+1]) < $offset && $historie[$cas] != $historie[$casy[$i+1]] && isset($casy[$i+1])) $vypis = true;
			
		}
		
		if($vypis) {
			echo '<strong style="margin-left: 35px" class="extra">'.$row['nicky'][$historie[$cas]].':</strong> '.date('H:i j.n.',$cas).'<br />';		
			if(abs($cas-$casy[$i+1]) > $offset && isset($casy[$i+1])) echo '<br />';
		}
	}
	
	echo '</div>';
}

do_footer('notip');
?>