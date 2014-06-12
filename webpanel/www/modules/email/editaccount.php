<?php
$user->loginRequired();

$domain_id = (isset($mod_verbs[2]))?$mod_verbs[2]:0;
$email_id = (isset($mod_verbs[3]))?$mod_verbs[3]:false;


$mail_domain = $db->openTable('mail_domains');
$mail_domain->getDataByDomainId($domain_id);

$mail_account = $db->openTable('mail_users');
$mail_account->getDataByEmailId($email_id);


if(!$mail_domain->count() || $mail_domain->getSystemUsername() != $user->getSystemUsername() || !$mail_account->count()){
	// not found || not your's so still not found.
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Email Management');
	$xtpl->assign('action', 'Account not found.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/email">here</a> to go back to email management.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}



$xtpl->restart(BASEPATH.'/template/email/editaccount.tpl');

$xtpl->assign('email', $mail_account->getEmail());
$xtpl->assign('email_id', $mail_account->getEmailId());
$xtpl->assign('domain_id', $mail_domain->getDomainId());

$xtpl->parse('editaccount');
$xtpl->out('editaccount');
