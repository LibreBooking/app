# noinspection SqlNoDataSourceInspectionForFile

ALTER TABLE `users`
  ADD COLUMN `api_only` TINYINT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `accessories`
  ADD COLUMN `credit_count` DECIMAL(7,2) UNSIGNED;

ALTER TABLE `accessories`
  ADD COLUMN `peak_credit_count` DECIMAL(7,2) UNSIGNED;

ALTER TABLE `accessories`
  ADD COLUMN `credit_applicability` TINYINT UNSIGNED NOT NULL DEFAULT 1;

ALTER TABLE `resources`
  ADD COLUMN `credit_applicability` TINYINT UNSIGNED NOT NULL DEFAULT 1;