{MAIN}
<script type="text/javascript">
<!--
function zobrazPopisek(id) {
	document.getElementById('popis_'+id).className = 'rasy_visible';
	document.getElementById('zobraz_'+id).className = 'rasy_hidden';
}

function skryjPopisek(id) {
	document.getElementById('popis_'+id).className = 'rasy_hidden';
	document.getElementById('zobraz_'+id).className = 'rasy_visible';
}
//-->
</script>

<h3>Změna rasy</h3>
Protože se neodvratně blíží restart, budeš si do nové jezdecké sezóny mít možnost změnit rasu a s tou hrát od příští sezóny a vyzkoušet tak třeba jiný styl hry. Rasa se změní až s restartem hry, do té doby si můžeš zvolit rasu kolikrát chceš (až ta poslední změna se bude počítat), ale rasa ti zůstane do restartu stejná jako máš teď.
<br /><br />
<strong class="extra">Agresivita</strong> - vlastnost pomáhající příslušníkovi rasy projíždět tratě rychleji. Čím větší agresivita, tím měnší strach, tím rychleji se odváží hráč jet na těžkých úsecích a tím větší ránu uštědří v šarvátkách.
<br /><br />
<strong class="extra">Reflexy</strong> - vlastnost pomáhající příslušníkovi rasy projíždět tratě bezpečněji. Čím větší reflexy, tím větší šance na úhyb před zlomyslným soupeřem a tím větší šance projet obtížné úseky bez jediného škrábnutí.
<br /><br />
<strong class="extra">Obchodnictví</strong> - vlastnost pomáhající příslušníkovi rasy lépe obchodovat a smlouvat. Čím větší umění obchodovat, tím menší cena kupovaného zboží a tím větší cena zboží prodávaného.
<br /><br />
<strong class="extra">Kluzák</strong> - umožňuje vám vybrat, se kterým typem kluzáku odstartujete sezónu nebo jestli místo kluzáku vezmete peníze (doporučuje se zkušenějším hráčům a hlavně obchodníkům). Můžete si tak přizpůsobit rasu a kluzák vám vyhovujícímu stylu jízdy.
<br /><br /><br />
{HLASKA}
<form action="newRasa.php?action=kluzak" method="post" style="margin: auto">
	&nbsp;&nbsp;&nbsp;
	Vybrat si kluzák na příští sezónu: &nbsp;
	<select name="kluzak">
		<option value="4"{CHECKED4}>Přizpůsobit rase</option>
		<option value="5"{CHECKED5}>Peníze místo kluzáku</option>
		<option value="1"{CHECKED1}>Sport</option>
		<option value="2"{CHECKED2}>Combi</option>
		<option value="3"{CHECKED3}>Wrecker</option>
	</select>
	&nbsp;&nbsp;
	<input type="submit" class="submit" value=" Změnit " />
</form>
<br />
<form action="newRasa.php" method="post" style="margin: auto" name="form_newrasa">
<span style="position: relative; left: 16px; top: -7px">Pro změnu rasy, potvrď výběr zde: <input type="submit" value=" Uložit rasu " class="submit" /></span>
{RASY}
<input type="submit" value=" Uložit rasu " class="submit" />
</form>
{::MAIN}

{TABLE RASY}
{ROW}
<table cellpadding="0" cellspacing="0" class="rasy">
	<tr class="horni">
		<td class="nazev">Název: </td>
		<td colspan="2">{NAZEV}</td>
	</tr>
	<tr>
		<td class="nazev">Vybrat: </td>
		<td><input type="radio" value="{ID}" name="rasa" /></td>
		<td rowspan="5" style="width: 128px; border-left: 1px solid #444; padding: 0px">
			<img src="skin/img/rasa{ID}.jpg" alt="{NAZEV}" />
		</td>
	</tr>
	<tr>
		<td class="nazev">Kluzák: </td>
		<td>{KLUZAK}</td>
	</tr>
	<tr>
		<td class="nazev">Agresivita: </td>
		<td>{AGRESIVITA}</td>
	</tr>
	<tr>
		<td class="nazev">Reflexy: </td>
		<td>{REFLEXY}</td>
	</tr>
	<tr>
		<td class="nazev">Obchodnictví: </td>
		<td>{OBCHOD}</td>
	</tr>
	<tr id="zobraz_{ID}" class="rasy_visible">
		<td colspan="3" style="background-color: #111"><a class="submit" onclick="zobrazPopisek({ID})">Zobrazit popis &raquo;</a></td>
	</tr>
	<tr class="rasy_hidden" id="popis_{ID}">
		<td class="nazev" style="vertical-align: top">Popis: <a class="submit" onclick="skryjPopisek({ID})">&laquo; skrýt</a></td>
		<td colspan="2">{POPIS}</td>
	</tr>
</table>
<br /><br />
{::ROW}
{::TABLE}

{MISC HLASKA}
&nbsp;&nbsp;&nbsp;<span class="extra">&gt;</span> Do příštího věku jsi se zatím rozhodl pro rasu <strong class="extra">{NAZEV}</strong><br /><br />
{::MISC}