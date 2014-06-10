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





$xtpl->restart(BASEPATH.'/template/email/newaccount.tpl');

$xtpl->assign('domainname', $mail_domain->getDomain());
$xtpl->assign('domain_id', $mail_domain->getDomainId());

$xtpl->parse('newaccount');
$xtpl->out('newaccount');
