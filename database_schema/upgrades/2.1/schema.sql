CREATE TABLE `dbversion` (
 `version_number` double unsigned NOT NULL default 0,
 `version_date` timestamp NOT NULL default current_timestamp
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

ALTER TABLE `resources` ADD COLUMN `admin_group_id` smallint(5) unsigned;
ALTER TABLE `resources` ADD CONSTRAINT `admin_group_id` FOREIGN KEY (`admin_group_id`) REFERENCES groups(`group_id`) ON DELETE SET NULL;