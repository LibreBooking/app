# noinspection SqlNoDataSourceInspectionForFile

ALTER TABLE `schedules`
  ADD COLUMN `total_concurrent_reservations` SMALLINT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `schedules`
  ADD COLUMN `max_resources_per_reservation` SMALLINT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `schedules`
  ADD COLUMN `additional_properties` TEXT;

ALTER TABLE `resources`
  ADD COLUMN `additional_properties` TEXT;