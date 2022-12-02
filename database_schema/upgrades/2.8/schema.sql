# noinspection SqlNoDataSourceInspectionForFile

ALTER TABLE `schedules`
  ADD COLUMN `total_concurrent_reservations` SMALLINT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `schedules`
  ADD COLUMN `max_resources_per_reservation` SMALLINT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `schedules`
  ADD COLUMN `additional_properties` TEXT;

ALTER TABLE `resources`
  ADD COLUMN `additional_properties` TEXT;

ALTER TABLE `payment_configuration`
  DROP COLUMN `payment_configuration_id`;
ALTER TABLE `payment_configuration`
  ADD COLUMN `credit_count` INT UNSIGNED NOT NULL DEFAULT 1 CHECK (`credit_count` > 0);
ALTER TABLE `payment_configuration`
  ADD CONSTRAINT `credit_count` PRIMARY KEY (`credit_count`);