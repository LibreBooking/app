insert into resources (name) values ('resource1'),('resource2');
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, role_id, status_id) 
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'US/Central', '2008-09-16 01:59:00', 1, 1);
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, role_id, status_id) 
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, 1);
insert into time_block_groups values (2, 'Business Day'),(3, 'Weekend Day');
insert into time_blocks (blockid, label) values (2, 'Prime Time'),(3, 'Off Hours');
insert into time_block_uses (block_id, block_group_id, start_time, end_time) values (2, 2, '12:00', '16:59'),(3, 2, '17:00', '23:59'),(3, 2, '00:00', '11:59'),(3,3, '00:00', '23:59');
insert into organizations values (2, 'Other Organization');
insert into groups values (2, 'Other Group');
insert into user_roles values (2,'basic user',0),(3,'group admin',2),(4,'sysadmin',9);
insert into addresses values (1, 'home', 'home street, city, state and country');
insert into user_addresses values (1,1);
insert into reservation_types values (2, 'Down Time');
insert into reservation_statuses values (2, 'Pending'),(3,'Approved'),(4,'Rejected');	
insert into schedules (scheduleid, name) values (1, 'default');
insert into schedule_time_block_groups values (1,2);
insert into user_resource_permissions values (1,1),(1,2),(2,1),(2,2);
