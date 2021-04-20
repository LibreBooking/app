<?php

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
	const SYNC_GROUPS = 'sync.groups';
	const PREVENT_CLEAN_USERNAME = 'prevent.clean.username';
}
