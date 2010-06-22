# phpScheduleIt 1.2.0 #
drop database if exists phpScheduleIt;
create database phpScheduleIt;
use phpScheduleIt;

# Create announcements table #
CREATE TABLE announcements (
    announcementid CHAR(16) NOT NULL PRIMARY KEY,
    announcement VARCHAR(255) NOT NULL DEFAULT '',
    number SMALLINT NOT NULL DEFAULT '0',
    start_datetime INTEGER,
    end_datetime INTEGER
);

# Create indexes ON announcements table #
CREATE INDEX announcements_startdatetime ON announcements(start_datetime);
CREATE INDEX announcements_enddatetime ON announcements(end_datetime);

# Create login table #
CREATE TABLE login (
  memberid CHAR(16) NOT NULL PRIMARY KEY,
  email VARCHAR(75) NOT NULL,
  password CHAR(32) NOT NULL,
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL,
  phone VARCHAR(16) NOT NULL,
  institution VARCHAR(255),
  position VARCHAR(100),
  e_add CHAR(1) NOT NULL DEFAULT 'y',
  e_mod CHAR(1) NOT NULL DEFAULT 'y',
  e_del CHAR(1) NOT NULL DEFAULT 'y',
  e_app CHAR(1) NOT NULL DEFAULT 'y',
  e_html CHAR(1) NOT NULL DEFAULT 'y',
  logon_name VARCHAR(30),
  is_admin SMALLINT DEFAULT 0,
  lang VARCHAR(5),
  timezone FLOAT NOT NULL DEFAULT 0
  );

# Create indexes ON login table #
CREATE INDEX login_email ON login (email);
CREATE INDEX login_password ON login (password);
CREATE INDEX login_logonname ON login (logon_name);

# Create reservations table #  
CREATE TABLE reservations (
  resid CHAR(16) NOT NULL PRIMARY KEY,
  machid CHAR(16) NOT NULL,
  scheduleid CHAR(16) NOT NULL,
  start_date INT NOT NULL DEFAULT 0,
  end_date INT NOT NULL DEFAULT 0,
  starttime INTEGER NOT NULL,
  endtime INTEGER NOT NULL,
  created INTEGER NOT NULL,
  modified INTEGER,
  parentid CHAR(16),
  is_blackout SMALLINT NOT NULL DEFAULT 0,
  is_pending SMALLINT NOT NULL DEFAULT 0,
  summary TEXT,
  allow_participation SMALLINT NOT NULL DEFAULT 0,
  allow_anon_participation SMALLINT NOT NULL DEFAULT 0
  );

# Create indexes ON reservations table #
CREATE INDEX res_machid ON reservations (machid);
CREATE INDEX res_scheduleid ON reservations (scheduleid);
CREATE INDEX reservations_startdate ON reservations (start_date);
CREATE INDEX reservations_enddate ON reservations (end_date);
CREATE INDEX res_startTime ON reservations (starttime);
CREATE INDEX res_endTime ON reservations (endtime);
CREATE INDEX res_created ON reservations (created);
CREATE INDEX res_modified ON reservations (modified);
CREATE INDEX res_parentid ON reservations (parentid);
CREATE INDEX res_isblackout ON reservations (is_blackout);
CREATE INDEX reservations_pending ON reservations (is_pending);

# Create resources table #
CREATE TABLE resources (
  machid CHAR(16) NOT NULL PRIMARY KEY,
  scheduleid CHAR(16) NOT NULL,
  name VARCHAR(75) NOT NULL,
  location VARCHAR(250),
  rphone VARCHAR(16),
  notes TEXT,
  status CHAR(1) NOT NULL DEFAULT 'a',
  minres INTEGER NOT NULL,
  maxres INTEGER NOT NULL,
  autoassign SMALLINT,
  approval SMALLINT,
  allow_multi SMALLINT,
  max_participants INTEGER,
  min_notice_time INTEGER,
  max_notice_time INTEGER
  );

# Create indexes ON resources table #
CREATE INDEX rs_scheduleid ON resources (scheduleid);
CREATE INDEX rs_name ON resources (name);
CREATE INDEX rs_status ON resources (status);

# Create permission table #
CREATE TABLE permission (
  memberid CHAR(16) NOT NULL,
  machid CHAR(16) NOT NULL,
  PRIMARY KEY(memberid, machid)
  );
  
# Create indexes ON permission table #
CREATE INDEX per_memberid ON permission (memberid);
CREATE INDEX per_machid ON permission (machid);

# Create schedules table #
CREATE TABLE schedules (
  scheduleid CHAR(16) NOT NULL PRIMARY KEY,
  scheduletitle CHAR(75),
  daystart INTEGER NOT NULL,
  dayend INTEGER NOT NULL,
  timespan INTEGER NOT NULL,
  timeformat INTEGER NOT NULL,
  weekdaystart INTEGER NOT NULL,
  viewdays INTEGER NOT NULL,
  usepermissions SMALLINT,
  ishidden SMALLINT,
  showsummary SMALLINT,
  adminemail VARCHAR(75),
  isdefault SMALLINT
  );
  
# Create DEFAULT schedule #
INSERT INTO schedules VALUES ('sc1423642970aa9f','default',480,1200,30,12,0,7,0,0,1,'admin@email.com',1);

# Create indexes ON schedules table #
CREATE INDEX sh_hidden ON schedules (ishidden);
CREATE INDEX sh_perms ON schedules (usepermissions);

# Create schedule permission tables
CREATE TABLE schedule_permission (
  scheduleid CHAR(16) NOT NULL,
  memberid CHAR(16) NOT NULL,
  PRIMARY KEY(scheduleid, memberid)
  );

# Create schedule permission indexes #
CREATE INDEX sp_scheduleid ON schedule_permission (scheduleid);
CREATE INDEX sp_memberid ON schedule_permission (memberid);
  
# Create reservation/user association table #
CREATE TABLE reservation_users (
  resid CHAR(16) NOT NULL,
  memberid CHAR(16) NOT NULL,
  owner SMALLINT,
  invited SMALLINT,
  perm_modify SMALLINT,
  perm_delete SMALLINT,
  accept_code CHAR(16),
  PRIMARY KEY(resid, memberid)
  );

CREATE INDEX resusers_resid ON reservation_users (resid);
CREATE INDEX resusers_memberid ON reservation_users (memberid);
CREATE INDEX resusers_owner ON reservation_users (owner);

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

# Create mutex table (circumvents MySQL limitations) #
CREATE TABLE mutex (
  i INTEGER NOT NULL PRIMARY KEY
  );

INSERT INTO mutex VALUES (0);
INSERT INTO mutex VALUES (1);

# Create groups table #
CREATE TABLE groups (
  groupid CHAR(16) NOT NULL PRIMARY KEY,
  group_name VARCHAR(50) NOT NULL
  );


# Create user/group relationship table #
CREATE TABLE user_groups (
  groupid CHAR(16) NOT NULL,
  memberid CHAR(50) NOT NULL,
  is_admin SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY(groupid, memberid)
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

grant select, insert, update, delete
ON phpScheduleIt.*
to schedule_user@localhost identified by 'password';

#SET PASSWORD FOR schedule_user@localhost = OLD_PASSWORD('password');