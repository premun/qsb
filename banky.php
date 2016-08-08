<?php

include 'library.php';
is_logged();

do_header('Banky');

$page = new cPage('banky');

$page->setCommon('MAIN');

$tempBanka = new banka(1);
$action = $_GET['action'];
  
if($action == "") {
	$result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.UID.' AND banka='.$tempBanka->id.' AND typ="V"');
	
	if(p($result) > 0) {
		$vklad = fa($result);
		$fill['vklady'] = $page->misc('VKLADY1');
		$fill['vklad'] = numF($vklad['vyse']);
		$fill['sazba1'] = $tempBanka->ir2;
	} else {
		$fill['vklady'] = $page->misc('VKLADY2');
	}
	
	$result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.UID.' AND banka='.$tempBanka->id.' AND typ="P"');
	if(p($result) > 0) {
		$vklad = fa($result);
		$fill['pujcky'] = $page->misc('PUJCKY1');
		$fill['pujcka'] = numF($vklad['vyse']);
		$fill['sazba2'] = $tempBanka->ir1;
		$fill['splatnost'] = ($vklad['splatnost'] < 0 ? 0 : $vklad['splatnost']);
	} else {
		$fill['pujcky'] = $page->misc('PUJCKY2');
	}

	$page->ext('NIC',1,0,$fill);
	exit;
}

if($action == "vklady") {
  $result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.UID.' AND banka='.$tempBanka->id.' AND typ="V"');
	if(p($result) != 0) {
		$row = fa($result);
		$fill['vklady'] = $page->misc('VKLADY3');
		$fill['vyse'] = numF($row['vyse']);
	} else {
		$fill['vklady'] = $page->misc('VKLADY2');
	}
	
	$fill['uid'] = UID;
	$fill['banka'] = $tempBanka->id;
	$fill['sazba'] = $tempBanka->ir2;

	$page->ext('VKLADY',1,0,$fill);
	exit;
}

if($action == "pujcky") {
	$result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.UID.' AND banka='.$tempBanka->id.' AND typ="P"');
	if(p($result) != 0) {
		$row = fa($result);
		
		$fill['pujcka'] = $page->misc('PUJCKY3');
		$fill['splatnost'] = ($row['splatnost'] < 0 ? 0 : $row['splatnost']);
		$fill['vyse'] = numF($row['vyse']);
		$fill['vyse2'] = $row['vyse'];
		$fill['sazba'] = numF($row['ir']);
		
	} else {
		
		$fill['pujcka'] = $page->misc('PUJCKY4');
		$fill['movitost'] = numF(getMovitost(UID,$tempBanka->id));
		
	}
	
	$fill['uid'] = UID;
	$fill['banka'] = $tempBanka->id;
	
	$page->ext('PUJCKY',1,0,$fill);
	exit;
}

do_footer();

?>