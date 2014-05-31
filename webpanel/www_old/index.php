<?php
// WWWDIR is a constance used to identify the base directory of our webpanel
// This is needed throughout the app
define('WWWDIR', '/nimble/webpanel/www');

// used to make system calls
//     cmd - the command being ran through sudo
//     notrim - 0 is default, multiple spaces and new lines are removed. 
//              1 will disable behavior
function root_cmd($cmd, $notrim=0){
	if($notrim == 1)
		return shell_exec('sudo '.$cmd);
	else
		return trim(shell_exec('sudo '.$cmd));
}

// this function is used to safely die/kill our scripts
function die_safe($msg = ''){
	global $db;
	if ($msg != '')
		echo $msg;

	$db->close();
	die;
}

// include stuff in case we need it
require_once(WWWDIR.'/lib/xtpl/xtemplate.class.php');

// this is our database password. We're getting it from the nimble conf file /nimble/conf/mysql_password
$dbpass = root_cmd('cat /nimble/conf/mysql_password');


// Connect to our database
$db = new mysqli('localhost', 'nimble', $dbpass, 'nimble');

// or die trying
if ($db->connect_error)
	die('Connect Error ('.$db->connect_errno.') '.$db->connect_error);

// Page contents
// Everything is loaded from the /nimble/webpanel/www/modules directory.
// below we have some sanity checking for our catchall in the .htacess to load the correct files.
$mod_verbs = split('/', $_REQUEST['mod_verbs']);
$mod_page = null;


// if we have 2 verbs or more, we will only use the first 2 verbs. Verbs 3+ are for page action
if(count($mod_verbs) >= 2){
	$mod_page = WWWDIR.'/modules/'.$mod_verbs[0].'/'.$mod_verbs[1].'.php';
}

// If we have only 1 verb, index is assumed as 2nd verb OR if we couldn't find a verb2.php
// file, we assume it's an action verb for the page and look for index.php instead
if(count($mod_verbs) == 1 || !file_exists($mod_page)){
	$mod_page = WWWDIR.'/modules/'.$mod_verbs[0].'/index.php';
}

// if there are no verbs, we just load the default index page.
if($mod_verbs[0] == "")
	$mod_page = WWWDIR.'/modules/default/index.php';


// last check to make sure the page exists
if(file_exists($mod_page))
	require_once($mod_page);
// fucking 404's if it doesn't.
else
	require_once(WWWDIR.'/modules/default/404.php');

// Stop the connection to our db, we're done.
$db->close();
