<?php
$user->loginRequired();

$domain_id = (isset($mod_verbs[2]))?$mod_verbs[2]:false;
$email_id = (isset($mod_verbs[3]))?$mod_verbs[3]:false;

$mail_domain = $db->openTable('mail_domains');
$mail_domain->getDataByDomainId($domain_id);


$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'Email Management');

if(!$mail_domain->count() || $mail_domain->getSystemUsername() != $user->getSystemUsername()){
	// not found || not your's so still not found.
	$fail []= 'Domain selected was not found.';
}

$fail = array();



$mail_account = $db->openTable('mail_users');

$mail_account->getDataByEmailId($email_id);
if(!$mail_account->count()){
	$fail []= 'Email account not found.';
}


// did we fail? if so, parse errors.
if(count($fail)){
	foreach($fail as $reason){
		$xtpl->assign('action', $reason);
		$xtpl->parse('list.action');
	}


// if all is good... add it.
}else{
	// delete the virtual box
	$email_user = split('@', $mail_account->getEmail());
	$email_user = $email_user[0];
	$shell->cmd('sudo rm -rf /home/vmail/{domainname}/{email_user}');
	$shell->prepare('domainname', $mail_domain->getDomain());
	$shell->prepare('email_user', $email_user);
	$shell->exec();
	

	$mail_account->delete();

	$xtpl->assign('action', $mail_account->getEmail().' deleted successfully.');
	$xtpl->parse('list.action');
	
}

$xtpl->assign('action', 'Click <a href="/email/manage/'.$domain_id.'">here</a> to go back to email account management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
