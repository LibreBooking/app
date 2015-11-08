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
		`minimum_quantity`      SMALLINT              NULL,
		`maximum_quantity`      SMALLINT              NULL,
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

ALTER TABLE `resources` MODIFY COLUMN `contact_info` varchar(255);
ALTER TABLE `resources` MODIFY COLUMN `location` varchar(255);

DROP TABLE IF EXISTS `resource_type_assignment`;
CREATE TABLE `resource_type_assignment` (
		`resource_id`      SMALLINT(5) UNSIGNED  NOT NULL,
		`resource_type_id` MEDIUMINT(8) UNSIGNED NOT NULL,
		PRIMARY KEY (`resource_id`, `resource_type_id`),
		FOREIGN KEY (`resource_id`)
		REFERENCES resources (`resource_id`)
				ON DELETE CASCADE,
		FOREIGN KEY (`resource_type_id`)
		REFERENCES resource_types (`resource_type_id`)
				ON DELETE CASCADE
)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `custom_attribute_entities`;
CREATE TABLE `custom_attribute_entities` (
		`custom_attribute_id` MEDIUMINT(8) UNSIGNED NOT NULL,
		`entity_id`           MEDIUMINT(8) UNSIGNED NOT NULL,
		PRIMARY KEY (`custom_attribute_id`, `entity_id`),
		FOREIGN KEY (`custom_attribute_id`)
		REFERENCES custom_attributes (`custom_attribute_id`)
				ON DELETE CASCADE
)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET utf8;

INSERT INTO custom_attribute_entities (custom_attribute_id, entity_id) (SELECT custom_attribute_id, entity_id FROM `custom_attributes` WHERE entity_id IS NOT NULL AND entity_id <> 0);

ALTER TABLE custom_attributes DROP COLUMN `entity_id`;

ALTER TABLE `quotas` ADD COLUMN `enforced_days` varchar(15);
ALTER TABLE `quotas` ADD COLUMN `enforced_time_start` time;
ALTER TABLE `quotas` ADD COLUMN `enforced_time_end` time;
