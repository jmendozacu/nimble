<?php

$nimble_id = $mod_verbs[2];
$token = $mod_verbs[3];

$edit_user = $db->openTable('users');
$edit_user->getDataByNimbleId($nimble_id);

if($edit_user->getLoginToken() != $token){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Reset Password');
	$xtpl->assign('action', 'Password reset url no longer valid.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/">here</a> to go to nimble login.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');

}elseif(isset($_REQUEST['password']) && $_REQUEST['password'] != $_REQUEST['retype_password'] ){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Reset Password');
	$xtpl->assign('action', 'Passwords did not match.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/">here</a> to go to nimble login.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
}elseif(isset($_REQUEST['password']) && strlen($_REQUEST['password']) < 8){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Reset Password');
	$xtpl->assign('action', 'Passwords is too short. Must be 8 or more characters long.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/">here</a> to go to nimble login.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
}elseif(isset($_REQUEST['password'])){
		// if it exists, passwd --stdin
	$shell->cmd('echo {password} | sudo passwd {username} --stdin');
	$shell->prepare('username', $edit_user->getSystemUsername());
	$shell->prepare('password', $_REQUEST['password']);
	$shell->exec();


	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Reset Password');
	$xtpl->assign('action', 'Password reset completed.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/">here</a> to go to nimble login.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
}else{
	$xtpl->restart(BASEPATH.'/template/default/resetpassword.tpl');

	$xtpl->assign('nimble_id', $edit_user->getNimbleId());
	$xtpl->assign('username', $edit_user->getSystemUsername());
	$xtpl->assign('token', $token);


	$xtpl->parse('edit_user');
	$xtpl->out('edit_user');
}
