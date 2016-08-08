<?php

def("CLIENT", 0.2);
def("LOG_FILE", 'vypisy/error_log.txt');

$Sql = new cSql('localhost','root','qsb','enter MySQL credentials here');

$err = new cErr(false,true);

$default_menu = '1,0,2,3,4,5,6,0,10,11,16,17,18,0,19,25,30,0,34,35,36,37,0,38';

$salt = 'this is a salt used for user password hashing';

$menu[0]['nazev'] = '---------';
$menu[0]['url'] = '';

$menu[1]['nazev'] = 'Home';
$menu[1]['url'] = 'home.php';

$menu[2]['nazev'] = 'Depo';
$menu[2]['url'] = 'depo.php';

$menu[3]['nazev'] = 'Závody';
$menu[3]['url'] = 'zavody.php?action=neodjete&empty=on&kat=on';

$menu[4]['nazev'] = 'Sázky';
$menu[4]['url'] = 'sazky.php?minimum=on';

$menu[5]['nazev'] = 'Pohár';
$menu[5]['url'] = 'pohar.php';

$menu[6]['nazev'] = 'Stáj';
$menu[6]['url'] = 'staje.php';

$menu[7]['nazev'] = 'Stájové sklady';
$menu[7]['url'] = 'staje.php?action=sklady';

$menu[8]['nazev'] = 'Stájové budovy';
$menu[8]['url'] = 'staje.php?action=budovy';

$menu[9]['nazev'] = 'Stájové finance';
$menu[9]['url'] = 'staje.php?action=finance';

$menu[10]['nazev'] = 'Obchod';
$menu[10]['url'] = 'obchod.php?action=sklad';

$menu[11]['nazev'] = 'Paliva';
$menu[11]['url'] = 'obchod.php?action=paliva';

$menu[12]['nazev'] = 'Nákup částí';
$menu[12]['url'] = 'obchod.php?action=casti';

$menu[13]['nazev'] = 'Výloha';
$menu[13]['url'] = 'obchod.php?action=vyloha';

$menu[14]['nazev'] = 'Přehled předmětů';
$menu[14]['url'] = 'items.php';

$menu[15]['nazev'] = 'Finance';
$menu[15]['url'] = 'prehledy.php?action=finance';

$menu[16]['nazev'] = 'Banky';
$menu[16]['url'] = 'banky.php';

$menu[17]['nazev'] = 'Brigády';
$menu[17]['url'] = 'brigady.php';

$menu[18]['nazev'] = 'Tratě';
$menu[18]['url'] = 'trate.php?action=all';

$menu[19]['nazev'] = 'Přehledy';
$menu[19]['url'] = 'prehledy.php?action=hraci';

$menu[20]['nazev'] = 'Online hráči';
$menu[20]['url'] = 'prehledy.php?action=online';

$menu[21]['nazev'] = 'Žebříček jezdců';
$menu[21]['url'] = 'prehledy.php?action=ladder';

$menu[22]['nazev'] = 'Přehled stájí';
$menu[22]['url'] = 'prehledy.php?action=staje';

$menu[23]['nazev'] = 'Questy';
$menu[23]['url'] = 'prehledy.php?action=questy&typ=all';

$menu[24]['nazev'] = 'Hall of Fame';
$menu[24]['url'] = 'prehledy.php?action=stats';

$menu[25]['nazev'] = 'Pošta';
$menu[25]['url'] = 'posta.php';

$menu[26]['nazev'] = 'Přijatá pošta';
$menu[26]['url'] = 'posta.php?action=prijata';

$menu[27]['nazev'] = 'Odeslaná pošta';
$menu[27]['url'] = 'posta.php?action=odeslana';

$menu[28]['nazev'] = 'Systémové fórum';
$menu[28]['url'] = 'forum.php?place=1';

$menu[29]['nazev'] = 'Chybové fórum';
$menu[29]['url'] = 'forum.php?place=2';

$menu[30]['nazev'] = 'Fórum';
$menu[30]['url'] = 'forum.php?place=3';

$menu[31]['nazev'] = 'Oznámení hráčům';
$menu[31]['url'] = 'forum.php?place=5';

$menu[32]['nazev'] = 'Burza';
$menu[32]['url'] = 'forum.php?place=4';

$menu[33]['nazev'] = 'Ohlašovací fórum';
$menu[33]['url'] = 'forum.php?place=6';

$menu[34]['nazev'] = 'Ankety';
$menu[34]['url'] = 'anketa.php';

$menu[35]['nazev'] = 'Nastavení';
$menu[35]['url'] = 'nastaveni.php';

$menu[36]['nazev'] = 'World';
$menu[36]['url'] = 'http://world.qsb.cz';

$menu[37]['nazev'] = 'Help';
$menu[37]['url'] = 'http://help.qsb.cz';

$menu[38]['nazev'] = 'Odhlásit';
$menu[38]['url'] = 'odhlas.php';

$menu[39]['nazev'] = 'Adminz';
$menu[39]['url'] = 'adminz.php';

$menu[40]['nazev'] = 'Statistiky';
$menu[40]['url'] = 'stats.php';

$menu[41]['nazev'] = 'Opraváři';
$menu[41]['url'] = 'obchod.php?action=opravari';

$menu[42]['nazev'] = 'Šablony';
$menu[42]['url'] = 'obchod.php?action=sablony';

$menu[43]['nazev'] = 'Konzulové';
$menu[43]['url'] = 'konzulove.php';

def("TRAT_ZAKLAD",10000);
def("TRAT_USEK",250);
def("TRAT_DELKA",4200); # km/usek -> stredni
def("TRAT_PRESTIZ",40); # NOVA TRAT -> +PRESTIZ
def("POUZITI_TRATE",500); # hrac dostane tolik, za zavod na jeho trati
def("TRAT_USEKY_MIN",10); # OMEZENI DELKY TRATE
def("TRAT_USEKY_MAX",15000);
# CENA TRATI == POCET_USEKU*TRAT_USEK+TRAT_ZAKLAD

def("DOTACE_MIN",10000);
def("DOTACE_MAX",250000);
def("ZAVOD_ZAKLADANI",1100);
def("ZAVOD_VSTUPNY",2);
def("ZAVOD_ZALOZENI_PRESTIZ",20);
def("ODSTUP_PRESTIZ",15);
def("MAX_DOTACE_HRAC",35000);
# CENA ZAVODU = DOTACE+ZAVOD_ZAKLADANI

def("SROT",15);
# ZAKLADNI PROCENTA U CENY SROTU

def("CENA_STAJE",30000); # CENA ZALOZENI STAJE
def("STAJ_KASA",15000); # KOLIK ZUSTANE NAZACATEK V KASE
def("STAJ_VSTUP",8000); # KOLIK STOJI VSTUP DO STAJE HRACE
def("STAJ_VSTUP_ZPET",6000); # Z TOHO JDE DO STAJOVE KASY JEN TOLIK
def("ZMENA_VLAJKY",4200); # CENA ZMENY VLAJKY
def("PARCELA",6400); # ZAKLADNI CENA PARCELY
def("NEW_PARCELA",800); # KAZDA DALSI PARCELA STOJI TOLIK NAVIC
def("STAJ_PRESTIZ",120); # ZALOZENI STAJE -> + STAJ_PRESTIZ prestize
def("MAX_BUDOV",25);
define('PRIRAZKA', 0.95); # BONUS % SLEVY PRI KOUPI PALIV DO STAJE

def("POSLANI_PREDMETU",350); # POSLANI PREDMETU NEKOMU ZE STAJE

def("MIN_VYLOHA_CENA",0.8); # MINIMALNI NASTAVITELNA CENA VE VYLOZE (PROCENTA)
def("MAX_VYLOHA_CENA",1.5); # MINIMALNI NASTAVITELNA CENA VE VYLOZE (PROCENTA)

def("ZBOURANI",300); # CENA ZBOURANI BUDOVY
def("SKLAD_VELKY",500); # KAPACITA VELKEHO SKLADU
def("SKLAD_MALY",200); # KAPACITA MALEHO SKLADU

def("HLASOVANI",5); # ANKETA -> +PENIZE
def("QUEST_ODMENA",2000); # ANKETA -> +PENIZE

def("SAZKA_VYHRA",8);

def("POHAR_NAZEV","QSB Cup");
def("POHAR_MAX_JEZDCU",2);

def("KLUZAK_MAX_VAHA",500);
def("KLUZAK_MAX_ZRYCH",100);

def("OPRAVAR_REGISTRACE",1000);
def("OPRAVAR_ZMENA",500);
def("OPRAVAR_DENNE",100);

function def($nazev,$val) {
  define($nazev,$val);
}

//$pohar_trate = Array(20,87,68,268,132,192,69,174,24,162,223,225,106,175,179);

$pohar_trate = array(79,31,244,285,119,166,91,46,81,258,299,214,174,24,162,223,225,106,175,179);

$ceny_kluzaky = array();
$ceny_kluzaky[0] = 0;
$ceny_kluzaky[1] = 25000;
$ceny_kluzaky[2] = 45000;
$ceny_kluzaky[3] = 75000;
$ceny_kluzaky[4] = 130000;
$ceny_kluzaky[5] = 250000;

$ceny_barvy[0] = '#FF6600';
$ceny_barvy[1] = '#FFFFFF';
$ceny_barvy[2] = '#7C7C7C';
$ceny_barvy[3] = '#82D7FF';
$ceny_barvy[4] = '#2254FF';
$ceny_barvy[5] = '#FFCC00';
$ceny_barvy[6] = '#FF6600';

$sklady_paliv[300] = 0;
$sklady_paliv[500] = 8000;
$sklady_paliv[1000] = 11000;
$sklady_paliv[1500] = 16000;
$sklady_paliv[2000] = 20000;

$etapy[1] = 0;
$etapy[2] = 3;
$etapy[3] = 7;
$etapy[4] = 11;
$etapy[5] = 16;

$tabs[1] = "podvozky";
$tabs[2] = "motory";
$tabs[3] = "drzaky";
$tabs[4] = "chladice";
$tabs[5] = "desky";
$tabs[6] = "brzdy";
$tabs[7] = "zdroje";
$tabs[8] = "pancerovani";
$tabs[9] = "suspenzory";
$tabs[10] = "p_motory";
$tabs[11] = "droidi";

$tabs2 = $tabs;

$jizdni_styly = array(1 =>  // defenzivni
							array(1 => array('id' => 1,
											 'nazev' => 'Unikání',
											 'nazev2' => 'Ghan\'khar',
											 'vztahy' => array(1 => 2, # proti Silnymu uderu
															   2 => 1, # proti Vytlacovani
															   3 => 0)),
								  2 => array('id' => 2,
											 'nazev' => 'Pirueta',
											 'nazev2' => 'Avi-pah',
											 'vztahy' => array(1 => 0,
															   2 => 2,
															   3 => 1)),
								  3 => array('id' => 3,
											 'nazev' => 'Kličkování',
											 'nazev2' => 'Whirlee',
											 'vztahy' => array(1 => 1,
															   2 => 0,
															   3 => 2))),
					 3 =>	// ofenzivni
							array(1 => array('id' => 1,
											 'nazev' => 'Silný úder',
											 'nazev2' => 'Tad\'hor',
											 'vztahy' => array(1 => 1,
															   2 => 2,
															   3 => 0)),
								  2 => array('id' => 2,
											 'nazev' => 'Vrážení',
											 'nazev2' => 'Yel hata',
											 'vztahy' => array(1 => 0,
															   2 => 1,
															   3 => 2)),
								  3 => array('id' => 3,
											 'nazev' => 'Vytlačování',
											 'nazev2' => 'Wakamo-su',
											 'vztahy' => array(1 => 2,
															   2 => 0,
															   3 => 1))));
$taktiky = array(1 =>  // defenzivni
						array(1 => 'Čekat útok zezadu',
							  2 => 'Čekat útok zepředu',
							  3 => 'Nespecifikováno'),
				 3 => // ofenzivni
						array(1 => 'Atakovat pozici',
							  2 => 'Bránit pozici',
							  3 => 'Napadat nejbližší'));

$ascii_smiles = array(1 => array(':D', ':-D', ';D', ':))'),
					  2 => array('X-|', 'X|', 'x|', 'x-|'),
					  3 => array('8.', '(Oo)', '(oO)', '(oo)', '(OO)', '(o_O)', '(O_o)', '(O_O)', '(o_o)'),
					  4 => array(':=)'),
					  5 => array(':(', ':-('),
					  6 => array(':.', ':-.'),
					  7 => array('8(', '8-(', ':F', ':-F'),
					  8 => array(':-x', ':X', ':x', ':-X'),
					  9 => array('8-(', '^,^'),
					  10=> array(':-/', '8-/', '8-/', ':-\\', ':\\', '8-\\', '8-\\', '8/', '8\\'),
					  11=> array(':)', ':-)', '8)', '8-)'),
					  12=> array(':S', ':-S', '8S', '8-S'),
					  13=> array(';)', ';-)'),
					  14=> array('(!)'));

/*

login, questy, total_dmg, total_skody, max_dmg, max_skody, total_vyvolane, total_nevyvolane, max_vyvolane, max_nevyvolane, zavody, vitezstvi, vyrazeni, nedojeti, useku, prosazeno, posta, brigady, opravy1, opravy2, prodej1, prodej2, udrzba, srot, budovy, staje

questy.status:
0 - neresetovat
1 - resetovat

sklad.umisteni:
0 - sklad
1 - kluzak
2 - vyloha
10 000+ - probiha oprava

predmety:
1 - podvozek
2 - motor
3 - drzaky
4 - chladic
5 - deska
6 - brzdy
7 - zdroj
8 - pancerovani
9 - suspenzory
10 - pridavny motory
*/

?>