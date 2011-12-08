<?php
$conf['settings']['domain.controllers'] = 'misc.ldap.ucalgary.ca'; // comma separated list of ldap servers such as misc.ldap.ucalgary.ca.
$conf['settings']['port'] = '389';      // default ldap port 389 or 636 for ssl.
$conf['settings']['username'] = '';     // admin user - bind to ldap service with an authorized account user/password
$conf['settings']['password'] = '';     // admin password - corresponding password
$conf['settings']['basedn'] =  'ou=people,o=ucalgary.ca';   // 'ou=uidauthent,o=domain.com';
$conf['settings']['version'] = '3';
$conf['settings']['use.ssl'] = 'false'; // 'true' if 636 was used.
$conf['settings']['account.suffix'] = '';
$conf['settings']['database.auth.when.ldap.user.not.found'] = 'false';
?>