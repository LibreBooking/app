DROP TABLE IF EXISTS `dbversion`;
CREATE TABLE `dbversion` (
 `version_number` DOUBLE unsigned NOT NULL DEFAULT 0,
 `version_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;

ALTER TABLE `resources` ADD COLUMN `admin_group_id` SMALLINT(5) unsigned;
ALTER TABLE `resources` ADD CONSTRAINT `admin_group_id` FOREIGN KEY (`admin_group_id`) REFERENCES `groups`(`group_id`) ON DELETE SET NULL;

ALTER TABLE `users` ADD COLUMN `public_id` VARCHAR(20);
CREATE UNIQUE INDEX `public_id` ON `users` (`public_id`);

ALTER TABLE `resources` ADD COLUMN `public_id` VARCHAR(20);
CREATE UNIQUE INDEX `public_id` ON `resources` (`public_id`);

ALTER TABLE `schedules` ADD COLUMN `public_id` VARCHAR(20);
CREATE UNIQUE INDEX `public_id` ON `schedules` (`public_id`);

ALTER TABLE `users` ADD COLUMN `allow_calendar_subscription` TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE `resources` ADD COLUMN `allow_calendar_subscription` TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE `schedules` ADD COLUMN `allow_calendar_subscription` TINYINT(1) NOT NULL DEFAULT 0;