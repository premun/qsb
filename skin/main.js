var IE=false,NN=false,xUA=navigator.userAgent.toLowerCase();

var is_gecko = ((xUA.indexOf('gecko')!=-1) && (xUA.indexOf('spoofer')==-1)
                && (xUA.indexOf('khtml') == -1) && (xUA.indexOf('netscape/7.0')==-1));

IE=(xUA.indexOf('opera 5')!=-1 || xUA.indexOf('opera/5')!=-1 || xUA.indexOf('opera 6')!=-1 || xUA.indexOf('opera/6')!=-1);
IE=document.all && xUA.indexOf('msie')!=-1 && parseInt(navigator.appVersion)>=4;
NN=xUA.indexOf('gecko')!=-1;
if(document.layers) {NN=true}

if(NN!=true) {IE=true}
else {IE=false}

function vlozTagy(pocatecni_tag, koncovy_tag) {
	showForumForm(1);
	
	if(typeof(document.posta_send) == "undefined") 
		var textarea = document.send.msg;
	else 
		var textarea = document.posta_send.posta_msg;
	
	// IE
	if(document.selection  && !is_gecko) {
		var vyber = document.selection.createRange().text;
		if(!vyber) {
			vyber='';
		}
		textarea.focus();
		if(vyber.charAt(vyber.length - 1) == " "){
			vyber = vyber.substring(0, vyber.length - 1);
			document.selection.createRange().text = pocatecni_tag + vyber + koncovy_tag + " ";
		} else {
			document.selection.createRange().text = pocatecni_tag + vyber + koncovy_tag;
		}

	// Mozilla
	} else if(textarea.selectionStart || textarea.selectionStart == '0') {
 		var vyber_zacatek = textarea.selectionStart;
		var vyber_konec = textarea.selectionEnd;
		var vrsek=textarea.scrollTop;
		var vyber = (textarea.value).substring(vyber_zacatek, vyber_konec);
		if(!vyber) {
			vyber='';
		}
		if(vyber.charAt(vyber.length - 1) == " "){
			nahrazeny_text = pocatecni_tag + vyber.substring(0, (vyber.length - 1)) + koncovy_tag + " ";
		} else {
			nahrazeny_text = pocatecni_tag + vyber + koncovy_tag;
		}
		textarea.value = textarea.value.substring(0, vyber_zacatek) + nahrazeny_text +
		  textarea.value.substring(vyber_konec, textarea.value.length);
		textarea.focus();

		var pozice=vyber_zacatek+(pocatecni_tag.length+vyber.length+koncovy_tag.length);
		textarea.selectionStart=pozice;
		textarea.selectionEnd=pozice;
		textarea.scrollTop=vrsek;

	// All others
	} else {
		var kopirovat_vystraha='!';
		var re1=new RegExp("\\$1","g");
		var re2=new RegExp("\\$2","g");
		kopirovat_vystraha=kopirovat_vystraha.replace(re1,'');
		kopirovat_vystraha=kopirovat_vystraha.replace(re2,pocatecni_tag+koncovy_tag);
		var text;

		if(!text) {
			text='';
		}
		text=pocatecni_tag+text+koncovy_tag;
		textarea.value=textarea.value+text;

		if(!is_safari) {
			textarea.focus();
		}
		noOverwrite=true;
	}

	if (textarea.createTextRange) textarea.caretPos = document.selection.createRange().duplicate();
}

function deleteForum(idz) {
	if(confirm('Opravdu vymazat tento příspěvek?')) {
		location = "deleteForum.php?id="+idz;									
	}
}

var last = Array();

function predmet(id,akce) {
	last[id] = $('#status_'+id).html();
	$('#status_'+id).html('Načítám ...');

	$.post('ajaxObchod.php?id='+id+'&action='+akce, {}, function(response) {
		if(response == 'last') response = last[id];
		if(response == 'refresh') location = 'obchod.php?action=sklad';
		$('#status_'+id).html(response);		
	});			
}

function fill(width,name) {
	setTimeout("filler("+width+",'"+name+"')",250);
}

function filler(width,name) {
	timer = 0;
	for(i=100;i>(width-1);i--) {
		setTimeout("setWidth("+i+",'"+name+"')",timer*10);
		timer++;
	}
}

function setWidth(w,n) {
	document.getElementById(n).width = w;
}

var zobrazeni = 'cas';
var loaded = 0;
var bezi = 0;

function prehod() {
	if(zobrazeni == 'cas') zobrazeni = 'zbyva';
		else zobrazeni = 'cas';
	
	loaded--;
	cas();
}

function cas() {
	if(typeof(timestamp) == "undefined") return true;
	
	loaded++;
	bezi++;
	
	if(zobrazeni == 'zbyva') {
		var cas = new Date(-1800*1000-loaded*1000);
	} else {
		var cas = new Date();
		cas.setTime(timestamp+bezi*1000);
	}	
	
	var hodiny = cas.getHours();
	var minuty = cas.getMinutes();
	var sekundy = cas.getSeconds();
	
	if(hodiny < 10) hodiny = '0'+hodiny;
	if(minuty < 10) minuty = '0'+minuty;
	if(sekundy < 10) sekundy = '0'+sekundy;
	
	if(loaded < 1800) {
		$('#cas').html(hodiny+':'+minuty+':'+sekundy);
	} else {
		$('#cas').html('<span class="error">Auto-odhlášení</span>');		
	}
}

function zobrazPopisek(id) {
	$('#popis_'+id).attr('class','rasy_visible');
	$('#zobraz_'+id).attr('class','rasy_hidden');
}

function skryjPopisek(id) {
	$('#popis_'+id).attr('class','rasy_hidden');
	$('#zobraz_'+id).attr('class','rasy_visible');
}

$('#cas').ready(function() {
	if(typeof(timestamp) != "undefined") {
		setInterval('cas()',1000);
	}
});

$(document).ready(function() {
	casovac();
});

function vynuluja(cislo) {
	document.getElementById("part_"+cislo+"b").selectedIndex = 0;
	document.getElementById("part_"+cislo+"c").selectedIndex = 0;
}

function vynulujb(cislo) {
	document.getElementById("part_"+cislo+"a").selectedIndex = 0;
	document.getElementById("part_"+cislo+"c").selectedIndex = 0;
}

function vynulujc(cislo) {
	document.getElementById("part_"+cislo+"b").selectedIndex = 0;
	document.getElementById("part_"+cislo+"a").selectedIndex = 0;
}

function showBox(text,e) {
	xs = e.clientX;
	ys = e.clientY;
	
	var object2 = document.getElementById('box').style;
	object2.opacity = 10;
	object2.MozOpacity = 10;
	object2.KhtmlOpacity = 10;
	object2.filter = "alpha(opacity=" + 10 + ")";
	
	var object1 = document.getElementById('box');
	object1.style.left = (xs+20)+'px';
	object1.style.top = (ys-70)+'px';
	object1.style.display = 'block';
	object1.innerHTML = text;
}

function hideBox() {
	document.getElementById('box').style.display = 'none';
}

function fade() {
	document.getElementById('box').style.display = 'block';
	opacity(100,0,500);
}

function opacity(opacStart, opacEnd, millisec) {
    var speed = Math.round(millisec / 100);
    document.getElementById('box').style.display = 'block';
    var timer = 0;

    if(opacStart > opacEnd) {
        for(i = opacStart; i >= opacEnd; i--) {
            setTimeout("changeOpac(" + i + ")",(timer * speed));
            timer++;
        }
    } else if(opacStart < opacEnd) {
        for(i = opacStart; i <= opacEnd; i++)
            {
            setTimeout("changeOpac(" + i + ")",(timer * speed));
            timer++;
        }
    }
}

function changeOpac(opacity) {
    var object = document.getElementById('box').style;
    object.opacity = (opacity / 100);
    object.MozOpacity = (opacity / 100);
    object.KhtmlOpacity = (opacity / 100);
    object.filter = "alpha(opacity=" + opacity + ")";
} 

function showForumForm(show) {
	switch(show) {
		case 0:
			$('form[name=send]').hide('normal');
			break;
		case 1:
			$('form[name=send]').show('normal');
			break;
		case 2:			
			$('form[name=send]').toggle('normal');
			break;
	}
}

function vymazZalohu(name) {
	$('tr[name='+name+']').hide(0);	
	$.post('adminz.php?action=vymazZalohu', {filename: name});
}

function deletePosta(action, id, start, sys) {		
	$('table[name=posta_'+id+']').slideUp('normal');
		
	$.post('del_posta.php?action='+action+'&id='+id, {request_method: 'jhadr', start: start, sys: sys}, function(response) {																		   
		if(response == '') return;
		
		if(response == 'no') return;
		
		$('#lastPosta').before(response);
		//$('table.posta:last').hide();
		//$('table.posta:last').show('normal');		
	});	
}

function setNastenka(id) {		
	$('#nastenka').html('<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Načítám...</div>');

	$('#nastenka_buttony a').attr('class', 'nastenka_button');	
	$('a[name=nastenka_'+id+']').attr('class', 'nastenka_button_active');
	
	$.post('nastenka.php',{nastenka_id: id},function(response) {
		$('#nastenka').html(response);
	});
}

function prijemce() {
	id = $('#prijemci').val();
	id = parseInt(id);
	nid = id+1;	
	
	$('#prijemce_'+id).after('<span id="prijemce_'+nid+'" style="display: none"><br />Komu: <input type="text" name="nick_'+nid+'" style="width: 150px" rel="ajaxList" autocomplete="off" /></span>');
	$('#prijemce_'+nid).slideDown('normal');
	$('#prijemci').val(nid);
}

function casovac() {
	$('.casovac').each(function() {
		var cas = $(this).attr('rel');
		cas--;
		
		if(cas <= 0) {
			setTimeout('location.reload()', 1000);
		}
		
		$(this).attr('rel', cas);
		
		var hodiny = (cas/60 > 59 ? (Math.floor(cas/3600) < 10 ? '0'+Math.floor(cas/3600) : Math.floor(cas/3600))+':' : '');
		var minuty = (Math.round(cas/60-Math.floor(cas/3600)*60) < 10 ? '0'+Math.floor(cas/60-Math.floor(cas/3600)*60) : Math.floor(cas/60-Math.floor(cas/3600)*60));
		var sekundy = (cas%60 < 10 ? '0'+cas%60 : cas%60);
		
		$(this).html(hodiny+minuty+':'+sekundy);
	});
	
	setTimeout('casovac()', 1000);	
}