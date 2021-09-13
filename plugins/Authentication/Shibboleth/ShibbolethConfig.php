<?php
/**
 * @file ShibbolethConfig.php
 *
 * Constant-interface.
 * Defines configuration keys.
 */
interface ShibbolethConfig
{
    /**
     * @var string
     */
    public const CONFIG_ID = 'shibboleth';

    /**
     * @var string
     */
    public const USERNAME = 'shibboleth.username';

    /**
     * @var string
     */
    public const FIRSTNAME = 'shibboleth.firstname';

    /**
     * @var string
     */
    public const LASTNAME = 'shibboleth.lastname';


    /**
     * @var string
     */
    public const EMAIL = 'shibboleth.email';

    /**
     * @var string
     */
    public const PHONE = 'shibboleth.phone';

    /**
     * @var string
     */
    public const ORGANIZATION = 'shibboleth.organization';
}
