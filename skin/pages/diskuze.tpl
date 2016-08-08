{MISC BARVA_NADPIS1}<span style="color: {BARVA}">{NADPIS1}</span>{::MISC}
{MISC BARVA_NADPIS2}<span style="color: {BARVA}">{NADPIS2}</span>{::MISC}

{MISC DISKUZE}
<span id="sekce_diskuze">
<br />
<br />
<form action="{PATH}diskuze.php?action=add&id={ID}" method="post" name="add_form">
	<input type="hidden" name="re" value="0" />
	{SMILES}
	<textarea style="width: 550px" name="obsah" rows="5"></textarea><br />
	<input type="submit" value=" Poslat příspěvek " style="width: 556px; margin-top: 5px; font-family: Calibri; font-weight: normal" />
</form>
<br />
<div class="separator"></div>
<br />
{TABS}
<div class="separator"></div>
</span>
<br />
{::MISC}

{TABLE FORUM}
{ROW}
<table class="guestbook" cellspacing="0" cellpadding="0"{STYLE}>
	<tr>
		<td class="sipka" style="background-color: {BARVA}"><img src="{PATH}skin/images/{ARROW}.png" alt="" /></td>
		<td class="nick" style="background-color: {BARVA}">{JMENO} {PRIJMENI} <span class="tmavy">| </span><a onclick="$('#reply_'+{ID}).slideToggle('normal')">Re</a></td>
		<td class="datum" style="background-color: {BARVA}">{DATUM}{DELETE}</td>
	</tr>
	<tr>
		<td class="msg" colspan="3" style="border-bottom: 1px solid #444{STRIPES}">{MSG}
			<div id="reply_{ID}" style="display: none; text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px dashed #444">
				<form action="{PATH}diskuze.php?action=add&id={CID}" method="post">
					<input type="hidden" name="re" value="{RE}" />
					<textarea style="width: 450px" name="obsah" rows="5" style="text-align: left"></textarea><br />
					<input type="submit" value=" Poslat příspěvek " style="width: 452px; margin-top: 5px" />
				</form>
			</div>
		</td>
	</tr>
</table>
<br /><br />
{::ROW}
{::TABLE}

{TABLE SMILES}
{ROW}<img src="{PATH}skin/images/smiles/{X}.gif" class="submit" alt="[SM{X}]" style="cursor: pointer" onclick="vlozTagy('[SM{X}]','');" />{::ROW}
{::TABLE}