{MAIN}
<h3>Brigády</h3>
{BRIGADA}
{BRIGADY}
{::MAIN}

{MISC MOJE}
Tvoje brigáda <strong>{MOJE_NAZEV}</strong> - <a href="brigada.php?action=cancel&id={MOJE_ID}">Zrušit</a>
<br />
<hr />
<br />
{::MISC}

{MISC UZ_MAS}<span class="ultra">Už máš brigádu</span>{::MISC}
{MISC MAS_TUTO}Máš tuto brigádu{::MISC}
{MISC ZAVOD}<span class="ultra">Jsi v závodě</span>{::MISC}
{MISC OBSAZENO}<span class="ultra">Brigáda je obsazena</span>{::MISC}

{TABLE BRIGADY}
{ROW}
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  	<td style="padding: 3px" colspan="2"><strong>{NAZEV}</strong></td>
  </tr>
  
  <tr>
  	<td class="val">Plat:</td>
	<td style="vertical-align: middle">{PLAT} Is</td>
  </tr> 
   
  <tr>
  	<td class="val" style="text-align: left">Ztráta&nbsp;prestiže&nbsp;denně:&nbsp;&nbsp;&nbsp;</td>
  	<td style="vertical-align: middle">{PRESTIZ}</td>
  </tr>  
   
  <tr>
  	<td class="val">Volná místa:</td>
  	<td style="vertical-align: middle">{VOLNO}</td>
  </tr>     

  <tr>
  	<td class="val">Doporučená rasa:</td>
  	<td style="vertical-align: middle">{RASA}</td>
  </tr> 
  
  <tr>
  	<td style="text-align: right; padding-right: 6px; background-color: #111111; border-top: 1px solid #444444" colspan="2">{VSTUP}</td>
  </tr>    
   
  <tr>
  	<td colspan="2" class="lista"></td>
  </tr>
</table>
<br /><br />
{::ROW}
{::TABLE}

{EXT VZIT}
<h3>{NAZEV}</h3>
Chceš se nechat najmout jako <strong>{NAZEV}</strong>? Denní ztráta prestiže je {PRESTIZ}. 
Vydělávat si budeš {PENIZE} Is.
<br />
<a href="brigada.php?id={ID}&action=sure">Vzít brigádu</a>
<br /><br />
<a href="brigady.php">Zpět</a>
{::EXT}