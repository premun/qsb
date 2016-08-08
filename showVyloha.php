<?php

include 'library.php';
is_logged();
$id = $_GET['id'];
$action = $_GET['action'];

if($action != 'all' && !is_numeric($id)) {
	go($_SERVER['HTTP_REFERER']);
	exit;
}

if(UID == $id) {
	go('obchod.php?action=vyloha');
	exit;
}

do_header('Výloha');

$page = new cPage('obchod');

$fill['hrac'] = ($id == 0 ? ' - všech hráčů' : getNick($id));

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

$fill['predmety'] = $page->misc('PRAZDNA_VYLOHA');

for($j=1;$j<12;$j++) {  
	if(!$_GET['typ'] || $_GET['typ'] == $j) {
		if($action == 'all') {
			$result = $Sql->q('SELECT s.id as id, s.zbozi as zbozi, s.login as login, s.cena2 as cena, s.vydrz as vydrz, h.login as nick FROM sklad as s LEFT JOIN hraci as h ON h.id = s.login 
								WHERE s.login != '.UID.' AND s.umisteni = 2 AND s.typ = '.$j.' ORDER BY s.cena2 ASC');
		} else {
			$result = $Sql->q('SELECT id, zbozi, login, cena2 as cena, vydrz FROM sklad WHERE login = '.$id.' AND umisteni = 2 AND typ = '.$j.' ORDER BY cena2 ASC');
		}
	
		if(p($result) > 0) {
		
			$line['pic'] = str_replace(' ','_',strtolower(trim(fuckDia($names[$j]))));
			$line['j'] = $j;
			$line['nazev'] = $names[$j];
			
			$data2 = array();
			
			for($i=0;$i<p($result);$i++) {
				$zbozi = fa($result);
				if(!($last['id'] == $zbozi['zbozi'] && $last['typ'] == $j)) $p = new cItem($zbozi['zbozi'],$j);
				
				$line2['id'] = $p->id;
				$line2['typ'] = $j;				
				
				if($zbozi['typ'] == 1) {
					$line2['typ2'] = ($p->typ ? '('.substr('SCW', $p->typ-1, 1).')' : '');
				} else {
					$line2['typ2'] = ($p->podvozek ? '('.substr('SCW', $p->podvozek-1, 1).')' : '');				
				}
				
				$line2['nazev'] = str_replace(' ','&nbsp;',$p->nazev);
				$line2['vydrz'] = drawBarMini($zbozi['vydrz']/$p->vydrz*100);
				$line2['cena'] = numF($zbozi['cena']);
				$line2['akce'] = '<td style="text-align: right; padding-right: 8px;">'.($action == 'all' ? '<a class="ultra" href="showProfile.php?id='.$zbozi['login'].'">('.$zbozi['nick'].')</span> ' : '').'<a class="submit" onclick="jHadr(\'buyItem.php?id='.$zbozi['id'].'\', {})">Koupit</a></td>';
				
				$last = array('id' => $p->id, 'typ' => $j);
				
				$data2[] = $line2;
				
			}
						
			$line['predmety'] = $page->getTable('PREDMETY',$data2);			
			$data[] = $line;
		}
	}
}

$fill['predmety'] = $page->getTable('TYP',$data);

$page->ext('VYLOHA',1,0,$fill);
?>