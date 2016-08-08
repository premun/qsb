<?php
include 'library.php';
include 'prepocet/cZavodInfo.php';
include 'prepocet/cZavodEvent.php';
include 'cls/ofc_object.php';
include 'cls/ofc.php';

is_logged();
$id = $_GET['id'];

$zavod = fa($Sql->q('SELECT nazev FROM zavody WHERE id = '.$id));

if($_GET['action'] == 'data') {
	$barvy[1] = '#CC0000';
	$barvy[2] = '#FFFFFF';
	$barvy[3] = '#339900';
	$barvy[4] = '#FFCC00';
	$barvy[5] = '#0066FF';
	$barvy[6] = '#FF6600';
	$barvy[7] = '#FF33FF';
	$barvy[8] = '#66CCFF';
	$barvy[9] = '#5F2F00';
	$barvy[10] = '#FF9999';

	# obecne
	$g = new graph();
	$g->bg_colour = '#000000';
	$g->title($zavod['nazev']. ' - Graf rychlostí v závislosti na čase', '{font-size: 17px; color: #FFFFFF}');
	
	$g->set_tool_tip('#key#<br>#x_label#<br>#val# km'.($_GET['type'] == 'vzdalenost' ? '' : '/h'));
	
	# data
	$obsah = file_get_contents('vypisy/zavody_info/'.$id.'_'.fileName($zavod['nazev']).'.dat');
	$info = unserialize($obsah);

	if($_GET['type'] == 'vzdalenost') {		
	
		foreach($info->vzdalenosti as $uid => $rychlosti) {		
			$barva++;

			foreach($rychlosti as $j => $rychlost) {
				$rychlosti[$j] = ceil($rychlost/2);
				if($max_y < ceil($rychlost/2)) $max_y = ceil($rychlost/2);
			}
			
			$max_y = ceil($max_y/10)*10;
			
			$g->set_data($rychlosti);
			$g->line(1, $barvy[$barva], getNick($uid), 10);
			
		}	
		
		$g->y_label_steps(5);
		$g->title($zavod['nazev']. ' - Graf vzdáleností v závislosti na čase', '{font-size: 17px; color: #FFFFFF}');
		
	} else {		
		foreach($info->rychlosti as $uid => $rychlosti) {
			foreach($rychlosti as $j => $rychlost) {
				if($max_y < ceil($rychlost+(50-$rychlost%50))) $max_y = ceil($rychlost+(50-$rychlost%50));
			}
			
			$barva++;
			$g->set_data($rychlosti);
			$g->line(1, $barvy[$barva], getNick($uid), 10);
		}	
		
		$g->y_label_steps(5);
	}
	
	# osa x
	$g->x_axis_colour('#FF6600', '#151515');
	$x = array();
	foreach($info->casy as $cas) {
		$cas /= 10;
		
		$hodiny = $cas%60;
		if($hodiny < 10) $minuty = '0'.$hodiny;
		
		$minuty = floor(($cas-$hodiny)*60);
		if($minuty < 10) $minuty = '0'.$minuty;
		
		$sekundy = round((($cas-$minuty/60-$hodiny)*60*60));
		if($sekundy < 10) $sekundy = '0'.$sekundy;
		
		$x[] = ($hodiny > 0 ? $hodiny.':' : '').$minuty.':'.$sekundy;
	}
	
	$g->set_x_labels($x);		
	$g->set_x_axis_steps(ceil(count($x)/45));
	$g->set_x_label_style(11, '#FFFFFF', 2, floor(count($x)/15));
	
	# osa y
	$g->y_axis_colour('#FF6600', '#151515');
	$g->set_y_max($max_y);	
	$g->set_y_label_style(11, '#FFFFFF');
	
	die($g->render());
}

do_header('Závody', 'empty');

?>

<br />
<form action="showRaceGraph.php" method="get" name="form_type" style="margin-left: 5px">
	<input type="hidden" name="id" value="<?=$id?>" />
	<a href="showRace.php?id=<?=$id?>#prubeh">&laquo; zpět</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<select name="type" onchange="document.form_type.submit()">
		<option value="rychlost">rychlostní graf</option>
		<option value="vzdalenost"<?=($_GET['type'] == 'vzdalenost' ? ' selected="selected"' : '')?>>vzdálenostní graf</option>
	</select>
</form>

<?php

open_flash_chart_object( 755, 400, 'showRaceGraph.php?id='.$id.'&action=data&type='.$_GET['type'], false);

?>

<br />
<br />

<?php
do_file('','footer_empty');
?>