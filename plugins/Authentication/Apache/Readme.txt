=======================
Setting up the Apache Authentication plugin for Booked Scheduler
=======================

The authentication is done by the Apache server. The username is obtained
from $_SERVER['REMOTE_USER']. If Kerberos is used, the realm is removed.

Make sure that it's working there correctly, because we have here almost no
additional checks on the authentication.


