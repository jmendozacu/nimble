<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/email/index.tpl');

$domains = $db->openTable('mail_domains');
$domains->getDataBySystemUsername($user->getSystemUsername());

if($domains->count()){
	do {
		$xtpl->assign('domainname', $domains->getDomain());
		$xtpl->assign('domain_id', $domains->getDomainId());
		$xtpl->parse('email.row');
	}while($domains->next());
}else{
	$xtpl->parse('email.no_rows');
}

$xtpl->parse('email');
$xtpl->out('email');
