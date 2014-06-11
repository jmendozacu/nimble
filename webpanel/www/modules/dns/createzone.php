<?php
$user->loginRequired();

// something to note about mydns is that it really doesn't give a fuck
// http://knowyourmeme.com/memes/and-not-a-single-fuck-was-given-that-day

// lets begin.
// listening to: Cell Dweller - Retros
// Got that tron feel going

$xtpl->restart(BASEPATH.'/template/list.tpl');

// ensure there is period at end of zone
if(isset($_REQUEST['domainname']) && !preg_match('/\.$/i', $_REQUEST['domainname']))
	$origin = $_REQUEST['domainname'].'.';
else
	$origin = $_REQUEST['domainname'];

// do a lookup to see if the zone exists.
$zone = $db->openTable('dns_soa');
$zone->getDataByOrigin($origin);

// Check that our variables are filled in
if(!isset($_REQUEST['domainname']) || !isset($_REQUEST['email_address']) || !isset($_REQUEST['zone_ttl']) || $_REQUEST['domainname'] == "" || $_REQUEST['email_address'] == "" || $_REQUEST['zone_ttl'] == ""){
	// must fill out all fields... thank you
	$xtpl->assign('action', 'You must fill in all fields.');
	$xtpl->parse('list.action');

// make sure zone name is valid characters
}elseif(!preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $_REQUEST['domainname']) //valid chars check
		|| !preg_match("/^.{1,253}$/", $_REQUEST['domainname']) //overall length check
		|| !preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $_REQUEST['domainname'])){
	// your a dick.. I'm not accepting your zone entry. Good bye.
	$xtpl->assign('action', 'Zone name is not valid. Not creating the zone "'.$origin.'".');
	$xtpl->parse('list.action');

}elseif(!preg_match('/.*\..*/i', $_REQUEST['domainname']) && $user->getPrivRootLevel() != 'Y'){
	$xtpl->assign('action', 'You are not allowed to control TLDs. "'.$origin.'" not created.');
	$xtpl->parse('list.action');

// check to make sure zone does not already exist.
}elseif($zone->count()){
	// that zone already exists you DICK!
	$xtpl->assign('action', 'The zone "'.$origin.'" already exists.');
	$xtpl->parse('list.action');

// make sure dude is not dicking us with a ttl less than 3600
}elseif((int) $_REQUEST['zone_ttl'] < 3600){
	// unacceptable zone ttl. There is no reason for a zone to have a TTL less than 3360
	$xtpl->assign('action', 'The zone TTL you set is unreasonably short.');
	$xtpl->parse('list.action');

// create the zone
}else{

	// bitchin'

	$zone->setOrigin($origin);
	$zone->setTtl($_REQUEST['zone_ttl']);
	$zone->setNs(php_uname('n'));
	$zone->setMbox($_REQUEST['email_address']);
	$zone->setSystemUsername($user->getSystemUsername());
	$zone->save();

	$xtpl->assign('action', 'Created zone "'.$origin.'" successfully.');
	$xtpl->parse('list.action');
}

$xtpl->assign('pagename', 'DNS Management');

$xtpl->assign('action', 'Click <a href="/dns">here</a> to go back to DNS management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
