<?php
/**
File in Authentication plugin package for ver 2.1.4 phpScheduleIt 
to implement Single Sign On Capability.  Based on code from the
phpScheduleIt Authentication Ldap plugin as well as a SAML
Authentication plugin for Moodle 1.9+.
See http://moodle.org/mod/data/view.php?d=13&rid=2574
This plugin uses the SimpleSAMLPHP version 1.8.2 libraries.
http://simplesamlphp.org/

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

// path to SimpleSAMLphp Service Provider(SP) base directory 
// the SP should be installed on the same server as phpScheduleIt
$conf['settings']['simplesamlphp.lib'] = '/var/simplesamlphp'; 
// path to SimpleSAML SP configuration directory
$conf['settings']['simplesamlphp.config'] = '/var/simplesamlphp/config';
// name of the SimpleSAML authentication source configured
// in SimpleSAML SP /var/simplesamlphp/config/authsources.php
$conf['settings']['simplesamlphp.sp'] = 'default-sp'; 
//
// SAML attribute names found in SimpleSAMLphp Identify Provider (Idp)
// configuration /var/simplesamlphp/config/authsources.php
// The Idp will most likely be installed on another server
// 
// SAML attriubute that is mapped to phpScheduleIT username
$conf['settings']['simplesamlphp.username'] = 'sAMAccountName'; 
// SAML attriubute that is mapped to phpScheduleIT firstname
$conf['settings']['simplesamlphp.firstname'] =  'givenName'; 
// SAML attriubute that is mapped to phpScheduleIT lastname
$conf['settings']['simplesamlphp.lastname'] = 'sn'; 
//SAML attriubute that is mapped to phpScheduleIT email
$conf['settings']['simplesamlphp.email'] = 'mail';  
//SAML attriubute that is mapped to phpScheduleIT phone
$conf['settings']['simplesamlphp.phone'] = 'telephoneNumber'; 
//SAML attriubute that is mapped to phpScheduleIT organization
$conf['settings']['simplesamlphp.organization'] = 'department';  
//SAML attriubute that is mapped to phpScheduleIT position
$conf['settings']['simplesamlphp.position'] = 'title';
?>