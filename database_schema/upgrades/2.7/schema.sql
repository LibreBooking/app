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
  `transaction_id` VARCHAR(50),
  `subtotal_amount`  DECIMAL(7, 2) NOT NULL,
  `tax_amount`  DECIMAL(7, 2) NOT NULL,
  `total_amount`  DECIMAL(7, 2) NOT NULL,
  `transaction_fee`  DECIMAL(7, 2),
  `currency` VARCHAR(3) NOT NULL,
  `transaction_href` VARCHAR(500) NOT NULL,
  `refund_href` VARCHAR(500) NOT NULL,
  `date_created` DATETIME NOT NULL,
  `gateway_name` VARCHAR(100) NOT NULL,
  `gateway_date_created` VARCHAR(25) NOT NULL,
  `payment_response` TEXT,
  PRIMARY KEY (`payment_transaction_log_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET utf8;