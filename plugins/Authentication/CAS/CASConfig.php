<?php
/**
Copyright 2013-2014 Bart Verheyde, Nick Korbel
bart.verheyde@ugent.be

This file is not part of Booked Scheduler.

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

class CASConfig
{
    const CONFIG_ID = 'CAS';

    const CAS_VERSION = 'cas.version';
    const CAS_SERVER_HOSTNAME = 'cas.server.hostname';
    const CAS_PORT = 'cas.port';
    const CAS_SERVER_URI = 'cas.server.uri';
    const CAS_CHANGESESSIONID = 'cas.change.session.id';
    const CAS_LOGOUT_SERVERS = 'cas.logout.servers';
    const CAS_CERTIFICATE = 'cas.certificate';
    const CAS_DEBUG_ENABLED = 'cas.debug.enabled';
    const EMAIL_SUFFIX = 'email.suffix';
    const DEBUG_FILE = 'cas.debug.file';
    const ATTRIBUTE_MAPPING = 'cas.attribute.mapping';
}