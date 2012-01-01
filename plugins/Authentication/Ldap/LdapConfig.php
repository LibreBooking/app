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


/**
 * Do not modify this file. This is constance declaration. Leave it as is.
 */
class LdapConfig {
    const CONFIG_ID = 'ldap';
    const PORT = 'port';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const BASEDN = 'basedn';
    const USE_SSL = 'use.ssl';
    const VERSION = 'version';
    const DOMAIN_CONTROLLERS = 'domain.controllers';
    const ACCOUNT_SUFFIX = 'account.suffix';
    const SECTION_AD = 'ad';
    const RETRY_AGAINST_DATABASE = 'database.auth.when.ldap.user.not.found';
}

?>