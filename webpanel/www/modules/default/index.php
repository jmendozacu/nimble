<?php
$xtpl->restart(BASEPATH.'/template/default/index.tpl');

if($user->loggedIn())
	header('Location: /default/overview');


$xtpl->parse('login');
$xtpl->out('login');

