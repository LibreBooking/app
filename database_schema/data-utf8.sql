insert into user_statuses values (1, 'Active'), (2, 'Awaiting'), (3, 'Inactive');
insert into roles values (1, 'Group Admin', 1);
insert into roles values (2, 'Application Admin', 2);
insert into reservation_types values (1, 'Reservation'), (2, 'Blackout');
insert into reservation_statuses values (1, 'Created'), (2, 'Deleted'), (3, 'Pending');
insert into resource_types (type_id, label) values (1, 'Resource');