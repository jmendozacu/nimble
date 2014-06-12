<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'Deleting User');


$edit_user = $db->openTable('ftpusers');

if(!isset($mod_verbs[2])){
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}

$ftpuser_id = $mod_verbs[2];
$edit_user->getDataByFtpuserId($ftpuser_id);
	

if(!$edit_user->count() || $edit_user->getSystemUsername() != $user->getSystemUsername()){
	$xtpl->assign('action','User not found.');
	$xtpl->parse('list.action');
}else{ // all looked good

	$sysusername = $edit_user->getFtpusername();

	// delete the linux user
	$shell->cmd('sudo userdel --force --remove {username}');
	$shell->prepare('username', $sysusername);
	$shell->exec();
	
	// delete the record of the user.
	$edit_user->delete();
	
	$xtpl->assign('action','Deleted ftp user '.$sysusername.' successfully.');
	$xtpl->parse('list.action');
}

	
$xtpl->assign('action','Click <a href="/ftp/">here</a> to go back.');
$xtpl->parse('list.action');


$xtpl->parse('list');
$xtpl->out('list');
