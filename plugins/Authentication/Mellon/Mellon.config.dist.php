<?php

$conf['settings']['email.domain'] = 'yourdomain.com'; // The email domain to append after the REMOTE_USER variable.
$conf['settings']['key.given.name'] = 'MELLON_givenname';
$conf['settings']['key.surname'] = 'MELLON_surname';
$conf['settings']['key.groups'] = 'ADFS_GROUP';  // The Group field that has been provided by Mellon.  Must be one line.  (Remember to set MellonMergeEnvVars to On)
$conf['settings']['group.mappings'] = 'Application Administrators=SomeMellonGroup';    // Group mappings, bookedAttribute=mellonAttribute.  Separate different mappings by semicolon (;).
