<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/list.tpl');
$xtpl->assign('pagename', 'Deleting User');


$edit_user = $db->openTable('users');

if(!isset($mod_verbs[2])){
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}

$nimble_id = $mod_verbs[2];
$edit_user->getDataByNimbleId($nimble_id);
	
if($edit_user->count() == 0){
	$xtpl->assign('action','User not found. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}

$sysusername = $edit_user->getSystemUsername();

// check if this person is root or in the ownership tree...
if(!$edit_user->checkOwnership($user->getSystemUsername()) && $user->getPrivRootLevel() != 'Y'){
	$xtpl->assign('action','You do not have user ownership privileges over the selected user. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}elseif($edit_user->getSystemUsername() == 'root'){
	$xtpl->assign('action','Deleting the root user is probably not a good idea. Nimble is ignoring your request. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}else{ // all looked good


	// First we need to list everything to user and their sub users have...
	function remove_user($username){
		extract($GLOBALS, EXTR_REFS | EXTR_SKIP);

		$nimuser = $db->openTable('users');
		$nimuser->getDataBySystemUsername($username);

		if($nimuser->count()){
			$find_user = $db->openTable('users');
			$find_user->getDataByOwnedBy($username);
			if($find_user->count())
			do{
				remove_user($find_user->getSystemUsername());

			}while($find_user->next());

			// list mysql users
			$db->prepare('dbuser', $username);
			$db->rawQuery("SELECT User,Host FROM mysql.user WHERE User like '{dbuser}_%';");
			$drops = array();
			if($db->count())
			do {
				$drops []= array(
					'dbuser' => $db->get_User(),
					'hostname' => $db->get_Host()
				);
			}while($db->next());
	
			foreach($drops as $v){
				$db->prepare('dbuser', $v['dbuser']);
				$db->prepare('hostname', $v['hostname']);
				$db->rawQuery("DROP USER '{dbuser}'@'{hostname}';", false);
			}

			// list mysql databases
			$db->prepare('dbuser', $username);
			$db->rawQuery("show databases like '{dbuser}_%';");
			$drops = array();
			if($db->count())
			do {
				$drops []= $db->get_0();
			}while($db->next());
	
			foreach($drops as $dbname){
				$db->prepare('dbname', $dbname);
				$db->rawQuery("DROP DATABASE {dbname};", false);
			}

			// remove all ftp users
			$ftp_user = $db->openTable('ftpusers');
			$ftp_user->getDataBySystemUsername($username);
			if($ftp_user->count())
			do{
				// delete the linux user
				$shell->cmd('sudo userdel {username}');
				$shell->prepare('username', $ftp_user->getFtpusername());
				$shell->exec();

				$ftp_user->delete();
		
			}while($ftp_user->next());

			// remove all vhost stuff...
			$vhosts = $db->openTable('vhosts');
			$vhosts->getDataBySystemUsername($username);
			if($vhosts->count())
			do{
				$shell->cmd("sudo /nimble/httpd/delete_hostname {hostname}");
				$shell->prepare('hostname', $vhosts->getDomain());
				$shell->exec();

				$vhosts->delete();
			}while($vhosts->next());

			// remove all IP addresses from user
			$ipaddrs = $db->openTable('ipaddrs');
			$ipaddrs->getDataBySystemUsername($username);
			if($ipaddrs->count())
			do{
				$ipaddrs->delete();
			}while($ipaddrs->next());


			// remove all email stuff
			$email_domains = $db->openTable('mail_domains');
			$email_domains->getDataBySystemUsername($username);
			if($email_domains->count())
			do{
				$email_users = $db->openTable('mail_users');
				$email_users->getDataByDomain($email_domains->getDomain());
				if($email_users->count())
				do {
					// delete the email user
					$email_users->delete();
				}while($email_users->next());

				// delete the email domain
				$shell->cmd('sudo rm -rf /home/vmail/{domainname}');
				$shell->prepare('domainname', $email_domains->getDomain());
				$shell->exec();
				$email_domains->delete();
			}while($email_domains->next());

			// remove all dns stuff
			$dns_rr = $db->openTable('dns_rr');
			$dns_rr->getDataBySystemUsername($username);
			if($dns_rr->count())
			do{
				$dns_rr->delete();
			}while($dns_rr->next());

			// remove dns SOAs.
			$dns_soa = $db->openTable('dns_soa');
			$dns_soa->getDataBySystemUsername($username);
			if($dns_soa->count())
			do{
				$dns_soa->delete();
			}while($dns_soa->next());


			// delete the linux user
			$shell->cmd('sudo userdel --force --remove {username}');
			$shell->prepare('username', $username);
			$shell->exec();
	
			// delete the record of the user.
			$nimuser->delete();
		}

	}

	remove_user($edit_user->getSystemUsername());
	
	$xtpl->assign('action','Deleted the selected user. Click <a href="/users/">here</a> to go back.');
	$xtpl->parse('list.action');
}

	


$xtpl->parse('list');
$xtpl->out('list');
