<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/mysql/newdbuser.tpl');
$xtpl->assign('system_username', $user->getSystemUsername());
$xtpl->parse('newdbuser');
$xtpl->out('newdbuser');
