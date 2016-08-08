<?php

include 'library.php';
is_logged();

$nazvy[1] = "Podvozek";
$nazvy[2] = "Motor";
$nazvy[3] = "Energodržáky";
$nazvy[4] = "Chladič";
$nazvy[5] = "Palubní deska";
$nazvy[6] = "Brzdy";
$nazvy[7] = "Zdroj";
$nazvy[8] = "Pancéřování";
$nazvy[9] = "Suspenzory";
$nazvy[10] = "Přídavný motor";

unset($tabs[11]);

$page = new cPage('sablony');

if(jhadr()) {
	$dlg = new cDialog('Šablona kluzáku','alert','width: 380px');

	$action = $_POST['action'];

	if($action == 'nova') {
		$dlg->title('Nová šablona');
		$dlg->body($page->misc('JHADR_NOVA'));
		$dlg->button('Zrušit','close');
		$dlg->button('Použít aktuální konfiguraci', 'location', 'sablony.php?action=nova&sub=aktualni');
		$dlg->button('Vytvořit novou', 'location', 'sablony.php?action=nova');
		$dlg->output();
	}

	if($action == 'pridat') {
		$dlg->title('Tvorba nové šablony');

		$nazev = $_POST['nazev'];

		if($nazev == "")
			$dlg->obody('Nevyplnil jsi název šablony');

		if(strlen($nazev) < 4)
			$dlg->obody('Název šablony je příliš krátký');

		if(p($Sql->q('SELECT nazev FROM sablony WHERE nazev = "'.$nazev.'"')))
			$dlg->obody('Tento název šablony již existuje');

		foreach($tabs as $id => $nazev2) {
			$idz = $_POST['sablona_'.$nazev2];
		
			if(!$idz && $id < 8) {
				$dlg->obody('V šabloně chybí <strong>'.strtolower(substr($nazvy[$id],0,1)).substr($nazvy[$id],1).'</strong>!');
				break;
			} elseif(!$idz && $id > 7) {
				continue;
			}
			
			$predmet = fa($Sql->q('SELECT s.login as login, '.($id == 1 ? 'p.typ as typ' : 'p.podvozek as typ').'
								   FROM sklad as s LEFT JOIN '.$tabs[$id].' as p ON p.id = s.zbozi
							   	   WHERE s.id = '.$idz));	
								   
			if($predmet['login'] != UID) {
				$dlg->obody('<strong>'.$nazvy[$id].'</strong> není tvůj předmět!');
				if($id < 8) 
					break;
				else
					continue;			
			}
			
			if($id == 1) {
				$typ = $predmet['typ'];
			} elseif($predmet['typ'] != $typ && $predmet['typ'] != 0) {
				$dlg->obody('<strong>'.$nazvy[$id].'</strong> nepasuje do podvozku.');
				break;				
			}
		}

		if(!$dlg->is_empty()) {
			$dlg->set('width', '270px');
			$dlg->button('OK','close');
			$dlg->output();
			konec();
		}
		
		foreach($tabs as $id => $tab) $predmety[$id] = ($_POST['sablona_'.$tab] == "" ? 0 : $_POST['sablona_'.$tab]);
		
		$Sql->q('INSERT into sablony(login,nazev,'.implode(',',$tabs).') values('.UID.',"'.$nazev.'",'.implode(',',$predmety).')');
		
		$max = fa($Sql->q('SELECT MAX(id) as id FROM sablony WHERE login = '.UID));
		
		$dlg->body('Šablona <strong>\''.$nazev.'\'</strong> byla vytvořena.');
		$dlg->button('Zpět do šablon','location','obchod.php?action=sablony');
		$dlg->button('Zobrazit šablonu','location','sablony.php?action=zobrazit&id='.$max['id']);
		$dlg->output();
	}
	
	if($action == 'smazat') {
		$id = $_POST['id'];
		
		$dlg->title('Mazání šablony');
		
		$result = $Sql->q('SELECT id, login, nazev FROM sablony WHERE id = '.$id);
		
		if(!p($result)) {
			$dlg->obody('Šablona nenalezena');
			$dlg->set('width', '270px');
			$dlg->button('OK','close');
			$dlg->output();
			konec();
		}
		
		$sablona = fa($result);
		
		if($sablona['login'] != UID)
			$dlg->obody('Šablona není tvoje');
			
		if(!$dlg->is_empty()) {
			$dlg->set('width', '270px');
			$dlg->button('OK','close');
			$dlg->output();
			konec();
		}
		
		if($_POST['o'] == 'rly') {
			$Sql->q('DELETE FROM sablony WHERE id = '.$id);
		
			$dlg->obody('Šablona smazána');
			$dlg->set('width', '270px');
			$dlg->button('OK','refresh');
			$dlg->output();
			konec();			
		}
		
		$dlg->obody('Opravdu si přeješ vymazat šablonu <strong>\''.$sablona['nazev'].'\'</strong>?
					 <form action="sablony.php" method="post" name="helper">
					 	<input type="hidden" name="action" value="smazat" />
					 	<input type="hidden" name="id" value="'.$id.'" />
					 	<input type="hidden" name="o" value="rly" />
					 </form>');	
					 
		$dlg->button('Ne','close');
		$dlg->button('Ano','jHadr_submit','helper');
		$dlg->output();
		konec();
	}
	
	if($action == 'pouzit') {
		$id = $_POST['id'];
		
		$dlg->title('Použít šablonu');
		$dlg->set('width', '270px');
		
		$result = $Sql->q('SELECT * FROM sablony WHERE id = '.$id);
		
		if(!p($result)) {
			$dlg->obody('Šablona nenalezena');
			$dlg->button('OK','close');
			$dlg->output();
			konec();
		}
		
		$sablona = fa($result);
		
		if($sablona['login'] != UID)
			$dlg->obody('Šablona není tvoje');

		if(p($Sql->q('SELECT zavodnici.login FROM zavodnici LEFT JOIN zavody ON zavodnici.zavod = zavody.id WHERE zavody.vitez = 0 AND zavodnici.login = '.UID)))
			$dlg->obody('Šablonu nelze použít - účastníš se závodu.');
		
		foreach($sablona as $nazev => $idz) {
			if(in_array($nazev,array('id', 'nazev', 'login'))) continue;
		
			foreach($tabs as $i => $nazev2) {
				if($nazev2 == $nazev) $id = $i;
			}
		
			if(!$idz && $id < 8) {
				$dlg->obody('V šabloně chybí <strong>'.strtolower(substr($nazvy[$id],0,1)).substr($nazvy[$id],1).'</strong>. Uprav prosím šablonu.');
				break;
			} elseif(!$idz && $id > 7) {
				continue;
			}
			
			$predmet = fa($Sql->q('SELECT s.login as login, '.($nazev == 'podvozky' ? 'p.typ as typ' : 'p.podvozek as typ').'
								   FROM sklad as s LEFT JOIN '.$nazev.' as p ON p.id = s.zbozi
							   	   WHERE s.id = '.$idz));	
			
			if($predmet['login'] != UID) {
				$dlg->obody('<strong>'.$nazvy[$id].'</strong> není tvůj předmět. Uprav prosím šablonu.');
				break;		
			}
			
			if($id == 1) {
				$typ = $predmet['typ'];
			} elseif($predmet['typ'] != $typ && $predmet['typ'] != 0) {
				$dlg->obody('<strong>'.$nazvy[$id].'</strong> nepasuje do podvozku. Uprav prosím šablonu.');
				break;	
			}
		}	
			
		if(!$dlg->is_empty()) {
			$dlg->button('Zavřít','close');
			$dlg->button('Upravit šablonu','location','sablony.php?action=zobrazit&id='.$_POST['id']);
			$dlg->output();
			konec();
		}	
		
		if($_POST['o'] == 'rly') {		
			$Sql->q('UPDATE sklad set umisteni = 0 WHERE umisteni = 1 AND login = '.UID);
			
			foreach($sablona as $nazev => $idz) {
				if(in_array($nazev,array('id', 'nazev', 'login'))) continue;			
				$Sql->q('UPDATE sklad set umisteni = 1, cena2 = 0 WHERE umisteni BETWEEN -1 AND 1000 AND login = '.UID.' AND id = '.$idz);
			}
		
			$dlg->obody('Šablona použita');
			$dlg->button('Do šablon','close');
			$dlg->button('Do skladu','location','obchod.php?action=sklad');
			$dlg->button('Do depa','location','depo.php');
			$dlg->output();
			konec();			
		}
		
		$dlg->obody('Opravdu použít šablonu <strong>\''.$sablona['nazev'].'\'</strong>?
					 <form action="sablony.php" method="post" name="helper">
					 	<input type="hidden" name="action" value="pouzit" />
					 	<input type="hidden" name="id" value="'.$_POST['id'].'" />
					 	<input type="hidden" name="o" value="rly" />
					 </form>');	
					 
		$dlg->button('Ne','close');
		$dlg->button('Ano','jHadr_submit','helper');
		$dlg->output();
		konec();
	}
}

$action = $_GET['action'];

if($action == 'nova') {	
	do_header('Předměty');

	$data = array();
	foreach($tabs as $id => $nazev2) {
	
		$result = $Sql->q('SELECT s.id as id, s.umisteni, p.nazev as nazev, '.($id == 1 ? 'p.typ as typ' : 'p.podvozek as typ').'
						   FROM sklad as s LEFT JOIN '.$tabs[$id].' as p ON p.id = s.zbozi
						   WHERE s.login = '.UID.' AND s.typ = '.$id);	
	
		if(p($result)) {
			$typy = 'SCW';
			$data2 = array();
			
			if($id > 7) $data2[] = array('id' => 0,
										 'nazev' => '',
										 'typ' => '',
										 'selected' => '');
			
			for($j=0;$j<p($result);$j++) {
				$predmet = fa($result);
				$predmet['typ'] = ($predmet['typ'] == 0 ? '' : ' ('.substr($typy, $predmet['typ']-1, 1).')');
				$predmet['selected'] = ($_GET['sub'] == 'aktualni' && $predmet['umisteni'] == 1 ? ' selected="selected"' : '');
				
				$data2[] = $predmet;
			}
		
			$data[] = array('nazev' => $nazvy[$id], 'select' => $page->getTable('NOVA_PREDMETY',$data2), 'nazev2' => $nazev2);
		}	
	}
	$page->getTable('NOVA',$data,'OBSAH');
	
	
	$data = array();
	foreach($tabs as $id => $nazev) {
		$data[] = array('id' => $id, 'nazev' => $nazev);
	}
	
	$fill['JS_NAZVY'] = $page->getTable('JS_NAZVY',$data);
	
	$page->fill($fill);
	$page->finish();
	do_footer();
}

if($action == 'upravit') {
		$id = $_GET['id'];
		$nazev = $_POST['nazev'];
	
		$result = $Sql->q('SELECT * FROM sablony WHERE id = '.$id);	
		
		if(!p($result)) {
			$_SESSION['chyba'] = 'Šablona nebyla nalezena';		
			go('sablony.php?action=zobrazit&id='.$id);
			exit;	
		}
		
		$sablona = fa($result);
		
		if($sablona['login'] != UID) {
			$_SESSION['chyba'] = 'Šablona není tvoje';		
			go('sablony.php?action=zobrazit&id='.$id);
			exit;		
		}

		if($nazev == "") {
			$_SESSION['chyba'] = 'Nevyplnil jsi název šablony';		
			go('sablony.php?action=zobrazit&id='.$id);
			exit;		
		}

		if(strlen($nazev) < 4) {
			$_SESSION['chyba'] = 'Název šablony je příliš krátký';		
			go('sablony.php?action=zobrazit&id='.$id);
			exit;	
		}

		if(p($Sql->q('SELECT nazev FROM sablony WHERE id != '.$id.' AND nazev = "'.$nazev.'"'))) {
			$_SESSION['chyba'] = 'Tento název šablony již existuje';		
			go('sablony.php?action=zobrazit&id='.$id);
			exit;	
		}

		foreach($tabs as $id2 => $nazev2) {
			$idz = $_POST['sablona_'.$nazev2];
		
			if(!$idz && $id2 < 8) {
				$_SESSION['chyba'] = 'V šabloně chybí '.strtolower(substr($nazvy[$id2],0,1)).substr($nazvy[$id2],1);		
				go('sablony.php?action=zobrazit&id='.$id2);
				exit;	
			} elseif(!$idz && $id2 > 7) {
				continue;
			}
			
			$predmet = fa($Sql->q('SELECT s.login as login, '.($id2 == 1 ? 'p.typ as typ' : 'p.podvozek as typ').'
								   FROM sklad as s LEFT JOIN '.$tabs[$id2].' as p ON p.id = s.zbozi
							   	   WHERE s.id = '.$idz));	
								   
			if($predmet['login'] != UID) {
				$_SESSION['chyba'] = $nazvy[$id2].' není tvůj předmět';		
				go('sablony.php?action=zobrazit&id='.$id);
				exit;			
			}
			
			if($id2 == 1) {
				$typ = $predmet['typ'];
			} elseif($predmet['typ'] != $typ && $predmet['typ'] != 0) {
				$_SESSION['chyba'] = $nazvy[$id2].' nepasuje do podvozku';		
				go('sablony.php?action=zobrazit&id='.$id);
				exit;	
			}	
		}

		$dotaz = 'UPDATE sablony set nazev = "'.$_POST['nazev'].'"';
	
		foreach($tabs as $g => $tab) {
			$dotaz .= ', '.$tab .' = '.($_POST['sablona_'.$tab] == "" ? 0 : $_POST['sablona_'.$tab]);
		}
		
		$dotaz .= ' WHERE login = '.UID.' AND id = '.$id;
		
		$Sql->q($dotaz);
		
		$_SESSION['chyba'] = 'Šablona upravena';		
		go('sablony.php?action=zobrazit&id='.$id);
		exit;
}

if($action == 'zobrazit') {	
	do_header('Předměty');
	
	$page->setCommon('UPRAVA_NADPIS');

	$id = $_GET['id'];

	$result = $Sql->q('SELECT * FROM sablony WHERE id = '.$id);	
	
	if(!p($result)) {
		$page->ext('NENALEZENA',1);
		exit;		
	}
	
	$sablona = fa($result);
	
	if($sablona['login'] != UID) {
		$page->ext('TVOJE',1);
		exit;		
	}
	
	$sablona = fa($Sql->q('SELECT * FROM sablony WHERE id = '.$id));
	
	$fill['nazev'] = $sablona['nazev'];
	$fill['id'] = $sablona['id'];
	
	$page->misc('ZOBRAZIT','OBSAH');
	
	foreach($tabs as $j => $nazev) {
		if(!$sablona[$nazev]) continue;		
		$simulace[$j] = $sablona[$nazev];
	}
		
	$kluzak = new cKluzak(UID, $simulace);
	
	$hlasky = $kluzak->getHlasky();
	if(count($hlasky) > 0) {
		$hlasky = '';
		foreach($kluzak->getHlasky() as $hl) {
		  $hlasky .= $hl.'<br />';
		}
	}

	$kluzak_typy[1] = 'Sport';
	$kluzak_typy[2] = 'Combi';
	$kluzak_typy[3] = 'Wrecker';
	
	$values[-1]['title'] = 'Typ kluzáku:';
	$values[-1]['value'] = (isset($kluzak_typy[$kluzak->podvozek['typ']]) ? $kluzak_typy[$kluzak->podvozek['typ']] : (isset($kluzak_typy[$kluzak->deska['podvozek']]) ? $kluzak_typy[$kluzak->deska['podvozek']] : 'Neurčen'));
	
	$values[0]['title'] = 'Maximální rychlost:';
	$values[0]['value'] = $kluzak->rychlost.' km/h';
	
	if(isset($kluzak->motor['rychlost'])) {
		$values[1]['title'] = '<acronym title="Rychlost kluzáku/motoru udává, kolik motor může jet za daných okolností. Tzn. že pokud má motor max. rychlost 245 km/h a je poničený, tak se s ním dá jet např. jen 180 km/h. Na max. rychlosti kluzáku se také podepisuje váha">Rychlost kluzáku/motoru:</acronym> ';
		$values[1]['value'] = drawBar($kluzak->rychlost*100/$kluzak->motor['rychlost']);
	}
	
	$values[2]['title'] = 'Váha/Nosnost:';
	$values[2]['value'] = $kluzak->vaha.'/'.$kluzak->podvozek['nosnost'].' kg';
	$values[3]['title'] = 'Chlazení:';
	$values[3]['value'] = $kluzak->chlazeni.'/'.$kluzak->chladic['vykon'].' kW';
	$values[4]['title'] = 'Spotřeba energie:';
	$values[4]['value'] = $kluzak->spotreba.'/'.$kluzak->zdroj['vykon'].' kW';
	$values[5]['title'] = 'Ovladatelnost:';
	$values[5]['value'] = drawBar($kluzak->ovladatelnost);
	$values[6]['title'] = 'Odolnost:';
	$values[6]['value'] = drawBar($kluzak->odolnost);
	$values[7]['title'] = 'Zrychlení:';
	$values[7]['value'] = drawBar($kluzak->zrychleni);
	$values[8]['title'] = 'Cena kluzáku:';
	$values[8]['value'] = numF($kluzak->cena).' Is';
	
	if($hlasky != '') {
		$values[9]['title'] = 'Varování:';
		$values[9]['value'] = $hlasky;
	}
	
	$page->getTable('VLASTNOSTI',$values,'VLASTNOSTI');
	
	$data = array();
	foreach($tabs as $id => $nazev2) {
	
		$result = $Sql->q('SELECT s.id as id, p.nazev as nazev, '.($id == 1 ? 'p.typ as typ' : 'p.podvozek as typ').'
						   FROM sklad as s LEFT JOIN '.$tabs[$id].' as p ON p.id = s.zbozi
						   WHERE s.login = '.UID.' AND s.typ = '.$id);	
	
		if(p($result)) {
			$typy = 'SCW';
			$data2 = array();
			
			if($id > 7) $data2[] = array('id' => 0,
										 'nazev' => '',
										 'typ' => '',
										 'selected' => '');
			
			for($j=0;$j<p($result);$j++) {
				$predmet = fa($result);
				$predmet['typ'] = ($predmet['typ'] == 0 ? '' : ' ('.substr($typy, $predmet['typ']-1, 1).')');
				$predmet['selected'] = ($predmet['id'] == $sablona[$tabs[$id]] ? ' selected="selected"' : '');
				
				$data2[] = $predmet;
			}
		
			$data[] = array('nazev' => $nazvy[$id], 'select' => $page->getTable('UPRAVIT_PREDMETY',$data2), 'nazev2' => $nazev2);
		}	
	}
	$page->getTable('UPRAVIT',$data,'UPRAVIT');
	
	$page->fill($fill);
	$page->finish();
	do_footer();
}
?>