<?php

$username = addslashes($_REQUEST['username']);
$password = addslashes($_REQUEST['password']);

$check = root_cmd('testsaslauthd -u "'.$username.'" -p "'.$password.'" -s password-auth');

$check = split(" ", $check);

if($check[1] == "OK"){
	echo 'System username and password for '.$username.' accepted.';
	
}else{
	echo 'Login attempt failed.';
}
