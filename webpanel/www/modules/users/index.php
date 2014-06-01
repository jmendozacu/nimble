<?php
$user->loginRequired();



function iterate_owned_users($system_username){
	global $db;

	$owned_users = $db->openTable('users');
	$owned_users->getDataByOwnedBy($system_username);
	if($owned_users->count() == 0)
		return;

	do {
		echo $owned_users->getSystemUsername();
		iterate_owned_users($owned_users->getSystemUsername());
	}while($owned_users->next());
	
}

iterate_owned_users($user->getSystemUsername());
