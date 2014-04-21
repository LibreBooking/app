ALTER TABLE `custom_attributes` ADD COLUMN `admin_only` tinyint(1) unsigned;

ALTER TABLE  `user_preferences` CHANGE COLUMN `value` `value` text;

ALTER TABLE  `reservation_files` CHANGE COLUMN `file_type` `file_type` varchar(75);