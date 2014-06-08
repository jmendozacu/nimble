<?php
// login required
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/default/overview.tpl');

if($user->getPrivOwnUsers() == 'Y')
	$xtpl->parse('overview.usermanagement');

if($user->getPrivRootLevel() == 'Y')
	$xtpl->parse('overview.root_controls');

$xtpl->parse('overview');
$xtpl->out('overview');
