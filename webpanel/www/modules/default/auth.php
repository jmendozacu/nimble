<?php

$xtpl->restart(BASEPATH.'/template/default/auth.tpl');

$username = addslashes($_REQUEST['username']);
$password = addslashes($_REQUEST['password']);

$check = root_cmd('testsaslauthd -u "'.$username.'" -p "'.$password.'" -s password-auth');

$check = split(" ", $check);

if($check[1] == "OK"){
	echo 'System username and password for '.$_REQUEST['username'].' accepted.<br>';
	$user_check = $db->openTable('users');
	$user_check->getDataBySystemUsername($_REQUEST['username']);


	
	if($user_check->count() > 0){
		$user_check->login();
		header("Location: /default/overview");
	}elseif($username == "root"){
		$setup_root = $db->openTable('users');
		$setup_root->setSystemUsername('root');
		$setup_root->setPrivOwnUsers('Y');
		$setup_root->setPrivGrantOwnUsers('Y');
		$setup_root->setPrivRootLevel('Y');
		$setup_root->setLoginToken(md5(date("U")));
		$setup_root->save();
		$setup_root->login();
		header("Location: /default/overview");
	}else{
		$xtpl->parse('fail');
		$xtpl->out('fail');
	}
	
}else{
	$xtpl->parse('fail');
	$xtpl->out('fail');
}
