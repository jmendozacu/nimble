<?php

$xtpl->restart(BASEPATH.'/template/default/auth.tpl');

$shell->cmd('sudo testsaslauthd -u {username} -p {password} -s password-auth');
$shell->prepare('username', $_REQUEST['username']);
$shell->prepare('password', $_REQUEST['password']);
$check = $shell->exec();

$check = split(" ", $check);

if($check[1] == "OK"){
	echo 'System username and password for '.$_REQUEST['username'].' accepted.<br>';
	$user_check = $db->openTable('users');
	$user_check->getDataBySystemUsername($_REQUEST['username']);


	
	if($user_check->count() > 0){
		$user_check->login();
		header("Location: /default/overview");
	}elseif($_REQUEST['username'] == "root"){
		$setup_root = $db->openTable('users');
		$setup_root->setSystemUsername('root');
		$setup_root->setPrivOwnUsers('Y');
		$setup_root->setPrivGrantOwnUsers('Y');
		$setup_root->setPrivRootLevel('Y');
		$setup_root->setOwnedBy('');
		$setup_root->setLoginToken(md5(date("U")));
		$setup_root->setEmailAddress('');
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
