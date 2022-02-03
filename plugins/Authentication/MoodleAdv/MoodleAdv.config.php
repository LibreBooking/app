<?php

//Moodle db details
$conf['settings']['moodleadv.dbhost'] = 'localhost';
$conf['settings']['moodleadv.dbname'] = 'moodledatabasename';
$conf['settings']['moodleadv.dbuser'] = 'username';
$conf['settings']['moodleadv.dbpass'] = 'password';
$conf['settings']['moodleadv.prefix'] = 'mdl_';

// Method for selecting authorization to LibreBooking roles|field|all
$conf['settings']['moodleadv.authmethod'] = 'field';

// Booking allowed by roles
$conf['settings']['moodleadv.roles'] = '1,3,4';

// Booking allowed by Field - Checkbox
$conf['settings']['moodleadv.field'] = '1';
