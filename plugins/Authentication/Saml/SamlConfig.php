<?php
/**
File in Authentication plugin package for ver 2.1.4 Booked Scheduler
to implement Single Sign On Capability.  Based on code from the
Booked Scheduler Authentication Ldap plugin as well as a SAML
Authentication plugin for Moodle 1.9+.
See http://moodle.org/mod/data/view.php?d=13&rid=2574
This plugin uses the SimpleSAMLPHP version 1.8.2 libraries.
http://simplesamlphp.org/

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/


/**
 * Do not modify this file. This is constance declaration. Leave it as is.
 */
class SamlConfig {
    const CONFIG_ID = 'saml';
    const SIMPLESAMLPHP_LIB = 'simplesamlphp.lib';
    const SIMPLESAMLPHP_CONFIG = 'simplesamlphp.config';
    const SIMPLESAMLPHP_SP = 'simplesamlphp.sp';
    const USERNAME = 'simplesamlphp.username';
    const FIRSTNAME = 'simplesamlphp.firstname';
    const LASTNAME = 'simplesamlphp.lastname';
    const EMAIL = 'simplesamlphp.email';
    const PHONE = 'simplesamlphp.phone';
    const ORGANIZATION = 'simplesamlphp.organization';
    const POSITION = 'simplesamlphp.position';
}

?>