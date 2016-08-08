{MAIN}
<h3>Tvorba trati</h3>
<form action="newTrack.php" method="get" name="form_useky">
	Jméno trati: <input type="text" name="nazev" maxlength="40" style="width: 170px" /><br /> 
	Délka úseků:
	<select name="delka">
		<option value="0">Krátká</option>
		<option value="1">Střední</option>
		<option value="2">Dlouhá</option>
	</select>
	<br />
	Popis: <br /><textarea name="popis" style="width: 240px; height: 60px"></textarea><br /> 
	<br /><input type="button" value=" OK " onclick="jHadr('newTrack.php?action=new', 'form_useky')" /><br /><br />
	U názvu jsou povolena všechna písmena(A-Z,a-z) včetně diakritiky, čísla(0-9), podtržítko(_) a mezera<br />
	<br />
	Trať stojí {ZAKLAD} Is + {USEK} Is zá každý úsek<br />
	Za každý závod na tvojí trati obdržíš {POUZITI} Is
</form>
<br />
<br />
<br />
{::MAIN}