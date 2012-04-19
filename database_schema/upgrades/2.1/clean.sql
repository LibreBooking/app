SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `dbversion`;

ALTER TABLE `resources` DROP FOREIGN KEY `admin_group_id`;
ALTER TABLE `resources` DROP COLUMN `admin_group_id`;

DELETE FROM roles WHERE role_id = 3;

DROP INDEX `public_id` ON `users`;
ALTER TABLE `users` DROP COLUMN `public_id`;

DROP INDEX `public_id` ON `resources`;
ALTER TABLE `resources` DROP COLUMN `public_id`;

DROP INDEX `public_id` ON `schedules`;
ALTER TABLE `schedules` DROP COLUMN `public_id`;

ALTER TABLE `users` DROP COLUMN `allow_calendar_subscription`;
ALTER TABLE `resources` DROP COLUMN `allow_calendar_subscription`;
ALTER TABLE `schedules` DROP COLUMN `allow_calendar_subscription`;

SET foreign_key_checks = 1;