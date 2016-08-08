<?php

class cErr {

    function cErr($vypis,$log) {
	    $this->vypisovani = $vypis;
	    $this->logovani = $log;
	    $this->counter = 0;
    }

    function add($msg,$typ) {
	    if($msg != $this->last_err) {
		    $this->counter++;
		    $this->errors[$this->counter] = $msg;
		    $this->typ[$this->counter] = $typ;
		    $this->last_err = $msg;
            
            if($this->logovani) $this->note();
	    }
    }

    function note() {
        $keys = array_keys($this->errors);
        $lid = end($keys);
        
        $obsah = file_get_contents(LOG_FILE);
        
        $obsah = date('d.m.Y H:i').' - {'.$_SERVER['REQUEST_URI'].'} ('.getNick(UID).')
        '.$this->errors[$lid]."\n\n".$obsah;

        @$fp = fopen(LOG_FILE, 'w');
        @fwrite($fp,$obsah);
        @fclose($fp);
    }
    
    function together() {
	    if(count($this->errors)) {
		    /*$this->vypis = '

    '.$_SERVER['SCRIPT_FILENAME'];*/
		    $this->vypis = '';
		    foreach($this->errors as $id=>$error) {
			    $this->vypis .= '
    ['.date('Y-m-d H:i').'] '.$error.' ('.$this->typ[$id].')';
		    }
	    }
    }

    function flog() {
	    if($this->logovani) {
		    $this->together();
		    if(!$this->vypis) return true;
		    $obsah = file_get_contents(LOG_FILE);
		    $obsah = '['.$_SERVER['PHP_SELF'].']  - '.($this->counter).' error'.($this->counter > 1).' occured
    '.$this->vypis.'

    '.$obsah;
		    @$fp = fopen(LOG_FILE,'w');
		    @fwrite($fp,$obsah);
		    @fclose($fp);
	    }
    }

    function vypis() {
	    $this->together();
	    if($this->vypis) {
		    return $this->vypis;
	    }
    }

}
?>