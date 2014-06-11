<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/dns/index.tpl');

$zones = $db->openTable('dns_soa');
$zones->getDataBySystemUsername($user->getSystemUsername());

if($zones->count()){
	do {
		$xtpl->assign('domainname', $zones->getOrigin());
		$xtpl->assign('domain_id', $zones->getId());
		$xtpl->parse('dns.row');
	}while($zones->next());
}else{
	$xtpl->parse('dns.no_rows');
}

$xtpl->parse('dns');
$xtpl->out('dns');
