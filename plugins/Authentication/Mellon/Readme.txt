# Apache Mellon Authentication Plugin

This authentication plugin is used with the Apache mod_auth_mellon authentication module for those that prefer to handle Authentication on the webserver side.

Current mod_auth_mellon Repo: https://github.com/latchset/mod_auth_mellon

Usage of this plugin requires an Apache server with mod_auth_mellon already configured and working.  For details on setting up Mellon, see the above repo.

This plugin assumes that the REMOTE_USER variable is being provided from Mellon.

Important! This plugin requires `MellonMergeEnvVars On` in your Apache configuration!

## Plugin Installation

Copy `Mellon.config.dist.php` to `Mellon.config.php` and adjust the settings to your environment.

Change `$conf['settings']['plugins']['Authentication'] = '';` to `$conf['settings']['plugins']['Authentication'] = 'Mellon'` in `/config/config.php`