<?php
$user->loginRequired();

$domain_id = (isset($mod_verbs[2]))?$mod_verbs[2]:0;

$mail_domain = $db->openTable('mail_domains');
$mail_domain->getDataByDomainId($domain_id);


if(!$mail_domain->count() || $mail_domain->getSystemUsername() != $user->getSystemUsername()){
	// not found || not your's so still not found.
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Email Management');
	$xtpl->assign('action', 'Domain selected was not found.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/email">here</a> to go back to email management.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}



$domain = $mail_domain->getDomain();

$xtpl->restart(BASEPATH.'/template/list.tpl');

$mail_users = $db->openTable('mail_users');
$mail_users->getDataByDomain($mail_domain->getDomain());

if($mail_users->count()){
	do {
		$mail_users->delete();
	}while($mail_users->next());
}

// delete the virtual boxes
$shell->cmd('sudo rm -rf /home/vmail/{domainname}');
$shell->prepare('domainname', $mail_domain->getDomain());
$shell->exec();

$mail_domain->delete();

$xtpl->assign('pagename', 'Deleting Email Domain');

$xtpl->assign('action', 'Deleted '.$domain.' and all associated email settings/files.');
$xtpl->parse('list.action');

$xtpl->assign('action', 'Click <a href="/email">here</a> to go back to email management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
