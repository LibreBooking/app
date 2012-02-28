SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `dbversion`;

ALTER TABLE `resources` DROP FOREIGN KEY `admin_group_id`;
ALTER TABLE `resources` DROP COLUMN `admin_group_id`;

DELETE FROM roles WHERE role_id = 3;

SET foreign_key_checks = 1;