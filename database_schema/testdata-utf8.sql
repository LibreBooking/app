use phpscheduleit2;

delete from resources;
alter table resources AUTO_INCREMENT = 1;
delete from  users;
alter table users AUTO_INCREMENT = 1;
delete from user_roles;
alter table user_roles AUTO_INCREMENT = 1;
delete from layouts;
alter table layouts AUTO_INCREMENT = 1;
delete from time_blocks;
alter table time_blocks AUTO_INCREMENT = 1;
delete from organizations;
alter table organizations AUTO_INCREMENT = 1;
delete from groups;
alter table groups AUTO_INCREMENT = 1;
delete from addresses;
alter table addresses AUTO_INCREMENT = 1;


insert into resources (name, type_id, requires_approval) values ('Conference Room 1', 1, 0),('Conference Room 2', 1, 0);


insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language)
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'America/Chicago', '2008-09-16 01:59:00', 1, now(), 'en_us');
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language)
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, now(), 'en_us');

insert into user_roles values (1, 2);
	
insert into layouts values (1, 'America/Chicago');

insert into time_blocks (availability_code, layout_id, start_time, end_time) values
(2, 1, '00:00', '08:00'),
(1, 1, '08:00', '08:30'),
(1, 1, '08:30', '09:00'),
(1, 1, '09:00', '09:30'),
(1, 1, '09:30', '10:00'),
(1, 1, '10:00', '10:30'),
(1, 1, '10:30', '11:00'),
(1, 1, '11:00', '11:30'),
(1, 1, '11:30', '12:00'),
(1, 1, '12:00', '12:30'),
(1, 1, '12:30', '13:00'),
(1, 1, '13:00', '13:30'),
(1, 1, '13:30', '14:00'),
(1, 1, '14:00', '14:30'),
(1, 1, '14:30', '15:00'),
(1, 1, '15:00', '15:30'),
(1, 1, '15:30', '16:00'),
(1, 1, '16:00', '16:30'),
(1, 1, '16:30', '17:00'),
(1, 1, '17:00', '17:30'),
(1, 1, '17:30', '18:00'),
(2, 1, '18:00', '00:00');


insert into organizations values (1, 'Default Organization'),(2, 'Other Organization');

insert into groups values (1, 'Default Group'),(2, 'Other Group');

insert into addresses values (1, 'home', 'home street, city, state and country');

truncate table user_addresses;
insert into user_addresses values (1, 1);

delete from schedules;
alter table schedules AUTO_INCREMENT = 1;
insert into schedules (schedule_id, name, isdefault, weekdaystart, layout_id) values (1, 'default', 1, 0, 1);

truncate table user_resource_permissions;
insert into user_resource_permissions values (1,1,1),(1,2,1),(2,1,1),(2,2,1);

truncate table resource_schedules;
insert into resource_schedules values(1, 1), (2, 1);