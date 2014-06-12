<?php
$user->loginRequired();

$ftpuser_id = $mod_verbs[2];

$edit_user = $db->openTable('ftpusers');
$edit_user->getDataByFtpuserId($ftpuser_id);

if($edit_user->count() == 0){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'User Not Found');
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}

$xtpl->restart(BASEPATH.'/template/ftp/edit.tpl');

$xtpl->assign('ftpuser_id', $edit_user->getFtpuserId());
$xtpl->assign('ftpusername', $edit_user->getFtpusername());
$xtpl->assign('ftp_homedir', $edit_user->getHomedir());

$xtpl->parse('edit_user');
$xtpl->out('edit_user');
