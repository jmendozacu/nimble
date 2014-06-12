<?php
$user->loginRequired();
$xtpl->restart(BASEPATH.'/template/list.tpl');

$mail_domain = $db->openTable('mail_domains');
$mail_domain->getDataByDomain($_REQUEST['domainname']);
// check if domain is already in use
if($mail_domain->count()){
	$xtpl->assign('action', 'Domain '.$_REQUEST['domainname'].' is already in use.');
	$xtpl->parse('list.action');
	
// make sure domain name looks valid
}elseif(!preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $_REQUEST['domainname']) //valid chars check
	|| !preg_match("/^.{1,253}$/", $_REQUEST['domainname']) //overall length check
	|| !preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $_REQUEST['domainname'])){

	$xtpl->assign('action', 'Domain '.$_REQUEST['domainname'].' does not look valid.');
	$xtpl->parse('list.action');

// all looks good, add it
}else{
	$mail_domain->setDomain($_REQUEST['domainname']);
	$mail_domain->setSystemUsername($user->getSystemUsername());

	$mail_domain->save();

	$xtpl->assign('action', 'Domain '.$_REQUEST['domainname'].' added.');
	$xtpl->parse('list.action');
}


$xtpl->assign('pagename', 'Adding Email Domain');
$xtpl->assign('action', 'Click <a href="/email">here</a> to go back to email manamgent.');
$xtpl->parse('list.action');
$xtpl->parse('list');
$xtpl->out('list');

