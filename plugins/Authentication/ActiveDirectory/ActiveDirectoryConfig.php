<?php

class ActiveDirectoryConfig
{
    public const CONFIG_ID = 'activeDirectory';
    public const PORT = 'port';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';
    public const BASEDN = 'basedn';
    public const USE_SSL = 'use.ssl';
    public const VERSION = 'version';
    public const DOMAIN_CONTROLLERS = 'domain.controllers';
    public const ACCOUNT_SUFFIX = 'account.suffix';
    public const SECTION_AD = 'ad';
    public const RETRY_AGAINST_DATABASE = 'database.auth.when.ldap.user.not.found';
    public const ATTRIBUTE_MAPPING = 'attribute.mapping';
    public const REQUIRED_GROUPS = 'required.groups';
    public const SYNC_GROUPS = 'sync.groups';
    public const USE_SSO = 'use.sso';
    public const PREVENT_CLEAN_USERNAME = 'prevent.clean.username';
}
