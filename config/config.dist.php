<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
/**
 * Application configuration
 */
$conf['settings']['server.timezone'] = 'America/Chicago';       // look up here http://php.net/manual/en/timezones.php
$conf['settings']['allow.self.registration'] = 'false';         // if users can register themselves
$conf['settings']['admin.email'] = 'admin@example.com';         // email address of admin user
$conf['settings']['default.page.size'] = '50';                  // number of records per page
$conf['settings']['enable.email'] = 'true';                     // global configuration to enable if any emails will be sent
$conf['settings']['default.language'] = 'en_US';                // find your language in phpScheduleIt/lang directory
$conf['settings']['script.url'] = 'http://localhost/Web';   	// public URL to the Web directory of this phpScheduleIt instance. this is the URL that appears when you are logging in
$conf['settings']['password.pattern'] = '/^[^\s]{6,}$/i';           // regular expression to enforce password complexity
$conf['settings']['schedule']['show.inaccessible.resources'] = 'true';  // whether or not resources that are inaccessible to the user are visible
$conf['settings']['schedule']['reservation.label'] = 'user';    // what to display on the reservation slot label. Options are: user, title, none
$conf['settings']['image.upload.directory'] = 'Web/uploads/images'; // ie public_html/phpscheduleit/Web/uploads/images
$conf['settings']['image.upload.url'] = 'uploads/images';       // path to show uploaded images from, relative to script.url
$conf['settings']['cache.templates'] = 'true';                  // recommended, caching template files helps web pages render faster
$conf['settings']['registration.captcha.enabled'] = 'true';     // recommended, requires php_gd2 enabled in php.ini
$conf['settings']['inactivity.timeout'] = '30';     			// minutes before the user is automatically logged out
$conf['settings']['name.format'] = '{first} {last}';     		// display format when showing user names
$conf['settings']['ics']['require.login'] = 'true';             // recommended, if the user must be logged in to access ics files
$conf['settings']['ics']['subscription.key'] = '';              // must be set to allow webcal subscriptions
$conf['settings']['privacy']['view.schedules'] = 'false';       // if unauthenticated users can view schedules
$conf['settings']['privacy']['view.reservations'] = 'false';    // if unauthenticated users can view reservations
$conf['settings']['privacy']['hide.user.details'] = 'false';    // if personal user details should be displayed to non-administrators
$conf['settings']['reservation']['start.time.constraint'] = 'future';        // when reservations can be created or edited. options are future, current, none
$conf['settings']['reservation.notify']['resource.admin.add'] = 'false';
$conf['settings']['reservation.notify']['resource.admin.update'] = 'false';
$conf['settings']['reservation.notify']['resource.admin.delete'] = 'false';
$conf['settings']['reservation.notify']['application.admin.add'] = 'false';
$conf['settings']['reservation.notify']['application.admin.update'] = 'false';
$conf['settings']['reservation.notify']['application.admin.delete'] = 'false';
$conf['settings']['reservation.notify']['group.admin.add'] = 'false';
$conf['settings']['reservation.notify']['group.admin.update'] = 'false';
$conf['settings']['reservation.notify']['group.admin.delete'] = 'false';
$conf['settings']['css.extension.file'] = ''; 			      	// full or relative url to an additional css file to include. this can be used to override the default style
/**
 * Database configuration
 */
$conf['settings']['database']['type'] = 'mysql';
$conf['settings']['database']['user'] = 'schedule_user';        // database user with permission to the phpScheduleIt database
$conf['settings']['database']['password'] = 'password';
$conf['settings']['database']['hostspec'] = '127.0.0.1';        // ip, dns or named pipe
$conf['settings']['database']['name'] = 'phpscheduleit2';
/**
 * Mail server configuration
 */
$conf['settings']['phpmailer']['mailer'] = 'mail';              // options are 'mail', 'smtp' or 'sendmail'
$conf['settings']['phpmailer']['smtp.host'] = '';               // 'smtp.university.ca'
$conf['settings']['phpmailer']['smtp.port'] = '25';
$conf['settings']['phpmailer']['smtp.secure'] = '';             // options are '', 'ssl' or 'tls'
$conf['settings']['phpmailer']['smtp.auth'] = 'true';           // options are 'true' or 'false'
$conf['settings']['phpmailer']['smtp.username'] = '';
$conf['settings']['phpmailer']['smtp.password'] = '';
$conf['settings']['phpmailer']['sendmail.path'] = '/usr/sbin/sendmail';
/**
 * Plugin configuration.  For more on plugins, see readme_installation.html
 */
$conf['settings']['plugins']['Authentication'] = '';
$conf['settings']['plugins']['Authorization'] = '';
$conf['settings']['plugins']['Permission'] = '';
$conf['settings']['plugins']['PreReservation'] = '';
$conf['settings']['plugins']['PostReservation'] = '';
/**
 * Installation settings
 */
$conf['settings']['install.password'] = '';
?>