<?php
class users extends Proto {
	// What table is our class going to use? This can be left empty.
	public $table = 'nimble_users';
	
	// We need to know some things about the table we're using...
	public $primary_key = 'nimble_id'; // required for save() to work
	
	// This is used when join statements are needed
	public $join_fragment = '';
	
	public function login(){
		$login_token = md5(rand(1,1000000).date("U").$this->getSystemUsername());
		$this->setLoginToken($login_token);
		$this->save();

		setcookie("user", $this->getSystemUsername(), null, '/', null, false, false);
		setcookie("token", $this->getLoginToken(), null, '/', null, false, false);

	}

	public function loggedIn(){
		if(!isset($_COOKIE['user']))
			return false;

		$this->getDataBySystemUsername($_COOKIE['user']);
		if($this->count() > 0 && $_COOKIE['token'] == $this->getLoginToken())
			return true;

		return false;
	}

	public function loginRequired(){
		if(!$this->loggedIn()){
			echo 'Login is required for this page.';
			die_safe();
		}
	}

	
	// Unset the cookies!!!
	public function logout(){
		if($this->loggedIn()){
			$login_token = md5(rand(1,1000000).date("U").$this->getSystemUsername());
			$this->setLoginToken($login_token);
			$this->save();

			setcookie("user", " ", null, '/', null, false, false);
			setcookie("token", " ", null, '/', null, false, false);
		}
	}

}
