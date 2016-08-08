<?php
include 'library.php';

$action = $_GET['action'];

if($action == 'login') {
	$login = $_GET['login'];
	$heslo = $_GET['heslo'];
	
	$result = $Sql->q('SELECT id, status FROM hraci WHERE login = "'.$login.'" AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$row = fa($result);
	
	die($row['id'].','.$row['status']);
}

if($action == 'posta') {
	$id = $_GET['id'];
	$heslo = $_GET['heslo'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$result = $Sql->q('SELECT * FROM posta WHERE (status = 0 OR status = 4) AND komu = '.$id);	
	
	if(!p($result)) die('0');
	
	$banned = 'B,O,S,G,R,M,I';
	
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		foreach(explode(',', $banned) as $char) {
			$row['msg'] = str_replace('['.$char.']','',$row['msg']);
			$row['msg'] = str_replace('[/'.$char.']','',$row['msg']);
		}
		
		for($j=1;$j<15;$j++) $row['msg'] = str_replace('[SM'.$j.']', $ascii_smiles[$j][0], $row['msg']);
		
		$posta[] = array('login' => getNick($row['kdo']), 'cas' => $row['cas'], 'msg' => $row['msg']);
	}
	
	$Sql->q('UPDATE posta set status = 1 WHERE status = 0 AND komu = '.$id);	
	$Sql->q('UPDATE posta set status = 3 WHERE status = 4 AND komu = '.$id);	
	
	echo serialize($posta);
}

if($action == 'forum') {
	$id = $_GET['id'];
	$heslo = $_GET['heslo'];
	$limit = $_GET['limit'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$result = $Sql->q('SELECT h.login as login, f.place as place, f.cas as cas, f.msg as msg FROM forum as f LEFT JOIN hraci as h ON h.id = f.login WHERE f.place NOT LIKE "%s%" ORDER BY f.id DESC LIMIT '.$limit.',1');
	
	if(!p($result)) die('0');
	
	$banned = 'B,O,S,G,R,M,I';
	
	$row = fa($result);
	
	foreach(explode(',', $banned) as $char) {
		$row['msg'] = str_replace('['.$char.']','',$row['msg']);
		$row['msg'] = str_replace('[/'.$char.']','',$row['msg']);
	}
	
	for($j=1;$j<15;$j++) $row['msg'] = str_replace('[SM'.$j.']', $ascii_smiles[$j][0], $row['msg']);
	
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

if($action == 'update') {
	$cas = $_GET['time'];
	$sum = $_GET['sum'];
	$ids = $_GET['ids'];
	$users = $_GET['users'];
	
	if(md5($salt.$cas) != $sum) exit;
	
	$fp = fopen('vypisy/irc.txt','w');
	fwrite($fp, $users);
	fclose($fp);
	
	if($ids != "") {   
		foreach($ids as $i => $d)
			if($d == "")
				unset($ids[$i]);
				
		if(count($ids)) {	
			$result = $Sql->q('SELECT komu FROM posta WHERE (status = 0 OR status = 4) AND komu IN('.$ids.')');
			
			if(p($result)) {
				for($i=0;$i<p($result);$i++) {
					$row = fa($result);
					if($i) if(in_array($row['komu'],$hraci)) continue;
					$posta .= (!$i ? '' : ',').$row['komu'];
					$hraci[] = $row['komu'];
				}
			}
		}
	}
	
	$result = $Sql->q('SELECT h.login as nick, f.place as place, f.cas as cas FROM forum as f LEFT JOIN hraci as h ON h.id = f.login WHERE f.place NOT LIKE "%s%" AND f.cas > '.$cas.' LIMIT 0,20');
	
	$forum = array();
	if(p($result)) {
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			$forum[] = $row['nick'].','.$row['cas'].','.$row['place'];
		}
	}
	
	$data[0] = $posta;
	$data[1] = $forum;
	
	echo serialize($data);
}

if($action == 'send') {
	$id = $_GET['id'];
	$heslo = $_GET['heslo'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE id = '.$id.' AND irc_heslo = "'.$heslo.'" LIMIT 0,1');
	
	if(!p($result)) die('403');
	
	$login = $_GET['login'];
	$msg = $_GET['msg'];
	
	$result = $Sql->q('SELECT id FROM hraci WHERE login = "'.$login.'" LIMIT 0,1');
	if(!p($result)) die('404');
	
	$row = fa($result);
	
	sendPosta($id,$row['id'],$msg);
	echo 'Uspesne odeslano';
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
}

?>