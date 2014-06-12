<?php
$user->loginRequired();
$xtpl->restart(BASEPATH.'/template/email/newdomain.tpl');
$xtpl->parse('newdomain');
$xtpl->out('newdomain');
