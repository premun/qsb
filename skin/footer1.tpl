			</div>
		</div>
		<div class="info_row">
			<img src="{SKINDIR}img/info_kluzak1.png" alt="" class="info_kluzak" />
			<div class="odrazka">Rychlé info</div>
			<div class="right_box">
				{INFOBOX}
			</div>			
			<div class="odrazka" style="height: 1px"></div>
			<br />
			<img src="{SKINDIR}img/info_kluzak2.png" alt="" class="info_kluzak" style="margin-top: -33px" />
			<div id="nastenka_buttony" class="nastenka_buttony">
				<a name="nastenka_1" class="nastenka_button{NASTENKA_1}" title="Adminská nástěnka" onclick="setNastenka(1)" style="background-position: 0px 0px; height: 41px"></a>
				<a name="nastenka_2" class="nastenka_button{NASTENKA_2}" title="Stájová nástěnka" onclick="setNastenka(2)" style="background-position: 0px -43px; height: 31px"></a>
				<a name="nastenka_3" class="nastenka_button{NASTENKA_3}" title="Paliva" onclick="setNastenka(3)" style="background-position: 0px -76px; height: 25px"></a>
				<a name="nastenka_4" class="nastenka_button{NASTENKA_4}" title="On-line" onclick="setNastenka(4)" style="background-position: 0px -103px; height: 26px"></a>
				<a name="nastenka_5" class="nastenka_button{NASTENKA_5}" title="IRC" onclick="setNastenka(5)" style="background-position: 0px -131px; height: 11px"></a>
<!--				<a name="nastenka_6" class="nastenka_button{NASTENKA_6}" title="Poznámkový blok" onclick="setNastenka(6)" style="background-position: 0px -143px; height: 20px"></a>-->
			</div>
			<div class="odrazka">Nástěnka</div>
			<div class="right_box" style="min-height: 193px" id="nastenka">{NASTENKA}</div>			
			<div class="odrazka" style="height: 1px"></div>
		</div>
	<div class="footer"><div class="obsah_tip" onclick="jHadr('tip.php', {sekce: '{TIP_SEKCE}'})"{NOTIP}><span class="extra">Tip:</span> {TIP}</div></div>
	</div>
	</div>
</div>
<div style="clear: both; margin-bottom: 5px"></div>
<!--
{ERROR}
{SQL}
-->

<script type="text/javascript" src="{SKINDIR}additive.js"></script>

<div id="ajaxList"></div>


<a href="http://www.toplist.cz/stat/552945" style="color: #000000">
<script language="JavaScript" type="text/javascript">
<!--
document.write ('<img src="http://toplist.cz/dot.asp?id=552945&amp;http='+escape(document.referrer)+'&amp;wi='+escape(window.screen.width)+'&amp;he='+escape(window.screen.height)+'" width="1" height="1" border=0 alt="TOPlist" />');
//-->
</script>
</a>
<noscript>
	<img src="http://toplist.cz/dot.asp?id=552945" border="0" alt="" width="1" height="1" />
</noscript>
</body>
</html>