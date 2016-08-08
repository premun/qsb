{MAIN}

{::MAIN}

{EXT NAJMOUT}
<script type="text/javascript">
<!--
	$(function() {
		$("#spolehlivost_s").slider({
			animate: true,
			min: 0,
			max: 100,
			step: 1,
			value: 0,
			width: 200,
			change: function(event, ui) {
				slajd2(ui.value);
			},
			slide: function(event, ui) {
				slajd2(ui.value);
			}
		});
	});
	
	var penize = {PENIZE};
	var zaklad = {ZAKLAD};
	var last = 0;
	var maximum1 = Math.floor(penize/{ZAKLAD}*100);
	var maximum2 = Math.floor(penize/({ZAKLAD}*1.7)*100);
	
	function slajd2(s) {
		if(typeof(s) != "number") s = last;
	
		last = s;
		
		var cena = (zaklad*s/100);
		if($("#aktualizace").attr('checked') == true) {
			cena = cena*1.7;
		}
		
		if(cena > penize) {
			if($("#aktualizace").attr('checked') == true) {
				s = maximum2;
				$("#spolehlivost_s").slider('option', 'value', maximum2);
			} else {
				s = maximum1;
				$("#spolehlivost_s").slider('option', 'value', maximum1);			
			}
			cena = penize;
		}
	
		$("#spolehlivost").html(s+"%");
		$("input[name=spolehlivost]").val(s);	
		$("#cena").html(Math.ceil(cena)+" Is");
	}
//-->
</script>
Cena: <span class="extra" id="cena">0 Is</span><br />
Spolehlivost informací: <span class="extra" id="spolehlivost">0%</span><br />
<div id="spolehlivost_s" style="margin: auto; margin-top: 9px; width: 266px"></div>
<em style="display: block; margin-top: 0px; margin-bottom: 3px; text-align: center">(nastavte spolehlivost pomocí táhla)</em>
<form action="spion.php" method="post" name="form_spion" style="margin-left: 0px">
	<input type="hidden" name="login" value="{LOGIN}" />
	<input type="hidden" name="zavod" value="{ZAVOD}" />
	<input type="hidden" name="spolehlivost" value="0" />
	<input type="checkbox" id="aktualizace" name="aktualizace" checked="checked" onchange="slajd2()" /><label for="aktualizace">Zasílat změny poštou</label>
</form>
{::EXT}

{EXT ZRUSIT}
Na tohoto závodníka je už špión nasazen (se spolehlivostí <strong>{SPOLEHLIVOST}%</strong>).
<br />
Zrušit tohoto špióna a nasadit nového?
<form action="spion.php" method="post" name="form_spion">
	<input type="hidden" name="action" value="zrusit" />
	<input type="hidden" name="login" value="{LOGIN}" />
	<input type="hidden" name="zavod" value="{ZAVOD}" />
</form>
{::EXT}

{EXT SHOW}
Na tohoto závodníka jsi nasadil špióna se spolehlivostí <strong>{SPOLEHLIVOST}%</strong>
<form action="spion.php" method="post" name="form_spion">
	<input type="hidden" name="action" value="zrusit" />
	<input type="hidden" name="login" value="{LOGIN}" />
	<input type="hidden" name="zavod" value="{ZAVOD}" />
</form>
{::EXT}