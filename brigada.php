<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

if($id == '' || !ereg('^[0-9]+$',$id)) {
	go('brigady.php');
	exit;
}

$result = $Sql->q('SELECT * from brigady WHERE id = '.$id);
if(p($result) == 0) {
	go('brigady.php');
	exit;  
}
$row = fa($result);

if($_GET['action'] == "cancel") {
	$result42 = $Sql->q('SELECT * from brigadnici WHERE login = '.UID.' AND brigada = '.$id);
	if(p($result42) > 0) {
		$Sql->q('DELETE from brigadnici WHERE login = '.UID.' AND brigada = '.$id);
		$_SESSION['chyba'] = "Brigáda zrušena";
		go('brigady.php');
		exit; 	  
	} else {
		go('brigady.php');
		exit; 
	}
}


$res4 = $Sql->q('SELECT z.id FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE z.vitez = 0 AND za.login = '.UID);
if(p($res4)) $ok = true;

$result = $Sql->q('SELECT * from brigady WHERE id = '.$id);
$row = fa($result);

if($row['max'] == -1) {
	$volno = "Neomezeně";
} else {
	$res = $Sql->q('SELECT * from brigadnici WHERE brigada = '.$row['id']);
	$volno = $row['max'] - p($res);
}

if($volno == 0 && $volno != "Neomezeně") {
	$_SESSION['chyba'] = "Brigáda je už plně obsazena";
	go('brigady.php');
	exit;
}

$res2 = $Sql->q('SELECT * from brigadnici WHERE login = '.UID);
if(p($res2) > 0) {
	$_SESSION['chyba'] = "Už máš brigádu";
	go('brigady.php');
	exit;
}

if($ok == true) {
	$_SESSION['chyba'] = "Již se účastníš nějakého závodu";
	go('brigady.php');
	exit;
}

if($_GET['action'] == "sure") {
	$Sql->q('INSERT into brigadnici(login,brigada) values('.UID.','.$id.')');
	#$Sql->q('UPDATE postavy set prestiz = prestiz-'.$row['prestiz'].' WHERE login = '.UID);
	$_SESSION['chyba'] = "Brigáda vzata";
	go('brigady.php');
	exit;	
}
$rasa = getRasa(UID);
$penize = $row['penize'];
if($row['rasa'] == $rasa['id']) $penize = $row['penize']*1.20;

$page = new cPage('brigady');

$fill['id'] = $id;
$fill['penize'] = numF($penize);
$fill['nazev'] = $row['nazev'];
$fill['prestiz'] = $row['prestiz2'];

$page->ext('VZIT',true,'Brigáda',$fill);
?>