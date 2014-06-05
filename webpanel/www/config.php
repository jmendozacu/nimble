<?php
// This is where our common config example is housed
// be sure to update the RewriteBase in .htaccess as needed.
$APP_CONF = array();

// Below are our MySQL settings if we initiate mysql in lib/premodule_staging.php and lib/postmodule_staging.php
// Preparing a statement to get the nimble password
$shell->cmd('sudo cat /nimble/conf/mysql_password');
// Setting our hostname
$APP_CONF['dbhost'] = 'localhost';
// Setting nimble username
$APP_CONF['dbuser'] = 'nimble';
// getting that magical password 
$APP_CONF['dbpass'] = $shell->exec();
// setting the username
$APP_CONF['dbname'] = 'nimble';
// optional
$APP_CONF['dbport'] = null;
$APP_CONF['dbsock'] = null;

// The module depth limit is the restricter for the module finder in index.php
// Default for this was set to 5. It prevents us from digging too deep into directories for our modules
$APP_CONF['MODULE_DEPTH_LIMIT'] = 5;

// Set the default timezone
// See: https://php.net/manual/en/timezones.america.php
date_default_timezone_set('America/New_York');
