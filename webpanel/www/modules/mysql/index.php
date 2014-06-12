<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/mysql/index.tpl');
$xtpl->assign('system_username', $user->getSystemUsername());

$db->prepare('dbuser', $user->getSystemUsername());
$db->prepare('dbuserhost', 'localhost');
$db->rawQuery("show databases like '{dbuser}_%';");

if($db->count()){
	// list databases
	do{
		$xtpl->assign('database', $db->get_0());
		$xtpl->parse('mysql.dbrow');
	}while($db->next());
}else{
	// no databases
	$xtpl->parse('mysql.no_dbrows');
}



$db->prepare('dbuser', $user->getSystemUsername());
$db->prepare('dbuserhost', 'localhost');
$db->rawQuery("SELECT User,Host FROM mysql.user WHERE User like '{dbuser}_%';");

if($db->count()){
	// list databases
	do{
		$xtpl->assign('dbuser', $db->get_0());
		$xtpl->assign('dbhost', $db->get_1());
		$xtpl->assign('dbuser_url', urlencode($db->get_0()));
		$xtpl->assign('dbhost_url', urlencode($db->get_1()));
		$xtpl->parse('mysql.dbuserrow');
	}while($db->next());
}else{
	// no databases
	$xtpl->parse('mysql.no_dbuserrows');
}

$xtpl->parse('mysql');
$xtpl->out('mysql');
