{MAIN}
<h3>{NADPIS} <span class="ultra">({ID}/{POCET})</span></h3>
<hr />
{OBSAH}
<hr style="clear: both" />
{BUTTONY}
<div style="clear: both"></div>
{::MAIN}

{MISC BUTTONY1}
<input type="button" value="&laquo; Přechozí {PREV}/{POCET}" onclick="location = 'tutorial?{PREV}'" style="{DISPLAY_1}float: left" />
<input type="button" value="{NEXT}/{POCET} Další &raquo;" onclick="location = 'tutorial?{NEXT}'" style="{DISPLAY_2}float: right" />
{::MISC}

{MISC BUTTONY2}
<input type="button" value="&laquo; Přechozí {PREV}/{POCET}" onclick="location = 'tutorial?{PREV}'" style="{DISPLAY_1}float: left" />
<input type="button" value="Registrovat!" onclick="location = 'registrace'" style="float: right" />
{::MISC}

########################################################################################################################################
##################################################     STRANA 1     ####################################################################
########################################################################################################################################
{MISC NAZEV_1}Krátký tutoriál{::MISC}

{MISC STRANA_1}
<img src="images/tutorial_kluzak.png" style="float: left; margin-right: 4px" alt="Quadra Speed Boosters" />
Vítej v krátkém tutoriálu, který ti objasní základy hry. Tutoriál se doporučuje všem nováčkům, protože vás seznámí se základy a nastíní základní obraz, jak se hra hraje. Ovládání je celkem intuitivní a pokud budeš mít zájem proniknout hlouběji do hry, tak v <a href="http://help.qsb.cz/">helpu</a> většinou najdeš, co potřebuješ, nebo se neboj zeptat na fóru přímo ve hře.
{::MISC}

########################################################################################################################################
##################################################     STRANA 2     ####################################################################
########################################################################################################################################
{MISC NAZEV_2}Overall{::MISC}

{MISC STRANA_2}
Quadra Speed Boosters je závodní, sázkařská a obchodní hra z prostředí podobného fenoménu Star Wars. Celá hra se točí kolem <strong class="extra">závodů kluzáků</strong>, které byly v epizodě I - Skrytá Hrozba.
<br />
<br />
<h4>Věky</h4>
Stejně jako většina webovek, je i QSB rozděleno do jezdeckých sezón (věků). Věk skončí <strong class="extra">vždy po odjetí QSB Cupu</strong>, což je pohár podobný formulím F1, a trvá zhruba měsíc a půl. Poté proběhne restart a začíná se znovu.
<br />
<br />
<h4>Přepočty</h4>
Quadra Speed Boosters je <strong class="extra">přepočtová hra</strong>, takže většina důležitých akcí (jako odjíždění závodů...) se odehrává během nich. Celkem jsou čtyři přepočty, kde ten poslední je hlavní.
<ul style="margin-left: 40px">
	<li><span class="ultra">13:00</span></li>
	<li><span class="ultra">16:00</span></li>
	<li><span class="ultra">19:00</span></li>
	<li><span class="common"><strong>23:00</strong></span></li>
</ul>
<h4>Ovládání</h4>
Ovládání je velmi jednoduché a tento obrázek popisuje rozmístění hlavních ovládacích panelů:
<a class="submit" onclick="jHadr('tutorial', {file: 'tutorial_ovladani.png', title: 'ovládání'})"><img src="images/tutorial_ovladani.png" alt="Klikni pro zvětšení" width="440" style="border: 1px solid #444; margin-top: 6px" /></a>
{::MISC}

########################################################################################################################################
##################################################     STRANA 3     ####################################################################
########################################################################################################################################
{MISC NAZEV_3}Kluzáky{::MISC}

{MISC STRANA_3}
Kluzáky, ve kterých se závodí, se dělí na <strong class="extra">3 hlavní skupiny</strong> a každá se hodí pro jiný styl jízdy. Každá rasa zároveň preferuje jeden typ, který ji nejvíce vyhovuje, jezdit však může každý ve všech. Všechny součástky kluzáku musí být kompatibilní.
<ul>
	<li><span class="common"><strong>Sport</strong> - rychlý a křehčí kluzák</span></li>
	<li><span class="common"><strong>Combi</strong> - rozumný kompromis ostatních typů</span></li>
	<li><span class="common"><strong>Wrecker</strong> - pomalejší kluzák uzpůsobený k vrážení a likvidování ostatních</span></li>
</ul>
<hr />
Každý kluzák se <strong class="extra">skládá ze 7 až 10 součástek</strong>. Prvních sedm je povinných pro vstup do závodu, zbylé tři dobrovolné.
<ul style="background-image: url(images/tutorial_motor.jpg); background-repeat: no-repeat; background-position: 180px 25px">
	<li><span class="common">Podvozky</span></li>
    <li><span class="common">Motory</span></li>
    <li><span class="common">Držáky</span></li>
    <li><span class="common">Chladiče</span></li>
    <li><span class="common">Palubní desky</span></li>
    <li><span class="common">Brzdy</span></li>
    <li><span class="common">Zdroje</span><hr /></li>
    <li><span class="common">Pancéřování</span></li>
    <li><span class="common">Suspenzory</span></li>
    <li><span class="common">Přídavné motory</span></li>
</ul>
Při stavbě kluzáku si dej pozor, abys měl dostatečné chlazení, zdroj energie a váha součástek nepřesahovala nosnost podvozku.
{::MISC}

########################################################################################################################################
##################################################     STRANA 4     ####################################################################
########################################################################################################################################
{MISC NAZEV_4}Závody{::MISC}

{MISC STRANA_4}
Při vstupu do závodu zvolíš taktické prvky, které ovlivní tvůj způsob projetí trati a interakce s protivníky. Závody se odjíždějí během přepočtů a po jejich odjetí se zobrazí:
<ul>
	<li><span class="common"><strong>Přehled dění</strong> - detailní výpis událostí na trati</span></li>
	<li><span class="common"><strong>Rychlostní grafy</strong> - záznam rychlostí a vzdáleností během zvávodu</span></li>
	<li><span class="common"><strong>Komentář</strong> - jedinečný generovaný komentář závodu</span></li>
</ul>
Ukázka grafu:<br />
<img src="images/tutorial_graf.png" alt="Rychlostní graf závodu" style="margin-top: 6px" />
<br />
<br />
<h4>Opravování předmětů</h4>
Pokud se ti při závodění poškodí některá součástka, je třeba ji opravit. Buď si předmět opravíš draze sám, nebo si koupíš na pomoc opravné droidy nebo předmět necháš opravit některého hráče obchodníka, který se tomu věnuje (nejlevnější varianta).
{::MISC}

########################################################################################################################################
##################################################     STRANA 5     ####################################################################
########################################################################################################################################
{MISC NAZEV_5}Tratě{::MISC}

{MISC STRANA_5}
Každý závod se odehrává na nějaké trati, kterou vytvořili sami hráči, a probíhá díky tomuto faktoru zcela unikátně. Každá trať má svou obtížnost, rychlostní omezení a délku, a musíš si vybírat závody hlavně podle tratí, kde dostaneš výhodu oproti ostatním a která vyhovuje tvému kluzáku.
<ul>
	<li><span class="common"><strong>Pro Wrecker</strong> - těžší tratě s velkým rychlostním omezením</span></li>
	<li><span class="common"><strong>Pro Sport</strong> - lehké rovné tratě</span></li>
	<li><span class="common"><strong>Pro Combi</strong> - střední až těžké tratě s nižším rychlostním omezením</span></li>
</ul>
<a class="submit" onclick="jHadr('tutorial', {file: 'tutorial_trate.png', title: 'tratě'})"><img src="images/tutorial_trate.png" alt="Klikni pro zvětšení" width="440" style="border: 1px solid #444" /></a>
{::MISC}

########################################################################################################################################
##################################################     STRANA 6     ####################################################################
########################################################################################################################################
{MISC NAZEV_6}Stáje{::MISC}

{MISC STRANA_6}
Stáj je organizovaný celek hráčů, který je řízen vlastníkem (zakladatelem stáje) a dále se skládá z obchodníků a závodníků. Obchodníci a závodníci jsou do stáje najímáni prostřednictvím smluv, kde je stanovena částka, kterou jim stáj vypláci jakožto plat každý hlavní denní přepočet. Stájoví závodníci se pak jako jediní mohou účastnit poháru.
<br />
<h4>Vlastník</h4>
<ul>
	<li><span class="common">Zakladatel stáje</span></li>
	<li><span class="common">Rozděluje platy a operuje s financemi</span></li>
	<li><span class="common">Přihlašuje jezdce do poháru</span></li>
	<li><span class="common">Stará se o stájovou nástěnku</span></li>
	<li><span class="common">Kupuje stájové budovy</span></li>
</ul>
<h4>Obchodník</h4>
<ul>
	<li><span class="common">Zásobuje závodníky palivem</span></li>
	<li><span class="common">Vydělává překupováním paliv</span></li>
	<li><span class="common">Opravuje a nakupuje předměty pro jezdce</span></li>
</ul>
<h4>Závodník</h4>
<ul>
	<li><span class="common">Tažná jednotka stáje</span></li>
	<li><span class="common">Reprezentuje stáj v poháru</span></li>
	<li><span class="common">Vydělává vyhráváním závodů</span></li>
</ul>
<br />
{::MISC}

########################################################################################################################################
##################################################     STRANA 7     ####################################################################
########################################################################################################################################
{MISC NAZEV_7}A to je vše!{::MISC}

{MISC STRANA_7}
Jak vidíš, QSB opravdu není na první pohled tak složitá hra. Pokud máš zájem hrát a dosud nemáš svůj hráčský účet, <strong><a href="registrace">zde je velmi jednoduchá registrace</a></strong>, ke které potřebuješ pouze funkční e-mailovou adresu a můžeš hned začít hrát!
<br />
<br />
Celou hrou tě budou provázet tipy a rady, které najdeš na spodku každé stránky. Pokud nebudeš i tak něco vědět, neboj se zeptat na fóru.
<br />
<br />
<strong class="extra">Hodně štěstí ve hře přeje admin hry Dr.Hadr!</strong>
{::MISC}