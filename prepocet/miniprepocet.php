<?php

include 'library.php';

$casp = date('H');

switch($casp) {
	case '11': 
		$casp = 13;
		break;
	case '12': 
		$casp = 13;
		break;
	case '13': 
		$casp = 13;
		break;
	case '14': 
		$casp = 13;
		break;
		############
	case '15': 
		$casp = 16;
		break;
	case '16': 
		$casp = 16;
		break;
	case '17': 
		$casp = 16;
		break;
		############
	case '18': 
		$casp = 19;
		break;
	case '19': 
		$casp = 19;
		break;
	case '20': 
		$casp = 19;
		break;
}
if($_GET['cas'] != '') $casp = $_GET['cas'];

$prepocet = new cPrepocet($casp,false,true,false,false);

$prepocet->run();
echo date('H:i d.m.',time()).' - '.$_SESSION['sql']."\n";
/*echo '<pre>';
print_r($prepocet);
echo '</pre>';*/
?>