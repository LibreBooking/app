<?php
/**
Copyright 2012-2015 Nick Korbel

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

class LdapConfig
{
    const CONFIG_ID = 'ldap';
    const HOST = 'host';
    const PORT = 'port';
    const VERSION = 'version';
    const STARTTLS = 'starttls';
    const BINDDN = 'binddn';
    const BINDPW = 'bindpw';
    const BASEDN = 'basedn';
    const FILTER = 'filter';
    const SCOPE = 'scope';
    const RETRY_AGAINST_DATABASE = 'database.auth.when.ldap.user.not.found';
	const ATTRIBUTE_MAPPING = 'attribute.mapping';
	const USER_ID_ATTRIBUTE = 'user.id.attribute';
	const REQUIRED_GROUP = 'required.group';
}

?>