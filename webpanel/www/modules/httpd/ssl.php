<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/httpd/ssl.tpl');

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
$xtpl->assign('cur_ipaddr', $vhost->getIpaddr());


$ipaddr = $db->openTable('ipaddrs');
$ipaddr->getDataBySystemUsername($user->getSystemUsername());
if(!$ipaddr->count()){
	$xtpl->parse('edit_ssl.no_ips');
}else{
	do {
		$xtpl->assign('ipaddr',$ipaddr->getIpaddr());
		$xtpl->parse('edit_ssl.ip_select.ip_option');
	}while($ipaddr->next());
	$xtpl->parse('edit_ssl.ip_select');
}


$xtpl->parse('edit_ssl');
$xtpl->out('edit_ssl');
