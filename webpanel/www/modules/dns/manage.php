<?php
$user->loginRequired();

$dns_id = (isset($mod_verbs[2]))?$mod_verbs[2]:0;


$zone = $db->openTable('dns_soa');
$zone->getDataById($dns_id);

if($zone->count() && $zone->getSystemUsername() == $user->getSystemUsername()){
	$xtpl->restart(BASEPATH.'/template/dns/manage.tpl');

	$xtpl->assign('domainname', $zone->getOrigin());
	$xtpl->assign('domain_id', $zone->getId());
	$xtpl->assign('admin_email', $zone->getMbox());
	$xtpl->assign('ttl', $zone->getTtl());


	$records = $db->openTable('dns_rr');
	$records->getDataByZone($zone->getId());

	if($records->count()){
		do {
			$xtpl->assign('id', $records->getId());
			$xtpl->assign('name', $records->getName());
			$xtpl->assign('type', $records->getType());
			$xtpl->assign('aux', $records->getAux());
			$xtpl->assign('data', $records->get_data()); // have to avoid Proto::getData($query = '')
	
			$xtpl->assign('ttl', $records->getTtl());
			$xtpl->parse('dns.row');
		}while($records->next());
	}else{
		$xtpl->parse('dns.no_rows');
	}

	$xtpl->parse('dns');
	$xtpl->out('dns');

}else{
	$xtpl->restart(BASEPATH.'/template/list.tpl');

	$xtpl->assign('pagename', 'DNS Management');
	$xtpl->assign('action', 'Failed to find DNS records');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/dns">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
}

