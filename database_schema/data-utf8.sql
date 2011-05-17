use phpscheduleit2;

insert into user_statuses values (1, 'active'), (2, 'awaiting'), (3, 'inactive');
insert into roles values (1, 'user', 1), (2, 'admin', 2);
insert into long_quotas (long_quotaid, label) values (1, 'default long quota');
insert into day_quotas (day_quotaid, label) values (1, 'default day quota');
insert into constraint_functions values (1, '');
insert into organizations values (1, 'default organization');
insert into groups values (1, 'default group');
insert into resource_types values (1, 'default');
insert into reservation_types values (1, 'Reservation'), (2, 'Blackout');
insert into reservation_statuses values (1, 'Active'), (2, 'Deleted');