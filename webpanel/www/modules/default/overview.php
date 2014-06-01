<?php
// login required
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/default/overview.tpl');

$xtpl->parse('overview');
$xtpl->out('overview');
