<?php

include 'library.php';
is_logged();

$page = new cPage('staje');

$dlg = new cDialog('Zakládání stáje','alert','width: 250px');

$nazev = $_POST['nazev'];
$popis = $_POST['popis'];
$zkratka = $_POST['zkratka'];
$b1 = '#'.$_POST['barva1'];
$b2 = '#'.$_POST['barva2'];
$b3 = '#'.$_POST['barva3'];

if(p($Sql->q('SELECT * from stajovnici WHERE login = '.UID)) > 0) {
	if(!jhadr()) $_SESSION['chyba'] = 'Už jsi v nějaké stáji';
	$dlg->obody('Už jsi v nějaké stáji');
	go('staje.php');
	konec();
}

if(p($Sql->q('SELECT * from staje WHERE nazev = "'.$nazev.'" OR zkratka = "'.$zkratka.'"')) > 0) {
	if(!jhadr()) $_SESSION['chyba'] = 'Takováto zkratka nebo název trati již existuje';
	$dlg->obody('Takováto zkratka nebo název trati již existuje');
	go('staje.php');
	konec();
}

if(getPenize(UID) < CENA_STAJE) {
	if(!jhadr()) $_SESSION['chyba'] = 'Nemáš dostatek peněz na založení stáje ('.numF(CENA_STAJE).' Is)';
	$dlg->obody('Nemáš dostatek peněz na založení stáje ('.numF(CENA_STAJE).' Is)');
	go('staje.php');
	konec();
}

if($nazev == "" || $zkratka == "") {
	if(!jhadr()) $_SESSION['chyba'] = 'Nevyplnil jsi všechny požadované údaje (název stáje, zkratka)';
	$dlg->obody('Nevyplnil jsi všechny požadované údaje (název stáje, zkratka)');
	go('staje.php');
	konec();
}

$reg = '^(#)([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$';

if(!eregi($reg,$b1) || !eregi($reg,$b2) || !eregi($reg,$b3)) {
	if(!jhadr()) $_SESSION['chyba'] = 'Zadaná vlastní barva nemá formát hexadecimálního kódu RGB';
	$dlg->obody('Zadaná vlastní barva nemá formát hexadecimálního kódu RGB');
	go('staje.php');
	konec();
}

$vlajka = $b1.",".$b2.",".$b3;
$prestiz = (getPrestiz(UID)+1000)/2;

if($_GET['action'] == "sure") {
	$Sql->q('INSERT into staje(login,nazev,zkratka,popis,vlajka,kasa,pozemek,prestiz) values('.UID.',"'.$nazev.'","'.$zkratka.'","'.$popis.'","'.$vlajka.'",'.STAJ_KASA.',5,'.round($prestiz).')');
	$Sql->q('UPDATE postavy set penize = penize-'.CENA_STAJE.', prestiz = prestiz+'.STAJ_PRESTIZ.' WHERE login = '.UID);
	finance(UID,CENA_STAJE,0,25);
	$staj = fa($Sql->q('SELECT id from staje WHERE login = '.UID.' AND nazev = "'.$nazev.'"'));
	$Sql->q('INSERT into stajovnici(login,staj,stav) values('.UID.','.$staj['id'].',1)');
	$Sql->q('INSERT into budovy(budova,staj,staveni) values(1,'.$staj['id'].',0)');
	$Sql->q('INSERT into budovy(budova,staj,staveni) values(2,'.$staj['id'].',1)');
	$Sql->q('INSERT into nastenka(login,sekce) values('.$staj['id'].',2)');

	$Sql->q('UPDATE stats set staje = staje+1 WHERE login = '.UID);	
	if(p($Sql->q('SELECT id FROM staje')) == 1) addQuest(UID,46,0);
	
	$_SESSION['chyba'] = 'Stáj byla úspěšně založena';
	go('staje.php');
	konec();
}

if(!$dlg->is_empty()) {
	$dlg->button('OK','close');
} else {
	$dlg->set('width', '400px');
	$dlg->button('Změnit údaje','close');
	$dlg->button('Založit','submit','form_staj');

	$fill['vlajka'] = drawFlag($b1,$b2,$b3);
	$fill['nazev'] = $nazev;
	$fill['zkratka'] = $zkratka;
	$fill['popis'] = $popis;
	
	$dlg->obody($page->ext('ZALOZIT',0,0,$fill));
	konec();
}

	$dlg->output();
?>