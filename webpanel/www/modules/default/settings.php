<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/default/settings.tpl');
$xtpl->parse('settings');
$xtpl->out('settings');
