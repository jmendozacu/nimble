<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');

$dbname  = (isset($mod_verbs[2]))?$mod_verbs[2]:0;

$xtpl->assign('pagename', 'Deleting Database');

$db->prepare('dbname', $dbname);
$db->rawQuery("SHOW DATABASES LIKE '{dbname}'");

// make sure dbname is not false
if(!$dbname){
	$xtpl->assign('action', 'Failed to delete database. No database name was set.');
	$xtpl->parse('list.action');

// make sure it belongs to you
}elseif(!preg_match('/^'.preg_quote($user->getSystemUsername(),'/').'_/i', $dbname)){
	$xtpl->assign('action', 'Failed to delete database '.$dbname.'. Does not belong to you.');
	$xtpl->parse('list.action');

// check if dbname already exists
}elseif(!$db->count()){
	$xtpl->assign('action', 'Failed to delete database '.$dbname.'. Does not exists.');
	$xtpl->parse('list.action');

// check format
}elseif(!preg_match('/^[A-Za-z0-9_]+$/i', $dbname)){
	$xtpl->assign('action', 'Failed to delete database '.$dbname.'. Can only contain characters "A-Za-z0-9_".');
	$xtpl->parse('list.action');

// all good? create it
}else{
	$db->prepare('dbname', $dbname);
	$db->rawQuery("DROP DATABASE {dbname};", false);
	
	$xtpl->assign('action', 'Deleted database '.$dbname.'.');
	$xtpl->parse('list.action');

}

$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
