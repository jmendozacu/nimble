<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');

$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec().'/';
$documentroot = sanitize_path( $_REQUEST['documentroot']);

$fail = false;

// make sure $_REQUEST['documentroot'] is inside $homedir
if(!check_path($homedir, $documentroot)){
	$xtpl->assign('action','Document root "'.$documentroot.'" is not inside your home directory: '.$homedir);
	$xtpl->parse('list.action');
	
	$fail = true;
}
// check if domain does already exists
$vhost = $db->openTable('vhosts');

if(isset($mod_verbs[2]))
	$vhost->getDataByVhostId($mod_verbs[2]);
else
	$vhost->getDataByDomain($_REQUEST['domainname']);



if($user->getSystemUsername() == 'root'){
	$xtpl->assign('action','mod_ruid2 in apache cannot run as root. Try making a <a href="/users">user</a> to create domains.');
	$xtpl->parse('list.action');
	$fail = true;
}


if($vhost->count()){
	// if domain exists, does user own it?
	if($user->getSystemUsername() != $vhost->getSystemUsername()){
		$xtpl->assign('action','Domain '.$vhost->getDomain().' is already in use by another user.');
		$xtpl->parse('list.action');
		$fail = true;
	}
}else{

	// make sure domain looks VALID
	if(!preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $_REQUEST['domainname']) //valid chars check
        	    || !preg_match("/^.{1,253}$/", $_REQUEST['domainname']) //overall length check
	            || !preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $_REQUEST['domainname'])){
		$xtpl->assign('action','Domain '.$_REQUEST['domainname'].' is not valid.');
		$xtpl->parse('list.action');
		$fail = true;
	}else{
		$vhost->setDomain($_REQUEST['domainname']);
	}
}

// if all is good
if(!$fail){
	// make sure $documentroot exists: mkdir -p $documentroot
	$shell->cmd("sudo -u {system_username} mkdir -p {documentroot}");
	$shell->prepare('system_username', $user->getSystemUsername());
	$shell->prepare('documentroot', $documentroot);
	$shell->exec();

	// add vhost to server /nimble/httpd/add_hostname {system_username} {hostname} {documentroot}
	$shell->cmd("sudo /nimble/httpd/add_hostname {system_username} {hostname} {documentroot}");
	$shell->prepare('documentroot', $documentroot);
	$shell->prepare('system_username', $user->getSystemUsername());
	$shell->prepare('hostname', $vhost->getDomain());
	$shell->exec();


	// add or update
	$vhost->setSystemUsername($user->getSystemUsername());
	$vhost->setDocumentroot($documentroot);
	$vhost->setIpaddr('');
	$vhost->setSslEnabled('N');
	$vhost->setSslCertificate('');
	$vhost->setSslKey('');
	$vhost->setSslCaCertificate('');
	$vhost->save();
	$xtpl->assign('action','Domain '.$vhost->getDomain().' update successful.');
	$xtpl->parse('list.action');
	
}

$xtpl->assign('pagename','Updating Domains');
$xtpl->assign('action','Click <a href="/httpd">here</a> to go back to domain managment.');
$xtpl->parse('list.action');
$xtpl->parse('list');
$xtpl->out('list');
