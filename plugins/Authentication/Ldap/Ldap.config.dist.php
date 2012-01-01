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