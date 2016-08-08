<?php

include 'library.php';
is_logged();

$id = $_GET['id'];
$anketa = $_POST['anketa'];
if($id == '' || !ereg('^[0-9]+$',$id)) {
  $_SESSION['chyba'] = "ID není číslo";
  go('anketa.php');
  exit;
}

if($anketa == '' || !ereg('^[0-9]+$',$anketa)) {
  $_SESSION['chyba'] = "Nemáš nic vybráno";
  go('anketa.php');
  exit;
}

$result = $Sql->q('SELECT * from ankety WHERE id = '.$id);

if(p($result) == 0) {
  $_SESSION['chyba'] = "Taková anketa neexistuje";
  go('anketa.php');
  exit;
}

if(p($Sql->q('SELECT * from hlasovani WHERE login = '.UID.' AND anketa = '.$id)) > 0) {
  $_SESSION['chyba'] = "Zde už jsi hlasoval";
  go('anketa.php');
  exit;
}

if($id == '' || !ereg('^[0-9]+$',$id)) {
  $_SESSION['chyba'] = "ID není číslo";
  go('anketa.php');
  exit;
}

$Sql->q('INSERT into hlasovani(login,anketa,odpoved) values('.UID.','.$id.','.$anketa.')');
$Sql->q('UPDATE postavy set prestiz = prestiz+'.HLASOVANI.' WHERE login = '.UID);

if(p($Sql->q('SELECT login FROM hlasovani WHERE login = '.UID)) > 10) {
	addQuest(UID,74,0);
}

$_SESSION['chyba'] = "Hlasováno";
go('anketa.php');
exit;
?>