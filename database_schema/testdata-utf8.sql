insert into resources (name) values ('resource1'),('resource2');
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, role_id, status_id) 
	values ('Jan', 'Mattila', 'jan.mattila@helvet.fi', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'Europe/Helsinki', '2010-03-26 12:44:00', 1, 1);
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, role_id, status_id) 
	values ('Nick', 'Korbel', 'nkorbel@gmail.com', 'nkorbel', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'US/Central', '2008-09-16 01:59:00', 1, 1);
insert into time_block_groups values (2, 'Business Day'),(3, 'Weekend');
insert into time_blocks values (2, 'Prime Time'),(3, 'Off Hours');
insert into organizations values (2, 'Other Organization');
insert into groups values (2, 'Other Group');
insert into user_roles values (2,'basic user',0),(3,'group admin',2),(4,'sysadmin',9);
insert into user_address values (1,'home street, city, state and country', 'home');
insert into reservation_type values (2, 'Down Time');
insert into reservation_status values (2, 'Pending'),(3,'Approved'),(4,'Rejected');	
