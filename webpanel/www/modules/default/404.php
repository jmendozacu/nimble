<?php
header("HTTP/1.0 404 Not Found");


$xtpl->restart(BASEPATH.'/template/404.tpl');
$xtpl->parse('404');
$xtpl->out('404');
