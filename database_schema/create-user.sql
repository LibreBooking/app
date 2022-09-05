DROP USER IF EXISTS 'schedule_user'@'%';
DROP USER IF EXISTS 'schedule_user'@'127.0.0.1';

CREATE USER 'schedule_user'@'%' identified by 'password';
CREATE USER 'schedule_user'@'127.0.0.1' identified by 'password';

GRANT ALL on librebooking.* to 'schedule_user'@'%';
GRANT ALL on librebooking.* to 'schedule_user'@'127.0.0.1';
