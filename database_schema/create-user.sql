DROP USER IF EXISTS 'lb_user'@'%';
CREATE USER 'lb_user'@'%' identified by 'password';

DROP USER IF EXISTS 'lb_user'@'127.0.0.1';
CREATE USER 'lb_user'@'127.0.0.1' identified by 'password';

GRANT ALL on librebooking.* to 'lb_user'@'%';
GRANT ALL on librebooking.* to 'lb_user'@'127.0.0.1';
