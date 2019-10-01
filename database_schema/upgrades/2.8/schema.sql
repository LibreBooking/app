DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`
(
	`id`     VARCHAR(32) NOT NULL,
	`access` INT(10) UNSIGNED,
	`data`   TEXT,
	PRIMARY KEY (`id`)
)
	ENGINE = InnoDB
	DEFAULT CHARACTER SET utf8;