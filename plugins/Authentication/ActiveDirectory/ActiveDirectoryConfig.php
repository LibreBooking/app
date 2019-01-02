<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

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

class ActiveDirectoryConfig
{
    const CONFIG_ID = 'activeDirectory';
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
	const ATTRIBUTE_MAPPING = 'attribute.mapping';
	const REQUIRED_GROUPS = 'required.groups';
	const SYNC_GROUPS = 'sync.groups';
	const USE_SSO = 'use.sso';
    const PREVENT_CLEAN_USERNAME = 'prevent.clean.username';
}