use phpscheduleit2;

truncate table resources;
insert into resources (name, requires_approval) values ('resource1', 0),('resource2', 0);

truncate table users;
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created)
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'US/Central', '2008-09-16 01:59:00', 1, now());
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created)
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, now());

delete from user_roles;
insert into user_roles values (1,'basic user',0),(3,'group admin',2),(4,'sysadmin',9);

insert into user_statuses (statusid, description) select 1, 'active' from user_statuses where not exists (select 1 from user_statuses where statusid = 1);

truncate table time_block_groups;
insert into time_block_groups values (2, 'Business Day'),(3, 'Weekend Day');

truncate table time_blocks;
insert into time_blocks (blockid, label, availability_code) values (2, 'Prime Time', 0),(3, 'Off Hours', 0);

truncate table time_block_uses;
insert into time_block_uses (block_id, block_group_id, start_time, end_time) values (2, 2, '12:00', '16:59'),(3, 2, '17:00', '23:59'),(3, 2, '00:00', '11:59'),(3,3, '00:00', '23:59');

truncate table organizations;
insert into organizations values (2, 'Other Organization');

truncate table groups;
insert into groups values (2, 'Other Group');

truncate table addresses;
insert into addresses values (1, 'home', 'home street, city, state and country');

truncate table user_addresses;
insert into user_addresses values (1,1);

truncate table reservation_types;
insert into reservation_types values (2, 'Down Time');

truncate table reservation_statuses;
insert into reservation_statuses values (2, 'Pending'),(3,'Approved'),(4,'Rejected');

truncate table schedules;
insert into schedules (scheduleid, name, isdefault, weekdaystart) values (1, 'default', 1, 0);

truncate table schedule_time_block_groups;
insert into schedule_time_block_groups values (1,2);

truncate table user_resource_permissions;
insert into user_resource_permissions values (1,1),(1,2),(2,1),(2,2);