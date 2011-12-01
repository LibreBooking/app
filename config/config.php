<?php
error_reporting(E_ALL & ~E_NOTICE);
/**
 * Application configuration
 */
$conf['settings']['server.timezone'] = 'America/Edmonton';   // look up here http://php.net/manual/en/timezones.php
$conf['settings']['allow.self.registration'] = 'false';  // this is email self registration on home page the other is optional LDAP authentication. You may have both at the same time
$conf['settings']['admin.email'] = 'dule@ucalgary.ca'; // notification email to be sent to admin user
$conf['settings']['default.page.size'] = '50';  // number of records per page
$conf['settings']['enable.email'] = 'true'; // sending auto email to users
$conf['settings']['default.language'] = 'en_US';    // find your language in phpScheduleIt/lang directory
$conf['settings']['allow.rss'] = 'true';    // rss
$conf['settings']['version'] = '2.0.0'; // latest
$conf['settings']['script.url'] = 'http://localhost/development';   // http://localhost/';
$conf['settings']['password.pattern'] = '/^[^\s]{6,}$/i';
$conf['settings']['schedule']['show.inaccessible.resources'] = 'true';
$conf['settings']['reservation']['notify.created'] = 'true';    // notifying a booking event
$conf['settings']['image.upload.directory'] = 'Web/uploads/images'; // ie public_html/phpscheduleit/Web/uploads/images
$conf['settings']['image.upload.url'] = 'uploads/images';   // relative to script.url
$conf['settings']['cache.templates'] = 'true';  // caching template files helps webpages render faster
/**
 * Database configuration
 */
$conf['settings']['database']['type'] = 'mysql';
$conf['settings']['database']['user'] = 'schedule_user';    // default user
$conf['settings']['database']['password'] = 'password'; // default password
$conf['settings']['database']['hostspec'] = '127.0.0.1';    // mysql.acs.university.com
$conf['settings']['database']['name'] = 'phpscheduleit2';
/**
 * Mail server configuration
 *
 *  'mail' for PHP default mail
 *  'smtp' for SMTP
 *  'sendmail' for sendmail
 *  'qmail' for qmail MTA
 *
 *  Path to sendmail ['/usr/sbin/sendmail']. This only needs to be set if the emailType is 'sendmail'
 *  $conf['app']['sendmailPath'] = '/usr/sbin/sendmail';
 */
$conf['settings']['phpmailer']['mailer'] = 'sendmail';  // type of mail server e.g $conf['app']['emailType'] = 'sendmail';
$conf['settings']['phpmailer']['smtp.host'] = '';   // 'smtp.university.ca'
$conf['settings']['phpmailer']['smtp.port'] = '';   // '25'
$conf['settings']['phpmailer']['smtp.secure'] = ''; // 'ssl'
$conf['settings']['phpmailer']['smtp.auth'] = '';   // 'Password'
$conf['settings']['phpmailer']['smtp.username'] = '';   // 'username'
$conf['settings']['phpmailer']['smtp.password'] = '';   // 'password'
/**
 * Authentication configuration
 *
 * Read /plugins/Authentication/readme.txt
 */
$conf['settings']['plugins']['Authentication'] = '';
$conf['settings']['plugins']['Authorization'] = '';
$conf['settings']['plugins']['Permission'] = '';
/**
 * Installation settings
 */
$conf['settings']['install.password'] = '';
?>