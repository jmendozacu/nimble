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

$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'MySQL Management');

if(strlen($_REQUEST['password']) <8){
	// password not long enough
	$xtpl->assign('action', 'New password is not long enough. Must be at least 8 characters long.');
	$xtpl->parse('list.action');
}elseif($_REQUEST['password'] != $_REQUEST['repassword']){
	// passwords don't match
	$xtpl->assign('action', 'New password and retyped copy of password did not match.');
	$xtpl->parse('list.action');
}else{
	$db->prepare('dbuser', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->prepare('password', $_REQUEST['password']);
	$db->rawQuery("SET PASSWORD FOR '{dbuser}'@'{hostname}' = PASSWORD('{password}');", false);

	$xtpl->assign('action', 'Updated password.');
	$xtpl->parse('list.action');

}

$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');

