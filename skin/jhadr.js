var button_locations = new Array();
var button_forms = new Array();
var button_alerts = new Array();
var button_jHadr_submit_form = new Array();
var loading = false;

function jHadr(url,data) {

	if(typeof(data) == "object") {
		for(var key in data) {
			if(data[key].substr(0,8) == 'object::') {
				var obj = document.getElementsByName(data[key].substr(8))[0];
				if(typeof(obj) != "undefined")
					data[key] = obj.value;
			}
		}
	} else {			
		if(typeof(document.getElementsByName(data)[0]) != "undefined") {
			
			var data2 = new Object();
			
			jQuery.each($("form[name="+data+"]").find("input,select"), function(i, val) {
				if($(this).attr("type") != "button" && $(this).attr("type") != "submit" && $(this).attr("type") != "checkbox") {
					data2[$(this).attr("name")] = $(this).attr("value");
				}
			});
			
			jQuery.each($("form[name="+data+"]").find("input[type=checkbox][checked]"), function(i, val) {
					data2[$(this).attr("name")] = 'on';
			});
			
			jQuery.each($("form[name="+data+"]").find("textarea"), function(i, val) {
				data2[$(this).attr("name")] = $(this).val();
			});
			
			data = new Object();				
			data = data2;
		} else {
			if(data.substr(0,8) == 'object::') {
				var name = data.substr(8);
				var obj = document.getElementsByName(name)[0];
				if(typeof(obj) != "undefined") {
					data = new Object();	
					data[name] = obj.value;		
				}			
			}
		}
	}		
	
	data.request_method = 'jhadr'; // aditive information for server's processing script
		
	loading = true;
	
	$("#dialog").dialog('option','width', 280);
	$("#dialog").dialog('option','height', 100);
	$("#dialog").dialog('option','resizable', false);
	$("#dialog").dialog('option','buttons', {});
	$("#dialog").dialog('option','title', '<img src="loading.gif" alt="Načítám data..." />');
	$("#dialog").html('<br /><br /><br /><div style="text-align: center">Načítám data...</div>');
	$("#dialog").dialog('open');

	$.post(url, data, function (response) {		
		if(response == "") return;
		if(loading == false) return;
		
		$("#dialog").dialog('close');		
		//$("#dialog").dialog('option','height', 'auto');
		//$("#dialog").dialog('option','width', 'auto');
		
		loading = false;
		
		if(response.substr(0,1) != "{") alert(response);
		
		resp = JSON.parse(response);
		
		if(typeof(resp.goto) == "string") {
			location = resp.goto;
			return;
		}
		
		if(typeof(resp.submit_form) == "string") {
			document.getElementsByName(resp.submit_form)[0].submit();
//			$("form[name=" + resp.submit_form + "]").submit();
			return;
		}
						
		for(var key in resp) {
			if(key != 'html' && resp.hasOwnProperty(key) && key != 'buttons') {
				$("#dialog").dialog('option', key, eval("resp."+key));
			}
		}
		
		var buttons = new Object();
		
		button_locations = new Array();
		button_forms = new Array();
		button_alerts = new Array();
		button_jHadr_submit_form = new Array();
		
		for(var key in resp.buttons) {
			name = resp.buttons[key].name;
			type = resp.buttons[key].type;
			func = resp.buttons[key].func;
			
			switch(type) {
				case 'close': 
					buttons[name] = function() { $("#dialog").dialog("close"); };
					break;
					
				case 'location': 
					button_locations[name] = func;
					buttons[name] = function() { $("#dialog").dialog("close"); };
					break;
					
				case 'refresh': 
					buttons[name] = function() { location.reload(); };
					break;
					
				case 'alert': 
					button_alerts[name] = func;
					buttons[name] = function() { $("#dialog").dialog("close"); };
					break;
					
				case 'submit': 
					button_forms[name] = func;
					buttons[name] = function() { $("#dialog").dialog("close"); };
					break;
					
				case 'jHadr_submit':
					button_jHadr_submit_form[name] = func;
					buttons[name] = function() { $("#dialog").dialog("close"); };
					break;					
			}
		}
		
		$("#dialog").dialog('option','resizable', true);
		$("#dialog").dialog('option', 'buttons', buttons);
		$("#dialog").dialog('option','resizable', true);		
		$("#dialog").html(resp.html);		
		$("#dialog").dialog('open');
	});
}	

$(function() {
	$("#dialog").dialog({
		bgiframe: true,
		minheight: 100,
		minwidth: 280,
		height: 100,
		width: 280,
		position: 'center',
		draggable: true,
		modal: true,
		title: "Quadra Speed Boosters",
		autoOpen: false,
		closeOnEscape: true,
		close:  function (event, ui) {
					loading = false;
				}
	});
});	

$("button[type=button]").live("click", function() {		

	if(typeof(button_locations[$(this).html()]) != "undefined") {
		location = button_locations[$(this).html()];
		return;
	}
	
	if(typeof(button_forms[$(this).html()]) != "undefined") {
		$("form[name="+button_forms[$(this).html()]+"]").submit();
		return;
	}
	
	if(typeof(button_alerts[$(this).html()]) != "undefined") {
		jHadr(button_alerts[$(this).html()], {submethod: 'alert_button'});
		return;
	}
	
	if(typeof(button_jHadr_submit_form[$(this).html()]) != "undefined") {
		jHadr($('form[name='+button_jHadr_submit_form[$(this).html()]+']').attr('action'), button_jHadr_submit_form[$(this).html()]);
		return;
	}
	
});