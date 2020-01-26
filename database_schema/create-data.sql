insert into `user_statuses` values (1, 'Active'), (2, 'Awaiting'), (3, 'Inactive');
insert into `roles` values (1, 'Group Admin', 1);
insert into `roles` values (2, 'Application Admin', 2);
insert into `reservation_types` values (1, 'Reservation'), (2, 'Blackout');
insert into `reservation_statuses` values (1, 'Created'), (2, 'Deleted'), (3, 'Pending');

insert into `layouts` values (1, 'America/New_York', 0);

insert into `time_blocks` (`availability_code`, `layout_id`, `start_time`, `end_time`) values
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

insert into `schedules` (`schedule_id`, `name`, `isdefault`, `weekdaystart`, `layout_id`) values (1, 'Default', 1, 0, 1);