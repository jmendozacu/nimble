<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');


$xtpl->assign('pagename', 'Deleting User');

if(isset($mod_verbs[2]))
	$dbuser = $mod_verbs[2];
else
	$dbuser = false;

if(isset($mod_verbs[3]) && preg_match('/^[A-Za-z0-9\%\._-]$/i', $mod_verbs[3])){
	$hostname = $mod_verbs[3];

	$db->prepare('dbuser', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->rawQuery("SELECT User, Host FROM mysql.user WHERE User = '{dbuser}' and Host = '{hostname}'");
}else{
	$hostname = false;
}

// make sure username is set
if(!$dbuser){
	$xtpl->assign('action', 'Failed to delete user. No username was set.');
	$xtpl->parse('list.action');

// check if hostname was acceptable
}elseif(!$hostname){
	$xtpl->assign('action', 'Failed to delete user "'.$dbuser.'". Hostname not acceptable.');
	$xtpl->parse('list.action');

// make sure you own user
}elseif(!preg_match('/^'.preg_quote($user->getSystemUsername(),'/').'_/i', $dbuser)){
	$xtpl->assign('action', 'Failed to delete user "'.$dbuser.'@'.$hostname.'". User not owned by you.');
	$xtpl->parse('list.action');

// check if user exists
}elseif(!$db->count()){
	$xtpl->assign('action', 'Failed to delete user "'.$dbuser.'@'.$hostname.'". User doest not exist.');
	$xtpl->parse('list.action');

// check if username is valid format
}elseif(!preg_match('/^[A-Za-z0-9_]+$/i', $dbuser)){
	$xtpl->assign('action', 'Failed to delete user "'.$dbuser.'@'.$hostname.'". Username may only contain characters "A-Za-z0-9_".');
	$xtpl->parse('list.action');


// all good? delete it
}else{
	$db->prepare('dbname', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->rawQuery("DROP USER '{dbname}'@'{hostname}';", false);
	
	$xtpl->assign('action', 'Deleted user '.$dbuser.'@'.$hostname);
	$xtpl->parse('list.action');

}

$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
