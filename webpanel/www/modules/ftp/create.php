<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/ftp/create.tpl');

$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec();

$xtpl->assign('basedir', $homedir.'/ftp');

$xtpl->assign('system_username', $user->getSystemUsername());

$xtpl->parse('create_user');
$xtpl->out('create_user');
