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


$xtpl->assign('domainname', $mail_domain->getDomain());
$xtpl->assign('domain_id', $mail_domain->getDomainId());

$xtpl->restart(BASEPATH.'/template/email/manage.tpl');

$mail_users = $db->openTable('mail_users');
$mail_users->getDataByDomain($mail_domain->getDomain());

if($mail_users->count()){
	do {
		// show a row.
		$xtpl->assign('email_id', $mail_users->getEmailId());
		$xtpl->assign('email', $mail_users->getEmail());
		$xtpl->parse('email.row');
	}while($mail_users->next());
}else{
	// no mail users
	$xtpl->parse('email.no_rows');
}

$xtpl->parse('email');
$xtpl->out('email');
