--
-- Table structure for table 'users'
--

DROP TABLE IF EXISTS 'users';
CREATE TABLE 'users' (
 'userid' int(10) unsigned NOT NULL auto_increment,
 'user_roleid' tinyint(2) unsigned NOT NULL default '1',
 'username' varchar(85) default NULL,
 'email' varchar(85) NOT NULL,
 'password' varchar(85) NOT NULL,
 'salt' varchar(85) NOT NULL,
 'fname' varchar(85) NOT NULL,
 'lname' varchar(85) NOT NULL,
 'phone' varchar(85) default NULL,
 'organizationid' mediumint(8) unsigned NOT NULL,
 'groupid' mediumint(8) unsigned NOT NULL default '0',
 'position' varchar(85) default NULL,
 'address' text default NULL,
 'timezone' varchar(85) NOT NULL,
 'lastlogin' datetime default NULL,
 'legacypassword' varchar(32) default NULL,
 'legacyid' char(16) default NULL,
 'homepageid' tinyint(2) unsigned NOT NULL default '1',
 PRIMARY KEY ('userid'),
 INDEX org_id ('organizationid'),
 FOREIGN KEY ('organizationid') REFERENCES organizations('orgid'),
 INDEX group_id ('groupid'),
 FOREIGN KEY ('groupid') REFERENCES user_groups('groupid'),
 INDEX accountrole_id ('accountroleid'),
 FOREIGN KEY ('accountroleid') REFERENCES user_roles('roleid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'organizations'
--

DROP TABLE IF EXISTS 'organizations';
CREATE TABLE 'organizations' (
 'orgid' mediumint(8) unsigned NOT NULL auto_increment,
 'name' varchar(85) NOT NULL,
 PRIMARY KEY  ('orgid'),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'user_groups'
--

DROP TABLE IF EXISTS 'user_groups';
CREATE TABLE 'user_groups' (
 'groupid' mediumint(8) unsigned NOT NULL auto_increment,
 'name' varchar(85) NOT NULL,
 PRIMARY KEY  ('groupid'),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'user_roles'
--

DROP TABLE IF EXISTS 'user_roles';
CREATE TABLE 'user_roles' (
 'roleid' tinyint(2) unsigned NOT NULL default '1',
 'role_name' varchar(85) NOT NULL,
 PRIMARY KEY  ('accountroleid'),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'reservation_info'
--

DROP TABLE IF EXISTS 'reservation_info';
CREATE TABLE 'reservation_info' (
 'reservation_infoid' int(10) unsigned NOT NULL auto_increment,
 'reserving_userid' int(10) unsigned NOT NULL,
 'start_date' datetime NOT NULL,
 'end_date' datetime NOT NULL,
 'date_created' datetime NOT NULL,
 'date_last_modified' datetime default NULL,
 'summary' text,
 'allow_participation' tinyint(1) unsigned NOT NULL default '0',
 'allow_anon_participation' tinyint(1) unsigned NOT NULL default '0',
 'typeid' int(10) unsigned NOT NULL,
 'statusid' int(10) unsigned NOT NULL,
 PRIMARY KEY  ('reservation_infoid'),
 INDEX res_user_id ('reserving_userid'),
 FOREIGN KEY ('reserving_userid') REFERENCES users('userid')
 INDEX type_id ('typeid'),
 FOREIGN KEY ('typeid') REFERENCES reservation_type('typeid'),
 INDEX status_id ('statusid'),
 FOREIGN KEY ('statusid') REFERENCES reservation_status('statusid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'reservation_type'
--

DROP TABLE IF EXISTS 'reservation_type';
CREATE TABLE 'reservation_type' (
 'typeid' int(10) unsigned NOT NULL auto_increment,
 'type_name' varchar(85) NOT NULL,
 PRIMARY KEY  ('typeid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'reservation_status'
--

DROP TABLE IF EXISTS 'reservation_status';
CREATE TABLE 'reservation_status' (
 'statusid' int(10) unsigned NOT NULL auto_increment,
 'status_name' varchar(85) NOT NULL,
 PRIMARY KEY  ('statusid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'reservations'
--

DROP TABLE IF EXISTS 'reservations';
CREATE TABLE 'reservations' (
 'reservation_id' int(10) unsigned NOT NULL auto_increment,
 'reservation_infoid' int(10) unsigned NOT NULL,
 'resourceid' int(10) unsigned NOT NULL,
 PRIMARY KEY  ('reservation_id'),
 INDEX reservation_id ('reservation_infoid'),
 FOREIGN KEY ('reservation_infoid') REFERENCES reservation_info('reservation_infoid'),
 INDEX resource_id ('resourceid'),
 FOREIGN KEY ('resourceid') REFERENCES resource('resourceid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'resources'
--

DROP TABLE IF EXISTS 'resources';
CREATE TABLE 'resources' (
 'resourceid' int(10) unsigned NOT NULL auto_increment,
 'name' varchar(85) NOT NULL,
 'location' varchar(85) default NULL,
 'phone' varchar(85) default NULL,
 'notes' text,
 'isactive' tinyint(1) unsigned NOT NULL default '1',
 'min_duration' time default NULL,
 'max_duration' time default NULL,
 'autoassign' tinyint(1) unsigned NOT NULL default '0',
 'requires_approval' tinyint(1) unsigned NOT NULL default '0',
 'allow_multiple_day_reservations' tinyint(1) unsigned NOT NULL default '1',
 'max_participants' int(10) unsigned default NULL,
 'min_notice_time' time default NULL,
 'max_notice_time' time default NULL,
 'constraintid' smallint(5) unsigned NOT NULL default '0',
 'legacyid' char(16) default NULL,
 PRIMARY KEY  ('resourceid'),
 INDEX constraint_id ('constraintid'),
 FOREIGN KEY ('constraintid') REFERENCES resource_constraints('constraintid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'resource_constraints'
--

DROP TABLE IF EXISTS 'resource_constraints';
CREATE TABLE 'resource_constraints' (
 'constraintid' smallint(5) unsigned NOT NULL default '0',
 'constraint_function' text,
 PRIMARY KEY ('constraintid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'resource_permissions'
--

DROP TABLE IF EXISTS 'resource_permissions';
CREATE TABLE 'resource_permissions' (
 'permissionid' bigint(20) unsigned NOT NULL auto_increment,
 'resourceid' int(10) unsigned NOT NULL,
 'userid' int(10) unsigned NOT NULL,
 PRIMARY KEY ('permissionid')
 INDEX resource_id ('resourceid'),
 FOREIGN KEY ('resourceid') REFERENCES resources('resourceid'),
 INDEX user_id ('userid'),
 FOREIGN KEY ('userid') REFERENCES users('userid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'schedules'
--

DROP TABLE IF EXISTS 'schedules';
CREATE TABLE 'schedules' (
 'scheduleid' int(10) unsigned NOT NULL auto_increment,
 'name' varchar(85) NOT NULL,
 'isdefault' tinyint(1) unsigned NOT NULL default '0',
 'daystart' date NOT NULL,
 'dayend' date NOT NULL,
 'weekdaystart' tinyint(2) unsigned NOT NULL default '0',
 'adminid' int(10) unsigned NOT NULL,
 'daysvisible' tinyint(2) unsigned NOT NULL default '7',
 PRIMARY KEY ('scheduleid')
 INDEX admin_id ('adminid'),
 FOREIGN KEY ('adminid') REFERENCES users('userid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'resource_schedules'
--

DROP TABLE IF EXISTS 'resource_schedules';
CREATE TABLE 'resource_schedules' (
 'resource_scheduleid' int(10) unsigned NOT NULL,
 'scheduleid' int(10) unsigned NOT NULL,
 'resourceid' int(10) unsigned NOT NULL,
 PRIMARY KEY ('resourcescheduleid')
 INDEX schedule_id ('scheduleid'),
 FOREIGN KEY ('scheduleid') REFERENCES schedules('scheduleid'),
 INDEX resource_id ('resourceid'),
 FOREIGN KEY ('resourceid') REFERENCES resources('resourceid')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'announcements'
--

DROP TABLE IF EXISTS 'announcements';
CREATE TABLE 'announcements' (
 'announcementid' int(10) unsigned NOT NULL auto_increment,
 'announcement_text' text NOT NULL,
 'order_number' smallint(5) unsigned NOT NULL default '0',
 'start_datetime' datetime default NULL,
 'end_datetime' datetime default NULL,
 PRIMARY KEY ('announcementid'),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


