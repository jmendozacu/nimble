<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/ftp/index.tpl');

// check if we're adding a user
// do you have create permissions?
// does user already exist on the system?
// are you allowed to grant the perms?
// end new user check




$ftpusers = $db->openTable('ftpusers');
$ftpusers->getDataBySystemUsername($user->getSystemUsername());

if($ftpusers->count()){
	do {

		$xtpl->assign('username',$ftpusers->getFtpusername());
		$xtpl->assign('homedir',$ftpusers->getHomedir());
		$xtpl->assign('ftpuser_id',$ftpusers->getFtpuserId());
		$xtpl->parse('ftpusers.row');

	}while($ftpusers->next());
}else{
	// no ftp users
	$xtpl->parse('ftpusers.no_rows');
}



$xtpl->parse('ftpusers');
$xtpl->out('ftpusers');
