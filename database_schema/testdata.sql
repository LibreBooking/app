truncate table account;
insert into account (username, email, userpassword, salt, fname, lname, phone, timezonename, lastlogin, homepageid)
values ('nkorbel', 'nkorbel@gmail.com', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'Nick', 'Korbel', 'none', 'US/Central', '2008-09-16 01:59:00', 1);

truncate table groups;
insert into groups (name)
values('group1');

truncate table account_groups;
insert into account_groups (userid, groupid)
values (1, 1);

truncate table layout;
insert into layout (name) values ('default');

truncate table layout_period;
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '00:00', '01:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '01:00', '02:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '02:00', '03:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '03:00', '04:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '04:00', '05:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '05:00', '06:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '06:00', '07:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '07:00', '08:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '08:00', '09:00', 1);
insert into layout_period (layoutid, starttime, endtime, periodtypeid)
values(1, '09:00', '10:00', 1);

truncate table schedule;
insert into schedule (name, isdefault, daystart, dayend, weekdaystart, adminid, daysvisible, layoutid)
values ('schedule', 1, '06:00:00', '15:00:00', 0, 1, 7, 1);

truncate table resource;
insert into resource (name)
values ('resource1');
insert into resource (name)
values ('resource2');

truncate table schedule_resource;
insert into schedule_resource (scheduleid, resourceid)
values (1, 1);
insert into schedule_resource (scheduleid, resourceid)
values (1, 2);

truncate table resource_group_permissions;
insert into resource_group_permissions (resourceid, groupid)
values (1, 1);

truncate table resource_permission;
insert into resource_permission (resourceid, userid)
values (2, 1);

truncate table reservation;
insert into reservation (start_date, end_date, date_created, allow_participation, allow_anon_participation, typeid, statusid)
values (now(), now(), now(), 0, 0, 1, 1);

truncate table reservation_resource;
insert into reservation_resource values(1,1);

truncate table reservation_resource;
insert into reservation_resource values(1,1,1);