<?php

include 'library.php';

$sekce = $_POST['sekce'];
if($sekce) $_SESSION['tip_sekce'] = $sekce;
	else   $sekce = $_SESSION['tip_sekce'];

$dlg = new cDialog('Herní tipy', 'alert', 'width: 477px, height: auto');

$page = new cPage('tipy');

$nahodny = fa($Sql->q('SELECT tip FROM tipy ORDER BY rand() LIMIT 1'));

$kusy = explode('-', $sekce);
$prvni = fa($Sql->q('SELECT tip FROM tipy WHERE '.(count($kusy) > 1 ? 'sekce = "'.$kusy[0].'" OR ' : '').'sekce = "'.$sekce.'" ORDER BY rand() LIMIT 0,1'));

if(!$prvni['tip']) $prvni['tip'] = '<span class="error">Pro tuto sekci nebyl nalezen žádný tip</span>';

$page->swap('TIP1',$prvni['tip']);
$page->swap('TIP2',$nahodny['tip']);

$dlg->body($page->finish());

$dlg->button('Zavřít','close');
$dlg->button('Další tip','alert','tip.php');

$dlg->output();
?>