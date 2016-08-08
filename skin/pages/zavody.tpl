{MAIN}
<hr style="clear: both" />
<h3>{NADPIS}</h3>
<br />
{OBSAH}

{::MAIN}

{EXT ZADNE}
<hr style="clear: both" />
<br />
Žádné závody<br />
<br />
{::EXT}

{TABLE MOJE NEODJETE}
<table cellspacing="0" cellpadding="1" class="zavody">
  <tr class="horni">
	<td class="nick">Název závodu</td>
	<td class="info" style="text-align: center">Hráči</td>
	<td class="info" style="text-align: center">Čas</td>
	<td class="info" style="text-align: center">Datum</td>
	<td class="info" style="text-align: center">Prestiž</td>
	<td class="info"></td>
  </tr>
  {ROW}
    <tr{ODDELOVAC}>
        <td class="nick">{ZAMEK}{PREDMET}<a href="showRace.php?id={ID}" style="color: {BARVA}">{NAZEV}</a></td>
        <td class="info" style="text-align: center">{POCET2}/{POCET}</td>
        <td class="info" style="text-align: center">{CAS}</td>
        <td class="info" style="text-align: center">{DATUM}</td>	
        <td class="info" style="text-align: center">{PRESTIZ}</td>
        <td class="info" style="text-align: center"><a href="showRace.php?id={ID}#editace">Editovat</a></td>
    </tr>
  {::ROW} 
  <tr><td class="lista" colspan="6"></td></tr>
</table>
<br /><br />
{::TABLE}

{TABLE MOJE ODJETE}
<table cellspacing="0" cellpadding="1" class="zavody">
  <tr class="horni">
	<td class="nick">Název závodu</td>
	<td class="info" style="text-align: center">Hráči</td>
	<td class="info" style="text-align: center">Čas</td>
	<td class="info" style="text-align: center">Datum</td>
	<td class="info" style="text-align: center">Prestiž</td>
	<td class="info" style="text-align: center">Dotace</td>
  </tr>
  {ROW}
    <tr{ODDELOVAC}>
        <td class="nick">{ZAMEK}{PREDMET}<a href="showRace.php?id={ID}">{NAZEV}</a></td>
        <td class="info" style="text-align: center">{POCET2}/{POCET}</td>
        <td class="info" style="text-align: center">{CAS}</td>
        <td class="info" style="text-align: center">{DATUM}</td>	
        <td class="info" style="text-align: center">{PRESTIZ}</td>
        <td class="info" style="text-align: right">{DOTACE}</td>
    </tr>
  {::ROW} 
  <tr><td class="lista" colspan="6"></td></tr>
</table>
<br /><br />
{::TABLE}

{TABLE ZAVODY}
<table cellspacing="0" cellpadding="1" class="zavody">
  <tr class="horni">
	<td class="nick">Název závodu</td>
	<td class="info">Hráči</td>
	<td class="info">Čas</td>
	<td class="info">Datum</td>
	<td class="info">Prestiž</td>
	<td class="info" style="text-align: center">Dotace</td>
  </tr>
  {ROW}
    <tr{ODDELOVAC} onmousemove="showBox('{BOX}',event)" onmouseout="hideBox()" style="cursor: pointer" onclick="location='showRace.php?id={ID}'">
        <td class="nick">{ZAMEK}{PREDMET}<a href="showRace.php?id={ID}" style="color: {BARVA}">{NAZEV}</a></td>
        <td class="info" style="text-align: center">{POCET2}/{POCET}</td>
        <td class="info" style="text-align: center">{CAS}</td>
        <td class="info" style="text-align: center">{DATUM}</td>	
        <td class="info" style="text-align: center">{PRESTIZ}</td>
        <td class="info" style="text-align: right">{DOTACE}</td>
    </tr>  
  {::ROW}
  <tr><td class="lista" colspan="6"></td></tr>
</table>
<br /><br />
{::TABLE}

{MISC ZAMEK}
<img src="./skin/img/locker.jpg" alt="Závod s heslem" /> 
{::MISC}

{MISC PREDMET}
<img src="./skin/img/star.png" alt="Závod s výherním předmětem" style="position: relative; top: 1px" /> 
{::MISC}

{MISC MOJE}
<span class="extra">Neodjeté závody:</span>
<br />
<br />
{NEODJETE}
<span class="extra">Odjeté závody:</span>
<br />
<br />
{ODJETE}
{::MISC}

{MISC FILTER}
  <form action="zavody.php" method="get" name="form1">
	Tratě: 
    {TRATE}
    <br />
    <input type="hidden" value="{ACTION}" name="action" />
    <input type="hidden" value="{KAT2}" name="kat" />
    <span{EMPTY}><input type="checkbox" name="empty"{CHECKBOX} onchange="document.form1.submit()" id="empty" /> <label for="empty">Zobrazovat prázdné</label></span>
    <br />
  </form>
  <form action="zavody.php" method="get" name="form2">
    <input type="hidden" value="{TRAT2}" name="trat" />
    <input type="hidden" value="{MOTOR2}" name="motor" />
    <input type="hidden" value="{ACTION}" name="action" />
    <input type="hidden" value="{EMPTY2}" name="empty" />
    <span{EMPTY}{KATEGORIE}><input type="checkbox" name="kat"{CHECKBOX2} onchange="document.form2.submit()" id="kat" /> <label for="kat">Moje cenová kategorie {CENA_KLUZAKU}</label></span>
    <br /><br />
  </form>
  {ZAVODY}
  {POHAR}
  {SIPKY}
  <div id="box"></div>
{::MISC}

{TABLE TRATE}
<select name="trat" onchange="document.form1.submit()">
<option value="">Všechny</option>
    {ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{MISC POHAR}
<strong>{POHAR_NAZEV}</strong>
<br /><br />
{POHAR_ZAVODY}
{::MISC}

{EXT VSTUP}
<h3>Vstup do závodu</h3>
{::EXT}

{EXT ODSTUP}
<h3>Odstupování ze závodu</h3>
{::EXT}

{EXT PLNY}Tento závod je plný.{::EXT}
{EXT ODJET}Tento závod již byl odjet.{::EXT}
{EXT NAJEDNOU}Nemůžeš vstoupit do více závodů v jeden čas{::EXT}
{EXT ZAKLADATEL}Nemůžeš vstoupit do tvého závodu{::EXT}
{EXT STAJ}V tomto závodě již jsou 2 lidé ze tvé stáje nebo není dostatek cizích závodníků{::EXT}
{EXT JSI}V tomto závodě již jsi{::EXT}
{EXT STAJ2}Nemůžeš vstoupit do tohoto závodu, protože tento závod je jen pro stájové závodníky{::EXT}
{EXT POHAR}Nemůžeš vstoupit do tohoto závodu, protože tento závod je jen pro závodníky přihlášené v poháru{::EXT}
{EXT KOMPLET}Nemůžeš vstoupit do tohoto závodu, protože tvůj kluzák není kompletní{::EXT}
{EXT CENA}Nemůžeš vstoupit do tohoto závodu, protože tvůj kluzák je moc drahý a nespadá do této cenové kategorie{::EXT}
{EXT MOTOR}Nemůžeš vstoupit do tohoto závodu, protože tvůj motor nezapadá do kategorie povolených typů motorů pro tento závod{::EXT}
{EXT PRESTIZ1}Nemůžeš vstoupit do závodu, protože nemáš dostatečně vysokou prestiž{::EXT}
{EXT PRESTIZ2}Nemůžeš vstoupit do závodu, protože máš moc vysokou prestiž{::EXT}
{EXT BRIGADA}Nemůžeš vstoupit do závodu, protože máš brigádu{::EXT}
{EXT PALIVO_NAKUP_PENIZE}Nemáš dostatek peněz na nákup paliva{::EXT}

{EXT PALIVO}<br />
Nemůžeš vstoupit do tohoto závodu, protože nemáš dostatek paliva pro tvůj kluzák!<br />
<br />
<table style="margin-left: 40px;">
	<tr><td rowspan="4"><img src="./skin/img/drop.jpg" /></td>
	<tr><td>Palivo: </td><td><strong class="extra">{PALIVO}</strong></td></tr>
	<tr><td>Máš: </td><td><strong class="extra">{MAS}</strong> kg/l/ks paliva {PALIVO}</td></tr>
	<tr><td>Potřebuješ:&nbsp;&nbsp;&nbsp;&nbsp;</td><td><strong class="extra">{SPOTREBA}</strong> kg/l/ks</td></tr>
	<tr><td>Cena:</td><td><strong class="extra">{CENA}</strong> Is</td></tr>
</table>
<br />
Nakup <a href="buyPalivo.php?id={PALIVO2}&trat={TRAT}">zde</a>.{::EXT}

{EXT PALIVO2}
<br />
Nemůžeš vstoupit do tohoto závodu, protože nemáš dostatek paliva pro tvůj kluzák!<br />
<br />
<table>
	<tr><td rowspan="5"><img src="./skin/img/drop2.jpg" style="margin-right: 15px" /></td>
	<tr><td>Palivo: </td><td><strong class="extra">{PALIVO}</strong></td></tr>
	<tr><td>Máš: </td><td><strong class="extra">{MAS}</strong> kg/l/ks paliva {PALIVO}</td></tr>
	<tr><td>Potřebuješ:&nbsp;&nbsp;&nbsp;&nbsp;</td><td><strong class="extra">{SPOTREBA}</strong> kg/l/ks</td></tr>
	<tr><td>Cena:</td><td><strong class="extra">{CENA}</strong> Is</td></tr>
</table>
{::EXT}
  
{EXT SAZKA}Na tento závod sis vsadil a nemůžeš do něj tedy vstoupit dokud nezrušíš <a href="showBet.php?id={SAZKA}">sázku</a>{::EXT}
{EXT NEJSI}V tomto závodě nejsi a tak z něj nemůžeš odejít{::EXT}
{EXT ODSTOUPIL}Odstoupil jsi ze závodu{::EXT}
{EXT ORLY}Opravdu si přeješ odstoupit ze závodu?<br />
Z počátečního vkladu (<span class="extra">{VKLAD} Is</span>) se ti vrátí jen 75% (<span class="extra">{ZPET} Is</span>){::EXT}
{EXT OBSAZEN}Závod je již plně obsazen{::EXT}
{EXT PREDEM}Vstupování do závodu je časově omezeno. Do závodu se dostanete nejpozději 10 minut před odjetím.{::EXT}
{EXT HESLO}Heslo bylo špatně zadáno<br /><br /><a href="enterRace.php?id={ID}">Zpět</a>{::EXT}
{EXT USPESNE}Úspěšně jsi vstoupil do závodu<br /><br /><a href="showRace.php?id={ID}">Zpět</a>{::EXT}
{EXT PENIZE}Nemáš dostatek peněz {PENIZE} pro vstup do závodu. Minimální vklad je {VKLAD}{::EXT}
{EXT ORLY2}Bude tě to stát minimální vklad, což je <span class="extra">{VKLAD} Is</span> a zbyde ti <span class="extra">{ZBYDE} Is</span>.<br />Při odstoupení ze závodu bude vráceno 75% vkladu.<br />
    <br /><br />
	<script type="text/javascript">
	<!--
		$(function() {
			$("#agresivita").slider({
				animate: true,
				min: -100,
				max: 100,
				step: 1,
				value: 0,
				width: 200,
				change: function(event, ui) {
					slajd(ui.value);
				},
				slide: function(event, ui) {
					slajd(ui.value);
				}
			});
		});
		
		$(function() {
			$("#opatrnost").slider({
				animate: true,
				min: 15,
				max: 85,
				step: 1,
				value: 50,
				width: 200,
				change: function(event, ui) {
					$("#opatrnost_value").html(ui.value+'%');
					$("input[name=opatrnost]:first").val(ui.value);
				},
				slide: function(event, ui) {
					$("#opatrnost_value").html(ui.value+'%');
					$("input[name=opatrnost]:first").val(ui.value);
				}
			});
		});
		
		$(function() {
			$("#control_tab").tabs({ fx: { opacity: 'toggle' } });
		});
		
		var last = 0;
		
		function slajd(p) {
			if(p < 0 && last >= 0) {
				$("#of").hide();
				$("#def").show();
				$("#ne").hide();
				$("#obet").show();
				$("#taktika").show();
				$("select[name=taktika1]").show();
				$("select[name=taktika2]").hide();
				$("#postoj_nazev").html('Defenzivní');
				$("#preferovany_cil").html('Očekávaný útočník:');
			}
			
			if(p > 0 && last <= 0) {
				$("#def").hide();
				$("#of").show();
				$("#ne").hide();
				$("#obet").show();
				$("#taktika").show();
				$("select[name=taktika1]").hide();
				$("select[name=taktika2]").show();
				$("#postoj_nazev").html('Ofenzivní');
				$("#preferovany_cil").html('Preferovaný cíl:');
			}
			
			if(p == 0 && last != 0) {
				$("#obet").hide();
				$("#def").hide();
				$("#of").hide();
				$("#ne").show();
				$("#taktika").hide();
				$("#postoj_nazev").html('Neutrální');
			}
			
			last = p;
			
			$("#agresivita_value").html(p+'%');
			$("input[name=agresivita]:first").val(p);
		}
	//-->
	</script>

	<div id="control_tab" style="width: 420px; margin: auto">
		<ul>
			<li><a href="#nastaveni_jizdy">Nastavení jízdy</a></li>
			<li><a href="#jizdni_styly">Jízdní styly</a></li>
			<li><a href="#napoveda">Nápověda</a></li>
		</ul>
		<div id="nastaveni_jizdy">	
			<form action="enterRace.php?id={ID}&action=sure" method="post" style="margin-left: 12px">
				<span class="extra">Opatrnost:</span> <span id="opatrnost_value">50%</span>
				<table style="width: 362px; font-size: 10px; color: #999; margin-top: 4px" cellpadding="0" cellspacing="0">
					<tr>
						<td style="text-align: left; width: 33%">Nebezpečný / rychlý</td>
						<td style="text-align: center; width: 33%">Normální</td>
						<td style="text-align: right; width: 33%">pomalý / Opatrný</td>
					</tr>
				</table>
				<div id="opatrnost" style="margin-top: 4px; width: 360px"></div>
		
				<br />
				<input type="hidden" name="opatrnost" value="50" />
				
				<span class="extra">Agresivita:</span> <span id="agresivita_value">0%</span>
				<table style="width: 362px; font-size: 10px; color: #999; margin-top: 4px" cellpadding="0" cellspacing="0">
					<tr>
						<td style="text-align: left; width: 33%">Defenzivní</td>
						<td style="text-align: center; width: 33%">Neutrální</td>
						<td style="text-align: right; width: 33%">Agresivní</td>
					</tr>
				</table>
				<div id="agresivita" style="margin-top: 4px; width: 360px"></div>
		
				<br />
				<input type="hidden" name="agresivita" value="0" />
				
				<span class="extra">Postoj:</span> <span id="postoj_nazev">Neutrální</span><br />
				<span id="def" style="display: none">
					{POSTOJ1}
				</span>
				
				<span id="of" style="display: none">
					{POSTOJ2}
				</span>
				
				<div id="ne" style="margin-top: 2px">
					Styl jízdy se bude odvíjet od agresivity rasy tvojí postavy.
				</div>
				
				{OBET}
			
				<span id="taktika" style="display: none">
					<br />
					<span class="extra">Taktika:</span><br />
					{TAKTIKA1}
					{TAKTIKA2}
				</span>
				
				<br />
				{HESLO}
				<input type="submit" value="Vstoupit do závodu" class="submit" style="width: 360px; text-align: center" />
			</form>
		</div>
		
		<div id="jizdni_styly">	
			Pro vysvětlení tabulek najeď na ikony<br />
			<table class="jizdni_styly" cellpadding="0" cellspacing="0">
				<br />
				{STYLY1}
			</table>
			<br />
			<table class="jizdni_styly" cellpadding="0" cellspacing="0">
				{STYLY2}
			</table>
			<br />
			<br />

			<strong class="extra">Ofenzivní styly</strong>
			<ul>
				<li style="color: #666"><span class="extra">Silný úder</span> (Tad'hor)<span class="common"> - budete útočit jedním silným a pomalejším nárazem a pokusem o vyřazení jednoho předmětu (úder bude koncentrován na jedno místo). Tento útok způsobuje nejvíce škod, ale nejméně zpomaluje protivníka</span></li>
				<li style="color: #666"><span class="extra">Vrážení</span> (Yel hata)<span class="common"> - zasypete napadeného salvou slabších úderů a poškodíte mu kluzák na mnoha místech. Poškozen může být různý počet předmětů, avšak rovnoměrně. Výše škod a zpomalení oběti jsou střední.</span></li>
				<li style="color: #666"><span class="extra">Vytlačování</span> (Wakamo-su)<span class="common"> - zapřete se do nepřitele a budete ho drtit o trať neustálým tlačením. Protivník je velmi zpomalen, ale obdrží jen malé škody</span></li>
			</ul>
			
			<br />

			<strong class="extra">Defenzivní styly</strong>
			<ul>
				<li style="color: #666"><span class="extra">Unikání</span> (Ghan'khar)<span class="common"> - skvělá obrana proti vytlačování, kdy vhodným přejezdem napříč tratí navedete protvníka (který se vás snaží vytlačit) do skalky nebo jiné překážky</span></li>
				<li style="color: #666"><span class="extra">Pirueta</span> (Avi-pah)<span class="common"> - provedete jeden dlouhý a rázný úhybný manévr a změníte nepřátelský silný úder v sebevraždu</span></li>
				<li style="color: #666"><span class="extra">Kličkování</span> (Whirlee)<span class="common"> - rychlé změny směru vás ochrání před vrážením</span></li>
			</ul>		
		</div>
		
		<div id="napoveda">	
			<table cellpadding="0" cellspacing="4" style="text-align: justify">
				<tr>
					<td style="vertical-align: top"><span class="extra">Opatrnost:</span></td>
					<td>Toto nastavení ovlivňuje, jak rychle budeš projíždět každý úsek tratě. Nižší opatrnost zvyšuje rychlost, jakou budeš projíždět každý úsek, ale s ní se zvedá i nebezpečí nabourání. Vyšší opatrnost ti zaručí naopak celkem bezpečný průjezd, ale vybírá si daň na rychlosti.<br /><br /></td>
				</tr>
				<tr>
					<td style="vertical-align: top"><span class="extra">Agresivita:</span></td>
					<td>Agresivita rozhoduje, jak se budeš chovat k ostatním jezdcům, pokud se k nim přiblížíš.
						<ul>
							<li>Záporná<span class="common"> - defenzivní jízda. Budeš se aktivně vyhýbat protivníkům (snížíš šanci být zasažen), ale větší obezřetnost se projeví na rychlosti.</span></li>
							<li>Nulová<span class="common"> - neutrální jízda. Chování jezdce bude závislé na tvojí rase, ale bude nahodilé. Budeš se jak vyhýbat, tak útočit, ale s horší úspěšností.</span></li>
							<li>Kladná<span class="common"> - ofenzivní jízda. Aktivně napadáš ostatní jezdce a ničíš jim kluzáky. Také tvoje jízda bude nepatrně rychlejší, ale i nebezpečnější.</span></li>
						</ul>
					</td>
				</tr>
				<tr>
					<td style="vertical-align: top"><span class="extra">Jízdní&nbsp;styly:</span></td>
					<td>Pokud nejedeš neutrálně, máš navíc na výběr jeden ze tří jízdních stylů. Ty určují, jak se zachováš v případě souboje - jakým stylem se vyhneš nebo budeš útočit. Každý styl má bonus proti jinému stylu a naopak je v nevýhodě proti dalšímu. Tyto bonusy jsou přehledně v tabulce v záložce 'Jízdní styly'. Pokud tedy dojde k souboji, jsou podlé této tabulky upraveny šance na vyhnutí a poté i velikost škod a jejich rozmístění.</td>
				</tr>
				<tr>
					<td style="vertical-align: top"><span class="extra">Taktiky:</span></td>
					<td>Taktiky se také týkají interakce s ostatními hráči a mohou ti poskytnout bonusy v soubojích.</td>
				</tr>
			</table>
		</div>
	</div>
	<br />
	<br />
	{TRAT}
	<br />
	<br />
{::EXT}

{TABLE POSTOJ1}
<select name="postoj1" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV} ({NAZEV2})</option>{::ROW}
</select>
{::TABLE}

{TABLE POSTOJ2}
<select name="postoj2" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV} ({NAZEV2})</option>{::ROW}
</select>
{::TABLE}

{TABLE OBET}
<span id="obet">
	<br />
	<span class="extra" id="preferovany_cil">Preferovaný cíl:</span><br />
	<select name="obet" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
		<option value="0">žádný preferovaný cíl</option>
		{ROW}<option value="{ID}"{CHECKED}>{LOGIN}</option>{::ROW}
	</select>
</span>
{::TABLE}

{TABLE TAKTIKA1}
<select name="taktika1" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE TAKTIKA2}
<select name="taktika2" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{MISC HESLO}<br />Heslo: <input type="password" name="heslo" value="" /><br />{::MISC}