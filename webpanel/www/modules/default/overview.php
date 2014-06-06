<?php
// login required
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/default/overview.tpl');

if($user->getPrivOwnUsers() == 'Y')
	$xtpl->parse('overview.usermanagement');

$xtpl->parse('overview');
$xtpl->out('overview');
