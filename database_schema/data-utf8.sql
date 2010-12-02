insert into user_statuses values (1, 'active');
insert into roles values (1, 'admin', 1);
insert into long_quotas (long_quotaid, label) values (1, 'default long quota');
insert into day_quotas (day_quotaid, label) values (1, 'default day quota');
insert into constraint_functions values (1, '');
insert into time_block_groups values (1, 'default day layout');
/*insert into time_blocks (blockid, label, block_group_id, start_time, end_time) values (1, 'default time block', 1, '00:00', '23:59:59');*/
/*insert into time_block_uses (block_id, block_group_id, start_time, end_time) values (1, 1, '00:00', '23:59');*/
insert into organizations values (1, 'default organization');
insert into groups values (1, 'default group');
insert into reservation_types values (1, 'Reservation'),;
insert into reservation_statuses values (1, 'Active'), (2, 'Deleted');