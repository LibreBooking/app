DROP USER IF EXISTS 'schedule_user'@'localhost';
DROP USER IF EXISTS 'schedule_user'@'127.0.0.1';

CREATE USER 'schedule_user'@'localhost' identified by 'password';
CREATE USER 'schedule_user'@'127.0.0.1' identified by 'password';

GRANT ALL on librebooking.* to 'schedule_user'@'localhost';
GRANT ALL on librebooking.* to 'schedule_user'@'127.0.0.1';
