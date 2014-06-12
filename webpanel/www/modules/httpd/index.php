<?php
$user->loginRequired();

// THINGS:
// - update vhosts (ssl optional)
// - delete vhosts

$xtpl->restart(BASEPATH.'/template/httpd/index.tpl');

$vhost = $db->openTable('vhosts');

$vhost->getDataBySystemUsername($user->getSystemUsername());


if($vhost->count()){
	do {
		$xtpl->assign('vhost_id', $vhost->getVhostId());
		$xtpl->assign('domain', $vhost->getDomain());
		$xtpl->assign('documentroot', $vhost->getDocumentroot());
		$xtpl->parse('httpd_interface.vhost_row');
	}while($vhost->next());
}else{
	$xtpl->parse('httpd_interface.no_vhosts');
}

$xtpl->parse('httpd_interface');
$xtpl->out('httpd_interface');
