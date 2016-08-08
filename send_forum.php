<?php

include 'library.php';
is_logged();

$msg = $_POST['msg'];
$place = $_GET['place'];

if($msg == '') {
	$_SESSION['chyba'] = 'Nevyplnil jsi všechny požadované údaje';
	go('forum.php?place='.$place);
	exit;
}
$msg = str_replace('<','&lt;',$msg);
$msg = str_replace('>','&gt;',$msg);

if($place == 5 && $_SESSION['status'] != 42) {
	$_SESSION['chyba'] = "Na toto fórum smí psát jen admin";
	go('forum.php?place='.$place);
	exit;
}

if($place == -1 && $_SESSION['status'] < 2) {
	$_SESSION['chyba'] = "Na toto fórum smí psát jen konzulové";
	go('forum.php?place='.$place);
	exit;
}

$result = $Sql->q('INSERT into forum(id,login,msg,cas,place) values(NULL,'.UID.',"'.$msg.'",'.time().',"'.$place.'")');
if(!$result) {
	$_SESSION['chyba'] = 'Při odesílání příspěvku se vykytla chyba';
	go('forum.php?place='.$place);
	exit; 
}

$_SESSION['chyba'] = 'Příspěvek byl úspěšně odeslán';
go(($_POST['action'] == 'staj' ? 'staje.php?action=forum' : 'forum.php?place='.$place));

?>