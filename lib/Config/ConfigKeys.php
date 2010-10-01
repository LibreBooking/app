<?php
class ConfigKeys
{
	const SERVER_TIMEZONE = 'server.timezone';	
	const ALLOW_REGISTRATION = 'allow.self.registration';
	const ADMIN_EMAIL = 'admin.email';
	const LANGUAGE = 'default.language';
	const ALLOW_RSS = 'allow.rss';
	const VERSION = 'version';
	const SCRIPT_URL = 'script.url';
	const USE_LOGON_NAME = 'use.logon.name';
	const PASSWORD_PATTERN = 'password.pattern';
	
	const SCHEDULE_SHOW_INACCESSIBLE_RESOURCES = 'show.inaccessible.resources';
	
	const DATABASE_TYPE = 'type';
	const DATABASE_USER = 'user';
	const DATABASE_PASSWORD = 'password';
	const DATABASE_HOSTSPEC = 'hostspec';
	const DATABASE_NAME = 'name';
	
	const PLUGIN_AUTH = 'Auth';
	
	const RESERVATION_NOTIFY_CREATED = 'notify.created';
}

class ConfigSection
{
	const DATABASE = 'database';
	const SCHEDULE = 'schedule';
	const RESERVATION = 'reservation';
}

?>