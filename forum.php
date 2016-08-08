<?php
include 'library.php';
include 'cls/cLink.php';

is_logged();

$page = new cPage('forum');

if(jhadr() && $_POST['action'] == 'nahled') {
	$msg = findLink::transform($_POST['msg']);
	$msg = textFormat($msg);
	$msg = nl2br($msg);

	$dlg = new cDialog('Náhled zprávy', 'alert', 'height: auto, width: 440px');
	$dlg->body($page->ext('NAHLED', 0, 0, array('text' => $msg)));
	$dlg->button('Zavřít', 'close');
	$dlg->button('Odeslat', 'submit', 'send');
	$dlg->output();
	exit;
}

do_header('Fórum');
$start = $_GET['start'];
$place = $_GET['place'];
if($start == '' || $start < 0) {
	$start = 0;
}
define('LIMIT',10);

$row = fa($Sql->q('SELECT forum from hraci WHERE id = '.UID));
$casti = explode(',',$row['forum']);

if(ereg('^[1-7]$',$place)) {  
	$max = fa($Sql->q('SELECT id FROM forum WHERE place = '.$place.' ORDER BY id DESC LIMIT 0,1'));
	$max = $max['id'];

	for($i=1;$i<8;$i++) {
		  $new .= (($i-1) ? ',' : '');
		  if($place == $i) {
			$new .= $max;
		  } else {
			$new .= ($casti[$i-1] == "" ? 0 : $casti[$i-1]);
		  }
	}
	
	if($new != $row['forum'] && isset($casti[$place-1])) {
		$novych = p($Sql->q('SELECT id FROM forum WHERE place = '.$place.' AND id > '.$casti[$place-1]));
		$last_seen = $casti[$place-1];
		if($novych > LIMIT && $start != (LIMIT*ceil($novych/LIMIT)-LIMIT)) {
			go('forum.php?place='.$place.'&start='.(LIMIT*ceil($novych/LIMIT)-LIMIT),'js');
			exit;
		}
		
		$Sql->q('UPDATE hraci set forum = "'.$new.'" WHERE id = '.UID);
		$casti = explode(',',$new);
	}
} 
 
$popis[1] = "Systémové fórum";
$popis[2] = "Chybové fórum";
$popis[3] = "Hráčské fórum";
$popis[4] = "Burza";
$popis[5] = "Oznámení hráčům";
$popis[6] = "Ohlaš. závodů/hledání stájí";
$popis[7] = "Dotazy & Help";

if($_SESSION['status'] > 1) $popis[-1] = 'Konzulské fórum';

if(!ereg('^s',$place) && !isset($popis[$place])) {
	$_SESSION['chyba'] = 'Neexistující fórum';
	go('forum.php?place=1','js');
	exit;
}

$celkem = 0;

for($i=1;$i<8;$i++) {
	$pocet = p($Sql->q('SELECT * FROM forum WHERE place = '.$i.' AND id > '.$casti[$i-1]));
	if($pocet > 0) {
		$celkem += $pocet;
		$pocet = '<span class="ultra">('.$pocet.')</span>';
	} else {
		$pocet = "";
	}	
	
	$line['pocet'] = $pocet;
	$line['place'] = $i;
	$line['nazev'] = $popis[$i];
	
	if($i < 4 || $i == 5) $data[] = $line;
		else $data2[] = $line;
}

if($_SESSION['status'] > 1) {
	$data2[] = array('pocet' => '', 'place' => -1, 'nazev' => $popis[-1]);
}

$result = $Sql->q('SELECT * from stajovnici WHERE login = '.UID);
if(p($result) > 0) {
	$row = fa($result);
	
	$stajovych = p($Sql->q('SELECT place FROM forum WHERE place = "s'.$row['staj'].'" AND cas > '.$row['forum']));
	
	$line['place'] = 's'.$row['staj'];
	$line['pocet'] = '';
	$line['nazev'] = 'Stájové fórum'.($stajovych && !ereg('s',$place) ? ' <span class="ultra">('.$stajovych.')</span>' : '');
	$celkem += $stajovych;
	$data2[] = $line;
}

$cInfobox->alter('forum', $celkem);

$page->getTable('FORA',$data,'FORA');
$page->getTable('FORA',$data2,'FORA2');

if($place == '') {
	$page->finish();
	do_footer();
	exit;
}

$places = Array();
if(isset($popis[-1])) $places[-1] = $popis[-1];
$places[1] = 'Systémové fórum';
$places[2] = 'Chybové fórum - <a href="http://help.qsb.cz/doku.php?id=qsb:chyby" target="_blank">wiki</a>';
$places[3] = 'Hráčské fórum';
$places[4] = 'Burza';
$places[5] = 'Oznámení hráčům';
$places[6] = 'Ohlašování závodů';
$places[7] = 'Dotazy & Help';
$places['s'.$row['staj']] = 'Stájové fórum';

if(ereg('s',$place)) {
	$bez = substr($place,1);
	if(p($Sql->q('SELECT login FROM stajovnici WHERE staj = '.$bez.' AND login = '.UID)) == 0) $staj_clen = true;
}

if(($place != 5 || ($place == 5 && $_SESSION['status'] == 42)) && $staj_clen != true) {
	$rows = 9;
	if($place == 5) $rows = 15;
	
	$page->misc('FORM','FORM');
	
	$fill['place'] = $place;
	$fill['rows'] = $rows;
	
	$data2 = array();
	for($j=1;$j<15;$j++) {
		$data2[]['x'] = $j;
	}
	
	$page->getTable('SMILES',$data2,'SMILES');
}

if(ereg('s',$place)) {
	$bez = substr($place,1);
	if(p($Sql->q('SELECT * from stajovnici WHERE staj = '.$bez.' AND login = '.UID)) == 0) {
		$page->ext('STAJ',1);
		exit;
	}
}

$fill['nazev'] = $places[$place];

#------------ SIPECKY!---------------#
if($start > 0) {
	$dil1 = '<a href="forum.php?place='.$place.'">&lt;&lt;</a> | <a href="forum.php?place='.$place.'&start='.($start-LIMIT).'">&lt;</a>';
}
$result = $Sql->q('SELECT * from forum WHERE place = "'.$place.'"');
$all = p($result);
if($all > ($start+LIMIT)) {
	$dil2 = '<a href="forum.php?place='.$place.'&start='.($start+LIMIT).'">&gt;</a> | <a href="forum.php?place='.$place.'&start='.($all-LIMIT).'">&gt;&gt;</a>';
}

if($all > LIMIT) {
	$dil3 = '
	<div style="margin: auto; text-align: center">';
	for($i=0;$i<ceil($all/LIMIT);$i++) {
		if(abs(abs($i*LIMIT)-$start) > 3*LIMIT) {
			if($i == 0 || $i == (ceil($all/LIMIT)-1)) $dil3 .= ' ... ';
		} else {
			if(($i*LIMIT) != $start) {
				$dil3 .= '<a href="forum.php?place='.$place.'&start='.($i*LIMIT).'">['.($i+1).']</a> ';
			} else {
				$dil3 .= '['.($i+1).'] ';
			}
		}
	}
	$dil3 .= '</div><br />';
}
$dil1 = $dil3.$dil1;

if($dil1 != '' || $dil2 != '') {
  $sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
}

$fill['sipky'] = $sipky;
#------------ SIPECKY!---------------#


$result = $Sql->q('SELECT f.id as id, f.login as login, h.login as nick, h.status as status, f.msg as msg, f.cas as cas FROM forum as f LEFT JOIN hraci as h ON h.id = f.login WHERE f.place = "'.$place.'" ORDER BY f.id DESC LIMIT '.$start.','.LIMIT);
if(p($result) == 0) {
	$page->swap('ZPRAVY','Toto fórum je prázdné');
	$page->fill($fill);
	$page->finish();
	do_footer();
	exit;
}

for($i=0;$i<p($result);$i++) {
	$add = "";  
	
	$msg = fa($result);
	
	if($novych > $i && $last_seen < $msg['id']) {
		$add = ' style="background-color: #292929"';
	}
	
	if($stajovych && $i < $stajovych && ereg('s',$place)) {
		$add = ' style="background-color: #292929"';
	}
		
	$delete = '';
	if(($_SESSION['status'] > 1 && $_SESSION['mazani_fora'] == 'yeah') || ($i == 0 && $msg['login'] == UID)) $delete = '<a class="submit" onclick="deleteForum('.$msg['id'].')">X</a> ';

	$zprava = $msg['msg'];
	
	$zprava = findLink::transform($zprava);
	
	$zprava = textFormat($zprava);
	
	$line['msg'] = nl2br($zprava);
	$line['nick'] = $msg['nick'];
	$line['datum'] = date('H:i d.m.',$msg['cas']);
	$line['login'] = $msg['login'];
	$line['vlajka'] = getFlag($msg['login']);
	$line['delete'] = $delete;
	$line['add'] = $add;
	$line['admin'] = '';
	if($msg['status'] == 2) $line['admin'] = $page->misc('KONZUL');
	if($msg['status'] == 42) $line['admin'] = $page->misc('ADMIN');	
	
	$data3[] = $line;
}

$page->getTable('ZPRAVA',$data3,'ZPRAVY');

$page->swap('ZPRAVY','Toto fórum je prázdné');
$page->swap('FORM','');

if(ereg('s',$place)) $Sql->q('UPDATE stajovnici set forum = '.time().' WHERE staj = '.$bez.' AND login = '.UID);

$page->fill($fill);
$page->finish();
do_footer();
?>