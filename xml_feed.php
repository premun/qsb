<?php
include 'library.php';

$action = $_GET['action'];

if($action == 'login') {
	$login = $_GET['login'];
	$heslo = $_GET['heslo'];
		
	$md5 = md5($salt.$heslo);	
	
	if($_GET['md5'] != "" && str_replace('*','',$heslo) == "") $md5 = $_GET['md5'];
	
	$result = $Sql->q('SELECT id, status FROM hraci WHERE login = "'.$login.'" AND heslo = "'.$md5.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$row = fa($result);
	
	die($row['id'].'&'.$row['status'].'&'.$md5.'&'.(file_exists('./avatars/avatar_'.str_repeat('0',5-strlen($row['id'])).$row['id'].'.jpg') ? '1' : '0').'&'.CLIENT);
}

if($action == 'update') {
	$id = $_GET['id'];
	$heslo = $_GET['md5'];
	$cas = $_GET['time'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$result = $Sql->q('SELECT komu FROM posta WHERE (status = 0 OR status = 4) AND komu = '.$id);	
	
	if(!p($result)) die('0');
	die('1');
}

if($action == 'posta') {
	$id = $_GET['id'];
	$heslo = $_GET['md5'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$result = $Sql->q('SELECT * FROM posta WHERE (status = 0 OR status = 4) AND komu = '.$id);	
	
	if(!p($result)) die('0');
	
	echo '<?xml version="1.0" encoding="utf-8"?>
<QSB_feed>';	
	
	$banned = 'B,O,S,G,R,M,I';
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		foreach(explode(',', $banned) as $char) {
			$row['msg'] = str_replace('['.$char.']','',$row['msg']);
			$row['msg'] = str_replace('[/'.$char.']','',$row['msg']);
		}
		
		for($j=1;$j<15;$j++) $row['msg'] = str_replace('[SM'.$j.']', $ascii_smiles[$j][0], $row['msg']);
		
		$row['msg'] = str_replace("\n",'{0}',$row['msg']);
		$row['msg'] = strip_tags($row['msg']);
		
		echo '
	<posta id="'.$row['id'].'" login="'.getNick($row['kdo']).'" datum="'.date('H:i j.n.', $row['cas']).'">
		'.urlencode($row['msg']).'
	</posta>';
		
		$posta[] = array('login' => getNick($row['kdo']), 'cas' => $row['cas'], 'msg' => $row['msg']);
	}
	
	$Sql->q('UPDATE posta set status = 1 WHERE status = 0 AND komu = '.$id);	
	$Sql->q('UPDATE posta set status = 3 WHERE status = 4 AND komu = '.$id);
	
	echo '
</QSB_feed>';
}

if($action == 'sendPosta') {
	$id = $_GET['id'];
	$heslo = $_GET['md5'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$login = urldecode($_GET['adresat']);
	$msg = urldecode($_GET['zprava']);
	
	$result = $Sql->q('SELECT id FROM hraci WHERE login = "'.$login.'" LIMIT 0,1');
	if(!p($result)) die('404');
	
	$row = fa($result);
	
	sendPosta($id,$row['id'],$msg);
	echo '1';
}

if($action == 'deletePosta') {
	$id = $_GET['id'];
	$posta_id = $_GET['posta_id'];
	$heslo = $_GET['md5'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');

	$result = $Sql->q('SELECT * FROM posta WHERE kdo = '.$id.' AND id = '.$posta_id);

	if(p($result) == 0) die('404');
	
	$row = fa($result);  
	$val = 5;

	if($row['status'] == 3) {
		$result = $Sql->q('DELETE FROM posta WHERE id = '.$posta_id);
		if($result)	die('255_1');
		die('0');
	}
	
	$result = $Sql->q('UPDATE posta set status = '.$val.' WHERE id = '.$posta_id);
	if($result)	die('255_2');
	
	die('0');
}

/*

if($action == 'forum') {
	$id = $_GET['id'];
	$heslo = $_GET['heslo'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$result = $Sql->q('SELECT h.login as login, f.place as place, f.cas as cas, f.msg as msg FROM forum as f LEFT JOIN hraci as h ON h.id = f.login WHERE f.place NOT LIKE "%s%" ORDER BY f.id DESC LIMIT 0,1');
	
	if(!p($result)) die('0');
	
	$banned = array('[B]','[O]','[S]','[/B]','[/O]','[/S]');
	
	$row = fa($result);
	
	foreach($banned as $char) $row['msg'] = str_replace($char,'',$row['msg']);
	for($j=1;$j<15;$j++) $row['msg'] = str_replace('[SM'.$j.']','',$row['msg']);
	
	echo serialize($row);
}

if($action == 'penize') {
	$id = $_GET['id'];
	$heslo = $_GET['heslo'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('Not logged in.');
	
	$result = $Sql->q('SELECT penize FROM postavy WHERE login = '.$id);
	
	if(!p($result)) die('Unknown error appeared');
		
	$row = fa($result);
	
	echo $row['penize'];
}

if($action == 'online') {
	$id = $_GET['id'];
	$heslo = $_GET['heslo'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$result = $Sql->q('SELECT login, cas FROM hraci WHERE logged = 1 AND cas > '.(time()-60*15).' ORDER BY login ASC');
	if(!p($result)) die('404');
		
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$sekundy = ((time()-$row['cas'])%60);
		if($sekundy < 10) $sekundy = '0'.$sekundy;
		
		$minuty = floor((time()-$row['cas'])/60);
		if($minuty < 10) $minuty = '0'.$minuty;
		
		$row['cas'] = $minuty.':'.$sekundy;		
		
		$hraci .= (!$i ? '' : ', ').$row['login'].' ('.$row['cas'].')';
	}
	
	echo $hraci;
}*/

?>