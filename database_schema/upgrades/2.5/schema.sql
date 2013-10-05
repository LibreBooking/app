
ALTER TABLE `custom_attributes` ADD COLUMN `entity_id` mediumint(8) unsigned;

ALTER TABLE `resources` ADD COLUMN `resource_type_id` mediumint(8) unsigned;

DROP TABLE IF EXISTS `resource_group_assignment`;


DROP TABLE IF EXISTS `resource_groups`;
CREATE TABLE `resource_groups` (
 `resource_group_id` mediumint(8) unsigned NOT NULL auto_increment,
 `resource_group_name` VARCHAR(75),
 `parent_id` mediumint(8) unsigned,
  PRIMARY KEY (`resource_group_id`),
  INDEX `resource_groups_parent_id` (`parent_id`),
  FOREIGN KEY (`parent_id`)
	REFERENCES resource_groups(`resource_group_id`)
	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `resource_types`;
CREATE TABLE `resource_types` (
 `resource_type_id` mediumint(8) unsigned NOT NULL auto_increment,
 `resource_type_name` VARCHAR(75),
 `resource_type_description` TEXT,
  PRIMARY KEY (`resource_type_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;


ALTER TABLE `resources` ADD FOREIGN KEY (`resource_type_id`) REFERENCES resource_types(`resource_type_id`) ON DELETE CASCADE;

DROP TABLE IF EXISTS `resource_group_assignment`;
CREATE TABLE `resource_group_assignment` (
 `resource_group_id` mediumint(8) unsigned NOT NULL,
 `resource_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`resource_group_id`, `resource_id`),
  INDEX `resource_group_assignment_resource_id` (`resource_id`),
  INDEX `resource_group_assignment_resource_group_id` (`resource_group_id`),
  FOREIGN KEY (`resource_group_id`)
		REFERENCES resource_groups(`resource_group_id`)
		ON DELETE CASCADE,
	FOREIGN KEY (`resource_id`)
		REFERENCES resources(`resource_id`)
	ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

