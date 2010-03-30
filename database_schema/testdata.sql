truncate table users;
insert into users (username, email, userpassword, salt, fname, lname, phone, timezonename, lastlogin, homepageid, statusid)
values ('nkorbel', 'nkorbel@gmail.com', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'Nick', 'Korbel', 'none', 'US/Central', '2008-09-16 01:59:00', 1, 2);

truncate table user_groups;
insert into user_groups (name)
values('group1');

truncate table account_groups;
insert into account_groups (userid, groupid)
values (1, 1);

truncate table layout;
insert into layout (name) values ('default');

truncate table time_blocks;
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '00:00', '01:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '01:00', '02:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '02:00', '03:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '03:00', '04:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '04:00', '05:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '05:00', '06:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '06:00', '07:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '07:00', '08:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '08:00', '09:00', 1);
insert into time_blocks (layoutid, start_time, end_time, availability_code)
values(1, '09:00', '10:00', 1);

truncate table schedules;
insert into schedules (name, isdefault, daystart, dayend, weekdaystart, adminid, daysvisible, layoutid)
values ('schedule', 1, '06:00:00', '15:00:00', 0, 1, 7, 1);

truncate table resources;
insert into resources (name)
values ('resource1');
insert into resource (name)
values ('resource2');

truncate table resource_schedules;
insert into resource_schedules (schedule_id, resource_id)
values (1, 1);
insert into schedule_resource (schedule_id, resource_id)
values (1, 2);

truncate table group_resource_permissions;
insert into group_resource_permissions (resource_id, group_id)
values (1, 1);

truncate table user_resource_permission;
insert into user_resource_permission (resource_id, user_id)
values (2, 1);

truncate table reservations;
insert into reservation (start_date, end_date, date_created, allow_participation, allow_anon_participation, typeid, statusid)
values (now(), now(), now(), 0, 0, 1, 1);

truncate table reservation_resource;
insert into reservation_resource values(1,1);