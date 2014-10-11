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

DROP TABLE IF EXISTS `resource_accessories`;

CREATE TABLE `resource_accessories` (
		`resource_accessory_id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
		`resource_id`           SMALLINT(5) UNSIGNED  NOT NULL,
		`accessory_id`          SMALLINT(5) UNSIGNED  NOT NULL,
		`minimum_quantity`      SMALLINT              NOT NULL,
		`maximum_quantity`      SMALLINT              NOT NULL,
		PRIMARY KEY (`resource_accessory_id`),
		FOREIGN KEY (`resource_id`)
		REFERENCES resources (`resource_id`)
				ON DELETE CASCADE,
		FOREIGN KEY (`accessory_id`)
		REFERENCES accessories (`accessory_id`)
				ON DELETE CASCADE
)
		ENGINE =InnoDB
		DEFAULT CHARACTER SET utf8;


ALTER TABLE `custom_attributes` ADD COLUMN `secondary_category` tinyint(2) unsigned;
ALTER TABLE `custom_attributes` ADD COLUMN `secondary_entity_id` mediumint(8) unsigned;
ALTER TABLE `custom_attributes` ADD COLUMN `is_private` tinyint(1) unsigned;

ALTER TABLE `resource_groups` ADD COLUMN `public_id` varchar(20);
