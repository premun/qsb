<?php

include 'library.php';
is_logged();
$id = $_GET['id'];
do_header('Závody');
echo '
<h3>Komentář k závodu</h3>
<a href="showRace.php?id='.$id.'#prubeh">&laquo; zpět</a>';
/*$result = $Sql->q('SELECT * from komentare WHERE zavod = '.$id);
if(p($result) == 0 || !$result) {
	$_SESSION['chyba'] == "Komentář k závod s ID ".$id." nebyl nalezen";
	do_footer();
	exit;
}
$cesta = fa($result);*/

$zavod = fa($Sql->q('SELECT nazev FROM zavody WHERE id = '.$id));

@$fp = fopen('./vypisy/komentare/'.$id.'_'.fileName($zavod['nazev']).'.txt','r');
if(!$fp) {
  	echo 'Komentář nebyl nalezen, dej vědět proím některému z adminů<br /><br />';
	drawBack();
	do_footer();  
	exit;
}
$koment = fread($fp,420000);
fclose($fp);

$koment = str_replace('[B]','<strong>',$koment);
$koment = str_replace('[/B]','</strong>',$koment);

echo $koment.'<br /><br />';

drawBack();
do_footer();
?>