DROP TABLE IF EXISTS `user_session`;
CREATE TABLE `user_session` (
 `user_session_id` mediumint(8) unsigned NOT NULL auto_increment,
 `user_id` mediumint(8) unsigned NOT NULL,
 `last_modified` datetime NOT NULL,
 `session_token` varchar(50) NOT NULL,
 `user_session_value` text NOT NULL,
  PRIMARY KEY (`user_session_id`),
  INDEX `user_session_user_id` (`user_id`),
  INDEX `user_session_session_token` (`session_token`),
  FOREIGN KEY (`user_id`)
	REFERENCES `users`(`user_id`)
	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

ALTER TABLE `time_blocks` ADD COLUMN `day_of_week` SMALLINT(5) unsigned;

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
 `reminder_id` int(11) unsigned NOT NULL auto_increment,
 `user_id` mediumint(8) unsigned NOT NULL,
 `address` text NOT NULL,
 `message` text NOT NULL,
 `sendtime` datetime NOT NULL,
 `refnumber` text NOT NULL,
 PRIMARY KEY (`reminder_id`),
 INDEX `reminders_user_id` (`user_id`),
 FOREIGN KEY (`user_id`)
 	REFERENCES `users`(`user_id`)
 	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `reservation_reminders`;
CREATE TABLE `reservation_reminders` (
 `reminder_id` int(11) unsigned NOT NULL auto_increment,
 `series_id` int unsigned NOT NULL,
 `minutes_prior` int unsigned NOT NULL,
 `reminder_type` tinyint(2) unsigned NOT NULL,
 PRIMARY KEY (`reminder_id`),
 FOREIGN KEY (`series_id`)
  	REFERENCES `reservation_series`(`series_id`)
  	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

ALTER TABLE `users` ADD COLUMN `default_schedule_id` smallint(5) unsigned;