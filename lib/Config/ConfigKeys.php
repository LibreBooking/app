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


class ConfigKeys {
    const ADMIN_EMAIL = 'admin.email';
    const ALLOW_REGISTRATION = 'allow.self.registration';
    const ALLOW_RSS = 'allow.rss';
    const DEFAULT_PAGE_SIZE = 'default.page.size';
    const ENABLE_EMAIL = 'enable.email';
	const INACTIVITY_TIMEOUT = 'inactivity.timeout';
    const LANGUAGE = 'default.language';
    const PASSWORD_PATTERN = 'password.pattern';
    const SCRIPT_URL = 'script.url';
    const SERVER_TIMEZONE = 'server.timezone';
    const REGISTRATION_ENABLE_CAPTCHA = 'registration.captcha.enabled';
    const VERSION = 'version';

    const SCHEDULE_SHOW_INACCESSIBLE_RESOURCES = 'show.inaccessible.resources';

    const DATABASE_TYPE = 'type';
    const DATABASE_USER = 'user';
    const DATABASE_PASSWORD = 'password';
    const DATABASE_HOSTSPEC = 'hostspec';
    const DATABASE_NAME = 'name';

    const PLUGIN_AUTHENTICATION = 'Authentication';
    const PLUGIN_AUTHORIZATION = 'Authorization';
    const PLUGIN_PERMISSION = 'Permission';
    const PLUGIN_PRERESERVATION = 'PreReservation';
    const PLUGIN_POSTRESERVATION = 'PostReservation';

    const RESERVATION_NOTIFY_CREATED = 'notify.created';
    const RESERVATION_NOTIFY_UPDATED = 'notify.updated';

    const IMAGE_UPLOAD_DIRECTORY = 'image.upload.directory';
    const IMAGE_UPLOAD_URL = 'image.upload.url';

    const CACHE_TEMPLATES = 'cache.templates';

    const INSTALLATION_PASSWORD = 'install.password';
}

class ConfigSection {
    const DATABASE = 'database';
    const PLUGINS = 'plugins';
    const RESERVATION = 'reservation';
    const SCHEDULE = 'schedule';
}

?>