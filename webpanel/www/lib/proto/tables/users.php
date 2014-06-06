<?php
class users extends Proto {
	// What table is our class going to use? This can be left empty.
	public $table = 'nimble_users';
	
	// We need to know some things about the table we're using...
	public $primary_key = 'nimble_id'; // required for save() to work
	
	// This is used when join statements are needed
	public $join_fragment = '';

	// 
	public $loggedin = false;
	
	public function login(){
		$login_token = md5(rand(1,1000000).date("U").$this->getSystemUsername());
		$this->setLoginToken($login_token);
		$this->save();

		setcookie("user", $this->getSystemUsername(), null, '/', null, false, false);
		setcookie("token", $this->getLoginToken(), null, '/', null, false, false);

	}

	public function loggedIn(){
		return $this->loggedin;
	}

	public function loggedIn_Init(){
		if(!isset($_COOKIE['user']))
			return $this->loggedin;

		$this->getDataBySystemUsername($_COOKIE['user']);
		if($this->count() > 0 && $_COOKIE['token'] == $this->getLoginToken())
			$this->loggedin = true;

		return $this->loggedin;
	}

	public function loginRequired(){
		extract($GLOBALS, EXTR_REFS | EXTR_SKIP);
		if(!$this->loggedIn()){
			$xtpl->restart(BASEPATH.'/template/list.tpl');
			$xtpl->assign('pagename', 'Login Required');
			$xtpl->assign('action','Login required. Click <a href="/">here</a> to login.');
			$xtpl->parse('list.action');
			$xtpl->parse('list');
			$xtpl->out('list');
			die_safe();
		}
	}

	
	// Unset the cookies!!!
	public function logout(){
		if($this->loggedIn()){
			if(isset($_COOKIE['su'])){
				setcookie("su", " ", null, '/', null, false, false);
			}else{
				$login_token = md5(rand(1,1000000).date("U").$this->getSystemUsername());
				$this->setLoginToken($login_token);
				$this->save();

				setcookie("user", " ", null, '/', null, false, false);
				setcookie("token", " ", null, '/', null, false, false);
			}
		}
	}


	public function checkOwnership($sysusername){
		$iterations=0;
		$tree = array();
		$current_owner = $this->getOwnedBy();
		do{
			$tree_builder = $this->openTable('users');
			$tree_builder->getDataBySystemUsername($current_owner);
			$current_owner = $tree_builder->getOwnedBy();
			if($tree_builder->getSystemUsername() == $sysusername)
				return true;
			$iterations++;
		}while($tree_builder->count() != 0 && $tree_builder->getOwnedBy() != '' && $iterations<1000);
		return false;
	}

	public function su($sysusername){
		setcookie("su", $sysusername, null, '/', null, false, false);
	}
}
