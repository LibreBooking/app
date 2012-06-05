<?php
$conf['settings']['domain.controllers'] = 'LisCorpDC01'; // comma separated list of ldap servers such as misc.ldap.ucalgary.ca.
$conf['settings']['port'] = '389';  // default ldap port 389 or 636 for ssl.
$conf['settings']['username'] = '';   // bind to ldap service with an authorized account user/password
$conf['settings']['password'] = ''; // corresponding password
$conf['settings']['basedn'] =  'DC=corp,DC=coinstar,DC=com';   // 'ou=uidauthent,o=domain.com';
$conf['settings']['version'] = '3';
$conf['settings']['use.ssl'] = 'false'; // 'true' if 636 was used.
$conf['settings']['account.suffix'] = '@corp.coinstar.com';
$conf['settings']['database.auth.when.ldap.user.not.found'] = 'false';
?>