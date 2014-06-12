<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'Updating User');


$edit_user = $db->openTable('ftpusers');

// check if we are editing or creating based on existence of mod_verb[2]
if(isset($mod_verbs[2])){
	$ftp_userid = $mod_verbs[2];
	$edit_user->getDataByFtpuserId($ftp_userid);
	$ftpusername = $edit_user->getFtpusername();

	$action = 'updating';
}else{ // creating new user
	$ftpusername = $user->getSystemUsername().'_'.$_REQUEST['username'];

	// for to check if username is free
	$shell->cmd('sudo getent passwd {username}');
	$shell->prepare('username', $ftpusername);
	$check_exists = $shell->exec();

	// so we know what we're doing in the if statements
	$action = 'creating';
}

// for to do homedir check
$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec().'/';
if($action == 'creating')
	$ftp_homedir = sanitize_path( $_REQUEST['homedir']);


// if updating, make sure user exists
if($action == 'updating' && !$edit_user->count()){
	$xtpl->assign('action','Invalid user selected.');
	$xtpl->parse('list.action');

// if updating, check if user is owned by system_username
}elseif($action == 'updating' && $edit_user->getSystemUsername() != $user->getSystemUsername()){
	$xtpl->assign('action','Invalid user selected.');
	$xtpl->parse('list.action');

// if creating, check if system user available
}elseif($action == 'creating' && $check_exists != ""){
	$xtpl->assign('action','Username already taken.');
	$xtpl->parse('list.action');

// if creating, check username length
}elseif($action == 'creating' && (strlen($ftpusername) > 32 || $_REQUEST['username'] = "")){
	$xtpl->assign('action','Username can not exceed 32 characters long.');
	$xtpl->parse('list.action');

// check home directory
}elseif($action == 'creating' && !check_path($homedir, $ftp_homedir)){
	$xtpl->assign('action','Selected home directory is invalid. Perhaps it is outside of your home directory?');
	$xtpl->parse('list.action');

// check password
}elseif($_REQUEST['password'] != $_REQUEST['retype_password']){
	$xtpl->assign('action','Passwords did not match.');
	$xtpl->parse('list.action');

}elseif(strlen($_REQUEST['password']) < 8){
	$xtpl->assign('action','Password must be at least 8 characters long.');
	$xtpl->parse('list.action');

// update the user if all is fine
}else{
	// lets make a cake.
	if($action == 'creating'){
		// get user's uid and gid
		$shell->cmd('getent passwd {username}');
		$shell->prepare('username', $user->getSystemUsername());
		$userinfo = $shell->exec();
		$userinfo = split(':', $userinfo);
		$system_userid = $userinfo[2];
		$system_groupid = $userinfo[3];

		// make sure the directory exists...
		$shell->cmd("sudo -u {system_username} mkdir -p {ftp_homedir}");
		$shell->prepare('system_username', $user->getSystemUsername());
		$shell->prepare('ftp_homedir', $ftp_homedir);
		$shell->exec();

		// useradd {username} -g {gid} -u {uid} -d {ftp_homedir} -o
		$shell->cmd('sudo useradd {username} -g {gid} -u {uid} -d {ftp_homedir} -s /sbin/nologin -o');
		$shell->prepare('username', $ftpusername);
		$shell->prepare('uid', $system_userid);
		$shell->prepare('gid', $system_groupid);
		$shell->prepare('ftp_homedir', $ftp_homedir);
		$shell->exec();

	}

	// check that new user was created
	$shell->cmd('sudo getent passwd {username}');
	$shell->prepare('username', $ftpusername);
	$created = ($shell->exec() == "")?false:true;

	// now we do the actual updating bits.
	if($created == ""){
		$xtpl->assign('action','Failed to update ftp user '.$ftpusername.'.');
		$xtpl->parse('list.action');
		
	}else{
		// if it exists, passwd --stdin
		$shell->cmd('echo {password} | sudo passwd {username} --stdin');
		$shell->prepare('username', $ftpusername);
		$shell->prepare('password', $_REQUEST['password']);
		if($_REQUEST['password'] != ""){
			$shell->exec();
		}

		// we only do this when creating a new user.
		if($action == 'creating'){
			$edit_user->setFtpusername($ftpusername);
			$edit_user->setSystemUsername($user->getSystemUsername());
			$edit_user->setHomedir($ftp_homedir);
			$edit_user->save();
		}

		$xtpl->assign('action','Updated ftp user '.$ftpusername.' successfully.');
		$xtpl->parse('list.action');
	}


}

$xtpl->assign('action', 'Click <a href="/ftp/">here</a> to return to FTP user management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
