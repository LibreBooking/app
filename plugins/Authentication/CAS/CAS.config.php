<?php
/**
Copyright 2012 Bart Verheyde
bart.verheyde@ugent.be
This file is not part of default phpScheduleIt.

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

$conf['settings']['cas_debug'] = true;      // Writes debug to /tmp/phpCAS.log  true false @ todo

$conf['settings']['cas_version'] = 'SAML_VERSION_1_1';		// SAML version is a constant in ../CAS/CAS.php 
$conf['settings']['cas_url_server'] = 'localhost';	// the hostname of the CAS server
$conf['settings']['cas_port'] = '443';				// the port the CAS server is running on
$conf['settings']['cas_uri_server'] = '';			// the URI the CAS server is responding on
$conf['settings']['cas_changeSessionID'] = true;		// Allow phpCAS to change the session_id
$conf['settings']['cas_communicationprotocol'] = 'saml';	// Used conection protocul between CAS

$conf['settings']['cas_logout_servers'] = 'server1,server2';	// Logout server

$conf['settings']['cas_certificates'] = '/etc/ssl/certs/ca-certificates.crt';

?>