<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/email/index.tpl');

$xtpl->parse('email');
$xtpl->out('email');
