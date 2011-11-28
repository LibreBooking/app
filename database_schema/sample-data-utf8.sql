use phpscheduleit2;

delete from groups where admin_group_id is not null;
delete from groups;
alter table groups AUTO_INCREMENT = 1;
delete from resources;
alter table resources AUTO_INCREMENT = 1;
delete from accessories;
alter table accessories AUTO_INCREMENT = 1;
delete from users;
alter table users AUTO_INCREMENT = 1;
delete from layouts;
alter table layouts AUTO_INCREMENT = 1;
delete from time_blocks;
alter table time_blocks AUTO_INCREMENT = 1;
delete from schedules;
alter table schedules AUTO_INCREMENT = 1;

insert into groups values (1, 'Group Administrators', null), (2, 'Application Administrators', null);

insert into group_roles values (1, 1);
insert into group_roles values (2, 2);

insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language, organization)
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '3b3dbb9b', 'America/Chicago', '2008-09-16 01:59:00', 1, now(), 'en_us', 'XYZ Org Inc.');
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language, organization)
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, now(), 'en_us', 'ABC Org Inc.');

insert into user_groups values (1, 2);

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

insert into schedules (schedule_id, name, isdefault, weekdaystart, layout_id) values (1, 'default', 1, 0, 1);

insert into resources (`resource_id`, `name`, `type_id`, `location`, `contact_info`, `description`, `notes`, `isactive`, `min_duration`, `min_increment`, `max_duration`, `unit_cost`, `autoassign`, `requires_approval`, `allow_multiday_reservations`, `max_participants`, `min_notice_time`, `max_notice_time`, `image_name`, `legacyid`, `schedule_id`) VALUES
(1, 'Conference Room 1', 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 'resource1.jpg', NULL, 1),
(2, 'Conference Room 2', 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 'resource2.jpg', NULL, 1);

insert into accessories (`accessory_id`, `accessory_name`, `accessory_quantity`) values
(1, 'accessory limited to 10', 10),
(2, 'accessory limited to 2', 2),
(3, 'unlimited accessory', NULL);

truncate table user_resource_permissions;
insert into user_resource_permissions values (1,1,1),(1,2,1),(2,1,1),(2,2,1);