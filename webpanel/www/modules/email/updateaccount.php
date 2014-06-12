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

// this is for updates.
if($email_id){
	$mail_account->getDataByEmailId($email_id);
	if(!$mail_account->count()){
		$fail []= 'Email account not found.';
	}

// This is our check for new accounts.
}else{
	if(isset($_REQUEST['user']) && $_REQUEST['user'] != ''){
		$email = $_REQUEST['user'].'@'.$mail_domain->getDomain(); // this is $_REQUEST['user']@$mail_domain->getDomain()
	}else{
		// username not set.
		$fail []= 'Email username was not set.';
	}

	$mail_account->getDataByEmail($email);
	if($mail_account->count()){
		$fail []= 'Email address '.$email.' already in use.';
	}

	// email cannot exceed 255 chars... database limitation... stupid long email address
	if(strlen($email) > 255){
		$fail []= 'Email address exceeds 255 characters... database limitation hit.';
	}

	$mail_account->setEmail($email);
}


// does password match re-password?
if(!isset($_REQUEST['password']) || !isset($_REQUEST['repassword']) || $_REQUEST['password'] != $_REQUEST['repassword']){
	$fail []= 'Problem with the password fields matching or being set.';
}

// Is password too short?
if(!isset($_REQUEST['password']) || strlen($_REQUEST['password']) < 8){
	$fail []= 'Email password is too short, must be at least 8 characters long.';
}

// did we fail? if so, parse errors.
if(count($fail)){
	foreach($fail as $reason){
		$xtpl->assign('action', $reason);
		$xtpl->parse('list.action');
	}


// if all is good... add it.
}else{
	$mail_account->setPassword($_REQUEST['password'], 'ENCRYPT');
	$mail_account->setDomain($mail_domain->getDomain());
	$mail_account->save();

	$xtpl->assign('action', 'Update for '.$mail_account->getEmail().' was successful.');
	$xtpl->parse('list.action');
	
}

$xtpl->assign('action', 'Click <a href="/email/manage/'.$domain_id.'">here</a> to go back to email account management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
