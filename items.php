<?php

include 'library.php';
is_logged();
do_header('Předměty');

$page = new cPage('items');

$id = $_GET['typ'];

if($id == '') $id = 1;

$pod[0] = "Všechny";
$pod[1] = "Sport";
$pod[2] = "Combi";
$pod[3] = "Wrecker";

$names[1] = "Podvozky";
$names[2] = "Motory";
$names[3] = "Držáky";
$names[4] = "Chladiče";
$names[5] = "Palubní desky";
$names[6] = "Brzdy";
$names[7] = "Zdroje";
$names[8] = "Pancéřování";
$names[9] = "Suspenzory";
$names[10] = "Přídavné motory";
$names[11] = "Opravní droidi";

foreach($names as $ind=>$val) $data[] = array('id' => $ind, 'nazev' => $val, 'selected' => ($id == $ind ? ' selected="selected"' : ''));

$page->getTable('KATEGORIE',$data,'KATEGORIE');

if($id == 'motory')
	$data[count($data)-1]['selected'] = 'selected="selected"';

##### PREHLED MOTORU #####

if($id == 'motory') {
	$sc = strtolower($_GET['sc']);
	$by = $_GET['by'];

	if($sc != 'asc' && $sc != 'desc') $sc = 'desc';
	if(!$by) $by = 'id';

	$result = $Sql->q('SELECT id, nazev, stala_cena FROM paliva_ceny ORDER BY id ASC');
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$palivo[$row['id']]['nazev'] = $row['nazev'];
		$palivo[$row['id']]['cena'] = $row['stala_cena'];
	}	

	$result = $Sql->q('SELECT * FROM motory ORDER BY '.$by.' '.$sc);

	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$motory[$row['id']]['id'] = $row['id'];
		$motory[$row['id']]['nazev'] = $row['nazev'];
		$motory[$row['id']]['typ'] = 2;
		$motory[$row['id']]['podvozek'] = $pod[$row['podvozek']];
		$motory[$row['id']]['rychlost'] = $row['rychlost'];
		$motory[$row['id']]['zrychleni'] = $row['zrychleni'];
		$motory[$row['id']]['vydrz'] = round($row['vydrz']/10);
		$motory[$row['id']]['vaha'] = $row['vaha'];
		$motory[$row['id']]['ovladatelnost'] = $row['ovladat'];
		$motory[$row['id']]['spotreba'] = numFP($row['spotreba']*$palivo[$row['palivo']]['cena']);
		$motory[$row['id']]['palivo'] = $row['palivo'];
		$motory[$row['id']]['palivo_nazev'] = $palivo[$row['palivo']]['nazev'];
		$motory[$row['id']]['chlazeni'] = $row['chlazeni'];
	}
	
	uasort($motory,'serad');
	
	$page->getTable('MOTORY',$motory,'PREDMETY');
	
	$page->swap('NAME',$names[$id]);
	$page->swap('SC',($sc == 'asc' ? 'desc' : 'asc'));
	$page->finish();
	do_footer();
	exit;
}

function serad($a, $b) {
	global $sc,$by;
	$second = 'id';
	
	$sc1 = 1;
	$sc2 = -1;
	
	if($sc == 'asc') {
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

##### KONEC PREHLED MOTORU #####

$result = $Sql->q('SELECT zbozi FROM sklad WHERE login = '.UID.' AND typ = '.$id);

for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$sklad[$row['zbozi']] = "set";
}

$col = "podvozek";
if($id == 1) $col = "typ";

$rasa = getRasa(UID);

$result = $Sql->q('SELECT id FROM sklad WHERE login = '.UID.' AND typ = '.$id);

for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$sklad[$row['zbozi']] = "set";
}

$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
$etapa = $result['val'];

$result = $Sql->q('SELECT p.id as id, p.nazev as nazev, z.cena as cena, z.etapa as etapa, z.obchodnik as obchodnik '.($id != 11 ? ',p.'.$col.' as typ' : '').' 
				   FROM zbozi as z LEFT JOIN '.$tabs2[$id].' as p ON p.id = z.zbozi 
				   WHERE z.typ = '.$id.'
				   ORDER BY z.etapa ASC, p.id ASC');

$data = array();

for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	$class = ($sklad[$row['id']] == "set" ? ' style="color: #FF9900"' : '');
	
	$row['etapa']++;
	
	$line['extra'] = $class;
	$line['id'] = $row['id'];
	$line['typ'] = $id;
	$line['typn'] = $pod[$row['typ']];
	$line['nazev'] = str_replace(' ', '&nbsp;', $row['nazev']);
	$line['cena'] = numF(getCost($row['cena'],$rasa,$row['obchodnik']));	
	$line['datum'] = ($row['etapa'] > $etapa ? etapa($row['etapa']) : '');
	$line['oddelovac'] = ($row['etapa'] && $row['etapa'] > $data[count($data)-1]['etapa'] ? 'border-top: 1px solid #444' : '');
	$line['etapa'] = $row['etapa'];
	
	$data[] = $line;
}

$page->getTable('PREDMETY',$data,'PREDMETY');

$page->swap('NAME',$names[$id]);

$page->finish();

do_footer();
?>