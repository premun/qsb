<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

$dlg = new cDialog('Změna jízdního stylu','alert');

$zavodnik = $Sql->q('SELECT * FROM zavodnici WHERE login = '.UID.' AND id = '.$id);
if(!p($zavodnik)) {
	$dlg->obody('Závodník nebyl nalezen');
	konec();
}

$zavodnik = fa($zavodnik);

$zavod = fa($Sql->q('SELECT id, vitez, cas, DATE_FORMAT(datum, "%d.%m. %Y") datum FROM zavody WHERE id = '.$zavodnik['zavod']));

$zavod['cas'] = ($zavod['cas'] == 0 ? 23 : $zavod['cas']);

$predem = true;
if(date('i') > 49 && p($Sql->q('SELECT zavod FROM zavodnici WHERE zavod = '.$zavod['id'])) >= $zavod['minimum']) {	# je xx:50- xx:59 	a	je tam dost lidi 
	if(date('H')+1 == $zavod['cas'] && $zavod['datum'] == date('d.m. Y')) 	# neni odlozenej, je dneska a je tesne pred prepoctem
		$predem = false;
	
	
	if(in_array(date('H'), array(12,15,18,22)) && $zavod['datum'] == '24.12. 4200') # byl odlozenej a je tesne pred jakymkoli prepoctem
		$predem = false; 
}

if(!$predem) {
	$dlg->obody('Nemůžeš měnit nastavení 10 minut před odjetím závodu');
	konec();
}

if(!$dlg->is_empty()) {
	$dlg->button('OK', 'close');
	$dlg->output();
	exit;
}

$opatrnost = $_POST['opatrnost'];
if(!is_numeric($opatrnost)) $opatrnost = 50;
$opatrnost = max(15,$opatrnost);
$opatrnost = min(85,$opatrnost);

$agresivita = $_POST['agresivita'];
if(!is_numeric($agresivita)) $agresivita = 50;
$agresivita = max(-100,$agresivita);
$agresivita = min(100,$agresivita);

$postoj = 0;
if($agresivita < 0) $postoj = $_POST['postoj1'];
if($agresivita > 0) $postoj = $_POST['postoj2'];

$taktika = 3;
if($agresivita < 0) $taktika = $_POST['taktika1'];
if($agresivita > 0) $taktika = $_POST['taktika2'];

$Sql->q('UPDATE zavodnici set agresivita = '.$agresivita.', opatrnost = '.$opatrnost.', obet = '.$_POST['obet'].', postoj = '.$postoj.', taktika = '.$taktika.' WHERE login = '.UID.' AND id = '.$id);

$result = $Sql->q('SELECT * FROM spioni WHERE zavodnik = '.$id);
for($i=0;$i<p($result);$i++) {
	$row = fa($result);
	sendPosta(0, $row['login'], spion($row['spolehlivost'], $id));
}

$dlg->body('Jízdní styl nastaven');
$dlg->button('OK', 'location', 'showRace.php?id='.$zavod['id'].'#sazky');

$dlg->output();
?>