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
