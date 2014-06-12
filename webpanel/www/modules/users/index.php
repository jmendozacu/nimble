<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/users/index.tpl');

// check if we're adding a user
// do you have create permissions?
// does user already exist on the system?
// are you allowed to grant the perms?
// end new user check


function iterate_owned_users($system_username){
	global $db;
	global $xtpl;

	$owned_users = $db->openTable('users');
	$owned_users->getDataByOwnedBy($system_username);
	if($owned_users->count() == 0)
		return;

	do {
		$PERM_STRING = "";
		if($owned_users->getPrivOwnUsers() == 'Y')
			$PERM_STRING .= "O ";
		if($owned_users->getPrivGrantOwnUsers() == 'Y')
			$PERM_STRING .= "G ";
		if($owned_users->getPrivRootLevel() == 'Y')
			$PERM_STRING .= "R ";
		$xtpl->assign('permission_string', $PERM_STRING);
		$xtpl->assign('system_username',$owned_users->getSystemUsername());
		$xtpl->assign('nimble_id',$owned_users->getNimbleId());
		$xtpl->parse('users_interface.user_row');
		iterate_owned_users($owned_users->getSystemUsername());
	}while($owned_users->next());
	
}



if($user->getPrivRootLevel() == 'Y'){

	$owned_users = $db->openTable('users');
	$owned_users->getData();

	do {

		$PERM_STRING = "";
		if($owned_users->getPrivOwnUsers() == 'Y')
			$PERM_STRING .= "O ";
		if($owned_users->getPrivGrantOwnUsers() == 'Y')
			$PERM_STRING .= "G ";
		if($owned_users->getPrivRootLevel() == 'Y')
			$PERM_STRING .= "R ";
		$xtpl->assign('permission_string', $PERM_STRING);
		$xtpl->assign('system_username',$owned_users->getSystemUsername());
		$xtpl->assign('nimble_id',$owned_users->getNimbleId());
		$xtpl->parse('users_interface.user_row');

	}while($owned_users->next());

}else{

	iterate_owned_users($user->getSystemUsername());

}



$xtpl->parse('users_interface');
$xtpl->out('users_interface');
