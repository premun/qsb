<?php

include 'library.php';
is_logged();
$id = $_GET['id'];

if($id == '' || !ereg('^[0-9]+$',$id)) {
	if(!jhadr()) $_SESSION['chyba'] = 'ID musí být číslo';
	go('posta.php?action=odeslana');
	konec();
}

if($_GET['action'] == 'odeslane') {
	$result = $Sql->q('SELECT * FROM posta WHERE kdo = '.UID.' AND id = '.$id);
	
	if(p($result) == 0) {
		if(!jhadr()) $_SESSION['chyba'] = 'Toto není tvoje pošta';
		go('posta.php?action=odeslana');
		konec();  
	}
	
	$row = fa($result);  
	$val = 3;
	
	if($row['status'] == 0) {
		$val = 4;
	} elseif($row['status'] == 5) {
		$result = $Sql->q('DELETE from posta WHERE id = '.$id);
		if($result) {
			if(!jhadr()) $_SESSION['chyba'] = 'Úspěšně vymazáno';
			go('posta.php?action=odeslana');
			konec();
		}
	}
	
	$result = $Sql->q('UPDATE posta set status = '.$val.' WHERE id = '.$id);
	if($result) {
		if(!jhadr()) $_SESSION['chyba'] = 'Úspěšně vymazáno';
		go('posta.php?action=odeslana');
		konec();
	}	
	
	if(jhadr()) {
		$page = new cPage('posta');
		$result = $Sql->q('SELECT * FROM posta WHERE kdo = '.UID.' AND status != 3 AND status != 4 AND status != 6 ORDER BY id DESC LIMIT '.($_POST['start']-1).',1');
			
		if(!p($result))	die('no');
		
		$msg = fa($result);	
				
		$zprava = findLink::transform($msg['msg']);
		
		$zprava = textFormat($zprava);  
		
		$line['id'] = $msg['id'];
		$line['datum'] = date('H:i j.n.',$msg['cas']);
		$line['zprava'] = nl2br($zprava);
		$line['komu'] = $msg['kdo'];
		$line['vlajka'] = getFlag($msg['komu']);
		$line['komu2'] = getNick($msg['komu']);
		$line['delete_start'] = $_POST['start'];
		$data[] = $line;
		
		$page->main = $page->getTable('ODESLANA',$data);
		$page->swap('HEADER','');
		echo $page->main;
	}
}

if($_GET['action'] == 'prijate' || $_GET['action'] == 'nova') {
	$result = $Sql->q('SELECT * from posta WHERE komu = '.UID.' AND id = '.$id);
	if(p($result) == 0) {
		if(!jhadr()) $_SESSION['chyba'] = 'Toto není tvoje pošta';
		go('posta.php?action=odeslana');
		konec();  
	}
	$row = fa($result);
	if($row['kdo'] == 0) {
		$result = $Sql->q('DELETE from posta WHERE id = '.$id);
		if($result) {
			if(!jhadr()) $_SESSION['chyba'] = 'Úspěšně vymazáno';
			go('posta.php?action=prijata');
			konec();
		}  
	}
	$val = 5;
	if($row['status'] == 3) {
		$result = $Sql->q('DELETE from posta WHERE id = '.$id);
		if($result) {
			if(!jhadr()) $_SESSION['chyba'] = 'Úspěšně vymazáno';
			go('posta.php?action=prijata');
			konec();
		}
	} else {
		$result = $Sql->q('UPDATE posta set status = '.$val.' WHERE id = '.$id);
		if($result) {
			if(!jhadr()) $_SESSION['chyba'] = 'Úspěšně vymazáno';
			go('posta.php?action=prijata');
			konec();
		}
	}
	
	if($_GET['action'] == 'nova') die('no');
	
	if(jhadr()) {
		$page = new cPage('posta');
		$result = $Sql->q('SELECT * FROM posta WHERE komu = '.UID.' AND (status = 1 OR status = 3) AND status != 6 AND status != 5 '.($_POST['sys'] == 'true' ? 'AND kdo != 0' : '').' ORDER BY id DESC LIMIT '.($_POST['start']-1).',1');
			
		if(!p($result))	die('no');
		
		$msg = fa($result);	
				
		$zprava = str_replace('[B]','<strong>',$msg['msg']);
		$zprava = str_replace('[/B]','</strong>',$zprava);
		$zprava = str_replace('[I]','<em>',$zprava);
		$zprava = str_replace('[/I]','</em>',$zprava);
		$zprava = str_replace('[U]','<span style="text-decoration: underline">',$zprava);
		$zprava = str_replace('[/U]','</span>',$zprava);
		$zprava = str_replace('[O]','<span class="extra">',$zprava);
		$zprava = str_replace('[/O]','</span>',$zprava);
		$zprava = str_replace('[S]','<span class="ultra">',$zprava);
		$zprava = str_replace('[/S]','</span>',$zprava);
		
		for($j=1;$j<15;$j++) {
			$zprava = str_replace('[SM'.$j.']','<img src="./skin/img/smiles/'.$j.'.gif" alt="">',$zprava);
		} 
		
		$line['id'] = $msg['id'];
		$line['datum'] = date('H:i j.n.',$msg['cas']);
		$line['zprava'] = nl2br($zprava);
		$line['kdo'] = $msg['kdo'];
		$line['vlajka'] = getFlag($msg['kdo']);
		$line['kdo2'] = getNick($msg['kdo']);
		$line['odpovedet'] = ($msg['kdo'] == 0 ? ' style="display: none"' : '');
		$line['delete_action'] = 'prijate';
		$line['sys'] = $_POST['sys'];
		$line['delete_start'] = $_POST['start'];
		$data[] = $line;
		
		$page->main = $page->getTable('PRIJATA',$data);
		$page->swap('HEADER','');
		echo $page->main;
	}
}

?>