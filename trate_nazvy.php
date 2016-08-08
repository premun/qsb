<?php
include 'library.php';

$nazev['zewlárna'] = "Boonta Training Course";
$nazev['komu sa nechce'] = "Mon Gazza Speedway";
$nazev['Gel na prdel'] = "Beedo's Wild Ride";
$nazev['huuul'] = "Aquilaris Classic";
$nazev['proč musel zemřít Jan Tleskač'] = "Malastare 100";
$nazev['why not'] = "Vengeance";
$nazev['záleží na tom'] = "Spice Mine Run";
$nazev['nezáleží'] = "Sunken City";
$nazev['maybe'] = "Howler Gorge";
$nazev['slowly'] = "Dug Derby";
$nazev['hmmm trat'] = "Scrapper's Run";
$nazev['těžší už to nebude'] = "Zugga Challenge";
$nazev['kmtghbž'] = "Baroo Coast";
$nazev['noňák'] = "Bumpy's Breakers";
$nazev['only noňák'] = "Executioner";
$nazev['málá pomalá'] = "Sebulba's Legacy";
$nazev['lucie'] = "Grabvine Gateway";
$nazev['009 zavod'] = "Andobi Mountain Run";
$nazev['Hip hoP TRaŤ'] = "Dethro's Revenge";
$nazev['000 TracK'] = "Fire Mountain Rally";
$nazev['001 TracK'] = "The Boonta Classic";
$nazev['nejrychlejsi nejkratsi'] = "Ando Prime Centrum";
$nazev['nejdkratsi nejtesi'] = "Inferno";
$nazev['C0M3 0N'] = "Abyss";
$nazev['danilsbeerroute'] = "The Gauntlet";
$nazev['easya'] = "Mos Espa Open";
$nazev['jej'] = "SoroSuub Facility";
$nazev['ondramh s'] = "Watchtower Run";
$nazev['m racing'] = "Orotoru G'am";
$nazev['lehká trat'] = "The Brightlands";
$nazev['demolation derbi'] = "The Badlands";
$nazev['kvalifikace cc zkusenos'] = "The Ballast Complex";
$nazev['svet 4'] = "Ruins of Carnuss Gorgull";
$nazev['kes'] = "Serres Sarrano";
$nazev['slavkova trat'] = "The Grand Reefs";
$nazev['klop jonk hi'] = "The Citadel";
$nazev['serenitína'] = "Nightlands";
$nazev['můj hrob ciniekokos'] = "Boonta Eve Classic";
$nazev['kokosova trať'] = "The Dreighton Triangle";
$nazev['lehuoček'] = "Agrilat Swamp Circuit";
$nazev['serentína II'] = "Keren Street Race";
$nazev['retun'] = "The Mining Facility";
$nazev['newim'] = "Classic Bantha Track";
$nazev['super'] = "Malastare 200";
$nazev['skok'] = "Gungan Track";
$nazev['A'] = "Sith Rally";
$nazev['H'] = "Sandcrawler Track";
$nazev['O'] = "Corusant Run";
$nazev['J'] = "Podracer Track";

foreach($nazev as $old => $new) {
	$Sql->q('UPDATE trate SET nazev = "'.$new.'" WHERE nazev = "'.$old.'"');
}
?>