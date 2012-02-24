CREATE TABLE `dbversion` (
 `version_number` double unsigned NOT NULL default 0,
 `version_date` timestamp NOT NULL default current_timestamp
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8;