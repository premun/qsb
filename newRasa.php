<?php

include 'library.php';
is_logged();
if($_POST['rasa'] != "") {	
	$result = $Sql->q('SELECT * FROM new_rasy WHERE login = '.UID);

	if(p($result)) {
		$row = fa($result);
		$Sql->q('UPDATE new_rasy set rasa = '.$_POST['rasa'].' WHERE login = '.UID);
	} else {
		$Sql->q('INSERT into new_rasy(login,rasa,kluzak) values('.UID.','.$_POST['rasa'].',4)');
	}
}

if($_GET['action'] == 'kluzak') {
	$result = $Sql->q('SELECT * FROM new_rasy WHERE login = '.UID);

	if(p($result)) {
		$row = fa($result);
		$Sql->q('UPDATE new_rasy set kluzak = '.$_POST['kluzak'].' WHERE login = '.UID);
	} else {
		$Sql->q('INSERT into new_rasy(login,rasa,kluzak) values('.UID.',0,'.$_POST['kluzak'].')');
	}
}

do_header('Změna rasy');

$page = new cPage('new_rasy');

$max['o'] = 21;
$min['o'] = 4;

$result = $Sql->q('SELECT kluzak,rasa FROM new_rasy WHERE login = '.UID);
if(p($result) > 0) {
	$rasa = fa($result);
	if($rasa['rasa'] != 0) {
		$page->misc('HLASKA','HLASKA');
		$page->swap('NAZEV',getRasaNazev($rasa['rasa']));
	} else {
		$page->swap('HLASKA','');
	}
} else {
	$page->swap('HLASKA','');
}

for($i=0;$i<6;$i++) $fill['checked'.$i] = ($rasa['kluzak'] == $i ? ' selected="selected"' : '');

$pod[0] = "Peníze místo kluzáku";
$pod[1] = "Sport";
$pod[2] = "Combi";
$pod[3] = "Wrecker";

$result = $Sql->q('SELECT id,nazev,popis,r,a,o,kluzak FROM rasy ORDER BY id ASC');
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	
	$row['agresivita'] = drawBar($row['a']);
	$row['reflexy'] = drawBar($row['r']);
	$row['obchod'] = drawBar(($row['o']+$min['o'])/$max['o']*100);
	$row['kluzak'] = $pod[$row['kluzak']];
	
	$data[] = $row;
}

$page->getTable('RASY',$data,'RASY');

$page->fill($fill);
$page->finish();
do_footer();

?>