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
	REFERENCES users(`user_id`)
	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;
