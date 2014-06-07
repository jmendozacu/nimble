<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');

$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec().'/';
$documentroot = sanitize_path( $_REQUEST['documentroot']);

$fail = false;

// check if domain does already exists
$vhost = $db->openTable('vhosts');

if(isset($mod_verbs[2]))
	$vhost->getDataByVhostId($mod_verbs[2]);



if($vhost->count()){
	// if domain exists, does user own it?
	if($user->getSystemUsername() != $vhost->getSystemUsername()){
		$xtpl->assign('action','Domain '.$vhost->getDomain().' is owned by another user.');
		$xtpl->parse('list.action');
		$fail = true;
	}
}else{
	$xtpl->assign('action','Could not find domain...');
	$xtpl->parse('list.action');
	
	$fail = true;
}

// if all is good
if(!$fail){
	// add vhost to server /nimble/httpd/add_hostname {system_username} {hostname} {documentroot}
	$shell->cmd("sudo /nimble/httpd/delete_hostname {hostname}");
	$shell->prepare('hostname', $vhost->getDomain());
	$shell->exec();

	// add or update
	$vhost->delete();

	$xtpl->assign('action','Domain '.$vhost->getDomain().' deleted successful.');
	$xtpl->parse('list.action');
	
}

$xtpl->assign('pagename','Updating Domains');
$xtpl->assign('action','Click <a href="/httpd">here</a> to go back to domain managment.');
$xtpl->parse('list.action');
$xtpl->parse('list');
$xtpl->out('list');
