<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/httpd/edit.tpl');

$vhost = $db->openTable('vhosts');
$vhost->getDataByVhostId($mod_verbs[2]);
if(!$vhost->count() || $vhost->getSystemUsername() != $user->getSystemUsername()){
	$xtpl->restart(BASEPATH.'/template/list.tpl');

	$xtpl->assign('action', 'Domain not found. Click <a href="/users/">here</a> to return to user management.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');

	die_safe();
}


$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec();

$xtpl->assign('vhost_id', $vhost->getVhostId());
$xtpl->assign('domainname', $vhost->getDomain());
$xtpl->assign('documentroot', $vhost->getDocumentroot());
$xtpl->assign('homedir', $homedir);

$xtpl->parse('edit_vhost');
$xtpl->out('edit_vhost');
