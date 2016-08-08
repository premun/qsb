<?php

include 'library.php';
is_logged();
$id = $_GET['id'];
$login = $_GET['login'];

if($id < 0) {
	go($_SERVER['HTTP_REFERER']);
	exit;
}

$page = new cPage('profil');

if($login && !$id) {
	$result = $Sql->q('SELECT id FROM hraci WHERE login = "'.$login.'"');
	if(p($result)) {
		$row = fa($result);
		$id = $row['id'];
	}
}

if($id == '' || !ereg('^[0-9]+$',$id)) {
	$page->ext('EXIST',1,'Hráč');
	exit;
}

$hrac = new cHrac($id,'all');

if($hrac->ok == '404') {
	$page->ext('EXIST',1,'Hráč');
	exit;
}

do_header('Hráč');

$rasa = $hrac->getRasa();
$hrac->datum = date('d.m.',$hrac->cas);
if(date('d.m.',$hrac->cas) == date('d.m.')) $hrac->datum = 'Dnes';

if($hrac->icq == '') {
  $hrac->icq = 'není';
} else {
  $hrac->icq = '<img src="http://status.icq.com/online.gif?icq='.$hrac->icq.'&img=5" alt="ICQ status" style="vertical-align: middle" /> '.$hrac->icq;
}

$rank = getRank($id);

$fill['login'] = $hrac->login;

$hrac->popis = str_replace('[B]','<strong>',$hrac->popis);
$hrac->popis = str_replace('[/B]','</strong>',$hrac->popis);
$hrac->popis = str_replace('[I]','<em>',$hrac->popis);
$hrac->popis = str_replace('[/I]','</em>',$hrac->popis);
$hrac->popis = str_replace('[O]','<span class="extra">',$hrac->popis);
$hrac->popis = str_replace('[/O]','</span>',$hrac->popis);
$hrac->popis = str_replace('[S]','<span class="ultra">',$hrac->popis);
$hrac->popis = str_replace('[/S]','</span>',$hrac->popis);
$hrac->popis = str_replace('[U]','<span style="text-decoration: underline">',$hrac->popis);
$hrac->popis = str_replace('[/U]','</span>',$hrac->popis);

for($j=1;$j<15;$j++) {
	$hrac->popis = str_replace('[SM'.$j.']','<img src="./smiles/'.$j.'.gif" style="vertical-align: middle" alt="">',$hrac->popis);
}

$fill['popis'] = nl2br(stripslashes($hrac->popis));

$data[0]['name'] = 'Titul:';
$data[0]['value'] = $hrac->stav;
$data[1]['name'] = 'Rasa:';
$data[1]['value'] = $rasa['nazev'];
$data[2]['name'] = 'Žebříček jezdců:';
$data[2]['value'] = $rank.' (<a href="prehledy.php?action=ladder&start='.($rank-1).'">Ukázat</a>)';

$staj = getStaj($id);
if($staj != false) {
	$staj = fa($Sql->q('SELECT nazev, id, vlajka from staje WHERE id = '.$staj));
	$data[3]['name'] = 'Stáj:';
	$data[3]['value'] = '<a href="showStaj.php?id='.$staj['id'].'">'.drawFlag2($staj['vlajka']).' '.$staj['nazev'].'</a>';
}

$data[4]['name'] = 'Prestiž:';
$data[4]['value'] = numF($hrac->prestiz);

$res5 = $Sql->q('SELECT * from brigadnici WHERE login = '.$id);
if(p($res5) > 0) {
	$brigada = fa($res5);
	$data[5]['name'] = 'Brigáda:';
	$data[5]['value'] = getBrigName($brigada['brigada']);
}

if($id == UID) {
	$data[6]['name'] = 'Peníze:';
	$data[6]['value'] = numF($hrac->penize).' Is';  
}


$data[7]['name'] = 'Naposled online:';
$data[7]['value'] = (time()-$hrac->cas < 60*15 ? 'Právě online' : date('H:i j.n.Y',$hrac->cas));
$data[8]['name'] = 'ICQ:';
$data[8]['value'] = $hrac->icq;
$data[9]['name'] = 'Kluzák:';
$data[9]['value'] = '<a href="showKluzak.php?id='.$id.'">Ukázat</a>';
$data[10]['name'] = 'Výloha:';
$data[10]['value'] = '<a href="showVyloha.php?id='.$id.'">Ukázat</a>';
$data[11]['name'] = 'Odjeté závody:';
$data[11]['value'] = $hrac->zavody.'-'.$hrac->prvni.'-'.$hrac->druhy.'-'.$hrac->treti;
$data[12]['name'] = '<a class="submit" onclick="jHadr(\'posta.php\', {id: \''.$hrac->login.'\'})">Napsat poštu</a>';
$data[12]['value'] = '&nbsp;';
//$data[13]['name'] = '<a href="posta.php?action=konverzace&login='.$hrac->login.'">Konverzace</a>';
//$data[13]['value'] = '&nbsp;';



array_unshift($data,array('name' => 'ID','value' => $id)); // PRIDAVAL SEM TAM ID A NECHTELO SE MI TO PSAT...

$id2 = $id;

while(strlen($id2) < 5) $id2 = '0'.$id2;

for($i=0;$i<count($data);$i++) {
	if(!$i && file_exists('./avatars/avatar_'.$id2.'.jpg')) {
		$data[0]['class'] = ' class="nobg"';
		$data[0]['image'] = '<td rowspan="'.(count($data)-1).'" style="padding-top: 11px; text-align: center"><img src="./avatars/avatar_'.$id2.'.jpg" alt="Avatar hráče '.$hrac->login.'" /></td>';
	} else {
		$data[$i]['image'] = '';
		$data[$i]['class'] = '';
	}
}

$page->getTable('PROFIL',$data,'PROFIL');

$page->fill($fill);

$fill2 = fa($Sql->q('SELECT * FROM stats WHERE login = '.$id));

$fill2['questik'] = 'Zatím žádný';
$fill2['questiku'] = '0';

if($fill2['questy']) {
	$kusy = explode(',',$fill2['questy']);
	
	$idq = $kusy[count($kusy)-1];
	$nazev = fa($Sql->q('SELECT nazev FROM questy WHERE id = '.$idq));
	$fill2['questik'] = $nazev['nazev'];
	if($kusy[0] == "") unset($kusy[0]);
	if($kusy[count($kusy)] == "") unset($kusy[count($kusy)]);
	$fill2['questiku'] = count($kusy);
}

$page->fill($fill2);

$page->finish();
do_footer();
?>