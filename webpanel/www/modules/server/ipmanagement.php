<?php
$user->loginRequired();

if($user->getPrivRootLevel() != 'Y'){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Restricted');
	$xtpl->assign('action', 'You must have root permissions to access this page.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}



if(isset($_REQUEST['ipaddr'])){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Adding IP Address');

	$ipaddr = $db->openTable('ipaddrs');
	$ipaddr->getDataByIpaddr($_REQUEST['ipaddr']);

	// is it already in use?
	if($ipaddr->count()){
		$xtpl->assign('action', 'IP address already in use..');
		$xtpl->parse('list.action');
	// check length
	}elseif(strlen($_REQUEST['ipaddr']) > 16 || strlen($_REQUEST['ipaddr']) < 7){
		$xtpl->assign('action', 'IP address has inappropriate length.');
		$xtpl->parse('list.action');
	// add it
	}else{
		$ipaddr = $db->openTable('ipaddrs');
		$ipaddr->setIpaddr($_REQUEST['ipaddr']);
		$ipaddr->setSystemUsername($_REQUEST['username']);
		$ipaddr->save();

		$xtpl->assign('action', 'IP address added successfully.');
		$xtpl->parse('list.action');
	}

	$xtpl->assign('action', 'Click <a href="/server/ipmanagement">here</a> to go back.');
	$xtpl->parse('list.action');

	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}


if(isset($mod_verbs[2]) && $mod_verbs[2] == 'remove'){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'Removing IP Address');

	$ip = (isset($mod_verbs[3]) && $mod_verbs[3] != '')?$mod_verbs[3]:'0.0.0.0';

	$ipaddr = $db->openTable('ipaddrs');
	$ipaddr->getDataByIpaddr($ip);

	if($ipaddr->count()){
		// found it, now delete it
		$ipaddr->delete();
		$xtpl->assign('action', 'IP address '.$ip.' removed successfully.');
		$xtpl->parse('list.action');
	}else{
		// not found
		$xtpl->assign('action', 'IP address '.$ip.' not found.');
		$xtpl->parse('list.action');
	}

	$xtpl->assign('action', 'Click <a href="/server/ipmanagement">here</a> to go back.');
	$xtpl->parse('list.action');

	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}

$xtpl->restart(BASEPATH.'/template/server/ipmanagement.tpl');

$ipuser = $db->openTable('users');
$ipuser->getData();
do {
	$xtpl->assign('username', $ipuser->getSystemUsername());
	$xtpl->parse('ipmanagement.useroption');
}while($ipuser->next());


$ipaddr = $db->openTable('ipaddrs');
$ipaddr->getData();


if($ipaddr->count())
do {
	$xtpl->assign('ipaddr', $ipaddr->getIpaddr());
	$xtpl->assign('system_username', $ipaddr->getSystemUsername());
	$xtpl->parse('ipmanagement.row');
}while($ipaddr->next());

$xtpl->parse('ipmanagement');
$xtpl->out('ipmanagement');
