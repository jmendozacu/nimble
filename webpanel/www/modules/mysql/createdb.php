<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');


$xtpl->assign('pagename', 'Creating Database');

if(isset($_REQUEST['database']))
	$dbname = $user->getSystemUsername().'_'.$_REQUEST['database'];
else
	$dbname = false;

$db->prepare('dbname', $dbname);
$db->rawQuery("SHOW DATABASES LIKE '{dbname}'");

// make sure dbname is not false
if(!$dbname){
	$xtpl->assign('action', 'Failed to create database. No database name was set.');
	$xtpl->parse('list.action');

// make sure dbname does not exceed 64 characters
}elseif(strlen($dbname) > 64){
	$xtpl->assign('action', 'Failed to create database '.$dbname.'. Name is too long.');
	$xtpl->parse('list.action');

// check if dbname already exists
}elseif($db->count()){
	$xtpl->assign('action', 'Failed to create database '.$dbname.'. Already exists.');
	$xtpl->parse('list.action');

// check format
}elseif(!preg_match('/^[A-Za-z0-9_]+$/i', $dbname)){
	$xtpl->assign('action', 'Failed to create database '.$dbname.'. Can only contain characters "A-Za-z0-9_".');
	$xtpl->parse('list.action');

// all good? create it
}else{
	$db->prepare('dbname', $dbname);
	$db->rawQuery("CREATE DATABASE {dbname};", false);
	
	$xtpl->assign('action', 'Created database '.$dbname.'.');
	$xtpl->parse('list.action');

}

$xtpl->assign('action', 'Click <a href="/mysql">here</a> to go back.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
