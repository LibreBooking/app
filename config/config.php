<?php
error_reporting(E_ALL & ~E_NOTICE);

$conf['settings']['server.timezone'] = 'America/Chicago';
$conf['settings']['allow.self.registration'] = 'true';
$conf['settings']['admin.email'] = 'admin@example.com';
$conf['settings']['default.page.size'] = '50';
$conf['settings']['enable.email'] = 'true';
$conf['settings']['default.language'] = 'en_US';
$conf['settings']['allow.rss'] = 'true';
$conf['settings']['version'] = '2.0.0';
$conf['settings']['script.url'] = 'http://localhost:8080/';
$conf['settings']['password.pattern'] = '/^[^\s]{6,}$/i';
$conf['settings']['schedule']['show.inaccessible.resources'] = 'true';
$conf['settings']['database']['type'] = 'mysql';
$conf['settings']['database']['user'] = 'schedule_user';
$conf['settings']['database']['password'] = 'password';
$conf['settings']['database']['hostspec'] = '127.0.0.1';
$conf['settings']['database']['name'] = 'phpscheduleit2';
$conf['settings']['reservation']['notify.created'] = 'true';
$conf['settings']['phpmailer']['mailer'] = 'mail';
$conf['settings']['phpmailer']['smtp.host'] = '';
$conf['settings']['phpmailer']['smtp.port'] = '';
$conf['settings']['phpmailer']['smtp.secure'] = '';
$conf['settings']['phpmailer']['smtp.auth'] = '';
$conf['settings']['phpmailer']['smtp.username'] = '';
$conf['settings']['phpmailer']['smtp.password'] = '';
$conf['settings']['image.upload.directory'] = 'Web/uploads/images';		// from root directory, ie public_html/phpscheduleit/Web/uploads/images should be set to Web/uploads/images
$conf['settings']['image.upload.url'] = 'uploads/images';				// from script.url
$conf['settings']['cache.templates'] = 'true';
$conf['settings']['plugins']['Authentication'] = '';
$conf['settings']['plugins']['Authorization'] = '';
$conf['settings']['plugins']['Permission'] = '';
$conf['settings']['install.password'] = '';
?>