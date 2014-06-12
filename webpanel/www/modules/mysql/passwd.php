<?php
$user->loginRequired();

$dbuser = (isset($mod_verbs[2]))?$mod_verbs[2]:false;
$hostname = (isset($mod_verbs[3]))?$mod_verbs[3]:false;

// check if user exists.
$db->prepare('dbuser', $dbuser);
$db->prepare('hostname', $hostname);
$db->rawQuery("SELECT User, Host FROM mysql.user WHERE User = '{dbuser}' and Host = '{hostname}'");

if(!$dbuser || !$hostname || !preg_match('/^'.preg_quote($user->getSystemUsername(),'/').'_/i', $dbuser) || !$db->count()){
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'MySQL Management');
	$xtpl->assign('action', 'No user selected.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();

}



$xtpl->restart(BASEPATH.'/template/mysql/passwd.tpl');
$xtpl->assign('dbuser', $dbuser);
$xtpl->assign('hostname', $hostname);
$xtpl->assign('dbuser_url', urlencode($dbuser));
$xtpl->assign('hostname_url', urlencode($hostname));
$xtpl->parse('passwd');
$xtpl->out('passwd');
