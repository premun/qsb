<?php

if(isset($showRace_id)) {
	$id2 = $showRace_id;
} else {
	include 'library.php';
	is_logged();
	do_header('Sázky');
	$id2 = $_GET['id'];
}

$page2 = new cPage('sazky');
$page2->setCommon('COMMON_SHOW'.($showRace_id ? '2' : ''));

$problem = false;

if($id2 == '' || !ereg('^[0-9]+$',$id2)) {
	$page2->ext('EXIST_ID',1);
	$problem = true;
	if(isset($showRace_id)) exit;
}

$result = $Sql->q('SELECT * from sazky WHERE id = '.$id2);
if(p($result) == 0) {
	$page2->ext('EXIST',1);
	$problem = true;
	if(isset($showRace_id)) exit;
}
$row1 = fa($result);

if($row1['login'] != UID) {
	$page2->ext('OWN',1);
	$problem = true;
	if(isset($showRace_id)) exit;
}

$result2 = $Sql->q('SELECT * FROM sazky WHERE login = '.UID.' AND zavod = '.$id2);
if(p($result2) == 0) {
	$sazka = true;
}

$result3 = $Sql->q('SELECT * FROM sazky WHERE id = '.$id2);
$sazka = fa($result3);

if(!$showRace_id) {
	$zavod = fa($Sql->q('SELECT id, nazev FROM zavody WHERE id = '.$sazka['zavod']));
}

if($sazka['misto'] == 0 && $sazka['misto'] != -1) {
	$sazka['misto'] = 'Nedojede';
}

if($sazka['misto'] > -1) {
	$sazka_zavodnik = '<a href="showProfile.php?id='.$sazka['zavodnik'].'">'.getNick($sazka['zavodnik']).'</a>';
	$misto2 = $sazka['misto'].'.';
}

if($misto2 == 0) {
	$misto2 = 'Nedojede';
}

if($sazka['misto'] == -1) {
	$misto2 = '';
	$sazka['zavodnik'] = '';
	$sazka_zavodnik = 'Nikdo nedojede';
}

$zruseni = '';
if($sazka['login'] == UID && $zavod['vitez'] == 0) {
	$zruseni = '<div style="text-align: center">'.
			($sazka['vyhra'] == -1 ? '<input type="button" onclick="location=\'abortBet.php?id='.$sazka['id'].'&action=auto\'" value=" Zrušit auto-zrušení sázky " class="submit" style="width: 383px" />' : 
									 '<input type="button" onclick="auto()" value=" Nastavit auto-zrušení sázky " class="submit" style="width: 383px" />');
	$zruseni .= '<br /><input type="button" onclick="location=\'abortBet.php?id='.$sazka['id'].'\'" value=" Zrušit sázku " class="submit" style="width: 383px" /></div>';
}

$page2->swap($zruseni,'ZRUSENI');

if($sazka['vyhra'] == 1) {
	$win = '<span style="color: #02FD09">Výhra</span>';
	$vyhra = numF($sazka['penize']);
} else {
	$win = '<span style="color: #FF0000">Prohra</span>';	
	$vyhra = 0;  
}  

if($zavod['vitez'] == 0) {
	$win = 'Čeká se na odjetí';
	$vyhra = 'Čeká se na odjetí';
}

$fill2 = array(
		'idz' => $id,
		'nazev' => $zavod['nazev'],
		'zavodnik' => $sazka_zavodnik,
		'misto' => $misto2,
		'sazka' => numF($sazka['sazka']),
		'zruseni' => $zruseni,
		'auto' => $auto,
		'vyhra' => $vyhra,
		'stav' => $win,
		'id' => $id,
		'ids' => $id2);

if(!$problem) $page2->ext('SHOWBET',false,false,$fill2);

?>