<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/httpd/create.tpl');

$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec();

$xtpl->assign('homedir', $homedir);

$xtpl->parse('create_vhost');
$xtpl->out('create_vhost');
