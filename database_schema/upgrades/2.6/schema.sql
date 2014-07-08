ALTER TABLE `custom_attributes` ADD COLUMN `admin_only` tinyint(1) unsigned;

ALTER TABLE  `user_preferences` CHANGE COLUMN `value` `value` text;

ALTER TABLE  `reservation_files` CHANGE COLUMN `file_type` `file_type` varchar(75);

DROP TABLE IF EXISTS `reservation_color_rules`;
CREATE TABLE `reservation_color_rules` (
 `reservation_color_rule_id` mediumint(8) unsigned NOT NULL auto_increment,
 `custom_attribute_id` mediumint(8) unsigned,
 `attribute_type` smallint unsigned,
 `required_value` text,
 `comparison_type` smallint unsigned,
 `color` varchar(50),
  PRIMARY KEY (`reservation_color_rule_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;