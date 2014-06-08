CREATE TABLE `dns_rr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zone` int(10) unsigned NOT NULL,
  `name` char(200) NOT NULL,
  `data` varbinary(128) NOT NULL,
  `aux` int(10) unsigned NOT NULL,
  `ttl` int(10) unsigned NOT NULL DEFAULT '86400',
  `type` enum('A','AAAA','ALIAS','CNAME','HINFO','MX','NAPTR','NS','PTR','RP','SRV','TXT') DEFAULT NULL,
  `system_username` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rr` (`zone`,`name`,`type`,`data`),
  KEY `system_username` (`system_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `dns_soa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `origin` char(255) NOT NULL,
  `ns` char(255) NOT NULL,
  `mbox` char(255) NOT NULL,
  `serial` int(10) unsigned NOT NULL DEFAULT '1',
  `refresh` int(10) unsigned NOT NULL DEFAULT '28800',
  `retry` int(10) unsigned NOT NULL DEFAULT '7200',
  `expire` int(10) unsigned NOT NULL DEFAULT '604800',
  `minimum` int(10) unsigned NOT NULL DEFAULT '86400',
  `ttl` int(10) unsigned NOT NULL DEFAULT '86400',
  `system_username` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `origin` (`origin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `mail_domains` (
  `domain` varchar(255) NOT NULL,
  PRIMARY KEY (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `mail_forwardings` (
  `source` varchar(80) NOT NULL,
  `destination` text NOT NULL,
  `domain` varchar(200) NOT NULL,
  PRIMARY KEY (`source`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `mail_transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(128) NOT NULL DEFAULT '',
  `transport` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`),
  KEY `domain_2` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `mail_users` (
  `email` varchar(80) NOT NULL,
  `password` varchar(20) NOT NULL,
  `domain` varchar(200) NOT NULL,
  PRIMARY KEY (`email`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `nimble_ipaddr` (
  `ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_username` varchar(32) NOT NULL,
  `ipaddr` varchar(16) NOT NULL,
  PRIMARY KEY (`ip_id`),
  UNIQUE KEY `system_username_2` (`system_username`),
  KEY `system_username` (`system_username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
CREATE TABLE `nimble_users` (
  `nimble_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_username` varchar(32) NOT NULL,
  `priv_own_users` enum('Y','N') NOT NULL,
  `priv_grant_own_users` enum('Y','N') NOT NULL,
  `priv_root_level` enum('Y','N') NOT NULL,
  `owned_by` varchar(32) NOT NULL,
  `login_token` varchar(32) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`nimble_id`),
  KEY `owned_by` (`owned_by`),
  KEY `system_username` (`system_username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
CREATE TABLE `website_vhosts` (
  `vhost_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_username` varchar(32) NOT NULL,
  `domain` varchar(254) NOT NULL,
  `documentroot` text NOT NULL,
  `ipaddr` varchar(16) NOT NULL,
  `ssl_certificate` longtext NOT NULL,
  `ssl_key` longtext NOT NULL,
  `ssl_ca_certificate` longtext NOT NULL,
  PRIMARY KEY (`vhost_id`),
  KEY `domain` (`domain`),
  KEY `system_username` (`system_username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
