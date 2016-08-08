<?php

include 'library.php';
is_logged();

do_header('Home');
$list = $_GET['list'];
if($list == '') {
  $list = 0;
}

?>
<h3>Home</h3>
<?php

$row = fa($Sql->q('SELECT status FROM hraci WHERE id = '.UID));

if($row['status'] == -1) {

	$rasa_p = getRasa(UID);
	$rasa = $rasa_p['id'];
	
	echo '
	Protože jsi tu poprvé (nebo proběhl restart), musí se nastavit startovní údaje tvojí postavy.<br /><hr />';
	
	echo 'Načítám potřebné informace z databáze...<br />';
	echo 'Třídím informace...<br />';
	echo 'Generuji údaje o postavě...<br />';
	$Sql->q('UPDATE postavy set penize = 14000, prestiz = 1000, prvni = 0, druhy = 0, treti = 0, zavody = 0 WHERE login = '.UID);
	echo 'Generuji start-money...<br />';
	finance(UID,14000,1,1);
	echo 'Generuji statistiky...<br />';
	echo 'Generuji komponenty...<br />';
	$res2 = $Sql->q('DELETE from sklad WHERE login = '.UID);
	
	echo 'Generuji cenu komponentů...<br />';
	
	$msg = 'Vítej ve hře Quadra Speed Boosters! 
	Hra byla restartována a ocitl jsi se v ostré sezóně. Cíl sezóny je vyhrát QSB Cup, což je pohár, kterého se může účastnit úplně každý, kdo je členem některé ze stájí. Zkus si tedy najít své místo nebo si založ stáj vlastní!
	
	[B][R]POZOR![/R][/B] ve hře došlo k jedné změně a to k úpravě výher ze závodu. Výhru obdržíte úplně stejně, jako doteď [B][M]PLUS[/M][/B] až 80% výhry navrch (v závislosti na obchodnickém skillu vaší rasy). Také došlo ke změnám statistik některých ras.
	
	Pokud jsi nováček a teprve začínáš, vše užitečné je na http://help.qsb.cz/ nebo na http://world.qsb.cz/ , kde najdeš tipy a rady, jak začínat s hraním.
	
	Přeji ti hodně štěstí do hry, zábavy a ať to dotáhneš v žebříčku na přední příčky, povedeš nejprestižnější stáj nebo vyděláš desetitisíce na palivech a sázkách!
	
	SYSTEM';
	
	/*$msg = 'Vítej ve hře Quadra Speed Boosters! 
	Hra byla restartována a ocitl jsi se v mezisezóně, která vyplňuje čas mezi dvěma sezónami. Po svátcích (v lednu) proběhne další restart a započne ostrá sezóna.
	
    Cíl sezóny je vyhrát QSB Cup, což je pohár, kterého se může účastnit úplně každý, kdo je členem některé ze stájí. 
	Výherce QSB Cupu navíc vyhraje hodnotnou cenu ve formě počítačové hry. Zkus si tedy najít své místo ve stáji nebo si založ stáj vlastní!
	
	Pokud si do ostré sezóny přeješ změnit svou rasu nebo kluzák, navštiv sekci [B]Nastavení[/B].
	
	Pokud jsi nováček a teprve začínáš, vše užitečné je v <a href="http://help.qsb.cz/" target="_blank">[O][B]Helpu[/B][/O]</a> nebo na <a href="http://world.qsb.cz/" target="_blank">[O][B]QSB Worldu[/B][/O]</a>, kde najdeš tipy a rady, jak začínat s hraním.
	
	Přeji ti hodně štěstí do hry, zábavy a ať to dotáhneš v žebříčku na přední příčky, povedeš nejprestižnější stáj nebo vyděláš desetitisíce na palivech a sázkách!
	
	SYSTEM';*/
	
	sendPosta(0,UID,addslashes($msg));	
	
	echo 'Generuji kluzák...<br />';
	
	$tabs2[1] = "podvozky";
	$tabs2[2] = "motory";
	$tabs2[3] = "drzaky";
	$tabs2[4] = "chladice";
	$tabs2[5] = "desky";
	$tabs2[6] = "brzdy";
	$tabs2[7] = "zdroje";
		
	$tabs[1] = "podvozek";
	$tabs[2] = "motor";
	$tabs[3] = "drzaky";
	$tabs[4] = "chladic";
	$tabs[5] = "deska";
	$tabs[6] = "brzdy";
	$tabs[7] = "zdroj";
	
	$sport['podvozek'] = 1;
	$sport['motor'] = 16;
	$sport['drzaky'] = 1;
	$sport['chladic'] = 2;
	$sport['deska'] = 11;
	$sport['brzdy'] = 1;
	$sport['zdroj'] = 1;
	
	$combi['podvozek'] = 11;
	$combi['motor'] = 31;
	$combi['drzaky'] = 1;
	$combi['chladic'] = 1;
	$combi['deska'] = 6;
	$combi['brzdy'] = 1;
	$combi['zdroj'] = 1;
	
	$wrecker['podvozek'] = 21;
	$wrecker['motor'] = 1;
	$wrecker['drzaky'] = 1;
	$wrecker['chladic'] = 1;
	$wrecker['deska'] = 1;
	$wrecker['brzdy'] = 1;
	$wrecker['zdroj'] = 1;
	
	$res = $Sql->q('SELECT rasa,kluzak FROM new_rasy WHERE login = '.UID);
	if(p($res)) {
		$new = fa($res);
	} else {
		$row1 = fa($Sql->q('SELECT rasa FROM postavy WHERE login = '.UID));
		$row2 = fa($Sql->q('SELECT kluzak FROM rasy WHERE id = '.$row1['rasa']));
		$new['rasa'] = $row1['rasa'];
		$new['kluzak'] = $row2['kluzak'];
	}
	
	if($new['rasa']) $Sql->q('UPDATE postavy set rasa = '.$new['rasa'].' WHERE login = '.UID);
	
	if($new['kluzak'] != 5) {	# KDYZ NEBERE PENIZE (je moznost ze bere to same jako rasa a ta penize ma)
		
		if($new['kluzak'] == 4) {	# KDYZ SE PRIZPUSOBUJE RASE
			$new = fa($Sql->q('SELECT id as rasa, kluzak FROM rasy WHERE id = '.$new['rasa']));
		}
		
		if($new['kluzak'] == 0) {	# KDYZ RASA MA PENIZE
			$Sql->q('UPDATE postavy set penize = penize+15000 WHERE login = '.UID);
			finance(UID,15000,1,1);
		} else {
		
			$pod[1] = "sport";
			$pod[2] = "combi";
			$pod[3] = "wrecker";
			
			$kluzak = $pod[$new['kluzak']];
			
			echo 'Skládám kluzák...<br />';
			if(!$kluzak) $kluzak = 'combi';
			foreach($tabs as $ind=>$val) {
                if($ind > 7) break;
				$predmet = fa($Sql->q('SELECT vydrz FROM '.$tabs2[$ind].' WHERE id = '.${$kluzak}[$val]));
				$Sql->q('INSERT into sklad(login,zbozi,typ,umisteni,cena,vydrz) values('.UID.','.${$kluzak}[$val].','.$ind.',1,2000,'.$predmet['vydrz'].')');
			}
		}
	} else {
		$Sql->q('UPDATE postavy set penize = penize+15000 WHERE login = '.UID);
		finance(UID,15000,1,1);
	}
	
	$rasa = @fa($Sql->q('SELECT r.nazev as nazev FROM postavy as p LEFT JOIN rasy as r ON r.id = p.rasa WHERE p.login = '.UID));
	if(isset($rasa['nazev'])) $_SESSION['rasa_nazev'] = $rasa['nazev'];
	
	echo 'Závěrečná kontrola dat...<br />';
	$Sql->q('UPDATE hraci set status = '.(UID < 3 ? 42 : (in_array(UID, array(832,969,6,1706,864)) ? 2 : 1)).', start = '.time().' WHERE id = '.UID);
	
	echo '<hr />';
	if($_SESSION['chyba'] == '') {
		echo 'Všechny operace proběhly úspěšně, pokračuj prosím <a href="posta.php?action=new">zde</a>.';
	} else {
		echo 'Při operaci došlo k chybě:<br />
		<span style="color: red">'.$_SESSION['chyba'].'</span><br />
		Omlouváme se, ale kontaktuj prosím admina (nejlépe mu pošli červenou chybu, kterou generování vyhodilo)';
	}
	do_footer();
	konec();
}
$prepocet = fa($Sql->q('SELECT * FROM sys WHERE val = -42'));
$cas = date('H');
$cas2 = date('i');

##################################################################################################################################
##################################################################################################################################
##################################################################################################################################

$page = new cPage('home');

$c = date("G");

$c13 = "13:00";
$c16 = "16:00";
$c19 = "19:00";
$c23 = "23:00";

if($c > 12) $c13 = "<span class='ultra'>13:00</span>";
if($c > 15) $c16 = "<span class='ultra'>16:00</span>";
if($c > 18) $c19 = "<span class='ultra'>19:00</span>";
if($c > 22) $c23 = "<span class='ultra'>23:00</span>";

$sys = fa($Sql->q('SELECT val FROM sys WHERE entity = "restart"'));
$last = $sys['val'];

$restart = date('j.n.',time()-60*60*24*$list);

$start = '';
if((strtotime(date('Y-m-d',time()-60*60*24*$list))-$last) < 0) $start = 'Tento den začala sezóna';

#------------ SIPECKY!---------------#
if($list == 1) {
  $dil1 = '<a href="home.php?list='.($list-1).'">&lt; '.date('j.n.',time()-60*60*24*($list-1)).'</a>';
}
elseif($list > 1) {
  $dil1 = '<a href="home.php?list='.($list-1).'">&lt; '.date('j.n.',time()-60*60*24*($list-1)).'</a>';
}
if((strtotime(date('Y-m-d',time()-60*60*24*$list))-$last) > 0) $dil2 = '<a href="home.php?list='.($list+1).'">'.date('j.n.',time()-60*60*24*($list+1)).' &gt;</a>';
$sipky = '<span class="center">'.$dil1.' <strong>|</strong> '.$dil2.'</span>';
#------------ SIPECKY!---------------#

// stats zavodu
$result = $Sql->q('SELECT z.id as id, z.cas as cas, z.nazev as nazev, z2.vyhra as vyhra, z2.poradi as poradi FROM zavody as z LEFT JOIN zavodnici as z2 ON z2.zavod = z.id WHERE z.datum = "'.date('Y-m-d',time()-60*60*24*$list).'" AND z2.login = '.UID.' AND z.vitez = 1 ORDER BY z.cas DESC');

$casy[0] = '23:00';
$casy[13] = '13:00';
$casy[16] = '16:00';
$casy[19] = '19:00';

if(p($result) != 0) {
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		if($row['poradi'] == 0) $row['poradi'] = 'nedojel';
		$row['vyhra'] = numF($row['vyhra']);
		$row['cas'] = $casy[$row["cas"]];
		$zavody[] = $row;
	}
	$zavody = $page->getTable('ZAVODY',$zavody);
} else $zavody = 'Tento den jsi neodjel žádný závod<br />'; 

// stats sazek
$result = $Sql->q('SELECT s.id as id, z.id as zid, z.cas as cas, z.nazev as nazev, s.sazka as sazka, s.vyhra as vyhra, s.penize as penize FROM zavody as z LEFT JOIN sazky as s ON s.zavod = z.id WHERE z.datum="'.date('Y-m-d',time()-60*60*24*$list).'" AND s.login = '.UID.' AND z.vitez = 1 ORDER BY z.cas DESC');

if (p($result)<>0) {
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);		
		$row['sazka'] = str_replace(' ','&nbsp;',numF($row['sazka']));
		$row['vyhra'] = str_replace(' ','&nbsp;',numF($row['penize']));
		$row['cas'] = $casy[$row["cas"]];
		$sazky[] = $row;
	}
	$sazky = $page->getTable('SAZKY',$sazky);
} else {
	$sazky = 'Tento den jsi si nevsadil na žádný závod<br />';
}

$time1 = mktime(0,0,0,date('n',time()-60*60*24*$list),date('d',time()-60*60*24*$list),date('Y',time()-60*60*24*$list));
$time2 = $time1+60*60*24;

$hrac = fa($Sql->q('SELECT start FROM hraci WHERE id = '.UID));

if($hrac['start'] > $time1) $time1 = $hrac['start'];

$result = $Sql->q('SELECT f.*, t.nazev as nazev FROM finance as f LEFT JOIN finance_typy as t ON t.id = f.typ WHERE f.cas > '.($time1-10).' AND f.cas < '.$time2.' AND (f.login = 0 OR f.login = '.UID.') ORDER BY cas DESC');

if (p($result)<>0) {
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		
		$line['cas'] = date('H:i',$row['cas']);
		$line['penize'] = str_replace(' ','&nbsp;',numF($row['penize']));
		$line['barva'] = ($row['zmena'] ? '#02FD09' : '#CC0000');
		$line['akce'] = $row['nazev'];	
		
		$finance[] = $line;	
	}
	$finance = $page->getTable('FINANCE',$finance);
} else $finance = 'Tento den nejsou zaznamenány žádné peněžní manipulace<br />';

# prehled sezony

for($i=0;$i<30;$i++) {
	$line['datum'] = date('j.n.', $last+$i*60*60*24);
	$line['box'] = '<strong>&nbsp;'.$line['datum'].' - <span>';
	
	switch($i) {
		case 0:
			$line['class'] = 'dulezity';
			$line['box'] .= 'První den sezóny</span></strong>';
			break;
			
		case $etapy[2]:
			$line['class'] = 'etapa';
			$line['box'] .= 'Etapa II</span></strong><br />Na trhu se objeví nové předměty<br /><br />Pohár odstartován k přihlašování jezdců<br /><br />Lze zakládat závody';
			break;
			
		case 8:
			$line['class'] = 'pohar';
			$line['box'] .= 'QSB Cup</span></strong><br />Odstartování QSB poháru. Tento den se jede první závod';
			break;
			
		case $etapy[3]:
			$line['class'] = 'etapa';
			$line['box'] .= 'Etapa III</span></strong><br />Na trhu se objeví další předměty';
			break;
			
		case $etapy[4]:
			$line['class'] = 'etapa';
			$line['box'] .= 'Etapa IV</span></strong><br />Na trhu se objeví další předměty';
			break;
			
		case $etapy[5]:
			$line['class'] = 'etapa';
			$line['box'] .= 'Etapa V</span></strong><br />Na trhu se objeví poslední skryté předměty';
			break;
			
		case 20:
			$line['class'] = 'davky';
			$line['box'] .= 'Sociální dávky</span></strong><br />Sociální dávky se zvednou na 5 000 Is';
			break;
			
		case 25:
			$line['class'] = 'pohar';
			$line['box'] .= 'QSB Cup</span></strong><br />Závody QSB poháru jsou nyní obden';
			break;
			
		case 28:
			$line['class'] = 'pohar';
			$line['box'] .= 'QSB Cup</span></strong><br />Poslední závod QSB poháru';
			break;
			
		case 31:
			$line['class'] = 'dulezity';
			$line['box'] .= 'Poslední den sezóny</span></strong>';
			break;
			
		default:
			$line['class'] = 'normal';
			$line['box'] .= ($line['datum'] == date('j.n.') ? 'Dnešní den' : 'Žádná akce').'</span></strong><br />';
			break;
			
	}
	
	if($line['datum'] == date('j.n.')) $line['class'] = 'dnes';
	
	$data[] = $line;
}

$page->getTable('SEZONA', $data, 'SEZONA');

####


$fill['finance'] = $finance;
$fill['sazky'] = $sazky;
$fill['odjete'] = $zavody;
$fill['c13'] = $c13;
$fill['c16'] = $c16;
$fill['c19'] = $c19;
$fill['c23'] = $c23;
$fill['sipky'] = $sipky;
$fill['restart'] = $restart;
$fill['start'] = $start;
$fill['prepocet'] = $prepocet['entity'];

$page->fill($fill);

$page->finish();

do_footer();
?>