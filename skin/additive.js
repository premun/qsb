var jmena = Array();
var current_ajaxList;

$("#ajaxList > a").live("click", function() {
	$('*[name='+current_ajaxList+']').val($(this).html());
	setTimeout("$('#ajaxList').hide()",0);
});

$("*[rel=ajaxList]").blur(function(){
	setTimeout("$('#ajaxList').hide()",100);
});

$("*[rel=ajaxList]").focus(function(){
	if($(this).val().length == 0) return;

	$('#ajaxList').show();	
});

$(document).ready(function() {
	$("*[rel=ajaxList]").attr('autocomplete', 'off');
	$('#ajaxList').hide();
});

$("*[rel=ajaxList]").live("keyup", function(){
	obsah = $(this).val();
	current_ajaxList = $(this).attr('name');
	if(obsah.length > 0) {
		if(obsah.length == 1) {
			$('#ajaxList').show();
			$('#ajaxList').width($(this).width());
			var offset = $(this).offset();
			$('#ajaxList').css('left',offset.left);
			$('#ajaxList').css('top',offset.top+$(this).height()+4);		
		}
	
		$.post('ajaxList.php', {char: obsah}, function (response) {
			jmena = response.split('|');

			$('#ajaxList').html('<span id="ajaxList_s"></span>');
			
			for(var id in jmena) {
				$('#ajaxList_s').before('<a>'+jmena[id]+'</a>');
			}
		});
	} else {
		$('#ajaxList').hide();
	}
});