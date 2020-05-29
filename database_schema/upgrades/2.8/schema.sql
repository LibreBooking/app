# noinspection SqlNoDataSourceInspectionForFile

ALTER TABLE `schedules`
  ADD COLUMN `total_concurrent_reservations` SMALLINT UNSIGNED NOT NULL DEFAULT 0;