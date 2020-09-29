# noinspection SqlNoDataSourceInspectionForFile

ALTER TABLE `users`
  ADD COLUMN `api_only` TINYINT UNSIGNED NOT NULL DEFAULT 0;