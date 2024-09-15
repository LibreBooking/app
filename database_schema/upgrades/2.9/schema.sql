ALTER TABLE `accessories`
CHANGE COLUMN `accessory_name` `accessory_name` VARCHAR(85) CHARACTER SET 'utf8mb4' NOT NULL ;

ALTER TABLE `announcements`
CHANGE COLUMN `announcement_text` `announcement_text` TEXT CHARACTER SET 'utf8mb4' NOT NULL ;

ALTER TABLE `blackout_series`
CHANGE COLUMN `title` `title` VARCHAR(85) CHARACTER SET 'utf8mb4' NOT NULL ,
CHANGE COLUMN `description` `description` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `credit_log`
CHANGE COLUMN `credit_note` `credit_note` VARCHAR(1000) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `custom_attribute_values`
CHANGE COLUMN `attribute_value` `attribute_value` TEXT CHARACTER SET 'utf8mb4' NOT NULL ;

ALTER TABLE `custom_attributes`
CHANGE COLUMN `display_label` `display_label` VARCHAR(50) CHARACTER SET 'utf8mb4' NOT NULL ,
CHANGE COLUMN `validation_regex` `validation_regex` VARCHAR(50) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `possible_values` `possible_values` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `groups`
CHANGE COLUMN `name` `name` VARCHAR(85) CHARACTER SET 'utf8mb4' NOT NULL ;

ALTER TABLE `reminders`
CHANGE COLUMN `address` `address` TEXT CHARACTER SET 'utf8mb4' NOT NULL ,
CHANGE COLUMN `message` `message` TEXT CHARACTER SET 'utf8mb4' NOT NULL ;

ALTER TABLE `reservation_series`
CHANGE COLUMN `title` `title` VARCHAR(300) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `description` `description` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `reservation_types`
CHANGE COLUMN `label` `label` VARCHAR(85) CHARACTER SET 'utf8mb4' NOT NULL ;

ALTER TABLE `resource_groups`
CHANGE COLUMN `resource_group_name` `resource_group_name` VARCHAR(75) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `resource_status_reasons`
CHANGE COLUMN `description` `description` VARCHAR(100) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `resource_types`
CHANGE COLUMN `resource_type_name` `resource_type_name` VARCHAR(75) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `resource_type_description` `resource_type_description` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `resources`
CHANGE COLUMN `name` `name` VARCHAR(85) CHARACTER SET 'utf8mb4' NOT NULL ,
CHANGE COLUMN `location` `location` VARCHAR(255) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `contact_info` `contact_info` VARCHAR(255) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `description` `description` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `notes` `notes` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `additional_properties` `additional_properties` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `saved_reports`
CHANGE COLUMN `report_name` `report_name` VARCHAR(50) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `schedules`
CHANGE COLUMN `name` `name` VARCHAR(85) CHARACTER SET 'utf8mb4' NOT NULL ,
CHANGE COLUMN `additional_properties` `additional_properties` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `terms_of_service`
CHANGE COLUMN `terms_text` `terms_text` TEXT CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `applicability` `applicability` VARCHAR(50) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `time_blocks`
CHANGE COLUMN `label` `label` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `end_label` `end_label` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `user_statuses`
CHANGE COLUMN `description` `description` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;

ALTER TABLE `users`
CHANGE COLUMN `fname` `fname` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `lname` `lname` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `username` `username` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `organization` `organization` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `position` `position` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `phone` `phone` VARCHAR(85) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ;
