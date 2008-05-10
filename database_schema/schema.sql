-- MySQL dump 10.11
--
-- Host: localhost    Database: phpscheduleit
-- ------------------------------------------------------
-- Server version	5.0.37-community-nt

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `userid` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) default NULL,
  `email` varchar(75) NOT NULL,
  `userpassword` varchar(45) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `phone` varchar(16) default NULL,
  `institution` varchar(255) default NULL,
  `positionname` varchar(100) default NULL,
  `timezonename` varchar(50) NOT NULL,
  `lastlogin` datetime default NULL,
  `legacypassword` varchar(32) default NULL,
  `legacyid` char(16) default NULL,
  `homepageid` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  USING BTREE (`userid`),
  KEY `user_username` (`username`),
  KEY `user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `accountrole`
--

DROP TABLE IF EXISTS `accountrole`;
CREATE TABLE `accountrole` (
  `accountroleid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL,
  `isadmin` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`accountroleid`),
  KEY `accountrole_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `additional_resources`
--

DROP TABLE IF EXISTS `additional_resources`;
CREATE TABLE `additional_resources` (
  `resourceid` char(16) NOT NULL,
  `name` varchar(75) NOT NULL,
  `status` char(1) NOT NULL default 'a',
  `number_available` int(11) NOT NULL default '-1',
  PRIMARY KEY  (`resourceid`),
  KEY `ar_name` (`name`),
  KEY `ar_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
CREATE TABLE `announcement` (
  `announcementid` int(10) unsigned NOT NULL auto_increment,
  `announcement_text` varchar(255) NOT NULL,
  `order_number` smallint(6) NOT NULL default '0',
  `start_datetime` datetime default NULL,
  `end_datetime` datetime default NULL,
  PRIMARY KEY  (`announcementid`),
  KEY `announcements_startdatetime` (`start_datetime`),
  KEY `announcements_enddatetime` (`end_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `announcementid` char(16) NOT NULL,
  `announcement` varchar(255) NOT NULL default '',
  `number` smallint(6) NOT NULL default '0',
  `start_datetime` int(11) default NULL,
  `end_datetime` int(11) default NULL,
  PRIMARY KEY  (`announcementid`),
  KEY `announcements_startdatetime` (`start_datetime`),
  KEY `announcements_enddatetime` (`end_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `anonymous_users`
--

DROP TABLE IF EXISTS `anonymous_users`;
CREATE TABLE `anonymous_users` (
  `memberid` char(16) NOT NULL,
  `email` varchar(75) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  PRIMARY KEY  (`memberid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `groupid` char(16) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `login_old`
--

DROP TABLE IF EXISTS `login_old`;
CREATE TABLE `login_old` (
  `memberid` char(16) character set latin1 default NULL,
  `email` varchar(75) character set latin1 NOT NULL,
  `userpassword` varchar(50) character set latin1 default NULL,
  `fname` varchar(30) character set latin1 NOT NULL,
  `lname` varchar(30) character set latin1 NOT NULL,
  `phone` varchar(16) character set latin1 NOT NULL,
  `institution` varchar(255) character set latin1 default NULL,
  `positionname` varchar(100) character set latin1 default NULL,
  `e_add` char(1) character set latin1 NOT NULL default 'y',
  `e_mod` char(1) character set latin1 NOT NULL default 'y',
  `e_del` char(1) character set latin1 NOT NULL default 'y',
  `e_app` char(1) character set latin1 NOT NULL default 'y',
  `e_html` char(1) character set latin1 NOT NULL default 'y',
  `username` varchar(30) character set latin1 default NULL,
  `is_admin` smallint(6) default '0',
  `lang` varchar(5) character set latin1 default NULL,
  `lastlogin` datetime default NULL,
  `salt` varchar(8) character set latin1 default NULL,
  `password` char(32) character set latin1 NOT NULL,
  `timezonename` varchar(50) character set latin1 default NULL,
  `loginid` bigint(20) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`loginid`),
  KEY `login_email` (`email`),
  KEY `login_password` (`userpassword`),
  KEY `login_logonname` USING BTREE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `mutex`
--

DROP TABLE IF EXISTS `mutex`;
CREATE TABLE `mutex` (
  `i` int(11) NOT NULL,
  PRIMARY KEY  (`i`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `memberid` char(16) NOT NULL,
  `machid` char(16) NOT NULL,
  PRIMARY KEY  (`memberid`,`machid`),
  KEY `per_memberid` (`memberid`),
  KEY `per_machid` (`machid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reminders`
--

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
  `reminderid` char(16) NOT NULL,
  `memberid` char(16) NOT NULL,
  `resid` char(16) NOT NULL,
  `reminder_time` bigint(20) NOT NULL,
  PRIMARY KEY  (`reminderid`),
  KEY `reminders_time` (`reminder_time`),
  KEY `reminders_memberid` (`memberid`),
  KEY `reminders_resid` (`resid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `reservationid` bigint(20) unsigned NOT NULL auto_increment,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `start_time` time NOT NULL COMMENT 'needed?',
  `end_time` time NOT NULL COMMENT 'needed?',
  `date_created` datetime NOT NULL,
  `date_modified` datetime default NULL,
  `is_blackout` tinyint(3) unsigned NOT NULL default '0',
  `is_pending` tinyint(3) unsigned NOT NULL default '0',
  `summary` text,
  `allow_participation` tinyint(3) unsigned NOT NULL default '0',
  `allow_anon_participation` tinyint(3) unsigned NOT NULL default '0',
  `parentid` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`reservationid`),
  KEY `reservation_startdate` (`start_date`),
  KEY `reservation_enddate` (`end_date`),
  KEY `reservation_isblackout` (`is_blackout`),
  KEY `reservation_ispending` (`is_pending`),
  KEY `reservation_parentid` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_resources`
--

DROP TABLE IF EXISTS `reservation_resources`;
CREATE TABLE `reservation_resources` (
  `resid` char(16) NOT NULL,
  `resourceid` char(16) NOT NULL,
  `owner` smallint(6) default NULL,
  PRIMARY KEY  (`resid`,`resourceid`),
  KEY `resresources_resid` (`resid`),
  KEY `resresources_resourceid` (`resourceid`),
  KEY `resresources_owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_users`
--

DROP TABLE IF EXISTS `reservation_users`;
CREATE TABLE `reservation_users` (
  `resid` char(16) NOT NULL,
  `memberid` char(16) NOT NULL,
  `owner` smallint(6) default NULL,
  `invited` smallint(6) default NULL,
  `perm_modify` smallint(6) default NULL,
  `perm_delete` smallint(6) default NULL,
  `accept_code` char(16) default NULL,
  PRIMARY KEY  (`resid`,`memberid`),
  KEY `resusers_resid` (`resid`),
  KEY `resusers_memberid` (`memberid`),
  KEY `resusers_owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `resid` char(16) NOT NULL,
  `machid` char(16) NOT NULL,
  `scheduleid` char(16) NOT NULL,
  `start_date` int(11) NOT NULL default '0',
  `end_date` int(11) NOT NULL default '0',
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) default NULL,
  `parentid` char(16) default NULL,
  `is_blackout` smallint(6) NOT NULL default '0',
  `is_pending` smallint(6) NOT NULL default '0',
  `summary` text,
  `allow_participation` smallint(6) NOT NULL default '0',
  `allow_anon_participation` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`resid`),
  KEY `res_machid` (`machid`),
  KEY `res_scheduleid` (`scheduleid`),
  KEY `reservations_startdate` (`start_date`),
  KEY `reservations_enddate` (`end_date`),
  KEY `res_startTime` (`starttime`),
  KEY `res_endTime` (`endtime`),
  KEY `res_created` (`created`),
  KEY `res_modified` (`modified`),
  KEY `res_parentid` (`parentid`),
  KEY `res_isblackout` (`is_blackout`),
  KEY `reservations_pending` (`is_pending`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource` (
  `resourceid` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(75) NOT NULL,
  `location` varchar(250) default NULL,
  `phone` varchar(16) default NULL,
  `notes` text,
  `isactive` tinyint(3) unsigned NOT NULL default '1',
  `min_length` int(10) unsigned default NULL,
  `max_length` int(11) default NULL,
  `autoassign` tinyint(3) unsigned NOT NULL default '0',
  `requires_approval` tinyint(3) unsigned NOT NULL default '0',
  `allow_multiple_day_reservations` tinyint(3) unsigned NOT NULL default '1',
  `max_participants` int(11) default NULL,
  `min_notice_time` int(11) default NULL,
  `max_notice_time` int(11) default NULL,
  `legacyid` char(16) default NULL,
  PRIMARY KEY  (`resourceid`),
  KEY `resource_name` (`name`),
  KEY `resource_autoassign` (`autoassign`),
  KEY `resource_isactive` (`isactive`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `resource_permission`
--

DROP TABLE IF EXISTS `resource_permission`;
CREATE TABLE `resource_permission` (
  `resourceid` bigint(20) unsigned NOT NULL,
  `userid` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`resourceid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `machid` char(16) NOT NULL,
  `scheduleid` char(16) NOT NULL,
  `name` varchar(75) NOT NULL,
  `location` varchar(250) default NULL,
  `rphone` varchar(16) default NULL,
  `notes` text,
  `status` char(1) NOT NULL default 'a',
  `minres` int(11) NOT NULL,
  `maxres` int(11) NOT NULL,
  `autoassign` smallint(6) default NULL,
  `approval` smallint(6) default NULL,
  `allow_multi` smallint(6) default NULL,
  `max_participants` int(11) default NULL,
  `min_notice_time` int(11) default NULL,
  `max_notice_time` int(11) default NULL,
  PRIMARY KEY  (`machid`),
  KEY `rs_scheduleid` (`scheduleid`),
  KEY `rs_name` (`name`),
  KEY `rs_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `schedule_permission`
--

DROP TABLE IF EXISTS `schedule_permission`;
CREATE TABLE `schedule_permission` (
  `scheduleid` char(16) NOT NULL,
  `memberid` char(16) NOT NULL,
  PRIMARY KEY  (`scheduleid`,`memberid`),
  KEY `sp_scheduleid` (`scheduleid`),
  KEY `sp_memberid` (`memberid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `scheduleid` char(16) NOT NULL,
  `scheduletitle` char(75) default NULL,
  `daystart` int(11) NOT NULL,
  `dayend` int(11) NOT NULL,
  `timespan` int(11) NOT NULL,
  `timeformat` int(11) NOT NULL,
  `weekdaystart` int(11) NOT NULL,
  `viewdays` int(11) NOT NULL,
  `usepermissions` smallint(6) default NULL,
  `ishidden` smallint(6) default NULL,
  `showsummary` smallint(6) default NULL,
  `adminemail` varchar(75) default NULL,
  `isdefault` smallint(6) default NULL,
  PRIMARY KEY  (`scheduleid`),
  KEY `sh_hidden` (`ishidden`),
  KEY `sh_perms` (`usepermissions`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `groupid` char(16) NOT NULL,
  `memberid` char(50) NOT NULL,
  `is_admin` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`groupid`,`memberid`),
  KEY `usergroups_groupid` (`groupid`),
  KEY `usergroups_memberid` (`memberid`),
  KEY `usergroups_is_admin` (`is_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-05-10 20:32:11
