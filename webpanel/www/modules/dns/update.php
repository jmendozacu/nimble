<?php
$user->loginRequired();

$acceptable_dns_types = array('A', 'AAAA', 'MX', 'CNAME', 'HINFO', 'SRV', 'TXT', 'NS', 'PTR', 'ALIAS', 'RP');

$dns_id = (isset($mod_verbs[2]))?$mod_verbs[2]:0;

$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'DNS Management');

$zone = $db->openTable('dns_soa');
$zone->getDataById($dns_id);

if($zone->count() && $zone->getSystemUsername() == $user->getSystemUsername()){
	$xtpl->restart(BASEPATH.'/template/list.tpl');

	$xtpl->assign('domainname', $zone->getOrigin());
	$xtpl->assign('domain_id', $zone->getId());
	$xtpl->assign('admin_email', $zone->getMbox());
	$xtpl->assign('ttl', $zone->getTtl());


	$records = $db->openTable('dns_rr');
	$records->getDataByZone($zone->getId());

	if($records->count()){
		do{
			$urecord = $_REQUEST['record'][$records->getId()];

			// was delete checked?
			if(isset($urecord['delete'])){

				$xtpl->assign('action', 'Deleting record "'.$records->getName().'".');
				$xtpl->parse('list.action');
				$records->delete();

			// check the type
			}elseif(!in_array($urecord['type'], $acceptable_dns_types)){
				$xtpl->assign('action', 'Failed to update record "'.$records->getName().'". Unacceptable type selected.');
				$xtpl->parse('list.action');
				

			// check to make sure aux has a numeric value
			}elseif(!is_numeric($urecord['aux'])){

				$xtpl->assign('action', 'Failed to update record "'.$records->getName().'". Priority was not a numeric value.');
				$xtpl->parse('list.action');

			// check to make sure ttl is no less than 300
			}elseif(!is_numeric($urecord['ttl']) || $urecord['ttl'] < 300){
				$xtpl->assign('action', 'Failed to update record "'.$records->getName().'". TTL was less than 300 seconds. That is unreasonable.');
				$xtpl->parse('list.action');

			// save the changes
			}else{

				$records->setName($urecord['name']);
				$records->setData($urecord['data']);
				$records->setType($urecord['type']);
				$records->setAux($urecord['aux']);
				$records->setTtl($urecord['ttl']);
				$records->save();

				$xtpl->assign('action', 'Saved record "'.$urecord['name'].'".');
				$xtpl->parse('list.action');
			}
		}while($records->next());
	}

	// new records
	if(isset($_REQUEST['new_record']) && is_array($_REQUEST['new_record']))
	foreach($_REQUEST['new_record'] as $urecord){

		// was delete checked?
		if(isset($urecord['delete'])){

			$xtpl->assign('action', 'Ignoring new record "'.$urecord['name'].'".');
			$xtpl->parse('list.action');

		// check the type
		}elseif(!in_array($urecord['type'], $acceptable_dns_types)){
			$xtpl->assign('action', 'Failed to save new record "'.$urecord['name'].'". Unacceptable type selected.');
			$xtpl->parse('list.action');
			

		// check to make sure aux has a numeric value
		}elseif(!is_numeric($urecord['aux'])){
			$xtpl->assign('action', 'Failed to save new record "'.$urecord['name'].'". Priority was not a numeric value.');
			$xtpl->parse('list.action');

		// check to make sure ttl is no less than 300
		}elseif(!is_numeric($urecord['ttl']) || $urecord['ttl'] < 300){
			$xtpl->assign('action', 'Failed to save new record "'.$urecord['name'].'". TTL was less than 300 seconds. That is unreasonable.');
			$xtpl->parse('list.action');

		// save the changes
		}else{

			$record = $db->openTable('dns_rr');
			$record->setZone($dns_id);
			$record->setName($urecord['name']);
			$record->setData($urecord['data']);
			$record->setType($urecord['type']);
			$record->setAux($urecord['aux']);
			$record->setTtl($urecord['ttl']);
			$record->save();

			$xtpl->assign('action', 'Saved new record "'.$urecord['name'].'".');
			$xtpl->parse('list.action');
		}

	}
}else{
	$xtpl->assign('action', 'Failed to find DNS records');
	$xtpl->parse('list.action');
}


$xtpl->assign('action', 'Click <a href="/dns/manage/'.$dns_id.'">here</a> to go back.');
$xtpl->parse('list.action');
$xtpl->parse('list');
$xtpl->out('list');

