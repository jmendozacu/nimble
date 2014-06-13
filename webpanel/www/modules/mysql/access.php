<?php
$user->loginRequired();

$dbname  = (isset($mod_verbs[2]))?$mod_verbs[2]:0;
$revoke_dbuser  = (isset($mod_verbs[3]))?$mod_verbs[3]:false;


$db->prepare('database', $dbname);
$db->rawQuery("show databases like '{database}';");

// make sure database exists
if(!$db->count()){
	// database does not exist.
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'MySQL Management');
	$xtpl->assign('action', 'Database not found.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}


// make sure user owns database
if(!preg_match('/^'.preg_quote($user->getSystemUsername(),'/').'_/i', $dbname)){
	// Maury says you're not the father
	$xtpl->restart(BASEPATH.'/template/list.tpl');
	$xtpl->assign('pagename', 'MySQL Management');
	$xtpl->assign('action', 'Database not found.');
	$xtpl->parse('list.action');
	$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}



$xtpl->restart(BASEPATH.'/template/mysql/access.tpl');


// add a new user if requested...
if(isset($_REQUEST['dbuser']) && preg_match('/^'.preg_quote($user->getSystemUsername(),'/').'_/i', $_REQUEST['dbuser'])){
	$split = split('@', $_REQUEST['dbuser']);
	$dbuser = $split[0];
	$hostname = $split[1];

	$db->prepare('dbuser', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->rawQuery("SELECT User, Host FROM mysql.user WHERE User = '{dbuser}' and Host = '{hostname}'");

	// if user exists, carry on
	if($db->count()){
		$db->prepare('dbuser', $dbuser);
		$db->prepare('hostname', $hostname);
		$db->prepare('dbname', $dbname);
		$db->rawQuery("GRANT ALL ON {dbname}.* TO '{dbuser}'@'{hostname}'", false);
		$db->rawQuery("FLUSH PRIVILEGES", false);
	}
}

// remove a user if requested
if($revoke_dbuser && preg_match('/^'.preg_quote($user->getSystemUsername(),'/').'_/i', $revoke_dbuser)){
	$split = split('@', $revoke_dbuser);
	$dbuser = $split[0];
	$hostname = $split[1];
	$db->prepare('dbuser', $dbuser);
	$db->prepare('hostname', $hostname);
	$db->rawQuery("SELECT User, Host FROM mysql.user WHERE User = '{dbuser}' and Host = '{hostname}'");

	// if user exists, carry on
	if($db->count()){
		$db->prepare('dbuser', $dbuser);
		$db->prepare('hostname', $hostname);
		$db->prepare('dbname', $dbname);
		$db->rawQuery("REVOKE ALL ON {dbname}.* FROM '{dbuser}'@'{hostname}'", false);
		$db->rawQuery("FLUSH PRIVILEGES", false);
	}
}

$xtpl->assign('dbname', $dbname);

// list all the users with permissions.
$db->prepare('database', $dbname);
$db->rawQuery("SELECT * FROM mysql.db WHERE Db='{database}';");

if($db->count()){
	do{
		$xtpl->assign('dbuser', $db->get_User());
		$xtpl->assign('hostname', $db->get_Host());
		$xtpl->assign('dbuser_url', urlencode($db->get_User()));
		$xtpl->assign('hostname_url', urlencode($db->get_Host()));
		$xtpl->parse('mysqlaccess.row');
	}while($db->next());
}else{
	$xtpl->parse('mysqlaccess.no_rows');
}



// list all the available users
$db->prepare('dbuser', $user->getSystemUsername());
$db->prepare('dbuserhost', 'localhost');
$db->rawQuery("SELECT User,Host FROM mysql.user WHERE User like '{dbuser}_%';");


if($db->count()){
	// list database users
	do{
		$xtpl->assign('dbuser', $db->get_0());
		$xtpl->assign('hostname', $db->get_1());
		$xtpl->parse('mysqlaccess.dbuser');
	}while($db->next());
}else{
	// no databases
	$xtpl->parse('mysqlaccess.no_dbuser');
}


$xtpl->parse('mysqlaccess');
$xtpl->out('mysqlaccess');
