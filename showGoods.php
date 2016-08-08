<?php

include 'library.php';
is_logged();

if($_POST['action'] == 'etapa') {
	$Sql->q('UPDATE zbozi set etapa = '.$_POST['etapa'].' WHERE id = '.$_POST['id']);
	exit;
}

$id = $_GET['id'];

$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
$etapa = $result['val']-1;

$result = $Sql->q('SELECT * FROM obchodnici WHERE id = '.$id);
$obch = fa($result);

do_header('Obchod');

$page = new cPage('showGoods');

$fill['nazev'] = $obch['nazev'];
$fill['rasa'] = getRasaNazev($obch['rasa']);
$fill['obsah'] = $page->misc('ZADNE');

$names[1] = "Podvozek";
$names[2] = "Motor";
$names[3] = "Držáky";
$names[4] = "Chladič";
$names[5] = "Palubní deska";
$names[6] = "Brzdy";
$names[7] = "Zdroje";
$names[8] = "Pancéřování";
$names[9] = "Suspenzory";
$names[10] = "Přídavné motory";
$names[11] = "Opravní droidi";

$kategorie[1] = "Podvozky";
$kategorie[2] = "Motory";
$kategorie[3] = "Energodržáky";
$kategorie[4] = "Chladiče";
$kategorie[5] = "Palubní desky";
$kategorie[6] = "Brzdy";
$kategorie[7] = "Zdroje";
$kategorie[8] = "Pancéřování";
$kategorie[9] = "Suspenzory";
$kategorie[10] = "Přídavné motory";
$kategorie[11] = "Opravní droidi";

$podvozky[0] = "Všechny";
$podvozky[1] = "Sport";
$podvozky[2] = "Combi";
$podvozky[3] = "Wrecker";

for($j=1;$j<count($tabs2)+1;$j++) {  	
	$typ = ($j > 1 ? 'podvozek' : 'typ');
	
	if($j != 11) {
		$result = $Sql->q('SELECT z.id as id, z.zbozi as zbozi2, z.kusy as kusy, z.celkem as celkem, z.cena as cena, z.obchodnik as obchodnik, z.etapa as etapa,
						  		  '.$tabs2[$j].'.nazev as nazev, '.$tabs2[$j].'.'.$typ.' as typ 
						  		  FROM zbozi as z LEFT JOIN '.$tabs2[$j].' ON z.zbozi = '.$tabs2[$j].'.id 
						  		  WHERE z.obchodnik = '.$id.' AND z.typ = '.$j.' AND z.etapa <= '.$etapa.' ORDER BY z.zbozi ASC');
	} else {
		$result = $Sql->q('SELECT z.id as id, z.zbozi as zbozi2, z.kusy as kusy, z.celkem as celkem, z.cena as cena, z.obchodnik as obchodnik, z.etapa as etapa,
								  '.$tabs2[$j].'.nazev as nazev, '.$tabs2[$j].'.urychleni as urychleni, '.$tabs2[$j].'.sleva as sleva 
								  FROM zbozi as z LEFT JOIN '.$tabs2[$j].' ON z.zbozi = '.$tabs2[$j].'.id 
								  WHERE z.obchodnik = '.$id.' AND z.typ = '.$j.' AND z.etapa <= '.$etapa.' ORDER BY z.zbozi ASC');		
	}	
	
	if(p($result) > 0) {
		//$line['pic'] = str_replace(' ','_',strtolower(trim(fuckDia($names[$j]))));
		$line['pic'] = 'rasa'.$obch['rasa'];
		
		$kusy = explode(' - ', $obch['nazev']);
		
		$line['popis'] = '<h4 style="border: none; margin-left: -4px"><span style="font-style: normal" class="extra">'.$kusy[0].'</span> - '.$fill['rasa'].'</h4>'.$kusy[1];
		$line['j'] = $j;
		$line['nazev'] = $kategorie[$j];
		
		$rasa = getRasa(UID);
		$penize = getPenize(UID);
		
		$data2 = array();
		
		for($i=0;$i<p($result);$i++) {
			$zbozi = fa($result);
			
			$cena = getCost($zbozi['cena'],$rasa,$zbozi['obchodnik']);
			
			$line2['id'] = $zbozi['zbozi2'];
			$line2['typ'] = $j;
			
			if($j != 11) {
				$line2['typn'] = $podvozky[$zbozi['typ']];
			} else {
				$line2['typn'] = ($zbozi['urychleni'] >= 0 ? $zbozi['urychleni'].'%' : '<span class="error">'.$zbozi['urychleni'].'%</span>').'</td><td>'.($zbozi['sleva'] >= 0 ? $zbozi['sleva'].'%' : '<span class="error">'.$zbozi['sleva'].'%</span>');
			}
			
			$line2['nazev'] = str_replace(' ','&nbsp;',$zbozi['nazev']);
			$line2['cena'] = str_replace(' ','&nbsp;',numF($cena));
			$line2['kusy'] = $zbozi['kusy'];
			$line2['celkem'] = $zbozi['celkem'];
			
			if($zbozi['kusy'] > 0 && $cena < $penize) {
				$line2['akce'] = '<td style="text-align: right; width: 60px; padding-right: 8px"><a class="submit" onclick="jHadr(\'buy.php?id='.$zbozi['id'].'\', {})">Koupit</a></td>';
			} else {
				$line2['akce'] = '<td style="text-align: right; width: 60px; padding-right: 8px; color: #656565; cursor: default">Koupit</td>';    
			}
			
			/*if(UID < 3) {
				$vypisek = '<td style="text-align: right; width: 60px"><select onchange="setEtapa('.$zbozi['id'].')" id="etapa_'.$zbozi['id'].'" style="font-size: 10px">';
				
				for($g=0;$g<5;$g++) {
					$vypisek .= '<option value="'.$g.'"'.($g == $zbozi['etapa'] ? ' selected="selected"' : '').'>'.($g+1).'.</option>';
				}
				
				$vypisek .= '</select></td>';
				
				$line2['akce'] = $vypisek;
			}*/

			$data2[] = $line2;			
		}
					
		$line['predmety'] = $page->getTable('PREDMETY',$data2);			
		$data[] = $line;
	}
}

$table = $page->getTable('TYP',$data);	

if($id == 11) {
	$table = str_replace('Typ podvozku','Rychlost&nbsp;&nbsp;&nbsp;</td><td>Sleva',$table);
}

$page->swap('OBSAH',$table);

$fill['etapa'] = (p($Sql->q('SELECT etapa FROM zbozi WHERE obchodnik = '.$id.' AND etapa > '.($etapa+1))) ? $page->misc('ETAPA') : '');
$fill['etapa_datum'] = etapa('next');

$page->fill($fill);
$page->finish();
do_footer();
?>