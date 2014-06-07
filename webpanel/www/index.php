<?php
// Lets begin
// BASEPATH is used throughout the app to get the app home directory.
define('BASEPATH', realpath(dirname(__FILE__)));

// We can use sessions. Yay.
ini_set('session.save_path', BASEPATH.'/cache/sessions/');
session_save_path(BASEPATH.'/cache/sessions/');
session_start();


// This will be ran before all modules are ran.
require_once(BASEPATH.'/lib/premodule_staging.php');

// Page contents
// Everything is loaded from the BASEPATH directory.
// below we have some sanity checking for our catchall in the .htacess to load the correct files.
if(isset($_REQUEST['mod_verbs']))
	$mod_verbs = explode('/', $_REQUEST['mod_verbs']);
else
	$mod_verbs = array('');

$mod_page = null;

// Figure out our path...
// Get a count of verbs to build the directory tree
$verb_count = count($mod_verbs);
// restrict directory tree to no more than 5 directories in
if($verb_count > $APP_CONF['MODULE_DEPTH_LIMIT'])
	$verb_count = $APP_CONF['MODULE_DEPTH_LIMIT'];

// BEGIN: module finder
// Build directory tree...
$dirtree = BASEPATH.'/modules/';
for($c=0;$c<$verb_count;$c++){
	$verb = $mod_verbs[$c];
	
	// test $dirtree/$verb/index.php
	$treetest = $dirtree.$verb.'/index.php';
	if(file_exists($treetest)){
		$mod_page = $treetest;
	}
	
	// test $dirtree/$verb.php
	$treetest = $dirtree.$verb.'.php';
	if(file_exists($treetest)){
		$mod_page = $treetest;
	}
	
	// test on in $dirtree/$verb/
	$dirtree .= $mod_verbs[$c].'/';
}
// END: module finder


// Module safety patrol
// Dirty pirate hookers trying to break the sandbox - We stop them
$mod_page = realpath($mod_page);
// Prepage a regex safe copy of BASEPATH.'/modules/'
$regex_safe_path = preg_quote(BASEPATH.'/modules/', '/');
// Compare our regex to $mod_page
$directory_restriction_check = preg_match('/^'.$regex_safe_path.'/', $mod_page);
// Match our regulare expression or get the 404 page!
if(!$directory_restriction_check){
	$mod_page = BASEPATH.'/modules/default/404.php';
}
// END: Module safety patrol


// if there are no verbs, we just load the default index page.
if($mod_verbs[0] == "")
	$mod_page = BASEPATH.'/modules/default/index.php';

// last check to make sure the page exists
// or 404's if it doesn't exist!
if(file_exists($mod_page)){
	require_once($mod_page);
}else{
	require_once(BASEPATH.'/modules/default/404.php');
}

// This will be ran ever every page is shown
require_once(BASEPATH.'/lib/postmodule_staging.php');
