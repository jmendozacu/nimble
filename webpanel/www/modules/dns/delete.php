<?php
$user->loginRequired();

// Listening to: Cell Dweller - Unshakeable
// Bitchin' - Lets make a delete feature.

$xtpl->restart(BASEPATH.'/template/list.tpl');

// Initialize some potentially missing variables.
$zone_id = (isset($mod_verbs[2]))?$mod_verbs[2]:0;

// Check if the user owns the selected zone
$zone = $db->openTable('dns_soa');
$zone->getDataById($zone_id);

if(!$zone->count() || $zone->getSystemUsername() != $user->getSystemUsername()){
	// This is obviously not yours...
	$xtpl->assign('action', 'Zone not found.');
	$xtpl->parse('list.action');
}else{
	// Delete the zone and the records. NOHESITATION!
	$records = $db->openTable('dns_rr');
	$records->getDataByZone($zone_id);

	if($records->count())
	do {
		$records->delete();
	}while($records->next());
	$zone->delete();

	$xtpl->assign('action', 'Zone "'.$zone->getOrigin().'" deleted.');
	$xtpl->parse('list.action');
}


$xtpl->assign('pagename', 'DNS Management');

$xtpl->assign('action', 'Click <a href="/dns">here</a> to go back to DNS management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');

