DROP TABLE IF EXISTS `custom_attributes`;
CREATE TABLE `custom_attributes` (
 `custom_attribute_id` mediumint(8) unsigned NOT NULL auto_increment,
 `display_label` varchar(50) NOT NULL,
 `display_type` tinyint(2) unsigned NOT NULL,
 `attribute_category` tinyint(2) unsigned NOT NULL,
 `validation_regex` varchar(50),
 `is_required` tinyint(1) unsigned NOT NULL,
 `possible_values` text,
 `sort_order` tinyint(2) unsigned,
  PRIMARY KEY (`custom_attribute_id`),
  INDEX (`attribute_category`),
  INDEX (`display_label`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `custom_attribute_values`;
CREATE TABLE `custom_attribute_values` (
 `custom_attribute_value_id` mediumint(8) unsigned NOT NULL auto_increment,
 `custom_attribute_id` mediumint(8) unsigned NOT NULL,
 `attribute_value` text NOT NULL,
 `entity_id` mediumint(8) unsigned NOT NULL,
 `attribute_category`  tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`custom_attribute_value_id`),
  INDEX (`custom_attribute_id`),
  INDEX `entity_category` (`entity_id`, `attribute_category`),
  INDEX `entity_attribute` (`entity_id`, `custom_attribute_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `account_activation`;
CREATE TABLE `account_activation` (
 `account_activation_id` mediumint(8) unsigned NOT NULL auto_increment,
 `user_id` mediumint(8) unsigned NOT NULL,
 `activation_code` varchar(30) NOT NULL,
 `date_created` datetime NOT NULL,
  PRIMARY KEY (`account_activation_id`),
  INDEX (`activation_code`),
  UNIQUE KEY (`activation_code`),
  FOREIGN KEY (`user_id`)
	REFERENCES users(`user_id`)
	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `reservation_files`;
CREATE TABLE IF NOT EXISTS `reservation_files` (
  `file_id` int unsigned NOT NULL auto_increment,
  `series_id` int unsigned NOT NULL,
  `file_name` varchar(250) NOT NULL,
  `file_type` varchar(15) NOT NULL,
  `file_size` varchar(45) NOT NULL,
  `file_extension` varchar(10) NOT NULL,
  PRIMARY KEY  (`file_id`),
  FOREIGN KEY (`series_id`)
  	REFERENCES reservation_series(`series_id`)
  	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;