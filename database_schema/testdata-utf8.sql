use phpscheduleit2;

truncate table resources;
insert into resources (name, requires_approval) values ('resource1', 0),('resource2', 0);

#insert into user_statuses (statusid, description) values (1, 'active');

truncate table users;
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created)
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'US/Central', '2008-09-16 01:59:00', 1, now());
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created)
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, now());

truncate table roles;
insert into roles values (1,'default admin',0),(2,'basic user',0),(3,'group admin',2),(4,'sysadmin',9);

truncate table user_roles;
insert into user_roles values (1, 1),(2, 1)

truncate table time_block_groups;
insert into time_block_groups values (1, 'Business Day');

truncate table time_blocks;
insert into time_blocks (blockid, label, availability_code, block_group_id, start_time, end_time) values
(2, 'Prime Time', 1, 1, '00:00', '12:00'),
(3, 'Off Hours', 1, 1, '12:00', '00:00');

truncate table organizations;
insert into organizations values (1, 'Default Organization'),(2, 'Other Organization');

truncate table groups;
insert into groups values (1, 'Default Group'),(2, 'Other Group');

truncate table addresses;
insert into addresses values (1, 'home', 'home street, city, state and country');

truncate table user_addresses;
insert into user_addresses values (1, 1);

truncate table reservation_types;
insert into reservation_types values (1, 'default'),(2, 'Down Time');

truncate table reservation_statuses;
insert into reservation_statuses values (1, 'Pending'),(2,'Approved'),(3,'Rejected');

truncate table schedules;
insert into schedules (scheduleid, name, isdefault, weekdaystart) values (1, 'default', 1, 0);

truncate table schedule_time_block_groups;
insert into schedule_time_block_groups values (1,1);

truncate table user_resource_permissions;
insert into user_resource_permissions values (1,1),(1,2),(2,1),(2,2);

truncate table resource_schedules;
insert into resource_schedules values(1, 1), (2, 1);