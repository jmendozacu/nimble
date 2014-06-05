<?php
$user->loginRequired();
if($user->getPrivOwnUsers() != 'Y' && $user->getPrivRootLevel())
	die_safe('You do not have permission to create users.');



$sysusername = $_REQUEST['username'];

$priv_own_users = (isset($_REQUEST['priv_own_users'])) ? "Y":"N";
$priv_grant_own_users = (isset($_REQUEST['priv_grant_own_users'])) ? "Y":"N";
$priv_root_level = (isset($_REQUEST['priv_root_level'])) ? "Y":"N";

$email_address = $_REQUEST['email_address'];
$send_emai = isset($_REQUEST['send_email']);


$creation_errors = array();

// check if username is free
$shell->cmd('sudo getent passwd {username}');
$shell->prepare('username', $_REQUEST['username']);
$check_exists = $shell->exec();
if($check_exists != "")
	$creation_errors[] = 'User "'.$_REQUEST['username'].'" already exists.';

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


$len_check = array(
		'username' => 3,
		'password' => 3
);

foreach($len_check as $key => $len){
	if(strlen($_REQUEST[$key]) < $len){
		$creation_errors[] = 'Something you typed in was too short to be reasonable.';
		break;
	}
}

// Try to create the user...
if(count($creation_errors) == 0){
	// useradd {username}
	$shell->cmd('sudo useradd {username}');
	$shell->prepare('username', $_REQUEST['username']);
	$shell->exec();

	// check that new user was created
	$shell->cmd('sudo getent passwd {username}');
	$shell->prepare('username', $_REQUEST['username']);
	$check_exists = $shell->exec();
	if($check_exists == ""){
		$creation_errors[] = 'Failed to create "'.$_REQUEST['username'].'"... system conflict... try a different name.';
	}else{
		// if it was created, passwd --stdin
		$shell->cmd('echo {password} | sudo passwd {username} --stdin');
		$shell->prepare('username', $_REQUEST['username']);
		$shell->prepare('password', $_REQUEST['password']);
		$shell->exec();
	}
	
}

if(count($creation_errors) > 0){
	foreach($creation_errors as $err){
		echo $err."<br>";
	}
}else{
	// 

	// done, lets make this newbie~
	$new_user = $db->openTable('users');
	$new_user->setSystemUsername($sysusername);
	$new_user->setPrivOwnUsers($priv_own_users);
	$new_user->setPrivGrantOwnUsers($priv_grant_own_users);
	$new_user->setPrivRootLevel($priv_root_level);
	$new_user->setOwnedBy($user->getSystemUsername());
	$new_user->setLoginToken(md5(rand(1,1000).date('U')));
	$new_user->setEmailAddress($email_address);
	$new_user->save();
}
