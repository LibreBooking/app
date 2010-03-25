DROP DATABASE IF EXISTS phpscheduleit2;

CREATE DATABASE phpscheduleit2;

USE phpscheduleit2;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
 `announcementid` int(10) unsigned NOT NULL auto_increment,
 `announcement_text` text NOT NULL,
 `order_number` smallint(5) unsigned NOT NULL,
 `start_datetime` datetime default NULL,
 `end_datetime` datetime default NULL,
 PRIMARY KEY (`announcementid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `long_quotas`
--

DROP TABLE IF EXISTS `long_quotas`;
CREATE TABLE `long_quotas` (
 `long_quotaid` mediumint(8) unsigned NOT NULL auto_increment,
 `label` varchar(85),
 `max_count` smallint(5) unsigned,
 `max_total_hours` smallint(5) unsigned,
 `quota_window_duration` time,
 PRIMARY KEY (`long_quotaid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `day_quotas`
--

DROP TABLE IF EXISTS `day_quotas`;
CREATE TABLE `day_quotas` (
 `day_quotaid` mediumint(8) unsigned NOT NULL auto_increment,
 `label` varchar(85),
 `max_total_hours` tinyint(2) unsigned,
 `max_count` tinyint(2) unsigned,
 `max_continuous` tinyint(2) unsigned,
 PRIMARY KEY (`day_quotaid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;


--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
 `orgid` mediumint(8) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 PRIMARY KEY (`orgid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
 `groupid` mediumint(8) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 PRIMARY KEY (`groupid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
 `roleid` tinyint(2) unsigned NOT NULL,
 `role_name` varchar(85),
 `isadmin` tinyint(1) unsigned,
 PRIMARY KEY (`roleid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
CREATE TABLE `user_status` (
 `statusid` tinyint(2) unsigned NOT NULL,
 `status_description` varchar(85),
 PRIMARY KEY (`statusid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
 `addressid` mediumint(8) unsigned NOT NULL auto_increment,
 `address_info` text,
 `address_label` varchar(85),
 PRIMARY KEY (`addressid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
 `userid` int(10) unsigned NOT NULL auto_increment,
 `username` varchar(85),
 `email` varchar(85) NOT NULL,
 `password` varchar(85) NOT NULL,
 `salt` varchar(85) NOT NULL,
 `fname` varchar(85) NOT NULL,
 `lname` varchar(85) NOT NULL,
 `phone` varchar(85) default NULL,
 `position` varchar(85),
 `timezone` varchar(85) NOT NULL,
 `lastlogin` datetime,
 `homepageid` tinyint(2) unsigned NOT NULL default '1',
 `organization_id` mediumint(8) unsigned,
 `group_id` mediumint(8) unsigned,
 `address_id` mediumint(8) unsigned,
 `day_quota_id` mediumint(8) unsigned,
 `long_quota_id` mediumint(8) unsigned,
 `role_id` tinyint(2) unsigned,
 `status_id` tinyint(2) unsigned NOT NULL,
 `legacypassword` varchar(32),
 `legacyid` char(16),
 PRIMARY KEY (`userid`),
 INDEX (`organization_id`),
 FOREIGN KEY (`organization_id`) REFERENCES organizations(`orgid`),
 INDEX (`group_id`),
 FOREIGN KEY (`group_id`) REFERENCES user_groups(`groupid`),
 INDEX (`address_id`),
 FOREIGN KEY (`address_id`) REFERENCES user_address(`addressid`),
 INDEX (`day_quota_id`),
 FOREIGN KEY (`day_quota_id`) REFERENCES day_quotas(`day_quotaid`),
 INDEX (`long_quota_id`),
 FOREIGN KEY (`long_quota_id`) REFERENCES long_quotas(`long_quotaid`),
 INDEX (`role_id`),
 FOREIGN KEY (`role_id`) REFERENCES user_roles(`roleid`),
 INDEX (`status_id`),
 FOREIGN KEY (`status_id`) REFERENCES user_status(`statusid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `resource_constraints`
--

DROP TABLE IF EXISTS `resource_constraints`;
CREATE TABLE `resource_constraints` (
 `constraintid` smallint(5) unsigned NOT NULL,
 `constraint_function` text,
 PRIMARY KEY (`constraintid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
 `resourceid` int(10) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 `location` varchar(85),
 `contact_info` varchar(85),
 `description` text,
 `notes` text,
 `isactive` tinyint(1) unsigned NOT NULL default '1',
 `min_duration` time default NULL,
 `min_increment` time default NULL,
 `max_duration` time default NULL,
 `unit_cost` dec(7,2),
 `autoassign` tinyint(1) unsigned NOT NULL,
 `requires_approval` tinyint(1) unsigned NOT NULL,
 `allow_multiple_day_reservations` tinyint(1) unsigned NOT NULL default '1',
 `max_participants` int(10) unsigned default NULL,
 `min_notice_time` time default NULL,
 `max_notice_time` time default NULL,
 `legacyid` char(16),
 `constraint_id` smallint(5) unsigned,
 `long_quota_id` mediumint(8) unsigned,
 `constraint_id` mediumint(8) unsigned,
 PRIMARY KEY (`resourceid`),
 INDEX (`constraint_id`),
 FOREIGN KEY (`constraint_id`) REFERENCES resource_constraints(`constraintid`),
 INDEX (`long_quota_id`),
 FOREIGN KEY (`long_quota_id`) REFERENCES long_quotas(`long_quotaid`), 
 INDEX (`day_quota_id`),
 FOREIGN KEY (`day_quota_id`) REFERENCES day_quotas(`day_quotaid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `resource_permissions`
--

DROP TABLE IF EXISTS `resource_permissions`;
CREATE TABLE `resource_permissions` (
 `resource_id` int(10) unsigned NOT NULL,
 `user_id` int(10) unsigned NOT NULL,
 PRIMARY KEY (`resource_id, user_id`),
 INDEX (`resource_id`),
 FOREIGN KEY (`resource_id`) REFERENCES resources(`resourceid`),
 INDEX (`user_id`),
 FOREIGN KEY (`user_id`) REFERENCES users(`userid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
 `scheduleid` int(10) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 `isdefault` tinyint(1) unsigned NOT NULL,
 `daystart` date NOT NULL,
 `dayend` date NOT NULL,
 `weekdaystart` tinyint(2) unsigned NOT NULL,
 `admin_id` int(10) unsigned NOT NULL,
 `daysvisible` tinyint(2) unsigned NOT NULL default '7',
 PRIMARY KEY (`scheduleid`),
 INDEX (`admin_id`),
 FOREIGN KEY (`admin_id`) REFERENCES users(`userid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `resource_schedules`
--

DROP TABLE IF EXISTS `resource_schedules`;
CREATE TABLE `resource_schedules` (
 `resource_scheduleid` int(10) unsigned NOT NULL,
 `scheduleid` int(10) unsigned NOT NULL,
 `resourceid` int(10) unsigned NOT NULL,
 PRIMARY KEY (`resource_scheduleid`),
 INDEX (`scheduleid`),
 FOREIGN KEY (`scheduleid`) REFERENCES schedules(`scheduleid`),
 INDEX (`resourceid`),
 FOREIGN KEY (`resourceid`) REFERENCES resources(`resourceid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `reservation_type`
--

DROP TABLE IF EXISTS `reservation_type`;
CREATE TABLE `reservation_type` (
 `typeid` int(10) unsigned NOT NULL auto_increment,
 `label` varchar(85) NOT NULL,
 PRIMARY KEY (`typeid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `reservation_status`
--

DROP TABLE IF EXISTS `reservation_status`;
CREATE TABLE `reservation_status` (
 `statusid` int(10) unsigned NOT NULL auto_increment,
 `label` varchar(85) NOT NULL,
 PRIMARY KEY (`statusid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `time_blocks`
--

DROP TABLE IF EXISTS `time_blocks`;
CREATE TABLE `time_blocks` (
 `blockid` int(10) unsigned NOT NULL auto_increment,
 `label` varchar(85) NOT NULL,
 `start_time` time NOT NULL,
 `end_time` time NOT NULL,
 `availability_code` tinyint(2) unsigned NOT NULL,
 `cost_multiplier` numeric(7,2),
 `constraint_function` text,
 PRIMARY KEY (`blockid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;


--
-- Table structure for table `reservation_info`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
 `reservationid` int(10) unsigned NOT NULL auto_increment,
 `start_date` datetime NOT NULL,
 `end_date` datetime NOT NULL,
 `date_created` datetime NOT NULL,
 `last_modified` timestamp,
 `title` varchar(85) NOT NULL,
 `description` text,
 `allow_participation` tinyint(1) unsigned NOT NULL,
 `allow_anon_participation` tinyint(1) unsigned,
 `user_id` int(10) unsigned NOT NULL,
 `role_id` int(10) unsigned NOT NULL,
 `resource_id` int(10) unsigned NOT NULL,
 `type_id` int(10) unsigned,
 `status_id` int(10) unsigned,
 `total_cost` dec(7,2),
 `time_block_id` int(10) unsigned,
 PRIMARY KEY (`reservationid`),
 INDEX (`reserving_user_id`),
 FOREIGN KEY (`reserving_user_id`) REFERENCES users(`userid`),
 INDEX (`resource_id`),
 FOREIGN KEY (`resource_id`) REFERENCES resources(`resourceid`),
 INDEX (`role_id`),
 FOREIGN KEY (`role_id`) REFERENCES user_roles(`roleid`),
 INDEX (`type_id`),
 FOREIGN KEY (`type_id`) REFERENCES reservation_type(`typeid`),
 INDEX (`status_id`),
 FOREIGN KEY (`status_id`) REFERENCES reservation_status(`statusid`),
 INDEX (`time_block_id`),
 FOREIGN KEY (`time_block_id`) REFERENCES time_blocks(`blockid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;
