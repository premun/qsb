<?php

include 'library.php';

if(jhadr()) {
	$dlg = new cDialog('Tutoriál - '.$_POST['title'], 'alert', 'width: auto, height: auto');
	$dlg->button('Zavřít','close');
	$dlg->body('<img src="images/'.$_POST['file'].'" alt="Tutoriál - '.$_POST['title'].'" />');	
	$dlg->output();
}

do_header('Tutoriál');

define('POCET', 7);

$page = new cPage('tutorial');

$kusy = explode('?', $_SERVER['REQUEST_URI']);

$id = end($kusy);

if(!is_numeric($id)) $id = 1;

$page->misc('STRANA_'.$id, 'OBSAH');
$page->misc('NAZEV_'.$id, 'NADPIS');
$page->misc('BUTTONY'.($id < POCET ? '1' : '2'), 'BUTTONY');

$fill['display_1'] = ($id > 1 ? '' : 'display: none; ');
$fill['display_2'] = ($id < POCET ? '' : 'display: none; ');

$fill['prev'] = ($id-1);
$fill['next'] = ($id+1);

$fill['id'] = $id;
$fill['pocet'] = POCET;

$page->fill($fill);
$page->finish();

do_footer('notip');
?>