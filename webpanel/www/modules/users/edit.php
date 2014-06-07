<?php
$user->loginRequired();

$nimble_id = $mod_verbs[2];

$edit_user = $db->openTable('users');
$edit_user->getDataByNimbleId($nimble_id);

if($edit_user->count() == 0){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'User Not Found');
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}

$xtpl->restart(BASEPATH.'/template/users/edit.tpl');

$xtpl->assign('nimble_id', $edit_user->getNimbleId());
$xtpl->assign('username', $edit_user->getSystemUsername());

$priv_own_users_checked = ($edit_user->getPrivOwnUsers() == 'Y') ? "checked":"";
$priv_grant_own_users_checked = ($edit_user->getPrivGrantOwnUsers() == 'Y') ? "checked":"";
$priv_root_level_checked = ($edit_user->getPrivRootLevel() == 'Y') ? "checked":"";

$xtpl->assign('priv_own_users_checked', $priv_own_users_checked);
$xtpl->assign('priv_grant_own_users_checked', $priv_grant_own_users_checked);
$xtpl->assign('priv_root_level_checked', $priv_root_level_checked);


if($user->getPrivGrantOwnUsers() == 'Y')
	$xtpl->parse('edit_user.show_priv_own_users');
if($user->getPrivRootLevel() == 'Y')
	$xtpl->parse('edit_user.show_priv_grant_own_users');
if($user->getPrivRootLevel() == 'Y')
	$xtpl->parse('edit_user.show_priv_root_level');

$xtpl->assign('email_address', $edit_user->getEmailAddress());

$xtpl->parse('edit_user');
$xtpl->out('edit_user');
