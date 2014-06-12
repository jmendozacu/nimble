<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');


$xtpl->assign('pagename', 'Creating User');

if(isset($_REQUEST['dbuser']))
	$dbuser = $user->getSystemUsername().'_'.$_REQUEST['dbuser'];
else
	$dbuser = false;


if(isset($_REQUEST['hostname']) && preg_match('/^[A-Za-z0-9\%\._-]$/i', $_REQUEST['hostname'])){
	$hostname = $_REQUEST['hostname'];

	$db->prepare('dbuser', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->rawQuery("SELECT User, Host FROM mysql.user WHERE User = '{dbuser}' and Host = '{hostname}'");
}else{
	$hostname = false;
}
// make sure username is set
if(!$dbuser){
	$xtpl->assign('action', 'Failed to create user. No username was set.');
	$xtpl->parse('list.action');

// check if hostname was acceptable
}elseif(!$hostname){
	$xtpl->assign('action', 'Failed to create user "'.$dbuser.'". Hostname not acceptable.');
	$xtpl->parse('list.action');

// check if user exists
}elseif($db->count()){
	$xtpl->assign('action', 'Failed to create user "'.$dbuser.'@'.$hostname.'". User already exists.');
	$xtpl->parse('list.action');

// check if username is valid format
}elseif(!preg_match('/^[A-Za-z0-9_]+$/i', $dbuser)){
	$xtpl->assign('action', 'Failed to create user "'.$dbuser.'@'.$hostname.'". Username may only contain characters "A-Za-z0-9_".');
	$xtpl->parse('list.action');

// check if username is too long
}elseif(strlen($dbuser) > 16){
	$xtpl->assign('action', 'Failed to create user "'.$dbuser.'@'.$hostname.'". Username exceeds 16 characters long.');
	$xtpl->parse('list.action');

// make sure password is 8 or more characters long
}elseif(strlen($_REQUEST['password']) <8){
	$xtpl->assign('action', 'Failed to create user "'.$dbuser.'@'.$hostname.'". Password is less than 8 characters long');
	$xtpl->parse('list.action');

// make sure password matches retyped password
}elseif($_REQUEST['password'] != $_REQUEST['repassword']){
	$xtpl->assign('action', 'Failed to create user "'.$dbuser.'@'.$hostname.'". Password did not match retyped password.');
	$xtpl->parse('list.action');


// all good? create it
}else{
	$db->prepare('dbname', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->prepare('password', $_REQUEST['password']);
	$db->rawQuery("CREATE USER '{dbname}'@'{hostname}' IDENTIFIED BY '{password}';", false);
	
	$xtpl->assign('action', 'Created user '.$dbuser.'@'.$hostname);
	$xtpl->parse('list.action');

}

$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
