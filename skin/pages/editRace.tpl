{MAIN}
{OBSAH}
{::MAIN}

{EXT EXIST}Hledaný závod neexistuje{::EXT}
{EXT ZAKLADAL}Tento závod si nezakládal ty{::EXT}
{EXT ODJET}Tento závod již byl odjet{::EXT}
{EXT FULL}Nemůžeš zrušit závod, ve kterém už je nějaký závodník{::EXT}

{MISC S_LIDMA}
	Protože v závodě už je hráč, máš jen omezené pravomoce při editaci.<br /><br />
	
	<form action="editRace.php?action=edit&id={ID}" method="post">
	<input type="hidden" name="zavodnici" value="ano" />
	
	Heslo:
	<input type="text" name="heslo" value="{HESLO}" />
	<br /><br />
	Minimální počet jezdců: {LIDI2}
	<br />
	Popis: <br />
	<textarea name="popis" cols="32" rows="4">{POPIS}</textarea>
	<br />
	<input type="submit" class="submit" value=" Upravit " />
	
	</form>
{::MISC}

{MISC BEZ}
<br />
<form action="editRace.php?action=edit&id={ID}" method="post" style="margin-left: 0px">
<table cellspacing="0" cellpadding="0" class="zavod" style="width: 380px">
  <tr class="horni">
	  <td style="padding: 3px" colspan="2"><strong>{NAZEV}</strong></td>
  </tr>
  
  <tr class="nobg">
	  <td class="val">Minimální vklad: </td>
	  <td><input type="text" name="vklad" value="{VKLAD}" /></td>
  </tr>

  <tr class="nobg">
	  <td class="val">Omezení prestiží: </td>
	  <td><input type="text" name="prestiz" value="{PRESTIZ1}" size="4" /> - <input type="text" name="prestiz2" value="{PRESTIZ2}" size="4" /></td>
  </tr>

  <tr class="nobg">
	  <td class="val">Dotace závodu: </td>
	  <td>{DOTACE} Is</td>
  </tr>

  <tr class="nobg">
	  <td class="val">Výherní předmět: </td>
	  <td>{PREDMET}</td>
  </tr>

  <tr class="nobg">
	  <td class="val">Cenová kategorie: </td>
	  <td>{CENY}</td>
  </tr>

  <tr class="nobg">
	  <td class="val">Vsazeno na závod: </td>
	  <td>{SAZKY} Is</td>
  </tr>

  <tr class="nobg">
	  <td class="val">Trať: </td>
	  <td>{TRATE}</td>
  </tr>
  
  <tr class="nobg">
  	<td class="val">Čas odjetí: </td>
	<td>
		<select name="cas">
			<option value="13">13:00</option>
			<option value="16">16:00</option>
			<option value="19">19:00</option>
			<option value="0" selected="selected">23:00</option>
		</select>
	</td>
  </tr>
  
  <tr class="nobg">
	  <td>Datum odjetí: </td>
	  <td>{DATUM}</td>
  </tr>
  
  <tr class="nobg">
	  <td class="val">Heslo: </td>
	  <td><input type="text" name="heslo" /></td>
  </tr>
  
  
  <tr class="nobg">
	  <td>Max&nbsp;počet&nbsp;závodníků:&nbsp;&nbsp;&nbsp;</td>
	  <td>{LIDI}</td>
  </tr>
  
  
  <tr class="nobg">
	  <td>Min&nbsp;počet&nbsp;závodníků:&nbsp;&nbsp;&nbsp;</td>
	  <td>{LIDI2}</td>
  </tr>  
  
  <tr class="nobg">
	  <td class="val" style="vertical-align: top">Popis: </td>
	  <td><textarea name="popis" cols="32" rows="4">{POPIS}</textarea></td>
  </tr>
  
</table>
<br />
<input type="button" onclick="location='editRace.php?id={ID}&action=cancel'" value=" Zrušit závod " class="submit" style="width: 383px" />
<br />
<input type="submit" value=" Uložit změny " class="submit" style="width: 383px" />
</form>
{::MISC}

{TABLE TRATE}
<select name="trat">
    {ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE LIDI}
<select name="pocet">
    {ROW}<option value="{POCET}"{CHECKED}>{POCET}</option>{::ROW}
</select>
{::TABLE}

{TABLE LIDI2}
<select name="minimum">
    {ROW}<option value="{POCET}"{CHECKED}>{POCET}</option>{::ROW}
</select>
{::TABLE}

{TABLE DATUM}
<select name="datum">
    {ROW}<option value="{CAS}"{CHECKED}>{DATUM}</option>{::ROW}
</select>
{::TABLE}

{TABLE CENY}
<select name="cena">
	<option value="-1">Neomezeno</option>
	{ROW}<option value="{ID}"{CHECKED}>{VALUE}</option>{::ROW}
</select>
{::TABLE}