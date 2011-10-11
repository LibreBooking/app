DROP DATABASE IF EXISTS phpscheduleit2;

CREATE DATABASE phpscheduleit2;

USE phpscheduleit2;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
 `announcementid` mediumint(8) unsigned NOT NULL auto_increment,
 `title` varchar(85) NOT NULL,
 `announcement_text` text,
 `priority` mediumint(8) NOT NULL,
 `start_datetime` datetime,
 `end_datetime` datetime,
 PRIMARY KEY (`announcementid`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `layouts`
--

DROP TABLE IF EXISTS `layouts`;
CREATE TABLE `layouts` (
 `layout_id` mediumint(8) unsigned NOT NULL auto_increment,
 `timezone` varchar(50) NOT NULL,
 PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `time_blocks`
--

DROP TABLE IF EXISTS `time_blocks`;
CREATE TABLE `time_blocks` (
 `block_id` mediumint(8) unsigned NOT NULL auto_increment,
 `label` varchar(85),
 `end_label` varchar(85),
 `availability_code` tinyint(2) unsigned NOT NULL,
 `cost_multiplier` numeric(7,2),
 `layout_id` mediumint(8) unsigned NOT NULL,
 `start_time` time NOT NULL,
 `end_time` time NOT NULL,
 PRIMARY KEY (`block_id`),
 INDEX (`layout_id`),
 FOREIGN KEY (`layout_id`) 
	REFERENCES layouts(`layout_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
 `group_id` smallint(5) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 `admin_group_id` smallint(5) unsigned,
 PRIMARY KEY (`group_id`),
 FOREIGN KEY (`admin_group_id`)
	REFERENCES groups(`group_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;


--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
 `role_id` tinyint(2) unsigned NOT NULL,
 `name` varchar(85),
 `role_level` tinyint(2) unsigned,
 PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `group_roles`;
CREATE TABLE `group_roles` (
 `group_id` smallint(8) unsigned NOT NULL,
 `role_id` tinyint(2) unsigned NOT NULL,
 PRIMARY KEY (`group_id`, `role_id`),
 INDEX (`group_id`),
 FOREIGN KEY (`group_id`)
	REFERENCES groups(`group_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`role_id`),
 FOREIGN KEY (`role_id`)
	REFERENCES roles(`role_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_statuses`
--

DROP TABLE IF EXISTS `user_statuses`;
CREATE TABLE `user_statuses` (
 `status_id` tinyint(2) unsigned NOT NULL,
 `description` varchar(85),
 PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `registration_form_settings`
--

DROP TABLE IF EXISTS `registration_form_settings`;
CREATE TABLE `registration_form_settings` (
 `form_id` mediumint(8) unsigned NOT NULL auto_increment,
 `fname_setting` tinyint(1) NOT NULL default '1',
 `lname_setting` tinyint(1) NOT NULL default '1',
 `username_setting` tinyint(1) NOT NULL default '1',
 `email_setting` tinyint(1) NOT NULL default '1',
 `password_setting` tinyint(1) NOT NULL default '1',
 `organization_setting` tinyint(1) NOT NULL default '2',
 `group_setting` tinyint(1) NOT NULL default '2',
 `position_setting` tinyint(1) NOT NULL default '2',
 `address_setting` tinyint(1) NOT NULL default '2',
 `phone_setting` tinyint(1) NOT NULL default '2',
 `homepage_setting`  tinyint(1) NOT NULL default '2',
 `timezone_setting` tinyint(1) NOT NULL default '3',
 PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
 `user_id` mediumint(8) unsigned NOT NULL auto_increment,
 `fname` varchar(85),
 `lname` varchar(85),
 `username` varchar(85),
 `email` varchar(85) NOT NULL,
 `password` varchar(85) NOT NULL,
 `salt` varchar(85) NOT NULL,
 `organization` varchar(85),
 `position` varchar(85),
 `phone` varchar(85),
 `timezone` varchar(85) NOT NULL,
 `language` VARCHAR(10) NOT NULL,
 `homepageid` tinyint(2) unsigned NOT NULL default '1',
 `date_created` datetime NOT NULL,
 `last_modified` timestamp,
 `lastlogin` datetime,
 `status_id` tinyint(2) unsigned NOT NULL,
 `legacyid` char(16),
 `legacypassword` varchar(32),
 PRIMARY KEY (`user_id`),
 INDEX (`status_id`),
 FOREIGN KEY (`status_id`) 
	REFERENCES user_statuses(`status_id`)
	ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
 `user_id` mediumint(8) unsigned NOT NULL,
 `group_id` smallint(5) unsigned NOT NULL,
 PRIMARY KEY (`group_id`, `user_id`),
 INDEX (`user_id`),
 FOREIGN KEY (`user_id`) 
	REFERENCES users(`user_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`group_id`),
 FOREIGN KEY (`group_id`) 
	REFERENCES groups(`group_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;


--
-- Table structure for table `resource_types`
--

DROP TABLE IF EXISTS `resource_types`;
CREATE TABLE `resource_types` (
 `type_id` tinyint(2) unsigned NOT NULL,
 `label` varchar(85) NOT NULL,
 PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
 `resource_id` smallint(5) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 `type_id` tinyint(2) unsigned,
 `location` varchar(85),
 `contact_info` varchar(85),
 `description` text,
 `notes` text,
 `isactive` tinyint(1) unsigned NOT NULL default '1',
 `min_duration` time,
 `min_increment` time,
 `max_duration` time,
 `unit_cost` dec(7,2),
 `autoassign` tinyint(1) unsigned NOT NULL default '1',
 `requires_approval` tinyint(1) unsigned NOT NULL,
 `allow_multiday_reservations` tinyint(1) unsigned NOT NULL default '1',
 `max_participants` mediumint(8) unsigned,
 `min_notice_time` time,
 `max_notice_time` time,
 `image_name` varchar(50),
 `legacyid` char(16),
 PRIMARY KEY (`resource_id`),
 INDEX (`type_id`),
 FOREIGN KEY (`type_id`) 
	REFERENCES resource_types(`type_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;


--
-- Table structure for table `user_resource_permissions`
--

DROP TABLE IF EXISTS `user_resource_permissions`;
CREATE TABLE `user_resource_permissions` (
 `user_id` mediumint(8) unsigned NOT NULL,
 `resource_id` smallint(5) unsigned NOT NULL,
 `permission_id` tinyint(2) unsigned NOT NULL default '1',
 PRIMARY KEY (`user_id`, `resource_id`),
 INDEX (`user_id`),
 FOREIGN KEY (`user_id`) 
	REFERENCES users(`user_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`resource_id`),
 FOREIGN KEY (`resource_id`) 
	REFERENCES resources(`resource_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `group_resource_permissions`
--

DROP TABLE IF EXISTS `group_resource_permissions`;
CREATE TABLE `group_resource_permissions` (
 `group_id` smallint(5) unsigned NOT NULL,
 `resource_id` smallint(5) unsigned NOT NULL,
 PRIMARY KEY (`group_id`, `resource_id`),
 INDEX (`group_id`),
 FOREIGN KEY (`group_id`) 
	REFERENCES groups(`group_id`) 
	ON UPDATE CASCADE ON DELETE CASCADE,
INDEX (`resource_id`),
FOREIGN KEY (`resource_id`) 
	REFERENCES resources(`resource_id`) 
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
 `schedule_id` smallint(5) unsigned NOT NULL auto_increment,
 `name` varchar(85) NOT NULL,
 `isdefault` tinyint(1) unsigned NOT NULL,
 `weekdaystart` tinyint(2) unsigned NOT NULL,
 `daysvisible` tinyint(2) unsigned NOT NULL default '7',
 `layout_id` mediumint(8) unsigned NOT NULL,
 PRIMARY KEY (`schedule_id`),
 INDEX (`layout_id`),
 FOREIGN KEY (`layout_id`) 
	REFERENCES layouts(`layout_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `schedule_admins`
--

DROP TABLE IF EXISTS `schedule_admins`;
CREATE TABLE `schedule_admins` (
 `schedule_id` smallint(5) unsigned NOT NULL,
 `user_id` mediumint(8) unsigned NOT NULL,
 PRIMARY KEY (`schedule_id`, `user_id`),
 INDEX (`schedule_id`),
 FOREIGN KEY (`schedule_id`) 
	REFERENCES schedules(`schedule_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`user_id`),
 FOREIGN KEY (`user_id`) 
	REFERENCES users(`user_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `resource_schedules`
--

DROP TABLE IF EXISTS `resource_schedules`;
CREATE TABLE `resource_schedules` (
 `resource_id` smallint(5) unsigned NOT NULL,
 `schedule_id` smallint(5) unsigned NOT NULL,
 PRIMARY KEY (`resource_id`, `schedule_id`),
 INDEX (`resource_id`),
 FOREIGN KEY (`resource_id`) 
	REFERENCES resources(`resource_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`schedule_id`),
 FOREIGN KEY (`schedule_id`) 
	REFERENCES schedules(`schedule_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `reservation_types`
--

DROP TABLE IF EXISTS `reservation_types`;
CREATE TABLE `reservation_types` (
 `type_id` tinyint(2) unsigned NOT NULL,
 `label` varchar(85) NOT NULL,
 PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `reservation_statuses`
--

DROP TABLE IF EXISTS `reservation_statuses`;
CREATE TABLE `reservation_statuses` (
 `status_id` tinyint(2) unsigned NOT NULL,
 `label` varchar(85) NOT NULL,
 PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `reservation_series`
--
DROP TABLE IF EXISTS `reservation_series`;
CREATE TABLE  `reservation_series` (
  `series_id` mediumint(8) unsigned NOT NULL auto_increment,
  `date_created` datetime NOT NULL,
  `last_modified` datetime,
  `title` varchar(85) NOT NULL,
  `description` text,
  `allow_participation` tinyint(1) unsigned NOT NULL,
  `allow_anon_participation` tinyint(1) unsigned NOT NULL,
  `type_id` tinyint(2) unsigned NOT NULL,
  `status_id` tinyint(2) unsigned NOT NULL,
  `total_cost` decimal(7,2) default NULL,
  `repeat_type` varchar(10) default NULL,
  `repeat_options` varchar(255) default NULL,
  `schedule_id` smallint(5) unsigned NOT NULL, 
  `owner_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`series_id`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `reservations_schedule` (`schedule_id`),
  CONSTRAINT `reservations_type` FOREIGN KEY (`type_id`) REFERENCES `reservation_types` (`type_id`) ON UPDATE CASCADE,
  CONSTRAINT `reservations_status` FOREIGN KEY (`status_id`) REFERENCES `reservation_statuses` (`status_id`) ON UPDATE CASCADE,
  CONSTRAINT `reservations_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`),
  CONSTRAINT `reservations_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `reservation_instances`
--

DROP TABLE IF EXISTS `reservation_instances`;
CREATE TABLE  `reservation_instances` (
  `reservation_instance_id` mediumint(8) unsigned NOT NULL auto_increment,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `series_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`reservation_instance_id`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`),
  KEY `reference_number` (`reference_number`),
  KEY `series_id` (`series_id`),
  CONSTRAINT `reservations_series` FOREIGN KEY (`series_id`) REFERENCES `reservation_series` (`series_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `reservation_users`
--

DROP TABLE IF EXISTS `reservation_users`;
CREATE TABLE `reservation_users` (
  `reservation_instance_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `reservation_user_level` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY  (`reservation_instance_id`,`user_id`),
  KEY `reservation_instance_id` (`reservation_instance_id`),
  KEY `user_id` (`user_id`),
  KEY `reservation_user_level` (`reservation_user_level`),
  FOREIGN KEY (`reservation_instance_id`) REFERENCES `reservation_instances` (`reservation_instance_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
	
--
-- Table structure for table `reservation_time_blocks`
--

DROP TABLE IF EXISTS `reservation_time_blocks`;
CREATE TABLE `reservation_time_blocks` (
 `series_id` mediumint(8) unsigned NOT NULL,
 `block_id` mediumint(8) unsigned NOT NULL,
 PRIMARY KEY (`series_id`, `block_id`),
 INDEX (`series_id`),
 FOREIGN KEY (`series_id`) 
	REFERENCES reservation_series(`series_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`block_id`),
 FOREIGN KEY (`block_id`) 
	REFERENCES time_blocks(`block_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `reservation_resources`
--

DROP TABLE IF EXISTS `reservation_resources`;
CREATE TABLE `reservation_resources` (
 `series_id` mediumint(8) unsigned NOT NULL,
 `resource_id` smallint(5) unsigned NOT NULL,
 `resource_level_id` tinyint(2) unsigned NOT NULL,
 PRIMARY KEY (`series_id`, `resource_id`),
 INDEX (`resource_id`),
 FOREIGN KEY (`resource_id`) 
	REFERENCES resources(`resource_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX (`series_id`),
 FOREIGN KEY (`series_id`) 
	REFERENCES reservation_series(`series_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

--
-- Table structure for table `user_email_preferences`
--

DROP TABLE IF EXISTS `user_email_preferences`;
CREATE TABLE `user_email_preferences` (
  `user_id` mediumint(8) unsigned NOT NULL,
  `event_category` varchar(45) NOT NULL,
  `event_type` varchar(45) NOT NULL,
 PRIMARY KEY (`user_id`),
 FOREIGN KEY (`user_id`)
	REFERENCES users(`user_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `quotas`
--

DROP TABLE IF EXISTS `quotas`;
CREATE TABLE `quotas` (
 `quota_id` mediumint(8) unsigned NOT NULL auto_increment,
 `quota_limit` decimal(7,2) unsigned NOT NULL,
 `unit` varchar(25) NOT NULL,
 `duration` varchar(25) NOT NULL,
 `resource_id` smallint(5) unsigned,
 `group_id` smallint(5) unsigned,
 `schedule_id` smallint(5) unsigned,
 PRIMARY KEY (`quota_id`),
 FOREIGN KEY (`resource_id`)
	REFERENCES resources(`resource_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 FOREIGN KEY (`group_id`)
	REFERENCES groups(`group_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
 FOREIGN KEY (`schedule_id`)
	REFERENCES schedules(`schedule_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

GRANT ALL on phpscheduleit2.* to 'schedule_user'@'localhost' identified by 'password';
