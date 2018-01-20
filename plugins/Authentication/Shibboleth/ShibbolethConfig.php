<?php
/**
 * @file ShibbolethConfig.php
 *
 * Constant-interface.
 * Defines configuration keys.
 */
interface ShibbolethConfig {

    /**
     * @var string
     */
    const CONFIG_ID = 'shibboleth';

    /**
     * @var string
     */
    const USERNAME = 'shibboleth.username';

    /**
     * @var string
     */
    const FIRSTNAME = 'shibboleth.firstname';

    /**
     * @var string
     */
    const LASTNAME = 'shibboleth.lastname';


    /**
     * @var string
     */
    const EMAIL = 'shibboleth.email';

    /**
     * @var string
     */
    const PHONE = 'shibboleth.phone';

    /**
     * @var string
     */
    const ORGANIZATION = 'shibboleth.organization';
}
