<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/users/create.tpl');

if($user->getPrivGrantOwnUsers() == 'Y')
	$xtpl->parse('create_user.show_priv_own_users');
if($user->getPrivRootLevel() == 'Y')
	$xtpl->parse('create_user.show_priv_grant_own_users');
if($user->getPrivRootLevel() == 'Y')
	$xtpl->parse('create_user.show_priv_root_level');

$xtpl->parse('create_user');
$xtpl->out('create_user');
