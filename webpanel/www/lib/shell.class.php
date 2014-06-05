<?php
class shell {
	public $prepared = array();
	public $cmd = null;
	public $debug = false;
	public $saniwrap = "'";
	public $sudo = false;

	public function __construct($cmd = ''){
		$this->cmd($cmd);
	}

	public function cmd($cmd){
		$this->cmd = $cmd;
	}

	public function exec($notrim=0){
		// Sanitize that shizzzzz if there are things to fill in from $this->prepared
		if(count($this->prepared) > 0){
			foreach($this->prepared as $key => $val){
				$this->cmd = str_replace('{'.$key.'}', $val, $this->cmd);
			}
			// Empty this out now!
			$this->prepared = array();
		}

		if($this->debug)
			return $this->cmd;

		$pre_cmd = "";
		if($this->sudo)
			$pre_cmd .= "sudo ";

		if($notrim == 1)
			return shell_exec($pre_cmd.$this->cmd);
		else
			return trim(shell_exec($pre_cmd.$this->cmd));
	}

	// Used to sanitize data going into command args.
	// YAY Sanitization! :)
	public function prepare($var, $val = null){
		if(is_array($var) && count($var) > 0){
			foreach($var as $key => $val){
				$val = str_replace("'", "'\"'\"'", $val);
				$this->prepared[$key] = $this->saniwrap.$val.$this->saniwrap;
			}
		}elseif($val != null){
			$val = str_replace("'", "'\"'\"'", $val);
			$this->prepared[$var] = $this->saniwrap.$val.$this->saniwrap;
		}
	}
}

