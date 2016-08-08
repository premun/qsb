{MAIN}
<a name="top"></a>
<h3>Registrace</h3>
Registrace nového herního účtu.<br /><br />
<form action="reg.php" method="post" style="margin-left: 0px" name="form_registrace">
<table cellspacing="1" cellpadding="0">
<tr>
  <td>Nickname: </td>
  <td><input type="text" name="login" maxlength="30" /></td>
</tr>
<tr>
  <td>Heslo: </td>
  <td><input type="password" name="heslo" maxlength="15" /></td>
</tr>
<tr>
  <td>Heslo znovu: &nbsp;&nbsp;&nbsp;</td>
  <td><input type="password" name="heslo2" maxlength="15" /></td>
</tr>
<tr>
  <td>E-mail: </td>
  <td><input type="text" name="e-mail" maxlength="50" /></td>
</tr>
<tr>
  <td>ICQ: </td>
  <td><input type="text" name="icq" maxlength="9" /></td>
</tr>
</table>
<hr />
<h3>Vyplňování údajů</h3>
<table cellspacing="1" cellpadding="0" class="prav_reg">
<tr>
  <td>
    <span class="extra">Nickname</span>&nbsp;- </td><td>jsou povolena všechna písmena(A-Z,a-z) včetně diakritiky, čísla(0-9) a podtržítko(_)
  </td>
</tr>
<tr>
  <td>
    <span class="extra">Heslo</span> - </td><td>platí stejně jako u nickname
  </td>
</tr>
<tr>
  <td> 
     <span class="extra">E-mail</span> - </td><td>je nutné vyplnit existující e-mailovou adresu, kvůli dokončení registrace
  </td>
</tr>
<tr>
  <td> 
     <span class="extra">ICQ</span> - </td><td>není nutné vyplňovat, jinak pište ve formátu 123456789 bez pomlček
  </td>
</tr>
</table>
<br />
<hr />
<h3>Pravidla</h3>
Hráč se tímto zavazuje k řádnému plnění pravidel, tak jak jsou uvedena <a href="http://help.qsb.cz/doku.php?id=pravidla">zde</a>. A je povinen je znát.
<br /><br /><hr />
<h3>Výběr rasy</h3>
<br />
<strong class="extra">Agresivita</strong> - vlastnost pomáhající příslušníkovi rasy projíždět tratě rychleji. Čím větší agresivita, tím měnší strach, tím rychleji se odváží hráč jet na těžkých úsecích a tím větší ránu uštědří v šarvátkách.
<br /><br />
<strong class="extra">Reflexy</strong> - vlastnost pomáhající příslušníkovi rasy projíždět tratě bezpečněji. Čím větší reflexy, tím větší šance na úhyb před zlomyslným soupeřem a tím větší šance projet obtížné úseky bez jediného škrábnutí.
<br /><br />
<strong class="extra">Obchodnictví</strong> - vlastnost pomáhající příslušníkovi rasy lépe obchodovat a smlouvat. Čím větší umění obchodovat, tím menší cena kupovaného zboží a tím větší cena zboží prodávaného.
<br /><br />
<strong class="extra">Kluzák</strong> - umožňuje vám vybrat, se kterým typem kluzáku odstartujete sezónu nebo jestli místo kluzáku vezmete peníze (doporučuje se zkušenějším hráčům a hlavně obchodníkům). Můžete si tak přizpůsobit rasu a kluzák vám vyhovujícímu stylu jízdy.
<br /><br />
	&nbsp;&nbsp;&nbsp;
	Vyber startovní kluzák: &nbsp;
	<select name="kluzak">
		<option value="4">Přizpůsobit rase</option>
		<option value="5">Peníze místo kluzáku</option>
		<option value="1">Sport</option>
		<option value="2">Combi</option>
		<option value="3">Wrecker</option>
	</select>
<br /><br />
{RASY}
<div style="text-align: right; width: 95%">
<input type="button" value=" OK " onclick="jHadr('reg.php','form_registrace')" /></div> 
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
		<td><input type="radio" value="{ID}" name="postava" {CHECKED}/></td>
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

{EXT COMMON}<h3>Registrace</h3>{::EXT}

{EXT BLOCK}Momentálně se není možno registrovat. Hra je dočasně zablokována kvůli úpravám. Zkuste to prosím později.{::EXT}

{EXT INFO}Chyba při předávání informací. Prosím kontaktuj admina{::EXT}
{EXT ID}Chyba při předávání informací - hráč s id {LOGIN} není uložen. Prosím kontaktuj admina{::EXT}
{EXT FINISHED}Registrace u tohoto hráče již proběhla kompletně{::EXT}
{EXT REGKEY}Chyba při předávání informací - špatný registrační klíč. Prosím kontaktuj admina{::EXT}

{EXT AKTIVACE}
Registrace pro nickname {LOGIN}
<br />
Potvrď prosím svůj nick zadaným heslem při první části registrace:
<br />
<br />
<form action="reg.php?action=com" method="post">
<table cellspacing="1" cellpadding="0">
<tr>
  <td>Nickname: &nbsp;&nbsp;&nbsp;</td>
  <td><input type="text" name="login" value="{LOGIN}" maxlength="30" /></td>
</tr>
<tr>
  <td>Heslo: </td>
  <td><input type="password" name="heslo" maxlength="15" /></td>
</tr>
<tr>
  <td><input type="hidden" value="{ID}" name="radek" /></td>
  <td style="text-align: right"><input type="submit" value=" OK " /></td>
</tr>
</table>
</form>
<br />
<br />
Pokud se vyskytnou potíže a například správné zadané heslo nefunguje, kontaktuj prosím admina na ICQ 315-389-695.
{::EXT}

{EXT USPESNA}
Registrace proběhla úspěšně. Během pár minut dorazí na adresu {EMAIL} potvrzovací e-mail. 
Pokud nepotvrdíte registraci pomocí e-mailu do 3 dnů, je možné, že budou vaše informace smazány a celou 
registraci budete muset provést od začátku.{::EXT}