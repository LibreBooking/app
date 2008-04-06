<?php
/*
$config['server.timezone'] = 'US/Central';
$config['allow.self.registration'] = 'true';
$config['admin.email'] = 'admin@email.com';
$config['default.language'] = 'en_US';
$config['allow.rss'] = 'true';
$config['version'] = '2.0.0';
$config['script.url'] = 'http://localhost/phpscheduleit';
$config['use.logon.name'] = 'true';
$config['password.pattern'] = '/^[^\s]{6,}$/i';
$config['database.type'] = 'mysql';
$config['database.user'] = 'schedule_user';
$config['database.password'] = 'password';
$config['database.hostspec'] = '.';
$config['database.name'] = 'phpScheduleIt';

$plugins['Auth'] = 'Ldap';
*/


$conf['settings']['server.timezone'] = 'US/Central';
$conf['settings']['allow.self.registration'] = 'true';
$conf['settings']['admin.email'] = 'admin@email.com';
$conf['settings']['default.language'] = 'en_US';
$conf['settings']['allow.rss'] = 'true';
$conf['settings']['version'] = '2.0.0';
$conf['settings']['script.url'] = 'http://localhost/phpscheduleit';
$conf['settings']['use.logon.name'] = 'true';
$conf['settings']['password.pattern'] = '/^[^\s]{6,}$/i';
$conf['settings']['database']['type'] = 'mysql';
$conf['settings']['database']['user'] = 'schedule_user';
$conf['settings']['database']['password'] = 'password';
$conf['settings']['database']['hostspec'] = '.';
$conf['settings']['database']['name'] = 'phpScheduleIt';
$conf['settings']['plugins']['Auth'] = 'Ldap';
?>