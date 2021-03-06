<?php
// These are common functions used throughout the application

// this function is used to safely die/kill our scripts. It ensures postmodule_staging.php is ran
function die_safe($msg = ''){
	// Make sure all the variables we made are still available.
	// Extracting as references so changes will effect outside function
	extract($GLOBALS, EXTR_REFS | EXTR_SKIP);
	
	// If there is a dying message, say it!
	if ($msg != '')
		echo $msg;

	
	// ensure showing after page contents
	require_once(BASEPATH.'/lib/postmodule_staging.php');
	
	// Now we die!
	die;
}


// used to see what verbs we have
function debug_verbs(){
	extract($GLOBALS, EXTR_REFS | EXTR_SKIP);
	
	echo "<pre>Debugging info...\n\n \$mod_verbs contains \n\n";
	echo var_dump($mod_verbs);
	echo "</pre>";
}

function sanitize_path($dir){
	// Dirty pirate hookers trying to break the sandbox - We stop them
	$dir = preg_replace('/(\/\.\.$|\/\.\.\/)/i', '/', $dir);
	$dir = preg_replace('/\/$/i', '', $dir);
	$dir = preg_replace('/["\']/i', '', $dir);


	return $dir;
}

// Checks to make sure $dir is inside of $chdir.
function check_path($chdir, $dir){
	// Dirty pirate hookers trying to break the sandbox - We stop them
	$dir = sanitize_path($dir);

	// Prepage a regex safe copy of BASEPATH.'/modules/'
	$regex_safe_path = preg_quote($chdir, '/');

	// Compare our regex to $dir
	return preg_match('/^'.$regex_safe_path.'/', $dir);
}



// used to forcefully tell people to fuck off when they use too many verbs
function verb_limit($limit){
	extract($GLOBALS, EXTR_REFS | EXTR_SKIP);
	require_once(BASEPATH.'/modules/default/404.php');
	die_safe();
}
