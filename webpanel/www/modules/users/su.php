<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'Switching User');


$edit_user = $db->openTable('users');

if(!isset($mod_verbs[2])){
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}

$nimble_id = $mod_verbs[2];
$edit_user->getDataByNimbleId($nimble_id);
	
if($edit_user->count() == 0){
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}

$sysusername = $edit_user->getSystemUsername();

// check if this person is root or in the ownership tree...
if(!$edit_user->checkOwnership($user->getSystemUsername()) && $user->getPrivRootLevel() != 'Y'){
	$xtpl->assign('action','You do not have user ownership privileges over the selected user. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}else{ // all looked good
	$user->su($edit_user->getSystemUsername());

	$xtpl->assign('action','User switch successful. Click <a href="/">here</a> to go to the mainpage.');
	$xtpl->parse('list.action');
}

	


$xtpl->parse('list');
$xtpl->out('list');
