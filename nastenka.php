<?php

include_once 'library.php';
is_logged();
$id = $_POST['nastenka_id'];

if(!headers_sent()) setcookie('nastenka',$id,time()+60*60*24*365*2);

$page2 = new cPage('nastenka');
	
switch($id) {
	case 1:
		$result = $Sql->q('SELECT * FROM nastenka WHERE sekce = 1 ORDER BY id DESC LIMIT 0,3');

		$data = array();
		for($i=0;$i<p($result);$i++) {
			$data[] = fa($result);
		}
		
		echo $page2->getTable('ADMINSKA', $data);
		
		break;
		
	case 2:
		$result = $Sql->q('SELECT staj FROM stajovnici WHERE login = '.UID);
		
		if(!p($result)) {
			echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Zatím nemáš stáj</div>';	
			break;
		}
		
		$staj = fa($result);
		
		$row = fa($Sql->q('SELECT * FROM nastenka WHERE sekce = 2 AND login = '.$staj['staj']));
		
		$obsah = textFormat($row['obsah']);
		
		echo '<div style="height: 8px"></div>'.nl2br($obsah);
		
		break;
		
	case 3:
		//echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Sekce v přípravě</div>';	
		$result = $Sql->q('SELECT palivo,mnozstvi FROM paliva_sklad WHERE staj = 0 AND login = '.UID.' AND mnozstvi >= 1 ORDER BY palivo ASC');
		if(p($result) > 0) {
			$celkem = 0;
			$jednotky = getJednotky();
			$data = array();
			for($i=0;$i<p($result);$i++) {
				$row = fa($result);
				$palivo = getPalivoAll($row['palivo']);
				
				$line['id'] = $row['palivo'];
				$line['nazev'] = $palivo['nazev'];
				$line['mnozstvi'] = numF($row['mnozstvi']);
				$line['jednotka'] = $jednotky[$row['palivo']];
	
				$data[] = $line;
				
				$line2 = $line;
				$line2['cena'] = $palivo['stala_cena']-$palivo['cena'];
				$line2['barva'] = "#797979";
				if($line2['cena'] < 0) $line2['barva'] = "#FF0000";
				if($line2['cena'] > 0) $line2['barva'] = "#02FD09";
				
				$line2['cena'] = numFP(abs($line2['cena']));
				
				$data2[] = $line2;
				$celkem += $row['mnozstvi'];
			}
			
			$row = fa($Sql->q('SELECT sklad FROM postavy WHERE login = '.UID));
			
			$page2->getTable('PALIVA',$data,'OBSAH');
			$page2->swap('CELKEM',numF($celkem));
			$page2->swap('LICENCE',numF($row['sklad']));
			$page2->finish();
			echo $page2->getTable('PALIVA_CENY',$data2);
			
		} else {
			echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Prázdný sklad</div>';
		}
		
		break;
		
	case 4:
		$result = $Sql->q('SELECT id, login, cas, status FROM hraci WHERE id != '.UID.' AND logged = 1 AND cas > '.(time()-60*15).' ORDER BY login ASC');
		
		if(!p($result)) {
			echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Žádní hráči online</div>';	
			break;
		}
	
		$data = array();
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			
			$row['login2'] = $row['login'];
			
			if(NO_SEND == 'true') $row['login'] = $row['login']."', no_send: 'true";
			
			if($row['status'] == 2) $row['login2'] = $page2->misc('KONZUL').$row['login2'];
			if($row['status'] == 42) $row['login2'] = $page2->misc('ADMIN').$row['login2'];	
			
			$row['cas'] = date('H:i', $row['cas']);
			$data[] = $row;
		}
		
		echo $page2->getTable('ONLINE', $data);
		
		break;
		
	case 5:
		if(filemtime('vypisy/irc.txt')+15*60 < time()) {
			echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">IRC bot momentálně N/A</div>';
			break;
		}
	
		$obsah = file_get_contents('vypisy/irc.txt');
		
		$obsah = str_replace('DrHadr','Dr.Hadr',$obsah);
		
		$users = explode(';', $obsah);
		
		sort($users);
		
		$data = array();
		foreach($users as $login) {
			if($login != 'Q' && $login != 'QSBot') $data[] = array('login' => $login);
		}
		
		if(!count($data)) 
			echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Kanál je prázdný</div>';
		else
			echo $page2->getTable('IRC', $data);
		
		break;
		
	case 6:
		echo '<br /><br /><br /><br /><br /><br /><br /><div style="text-align: center">Sekce v přípravě</div>';	
		break;
}

?>