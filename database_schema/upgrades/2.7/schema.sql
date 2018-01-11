# noinspection SqlNoDataSourceInspectionForFile

ALTER TABLE `resources`
  CHANGE COLUMN `sort_order` `sort_order` SMALLINT UNSIGNED;

DROP TABLE IF EXISTS `payment_configuration`;
CREATE TABLE `payment_configuration` (
  `payment_configuration_id` TINYINT UNSIGNED       NOT NULL AUTO_INCREMENT,
  `credit_cost`              DECIMAL(7, 2) UNSIGNED NOT NULL,
  `credit_currency`          VARCHAR(10)            NOT NULL,
  PRIMARY KEY (`payment_configuration_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `payment_gateway_settings`;
CREATE TABLE `payment_gateway_settings` (
  `gateway_type`  VARCHAR(255)  NOT NULL,
  `setting_name`  VARCHAR(255)  NOT NULL,
  `setting_value` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`gateway_type`, `setting_name`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `credit_log`;
CREATE TABLE `credit_log` (
  `credit_log_id`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`  MEDIUMINT(8) UNSIGNED NOT NULL,
  `original_credit_count`  DECIMAL(7, 2),
  `credit_count`  DECIMAL(7, 2),
  `credit_note` VARCHAR(1000),
  `date_created` DATETIME NOT NULL,
  PRIMARY KEY (`credit_log_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `payment_transaction_log`;
CREATE TABLE `payment_transaction_log` (
  `payment_transaction_log_id`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`  MEDIUMINT(8) UNSIGNED NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `invoice_number` VARCHAR(50),
  `transaction_id` VARCHAR(50) NOT NULL,
  `subtotal_amount`  DECIMAL(7, 2) NOT NULL,
  `tax_amount`  DECIMAL(7, 2) NOT NULL,
  `total_amount`  DECIMAL(7, 2) NOT NULL,
  `transaction_fee`  DECIMAL(7, 2),
  `currency` VARCHAR(3) NOT NULL,
  `transaction_href` VARCHAR(500),
  `refund_href` VARCHAR(500),
  `date_created` DATETIME NOT NULL,
  `gateway_name` VARCHAR(100) NOT NULL,
  `gateway_date_created` VARCHAR(25) NOT NULL,
  `payment_response` TEXT,
  PRIMARY KEY (`payment_transaction_log_id`),
  KEY `user_id` (`user_id`),
  KEY `invoice_number` (`invoice_number`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;

DROP TABLE IF EXISTS `refund_transaction_log`;
CREATE TABLE `refund_transaction_log` (
  `refund_transaction_log_id`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_transaction_log_id`  INT(10) UNSIGNED NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `transaction_id` VARCHAR(50),
  `total_refund_amount`  DECIMAL(7, 2) NOT NULL,
  `payment_refund_amount`  DECIMAL(7, 2),
  `fee_refund_amount`  DECIMAL(7, 2),
  `transaction_href` VARCHAR(500),
  `date_created` DATETIME NOT NULL,
  `gateway_date_created` VARCHAR(25) NOT NULL,
  `refund_response` TEXT,
  PRIMARY KEY (`refund_transaction_log_id`),
  FOREIGN KEY (`payment_transaction_log_id`)
  REFERENCES payment_transaction_log (`payment_transaction_log_id`)
  ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;

ALTER TABLE `groups`
  ADD COLUMN `isdefault` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `groups` ADD INDEX(`isdefault`);

DROP TABLE IF EXISTS `terms_of_service`;
CREATE TABLE `terms_of_service` (
  `terms_of_service_id`  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `terms_text` TEXT,
  `terms_url` VARCHAR(255),
  `terms_file` VARCHAR(50),
  `applicability` VARCHAR(50),
  `date_created` DATETIME NOT NULL,
  PRIMARY KEY (`terms_of_service_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;

ALTER TABLE `reservation_series`
  ADD COLUMN `terms_date_accepted` DATETIME;

ALTER TABLE `users`
  ADD COLUMN `terms_date_accepted` DATETIME;

ALTER TABLE `announcements`
  ADD COLUMN `display_page` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1;
ALTER TABLE `announcements` ADD INDEX(`display_page`);