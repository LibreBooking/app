<?php

$conf['settings']['domain.controllers'] = 'mydomain,local'; // comma separated list of ldap servers such as domaincontroller1,controller2
$conf['settings']['port'] = '389';      // default ldap port 389 or 636 for ssl.
$conf['settings']['username'] = '';     // admin user - bind to ldap service with an authorized account user/password
$conf['settings']['password'] = '';     // admin password - corresponding password
$conf['settings']['basedn'] =  'ou=uidauthent,o=domain.com';   // The base dn for your domain. This is generally the same as your account suffix, but broken up and prefixed with DC=. Your base dn can be located in the extended attributes in Active Directory Users and Computers MMC.
$conf['settings']['version'] = '3';		// LDAP protocol version
$conf['settings']['use.ssl'] = 'false'; // 'true' if 636 was used.
$conf['settings']['account.suffix'] = '';	// The full account suffix for your domain. Example: @uidauthent.domain.com.
$conf['settings']['database.auth.when.ldap.user.not.found'] = 'false';	// if ldap auth fails, authenticate against Booked Scheduler database
$conf['settings']['attribute.mapping'] = 'sn=sn,givenname=givenname,mail=mail,telephonenumber=telephonenumber,physicaldeliveryofficename=physicaldeliveryofficename,title=title';	// mapping of required attributes to attribute names in your directory
$conf['settings']['required.groups'] = '';	// Required groups (empty if not necessary) User only needs to belong to at least one listed (eg. Group1,Group2)
$conf['settings']['sync.groups'] = 'false';	// Whether or not groups should be synced into Booked. When true then be sure that the attribute.mapping config value contains a correct map for groups
$conf['settings']['use.sso'] = 'false';	// Whether or not to use single sign on
$conf['settings']['prevent.clean.username'] = 'false';	// If the username is an email address or contains the domain, clean it
