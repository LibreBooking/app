<?php

class LdapConfig
{
    public const CONFIG_ID = 'ldap';
    public const HOST = 'host';
    public const PORT = 'port';
    public const VERSION = 'version';
    public const STARTTLS = 'starttls';
    public const BINDDN = 'binddn';
    public const BINDPW = 'bindpw';
    public const BASEDN = 'basedn';
    public const FILTER = 'filter';
    public const SCOPE = 'scope';
    public const RETRY_AGAINST_DATABASE = 'database.auth.when.ldap.user.not.found';
    public const ATTRIBUTE_MAPPING = 'attribute.mapping';
    public const USER_ID_ATTRIBUTE = 'user.id.attribute';
    public const REQUIRED_GROUP = 'required.group';
    public const SYNC_GROUPS = 'sync.groups';
    public const PREVENT_CLEAN_USERNAME = 'prevent.clean.username';
}
