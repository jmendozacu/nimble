<?php
$user->loginRequired();

$xtpl->restart(BASEPATH.'/template/httpd/ssl.tpl');

$vhost = $db->openTable('vhosts');
$vhost->getDataByVhostId($mod_verbs[2]);
if(!$vhost->count() || $vhost->getSystemUsername() != $user->getSystemUsername()){
	$xtpl->restart(BASEPATH.'/template/list.tpl');

	$xtpl->assign('action', 'Domain not found. Click <a href="/users/">here</a> to return to user management.');
	$xtpl->parse('list.action');
	$xtpl->parse('list');
	$xtpl->out('list');

	die_safe();
}

// Updating SSL stuff
if($_SERVER['REQUEST_METHOD'] == "POST"){
	// remove all whitespacing in key, cert, and ca cert
	$sslkey = trim($_REQUEST['sslkey']);
	$sslcertificate = trim($_REQUEST['sslcertificate']);
	$sslcacertificate = trim($_REQUEST['sslcacertificate']);

	$sslkey_res = openssl_pkey_get_private($sslkey);
	$sslcertificate_res = openssl_pkey_get_public($sslcertificate);
	$sslcacertificate_res = openssl_pkey_get_public($sslcacertificate);

	if($sslkey_res)
		$sslkey_data = openssl_pkey_get_details($sslkey_res);

	if($sslcertificate_res)
		$sslcertificate_data = openssl_pkey_get_details($sslcertificate_res);
	
	if($sslcacertificate_res)
		$sslcacertificate_data = openssl_pkey_get_details($sslcacertificate_res);




	// check if we can use IP selected
	$ipaddr = $db->openTable('ipaddrs');
	$ipaddr->getDataByIpaddr($_REQUEST['ipaddr']);



	if(!$ipaddr->count()){
		$xtpl->assign('action', 'Invalid selection for IP address.');
		$xtpl->parse('edit_ssl.action');

	// check if key is encrypted
	}elseif(preg_match('/encrypted/i', $sslkey)){
		$xtpl->assign('action', 'Your SSL key has a passphrase. Can not use it with server configuration.');
		$xtpl->parse('edit_ssl.action');

	// make sure key and cert are pair
	}elseif(!isset($sslkey_data['rsa']) || !isset($sslcertificate_data['rsa']) || md5($sslcertificate_data['rsa']['n']) != md5($sslkey_data['rsa']['n'])){

		$xtpl->assign('action', 'Your SSL key and SSL certificate modulus does not seem to match.');
		$xtpl->parse('edit_ssl.action');

	// check the ca certificate file
	}elseif($sslcacertificate != "" && !isset($sslcacertificate_data['rsa'])){

		$xtpl->assign('action', 'Was unable to confirm that the CA Certificate was valid cert.');
		$xtpl->parse('edit_ssl.action');

	// enable it
	}else{

		file_put_contents(BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.crt', $sslcertificate);
		file_put_contents(BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.ca.crt', $sslcacertificate);
		file_put_contents(BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.key', $sslkey);

		$shell->cmd('sudo chown root:root {certfile} {cacertfile} {certkeyfile}');
		$shell->prepare('certfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.crt');
		$shell->prepare('cacertfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.ca.crt');
		$shell->prepare('certkeyfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.key');
		$shell->exec();

		$shell->cmd('sudo chmod 600 {certfile} {cacertfile} {certkeyfile}');
		$shell->prepare('certfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.crt');
		$shell->prepare('cacertfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.ca.crt');
		$shell->prepare('certkeyfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.key');
		$shell->exec();

		$shell->cmd('sudo mv -f {certfile} /etc/pki/tls/certs/{domainname}.crt');
		$shell->prepare('certfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.crt');
		$shell->prepare('domainname', $vhost->getDomain());
		$shell->exec();

		$shell->cmd('sudo mv -f {cacertfile} /etc/pki/tls/certs/{domainname}.ca.crt');
		$shell->prepare('cacertfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.ca.crt');
		$shell->prepare('domainname', $vhost->getDomain());
		$shell->exec();

		$shell->cmd('sudo mv -f {certkeyfile} /etc/pki/tls/private/{domainname}.key');
		$shell->prepare('certkeyfile', BASEPATH.'/cache/ssl_holding.'.$user->getSystemUsername().'.key');
		$shell->prepare('domainname', $vhost->getDomain());
		$shell->exec();

		$vhost->setSslCaCertificate($sslcacertificate);
		$vhost->setSslCertificate($sslcertificate);
		$vhost->setSslKey($sslkey);

		if(isset($_REQUEST['ssl_enabled'])){
			// enable ssl
			$vhost->setIpaddr($ipaddr->getIpaddr());
			$vhost->setSslEnabled('Y');

			$shell->cmd('sudo /nimble/httpd/add_hostname_ssl {username} {hostname} {documentroot} {ipaddr}');
			$shell->prepare('username', $user->getSystemUsername());
			$shell->prepare('hostname', $vhost->getDomain());
			$shell->prepare('documentroot', $vhost->getDocumentroot());
			$shell->prepare('ipaddr', $vhost->getIpaddr());
			$shell->exec();

		}else{
			// disable it
			$vhost->setIpaddr('');
			$vhost->setSslEnabled('N');

			$shell->cmd('/nimble/httpd/delete_hostname_sslonly {hostname}');
			$shell->prepare('hostname', $vhost->getDomain());
			$shell->exec();
		}

		$vhost->save();

		$xtpl->assign('action', 'Updated SSL data. Click <a href="/httpd">here</a> to go back to domain management.');
		$xtpl->parse('edit_ssl.action');
	}
}

$shell->cmd("getent passwd {username} | awk -F: '{print $6}'");
$shell->prepare('username', $user->getSystemUsername());
$homedir = $shell->exec();

if($vhost->getSslEnabled() == 'Y')
	$xtpl->assign('ssl_enabled', 'checked');

$xtpl->assign('vhost_id', $vhost->getVhostId());
$xtpl->assign('domainname', $vhost->getDomain());
$xtpl->assign('cur_ipaddr', $vhost->getIpaddr());

$xtpl->assign('sslcertificate', $vhost->getSslCertificate());
$xtpl->assign('sslkey', $vhost->getSslKey());
$xtpl->assign('sslcacertificate', $vhost->getSslCaCertificate());

$ipaddr = $db->openTable('ipaddrs');
$ipaddr->getDataBySystemUsername($user->getSystemUsername());
if(!$ipaddr->count()){
	$xtpl->parse('edit_ssl.no_ips');
}else{
	if($vhost->getIpaddr() == "")
		$xtpl->assign('noip_selected', 'selected');
	else
		$xtpl->assign('noip_selected', '');
	do {
		if($ipaddr->getIpaddr() == $vhost->getIpaddr())
			$xtpl->assign('selected', 'selected');
		else
			$xtpl->assign('selected', '');
		$xtpl->assign('ipaddr',$ipaddr->getIpaddr());
		$xtpl->parse('edit_ssl.ip_select.ip_option');
	}while($ipaddr->next());
	$xtpl->parse('edit_ssl.ip_select');
}


$xtpl->parse('edit_ssl');
$xtpl->out('edit_ssl');
