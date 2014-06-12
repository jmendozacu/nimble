<?php
$xtpl->restart(BASEPATH.'/template/list.tpl');

$user_lookup = $db->openTable('users');
$user_lookup->getDataBySystemUsername($_REQUEST['username']);

if($user_lookup->count()){
	if($user_lookup->getEmailAddress() != ""){
		if($user_lookup->getLoginToken() == ""){
			$user_lookup->setLoginToken(md5(rand(1,1000).date("U")));
			$user_lookup->save();
		}
		if($_SERVER['HTTPS'] == 'on')
			$URL = 'https://'.$_SERVER['HTTP_HOST'].'/default/resetpassword/'.$user_lookup->getNimbleId().'/'.$user_lookup->getLoginToken();
		else
			$URL = 'http://'.$_SERVER['HTTP_HOST'].'/default/resetpassword/'.$user_lookup->getNimbleId().'/'.$user_lookup->getLoginToken();

		// send a friendly welcome email?
		$subject = 'Nimble Password Recovery';
		$message =  "You or someone else has requested a password reset for your user: ".$user_lookup->getSystemUsername().". Below is a link that will remain valid for password reset until the next login occurs.\n\n";
		$message .= $URL."\n";
		$headers = 'X-Mailer: Nimble Control Panel';

		mail($user_lookup->getEmailAddress(), $subject, $message, $headers);


		$xtpl->assign('action', 'Sent message to email address listed.');
		$xtpl->parse('list.action');
	}else{
		$xtpl->assign('action', 'There is no email address on file for that user. Recovery failed.');
		$xtpl->parse('list.action');
	}

}else{
	$xtpl->assign('action', 'User not found.');
	$xtpl->parse('list.action');
}

$xtpl->assign('action', 'Click <a href="/">here</a> to go back to the login page..');
$xtpl->parse('list.action');

$xtpl->assign('pagename', 'Password Recovery');
$xtpl->parse('list');
$xtpl->out('list');

