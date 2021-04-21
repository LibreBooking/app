<?php

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
