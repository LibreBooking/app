SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `dbversion`;

DELETE FROM roles WHERE role_id = 3;

SET foreign_key_checks = 1;