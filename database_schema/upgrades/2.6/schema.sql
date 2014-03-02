ALTER TABLE `custom_attributes` ADD COLUMN `admin_only` tinyint(1) unsigned;

ALTER TABLE  `user_preferences` CHANGE COLUMN `value` text;