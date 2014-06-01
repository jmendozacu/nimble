<?php
$user->loginRequired();



function iterate_owned_users($system_username){
	global $db;
	global $xtpl;

	$owned_users = $db->openTable('users');
	$owned_users->getDataByOwnedBy($system_username);
	if($owned_users->count() == 0)
		return;

	do {
		echo $owned_users->getSystemUsername();
		iterate_owned_users($owned_users->getSystemUsername());
	}while($owned_users->next());
	
}



if($user->getPrivRootLevel() == 'Y'){

	$owned_users = $db->openTable('users');
	$owned_users->getData();

	do {

		echo $owned_users->getSystemUsername();

	}while($owned_users->next());

}else{

	iterate_owned_users($user->getSystemUsername());

}
