# noinspection SqlNoDataSourceInspectionForFile

DROP TABLE IF EXISTS `group_credit_replenishment_rule`;
CREATE TABLE `group_credit_replenishment_rule`
(
    `group_credit_replenishment_rule_id` SMALLINT(5) UNSIGNED   NOT NULL AUTO_INCREMENT,
    `group_id`                           SMALLINT(5) UNSIGNED   NOT NULL,
    `type`                               TINYINT UNSIGNED       NOT NULL,
    `amount`                             DECIMAL(7, 2) UNSIGNED NOT NULL,
    `day_of_month`                       TINYINT UNSIGNED       NOT NULL DEFAULT 0,
    `interval`                           SMALLINT(5) UNSIGNED   NOT NULL DEFAULT 0,
    `last_replenishment_date`            DATETIME,
    PRIMARY KEY (`group_credit_replenishment_rule_id`),
    FOREIGN KEY (`group_id`)
        REFERENCES `groups` (`group_id`)
        ON DELETE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER
        SET utf8;

ALTER TABLE `resources`
    ADD COLUMN `auto_extend_reservations` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0;