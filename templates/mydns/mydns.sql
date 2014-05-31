-- Modified for nimble use
--
--  Table structure for table 'dns_soa' (zones of authority)
--
CREATE TABLE IF NOT EXISTS dns_soa (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  origin     CHAR(255) NOT NULL,
  ns         CHAR(255) NOT NULL,
  mbox       CHAR(255) NOT NULL,
  serial     INT UNSIGNED NOT NULL default '1',
  refresh    INT UNSIGNED NOT NULL default '28800',
  retry      INT UNSIGNED NOT NULL default '7200',
  expire     INT UNSIGNED NOT NULL default '604800',
  minimum    INT UNSIGNED NOT NULL default '86400',
  ttl        INT UNSIGNED NOT NULL default '86400',
  sysuser    VARCHAR(32),
  UNIQUE KEY (origin)
) Engine=InnoDB;

--
--  Table structure for table 'dns_rr' (resource records)
--
CREATE TABLE IF NOT EXISTS dns_rr (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  zone       INT UNSIGNED NOT NULL,
  name       CHAR(200) NOT NULL,
  data       VARBINARY(128) NOT NULL,
  aux        INT UNSIGNED NOT NULL,
  ttl        INT UNSIGNED NOT NULL default '86400',
  type       ENUM('A','AAAA','ALIAS','CNAME','HINFO','MX','NAPTR','NS','PTR','RP','SRV','TXT'),
  sysuser    VARCHAR(32),
  UNIQUE KEY rr (zone,name,type,data)
) Engine=InnoDB;
