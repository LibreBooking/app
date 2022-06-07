DROP USER IF EXISTS 'lb_user'@'localhost';
DROP USER IF EXISTS 'lb_user'@'127.0.0.1';

CREATE USER 'lb_user'@'localhost' identified by 'password';
CREATE USER 'lb_user'@'127.0.0.1' identified by 'password';

GRANT ALL on librebooking.* to 'lb_user'@'localhost';
GRANT ALL on librebooking.* to 'lb_user'@'127.0.0.1';
