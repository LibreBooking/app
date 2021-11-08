<?php

/**
File in Authentication plugin package for ver 2.1.4 Booked Scheduler
to implement Single Sign On Capability.  Based on code from the
Booked Scheduler Authentication Ldap plugin as well as a SAML
Authentication plugin for Moodle 1.9+.
See http://moodle.org/mod/data/view.php?d=13&rid=2574
This plugin uses the SimpleSAMLPHP version 1.8.2 libraries.
http://simplesamlphp.org/
*/

// path to SimpleSAMLphp Service Provider(SP) base directory
// the SP should be installed on the same server as Booked Scheduler
$conf['settings']['simplesamlphp.lib'] = '/var/simplesamlphp';
// path to SimpleSAML SP configuration directory
$conf['settings']['simplesamlphp.config'] = '/var/simplesamlphp/config';
// name of the SimpleSAML authentication source configured
// in SimpleSAML SP /var/simplesamlphp/config/authsources.php
$conf['settings']['simplesamlphp.sp'] = 'default-sp';
//
// SAML attribute names found in SimpleSAMLphp Identify Provider (Idp)
// configuration /var/simplesamlphp/config/authsources.php
// The Idp will most likely be installed on another server
//
// SAML attriubute that is mapped to Booked Scheduler username
$conf['settings']['simplesamlphp.username'] = 'sAMAccountName';
// SAML attriubute that is mapped to Booked Scheduler firstname
$conf['settings']['simplesamlphp.firstname'] =  'givenName';
// SAML attriubute that is mapped to Booked Scheduler lastname
$conf['settings']['simplesamlphp.lastname'] = 'sn';
//SAML attriubute that is mapped to Booked Scheduler email
$conf['settings']['simplesamlphp.email'] = 'mail';
//SAML attriubute that is mapped to Booked Scheduler phone
$conf['settings']['simplesamlphp.phone'] = 'telephoneNumber';
//SAML attriubute that is mapped to Booked Scheduler organization
$conf['settings']['simplesamlphp.organization'] = 'department';
//SAML attriubute that is mapped to Booked Scheduler position
$conf['settings']['simplesamlphp.position'] = 'title';
$conf['settings']['simplesamlphp.groups'] = 'groups';
$conf['settings']['simplesamlphp.sync.groups'] = 'false';
