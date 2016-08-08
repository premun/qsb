{MAIN}
<script type="text/javascript">
<!--
function setEtapa(id) {
	$.post('showGoods.php', {action: 'etapa', id: id, etapa: $('#etapa_'+id).val()});
}
//-->
</script>
{OBSAH}
{ETAPA}
{::MAIN}

{MISC ZADNE}Tento obchodník nemá žádné zboží{::MISC}
{MISC ETAPA}<div style="text-align: center">Další zboží se objeví <strong class="extra">{ETAPA_DATUM}</strong></div>{::MISC}

{TABLE TYP}
{ROW}
<br /><br />
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr class="kluzak2_items">
		<td class="val" style="padding: 2px; padding-top: 0px"><img src="./skin/img/{PIC}.jpg" alt="{NAZEV}" onclick="location='items.php?typ={J}'" class="submit" height="80" /></td>
		<td>{POPIS}</td>
	</tr>	
</table>
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr class="horni">
	  <td class="prvni">Název</td>
	  <td style="text-align: center;">Typ podvozku</td>	  
	  <td style="text-align: right; padding-right: 8px;">Na skladě</td>
	  <td style="text-align: right; padding-right: 8px;">Cena</td>
	  <td style="text-align: right; padding-right: 8px;"></td>
	</tr>
		{PREDMETY}
</table>
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr>
		<td class="lista"></td>
	</tr>
</table>
<br />
<br />
{::ROW}
{::TABLE}

{TABLE PREDMETY}
{ROW}
<tr class="kluzak2_items">
	<td class="prvni" style="width: 120px"><a href="showItem.php?id={ID}&typ={TYP}" class="common">{NAZEV}</a></td>
	<td style="text-align: center">{TYPN}</td>
	<td style="text-align: right; padding-right: 23px">{KUSY}/{CELKEM}</td>
	<td style="text-align: right; padding-right: 8px">{CENA}</td>
	{AKCE}
</tr>
{::ROW}
{::TABLE}