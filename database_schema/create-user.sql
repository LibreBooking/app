DROP USER 'booked_user'@'localhost';
DROP USER 'booked_user'@'127.0.0.1';

CREATE USER 'booked_user'@'localhost' identified by 'password';
CREATE USER 'booked_user'@'127.0.0.1' identified by 'password';

GRANT ALL on booked.* to 'booked_user'@'localhost';
GRANT ALL on booked.* to 'booked_user'@'127.0.0.1';