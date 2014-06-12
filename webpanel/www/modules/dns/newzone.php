<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/dns/newzone.tpl');
$xtpl->parse('newzone');
$xtpl->out('newzone');
