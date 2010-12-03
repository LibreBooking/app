use phpscheduleit2;

truncate table resources;
truncate table users;
truncate table roles;
truncate table user_roles;
truncate table time_block_groups;
truncate table time_blocks;
truncate table organizations;
truncate table groups;
truncate table addresses;


insert into resources (name, type_id, requires_approval) values ('resource1', 1, 0),('resource2', 1, 0);

insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language)
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'America/Chicago', '2008-09-16 01:59:00', 1, now(), 'en_us');
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language)
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, now(), 'en_us');


insert into roles values (1,'default admin',0),(2,'basic user',0),(3,'group admin',2),(4,'sysadmin',9);

insert into user_roles values (1, 1),(2, 1);

insert into time_block_groups values (1, 'Business Day');

insert into time_blocks (blockid, label, availability_code, block_group_id, start_time, end_time) values
(1, '', 1, 1, '00:00', '06:00'),
(2, '', 1, 1, '06:00', '08:00'),
(3, '', 2, 1, '08:00', '12:00'),
(4, '', 1, 1, '12:00', '18:00'),
(5, '', 1, 1, '18:00', '00:00');


insert into organizations values (1, 'Default Organization'),(2, 'Other Organization');

insert into groups values (1, 'Default Group'),(2, 'Other Group');

insert into addresses values (1, 'home', 'home street, city, state and country');

truncate table user_addresses;
insert into user_addresses values (1, 1);

truncate table schedules;
insert into schedules (scheduleid, name, isdefault, weekdaystart) values (1, 'default', 1, 0);

truncate table schedule_time_block_groups;
insert into schedule_time_block_groups values (1,1);

truncate table user_resource_permissions;
insert into user_resource_permissions values (1,1,1),(1,2,1),(2,1,1),(2,2,1);

truncate table resource_schedules;
insert into resource_schedules values(1, 1), (2, 1);