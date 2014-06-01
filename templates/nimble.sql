-- MySQL dump 10.13  Distrib 5.6.17, for Linux (x86_64)
--
-- Host: localhost    Database: nimble
-- ------------------------------------------------------
-- Server version	5.6.17


--
-- Table structure for table `dns_rr`
--

DROP TABLE IF EXISTS `dns_rr`;
CREATE TABLE `dns_rr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zone` int(10) unsigned NOT NULL,
  `name` char(200) NOT NULL,
  `data` varbinary(128) NOT NULL,
  `aux` int(10) unsigned NOT NULL,
  `ttl` int(10) unsigned NOT NULL DEFAULT '86400',
  `type` enum('A','AAAA','ALIAS','CNAME','HINFO','MX','NAPTR','NS','PTR','RP','SRV','TXT') DEFAULT NULL,
  `system_username` varchar(32) DEFAULT NULL,
  `vhost_document_root` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rr` (`zone`,`name`,`type`,`data`),
  KEY `system_username` (`system_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `dns_soa`
--

DROP TABLE IF EXISTS `dns_soa`;
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

--
-- Table structure for table `mail_domains`
--

DROP TABLE IF EXISTS `mail_domains`;
CREATE TABLE `mail_domains` (
  `domain` varchar(255) NOT NULL,
  PRIMARY KEY (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `mail_forwardings`
--

DROP TABLE IF EXISTS `mail_forwardings`;
CREATE TABLE `mail_forwardings` (
  `source` varchar(80) NOT NULL,
  `destination` text NOT NULL,
  `domain` varchar(200) NOT NULL,
  PRIMARY KEY (`source`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `mail_transport`
--

DROP TABLE IF EXISTS `mail_transport`;
CREATE TABLE `mail_transport` (
  `domain` varchar(128) NOT NULL DEFAULT '',
  `transport` varchar(128) NOT NULL DEFAULT '',
  UNIQUE KEY `domain` (`domain`),
  KEY `domain_2` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `mail_users`
--

DROP TABLE IF EXISTS `mail_users`;
CREATE TABLE `mail_users` (
  `email` varchar(80) NOT NULL,
  `password` varchar(20) NOT NULL,
  `domain` varchar(200) NOT NULL,
  PRIMARY KEY (`email`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `nimble_users`
--

DROP TABLE IF EXISTS `nimble_users`;
CREATE TABLE `nimble_users` (
  `nimble_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_username` varchar(32) NOT NULL,
  `priv_own_users` enum('Y','N') NOT NULL,
  `priv_grant_own_users` enum('Y','N') NOT NULL,
  `priv_root_level` enum('Y','N') NOT NULL,
  `owned_by` varchar(32) NOT NULL,
  `login_token` varchar(32) NOT NULL,
  PRIMARY KEY (`nimble_id`),
  KEY `owned_by` (`owned_by`),
  KEY `system_username` (`system_username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Dump completed on 2014-06-01  8:07:48
