<?php
// This file is ran before any module is ran. It is used to setup our environment.
// See {BASEPATH}/lib/postmodule_staging.php for everything that runs after execution


// used to make system calls... needed throughout everything
//     cmd - the command being ran through sudo
//     notrim - 0 is default, multiple spaces and new lines are removed. 
//              1 will disable behavior
function root_cmd($cmd, $notrim=0){
	if($notrim == 1)
		return shell_exec('sudo '.$cmd);
	else
		return trim(shell_exec('sudo '.$cmd));
}


// include your libraries that are needed throughout the site here
// My config file houses my app settings to be used globally.
require_once(BASEPATH.'/config.php');

// database abstraction layer
require_once(BASEPATH.'/lib/proto/proto.class.php');

// templating system
require_once(BASEPATH.'/lib/xtpl/xtemplate.class.php');

// My global_functions file houses common functions I may need.
require_once(BASEPATH.'/lib/global_functions.php');

// Make sure magic quotes don't fudge things up... because #fuckMagicQuotes
if(get_magic_quotes_gpc())
	die_safe('You have magic quotes turned on. Disable it, we have our own sanity built in.');
	
// If we have a database, connect to it here
$db = new Proto($APP_CONF['dbhost'], $APP_CONF['dbuser'], $APP_CONF['dbpass'], $APP_CONF['dbname'], $APP_CONF['dbport'], $APP_CONF['dbsock']);
if ($db->linker->connect_error)
	die('Connect Error ('.$db->linker->connect_errno.') '.$db->linker->connect_error);

if($db->linker->server_version < 50600)
	die_safe("The MySQL server must be at least version 5.6.");

// buffer content
ob_start();

// begin content display with our header
$xtpl = new XTemplate(BASEPATH.'/template/overall.tpl');


$xtpl->parse('header');
$xtpl->out('header');
