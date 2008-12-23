insert into account (username, email, userpassword, salt, fname, lname, phone, timezonename, lastlogin, homepageid)
values ('nkorbel', 'nkorbel@gmail.com', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'Nick', 'Korbel', 'none', 'US/Central', '2008-09-16 01:59:00', 1);

insert into schedule (name, isdefault, daystart, dayend, weekdaystart, adminid, daysvisible) 
values ('schedule', 1, '06:00:00', '15:00:00', 0, 1, 7);

insert into resource (name)
values ('resource1');

insert into schedule_resource values (1, 1);

insert into reservation (start_date, end_date, date_created, allow_participation, allow_anon_participation, typeid, statusid)
values (now(), now(), now(), 0, 0, 1, 1);