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
  `statusid` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  USING BTREE (`userid`),
  KEY `user_username` (`username`),
  KEY `user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `phpscheduleit`.`account_groups`;
CREATE TABLE  `phpscheduleit`.`account_groups` (
  `userid` int(10) unsigned NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`userid`,`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `account_status`
--

DROP TABLE IF EXISTS `account_status`;
CREATE TABLE `account_status` (
  `accountstatusid` tinyint(3) unsigned NOT NULL auto_increment,
  `statusdescription` varchar(45) default NULL,
  PRIMARY KEY  USING BTREE (`accountstatusid`)
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

DROP TABLE IF EXISTS `phpscheduleit`.`groups`;
CREATE TABLE  `phpscheduleit`.`groups` (
  `groupid` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `reservationid` int(10) unsigned NOT NULL auto_increment,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime default NULL,
  `summary` text,
  `allow_participation` tinyint(3) unsigned NOT NULL default '0',
  `allow_anon_participation` tinyint(3) unsigned NOT NULL default '0',
  `parentid` bigint(20) unsigned default NULL,
  `typeid` int(10) unsigned NOT NULL,
  `statusid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`reservationid`),
  KEY `reservation_startdate` (`start_date`),
  KEY `reservation_enddate` (`end_date`),
  KEY `reservation_parentid` (`parentid`),
  KEY `reservation_typeid` (`typeid`),
  KEY `reservation_statusid` (`statusid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_resource`
--

DROP TABLE IF EXISTS `reservation_resource`;
CREATE TABLE `reservation_resource` (
  `reservationid` int(10) unsigned NOT NULL,
  `resourceid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`reservationid`,`resourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_status`
--

DROP TABLE IF EXISTS `reservation_status`;
CREATE TABLE `reservation_status` (
  `statusid` int(10) unsigned NOT NULL auto_increment,
  `status_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`statusid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_type`
--

DROP TABLE IF EXISTS `reservation_type`;
CREATE TABLE `reservation_type` (
  `typeid` int(10) unsigned NOT NULL auto_increment,
  `type_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`typeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_user`
--

DROP TABLE IF EXISTS `reservation_user`;
CREATE TABLE `reservation_user` (
  `reservationid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `levelid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`userid`,`reservationid`),
  KEY `reservation_user_user_level` USING BTREE (`levelid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `reservation_user_level`
--

DROP TABLE IF EXISTS `reservation_user_level`;
CREATE TABLE `reservation_user_level` (
  `levelid` int(10) unsigned NOT NULL auto_increment,
  `level_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`levelid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource` (
  `resourceid` int(10) unsigned NOT NULL auto_increment,
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

DROP TABLE IF EXISTS `phpscheduleit`.`resource_group_permissions`;
CREATE TABLE  `phpscheduleit`.`resource_group_permissions` (
  `resourceid` int(10) unsigned NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`resourceid`,`groupid`)
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
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `scheduleid` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `isdefault` tinyint(3) unsigned NOT NULL default '0',
  `daystart` time NOT NULL,
  `dayend` time NOT NULL,
  `weekdaystart` tinyint(3) unsigned NOT NULL default '0',
  `adminid` bigint(20) unsigned NOT NULL,
  `daysvisible` tinyint(3) unsigned NOT NULL default '7',
  `layoutid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`scheduleid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `layout`
--

DROP TABLE IF EXISTS `layout`;
CREATE TABLE  `layout` (
  `layoutid` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  PRIMARY KEY  (`layoutid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `layout_period`;
CREATE TABLE  `layout_period` (
  `periodid` int(10) unsigned NOT NULL auto_increment,
  `layoutid` int(10) unsigned NOT NULL,
  `label` varchar(45) NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  PRIMARY KEY  (`periodid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Table structure for table `schedule_resource`
--

DROP TABLE IF EXISTS `schedule_resource`;
CREATE TABLE `schedule_resource` (
  `scheduleid` int(10) unsigned NOT NULL,
  `resourceid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`scheduleid`,`resourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-08-22  4:49:06