{MAIN}
<h3>Info hráče {LOGIN}</h3>
<br />

{PROFIL}

<br /><br />
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  <td style="padding: 3px" colspan="2"><strong>Celkové statistiky</strong></td>
  </tr>
  
  <tr>
	  <td class="val">Odjeté závody: </td>
	  <td style="text-align: left">{ZAVODY}</td>
  </tr> 
  <tr>
	  <td class="val">Vítězství: </td>
	  <td style="text-align: left">{VITEZSTVI}</td>
  </tr> 
  <tr>
	  <td class="val">Nedojeté závody: </td>
	  <td style="text-align: left">{NEDOJETI}</td>
  </tr> 
  <tr>
	  <td class="val">Vyhrané sázky: </td>
	  <td style="text-align: left">{SAZKY}</td>
  </tr> 
  <tr>
	  <td class="val">Prosázeno: </td>
	  <td style="text-align: left">{PROSAZENO}</td>
  </tr> 
  <tr>
	  <td class="val">Opravářských smluv: </td>
	  <td style="text-align: left">{OPRAVY3}</td>
  </tr> 
  <tr>
	  <td class="val">Založil závodů: </td>
	  <td style="text-align: left">{ZALOZENI}</td>
  </tr> 
  <tr>
	  <td class="val">Způsobené škody: </td>
	  <td style="text-align: left">{TOTAL_DMG}</td>
  </tr> 
  <tr>
	  <td class="val">Obdržené škody: </td>
	  <td style="text-align: left">{TOTAL_SKODY}</td>
  </tr> 
  <tr>
	  <td class="val">Vyřadil hráčů: </td>
	  <td style="text-align: left">{VYRAZENI}</td>
  </tr> 
  <tr>
	  <td class="val">Vyhnul se útokům: </td>
	  <td style="text-align: left">{TOTAL_UHYBY}</td>
  </tr> 
  <tr>
	  <td class="val">Vyvolal soubojů: </td>
	  <td style="text-align: left">{TOTAL_VYVOLANE}</td>
  </tr> 
  <tr>
	  <td class="val">Ostatní souboje: </td>
	  <td style="text-align: left">{TOTAL_NEVYVOLANE}</td>
  </tr> 
  <tr>
	  <td class="val">Splněných questů:</td>
	  <td style="text-align: left">{QUESTIKU}</td>
  </tr> 
  <tr>
	  <td class="val">Posledně&nbsp;splněný&nbsp;quest:&nbsp;&nbsp;&nbsp;</td>
	  <td style="text-align: left">{QUESTIK}</td>
  </tr> 
  
  <tr>
  <td colspan="2" class="lista"></td>
  </tr>
</table>
<br />
<br />
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  <td style="padding: 3px" colspan="2"><strong>Rekordy během 1 závodu</strong></td>
  </tr>
  <tr>
	  <td class="val">Způsobené škody: </td>
	  <td style="text-align: left">{MAX_DMG}</td>
  </tr> 
  <tr>
	  <td class="val">Obdržené škody: </td>
	  <td style="text-align: left">{MAX_SKODY}</td>
  </tr> 
  <tr>
	  <td class="val">Vyhnul se útokům: </td>
	  <td style="text-align: left">{MAX_UHYBY}</td>
  </tr> 
  <tr>
	  <td class="val">Vyvolal soubojů: </td>
	  <td style="text-align: left">{MAX_VYVOLANE}</td>
  </tr> 
  <tr>
	  <td class="val">Ostatní souboje: </td>
	  <td style="text-align: left">{MAX_NEVYVOLANE}</td>
  </tr> 
  
  <tr>
  <td colspan="2" class="lista"></td>
  </tr>
</table>
<br />
<br />
{::MAIN}

{TABLE PROFIL}
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  <td style="padding: 3px" colspan="3"><strong>{LOGIN}</strong></td>
  </tr>
  
  {ROW}
  <tr{CLASS}>
  <td class="val">{NAME} </td>
  <td style="text-align: left">{VALUE}</td>
  {IMAGE}
  </tr>
  {::ROW}
  
  <tr>
  <td class="val" style="vertical-align: top">Popis: </td>
  <td colspan="2">{POPIS}</td>
  </tr> 
  
  <tr>
  <td colspan="3" class="lista"></td>
  </tr>
</table>
{::TABLE}

{EXT EXIST}<h3>Profil hráče</h3>Hledaný hráč neexistuje<br /><br />{::EXT}