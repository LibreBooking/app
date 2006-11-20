USE phpscheduleIt;

# Add support for maximum participants
ALTER TABLE resources ADD COLUMN max_participants INTEGER;

# Add support for uninvited participation
ALTER TABLE reservations ADD COLUMN allow_participation SMALLINT NOT NULL DEFAULT 0;

# Add support for anonymous participation
ALTER TABLE reservations ADD COLUMN allow_anon_participation SMALLINT NOT NULL DEFAULT 0;

# Create anonymous user table #
CREATE TABLE anonymous_users (
  memberid CHAR(16) NOT NULL PRIMARY KEY,
  email VARCHAR(75) NOT NULL,
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL
  );

# Create additional_resources table #
CREATE TABLE additional_resources (
  resourceid CHAR(16) NOT NULL PRIMARY KEY,
  name VARCHAR(75) NOT NULL,
  status CHAR(1) NOT NULL DEFAULT 'a',
  number_available INTEGER NOT NULL DEFAULT -1
  );

# Create indexes ON additional_resources table #
CREATE INDEX ar_name ON additional_resources (name);
CREATE INDEX ar_status ON additional_resources (status);

# Create reservation_resources table #
CREATE TABLE reservation_resources (
  resid CHAR(16) NOT NULL,
  resourceid CHAR(16) NOT NULL,
  owner SMALLINT,
  PRIMARY KEY(resid, resourceid)
  );

CREATE INDEX resresources_resid ON reservation_resources (resid);
CREATE INDEX resresources_resourceid ON reservation_resources (resourceid);
CREATE INDEX resresources_owner ON reservation_resources (owner);

CREATE TABLE mutex(
  i INTEGER NOT NULL PRIMARY KEY
  );

INSERT INTO mutex VALUES (0);
INSERT INTO mutex VALUES (1);

# PostgreSQL support #
ALTER TABLE reservations CHANGE startTime starttime INTEGER NOT NULL;
ALTER TABLE reservations CHANGE endTime endtime INTEGER NOT NULL;
ALTER TABLE resources CHANGE minRes minres INTEGER NOT NULL;
ALTER TABLE resources CHANGE maxRes maxres INTEGER NOT NULL;
ALTER TABLE resources CHANGE autoAssign autoassign SMALLINT;

ALTER TABLE schedules CHANGE scheduleTitle scheduletitle CHAR(75);
ALTER TABLE schedules CHANGE dayStart daystart INTEGER NOT NULL;
ALTER TABLE schedules CHANGE dayEnd dayend INTEGER NOT NULL;
ALTER TABLE schedules CHANGE timeSpan timespan INTEGER NOT NULL;
ALTER TABLE schedules CHANGE timeFormat timeformat INTEGER NOT NULL;
ALTER TABLE schedules CHANGE weekDayStart weekdaystart INTEGER NOT NULL;
ALTER TABLE schedules CHANGE viewDays viewdays INTEGER NOT NULL;
ALTER TABLE schedules CHANGE usePermissions usepermissions SMALLINT;
ALTER TABLE schedules CHANGE isHidden ishidden SMALLINT;
ALTER TABLE schedules CHANGE showSummary showsummary SMALLINT;
ALTER TABLE schedules CHANGE adminEmail adminemail CHAR(75);
ALTER TABLE schedules CHANGE isDefault isdefault SMALLINT;

# Add support for groups #
CREATE TABLE groups (
  groupid CHAR(16) NOT NULL PRIMARY KEY,
  group_name VARCHAR(50) NOT NULL
  );

CREATE TABLE user_groups (
  groupid CHAR(16) NOT NULL,
  memberid CHAR(50) NOT NULL,
  is_admin SMALLINT NOT NULL DEFAULT 0
  );

CREATE INDEX usergroups_groupid ON user_groups (groupid);
CREATE INDEX usergroups_memberid ON user_groups (memberid);
CREATE INDEX usergroups_is_admin ON user_groups (is_admin);

# Create reminders table #
CREATE TABLE reminders (
  reminderid CHAR(16) NOT NULL PRIMARY KEY,
  memberid CHAR(16) NOT NULL,
  resid CHAR(16) NOT NULL,
  reminder_time BIGINT NOT NULL
  );

CREATE INDEX reminders_time ON reminders (reminder_time);
CREATE INDEX reminders_memberid ON reminders (memberid);
CREATE INDEX reminders_resid ON reminders (resid);

# Store lang for RSS and email reminders #
ALTER TABLE login ADD COLUMN lang VARCHAR(5);

# Store timezone for each user #
ALTER TABLE login ADD COLUMN timezone FLOAT NOT NULL DEFAULT 0;

# Add support for min/max notice time
ALTER TABLE resources ADD COLUMN min_notice_time INTEGER NOT NULL DEFAULT 0;
ALTER TABLE resources ADD COLUMN max_notice_time INTEGER NOT NULL DEFAULT 0;
UPDATE resources, schedules SET min_notice_time = dayoffset * 24 WHERE resources.scheduleid = schedules.scheduleid AND dayoffset IS NOT NULL;
ALTER TABLE schedules DROP COLUMN dayoffset;