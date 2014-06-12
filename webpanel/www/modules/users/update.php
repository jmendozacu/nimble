<?php
// TODO: lots of copy/paste code needs to be cleaned up. This was adapted from new.php... so yeah.
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'Updating User');


if($user->getPrivOwnUsers() != 'Y' && $user->getPrivRootLevel() != 'Y'){
	$xtpl->assign('action','You do not have user ownership privileges. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');
	die_safe();
}

$priv_own_users = (isset($_REQUEST['priv_own_users'])) ? "Y":"N";
$priv_grant_own_users = (isset($_REQUEST['priv_grant_own_users'])) ? "Y":"N";
$priv_root_level = (isset($_REQUEST['priv_root_level'])) ? "Y":"N";

$email_address = $_REQUEST['email_address'];
$send_emai = isset($_REQUEST['send_email']);


$creation_errors = array();


$edit_user = $db->openTable('users');

if(isset($mod_verbs[2])){
	$nimble_id = $mod_verbs[2];
	$edit_user->getDataByNimbleId($nimble_id);
	
	if($edit_user->count() == 0){
		$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
		$xtpl->parse('list.action');
		$xtpl->parse('list');
		$xtpl->out('list');
		die_safe();
	}
	$sysusername = $edit_user->getSystemUsername();

	// check if this person is root or in the ownership tree...
	if(!$edit_user->checkOwnership($user->getSystemUsername()) && $user->getPrivRootLevel() != 'Y'){
		$xtpl->assign('action','You do not have user ownership privileges over the selected user. Click <a href="/users/">here</a> to go back.');
		$xtpl->parse('list.action');
		$xtpl->parse('list');
		$xtpl->out('list');
		die_safe();
	}

}else{
	$sysusername = $_REQUEST['username'];

	// check if username is free
	$shell->cmd('sudo getent passwd {username}');
	$shell->prepare('username', $_REQUEST['username']);
	$check_exists = $shell->exec();
	if($check_exists != "")
		$creation_errors[] = 'User "'.$_REQUEST['username'].'" already exists.';

	if(strlen($_REQUEST['username']) > 8)
		$creation_errors[] = 'Username is limited to no more than 8 characters in length.';
}


// check if we can + own users
if($user->getPrivGrantOwnUsers() != 'Y' && $priv_own_users == 'Y')
	$creation_errors[] = 'Failed to grant nimble permission +O';

// check if we can + grant own users
if($user->getPrivRootLevel() != 'Y' && $priv_grant_own_users == 'Y')
	$creation_errors[] = 'Failed to grant nimble permission +G';

// check if we can + grant own users
if($user->getPrivRootLevel() != 'Y' && $priv_root_level == 'Y')
	$creation_errors[] = 'Failed to grant nimble permission +R';

// does the email look valid? If not, fuck off
if(isset($_REQUEST['email_address']) && strlen($_REQUEST['email_address']) > 0){
	if(preg_match('/^[a-z0-9_+.]{1,64}@([a-z0-9-.]*){1,}\.[a-z]{1,5}$/i', $_REQUEST['email_address'])){
		// send a friendly welcome email?
		$subject = 'New Nimble Account Created';
		$message =  "Your nimble username and password are below.\n\n";
		$message .= "Username: ".$_REQUEST['username']."\n";
		$message .= "Password: ".$_REQUEST['password']."\n";
		$headers = 'X-Mailer: Nimble Control Panel';

		mail($_REQUEST['email_address'], $subject, $message, $headers);
	}else{
		$creation_errors[] = 'Email is not valid.';
	}
}

if(!isset($_REQUEST['password']) || !isset($_REQUEST['retype_password']) || $_REQUEST['password'] != $_REQUEST['retype_password']){
	$creation_errors[] = 'Problem with the password and retyped password. If failed the match check.';
}

$len_check = array();
if($edit_user->count() == 0)
	$len_check['username'] = 3;
if($edit_user->count() == 0 && $_REQUEST['password'] != "")
	$len_check['password'] = 3;

foreach($len_check as $key => $len){
	if(strlen($_REQUEST[$key]) < $len){
		$creation_errors[] = 'Something you typed in was too short to be reasonable.';
		break;
	}
}

// Try to create the user...
if(count($creation_errors) == 0){
	if($edit_user->count() == 0){
		// useradd {username}
		$shell->cmd('sudo useradd {username}');
		$shell->prepare('username', $_REQUEST['username']);
		$shell->exec();

		// check that new user was created
		$shell->cmd('sudo getent passwd {username}');
		$shell->prepare('username', $_REQUEST['username']);
		$check_exists = ($shell->exec() == "")?false:true;
	}else{
		$check_exists = true;
	}

	if(!$check_exists){
		$creation_errors[] = 'Failed to create "'.$_REQUEST['username'].'"... system conflict... try a different name.';
	}else{
		// if it was created, passwd --stdin
		$shell->cmd('echo {password} | sudo passwd {username} --stdin');
		$shell->prepare('username', $sysusername);
		$shell->prepare('password', $_REQUEST['password']);
		if($_REQUEST['password'] != ""){
			$shell->exec();
			$edit_user->setLoginToken(md5(rand(1,1000).date('U')));
		}
	}
	
}

if(count($creation_errors) > 0){
	foreach($creation_errors as $err){
		$xtpl->assign('action', $err);
		$xtpl->parse('list.action');
	}
}else{
	// 

	// done, lets make this newbie~
	$edit_user->setSystemUsername($sysusername);
	$edit_user->setPrivOwnUsers($priv_own_users);
	$edit_user->setPrivGrantOwnUsers($priv_grant_own_users);
	$edit_user->setPrivRootLevel($priv_root_level);
	if($edit_user->count() == 0){
		$edit_user->setOwnedBy($user->getSystemUsername());
		$edit_user->setLoginToken(md5(rand(1,1000).date('U')));
	}
	$edit_user->setEmailAddress($email_address);
	$edit_user->save();


	$xtpl->assign('action', 'Modifications for '.$sysusername.' were successful.');
	$xtpl->parse('list.action');
}


$xtpl->assign('action', 'Click <a href="/users/">here</a> to return to user management.');
$xtpl->parse('list.action');

$xtpl->parse('list');
$xtpl->out('list');
