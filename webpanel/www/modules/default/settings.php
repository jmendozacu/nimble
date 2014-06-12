<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/default/settings.tpl');

if(isset($_REQUEST['email_address']) && $_REQUEST['email_address'] != $user->getEmailAddress()){
	$user->setEmailAddress($_REQUEST['email_address']);
	$user->save();

	$xtpl->assign('action', 'email address has been updated.');
	$xtpl->parse('settings.action');
}

if(isset($_REQUEST['password']) && $_REQUEST['password'] == $_REQUEST['retype_password'] && $_REQUEST['password'] != ""){
	$shell->cmd('echo {password} | sudo passwd {username} --stdin');
	$shell->prepare('username', $user->getSystemUsername());
	$shell->prepare('password', $_REQUEST['password']);
	$shell->exec();

	$xtpl->assign('action', 'Password has been updated.');
	$xtpl->parse('settings.action');
}

if(isset($_REQUEST['password']) && $_REQUEST['password'] != $_REQUEST['retype_password'] && $_REQUEST['password'] != ""){
	$xtpl->assign('action', 'Password did not match the retyped password.');
	$xtpl->parse('settings.action');
	$xtpl->assign('action', 'Password was not updated.');
	$xtpl->parse('settings.action');
}


$xtpl->assign('email_address', $user->getEmailAddress());

$xtpl->parse('settings');
$xtpl->out('settings');
