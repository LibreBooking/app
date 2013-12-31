<?php

/**
File in Authentication plugin package for ver 2.1.4 Booked Scheduler
to implement Single Sign On Capability.  Based on code from the
Booked Scheduler Authentication Ldap plugin as well as a SAML
Authentication plugin for Moodle 1.9+.
See http://moodle.org/mod/data/view.php?d=13&rid=2574
This plugin uses the SimpleSAMLPHP version 1.8.2 libraries.
http://simplesamlphp.org/
 *
 */

/**
 * PHP SAML CLASS FOR COMMUNICATING WITH Simple Saml PHP Service Provider
 *
 */

/**
* Main adSAML class
*
*/

class adSAML {

    /**
    * Name of the Simple Saml service provider instance
    *
    * @var string
    */
    private $ssphpSP = 'default-sp';

    /**
    * Full directory path name that holds simpleSAMLphp library on your server
    *
    * @var string
    */
    private $samlLib;

    /**
    * Full directory path name that holds simpleSAMLphp config.php file
    * on  your server
    *
    * @var string
    */
    private $samlConfig;

    /**
    * Instance of the helper class for Simple Saml Applications
    * 
    * @var SimpleSAML_Auth_Simple object
    */
    private $authSimple ;

    /**
    * Holds a list of user attributes obtained from SimpleSAMLphp
    * Identity Provider (IDP)
    *
    * @var associative array where attribute names are keys
    */
    private $userAttributes;

    /**
    * Default Constructor
    *
    * Instantiate an instance of the SimpleSAML_Auth_Simple class
    * and call requireAuth() to validate a user
    *
    * @param array $options Array of options to pass to the constructor
    *
    */
    function __construct($options = array())
    {
      // Auto load  libraries and
      // obtain simple SAML SP configuration data
       $this->samlLib = $options["ssphp_lib"];
       $this->samlConfig = $options["ssphp_config"];
       require_once($this->samlLib . '/lib/_autoload.php');
       SimpleSAML_Configuration::init($this->samlConfig);

        // You can specifically overide any of the default configuration options setup above
        if (count($options)>0){
            if (array_key_exists("ssphp_sp",$options))
            {
                $this->ssphpSP = $options["ssphp_sp"];
            }
            else
            {
              Log::Error("Could not connect to SAML service provider."
                   . "  Please check your SAML configuration settings");
            }

        }

        $this->authSimple = new SimpleSAML_Auth_Simple($this->ssphpSP);
        // requireAuth() redirects user to SSO login page
        // where user needs to enter SSO username and password.
        // If user is not validated, then this function does not return
        $this->authSimple->requireAuth();
    }

    /**
    * Return true if user has logged into SimpleSAML logon page
    * (user record exists in SimpleSAMLphp IDP data store)
    *
    * @return bool
    */
    public function authenticate() {
       $returnValue = false;
       if($this->authSimple->isAuthenticated())
       {
         //obtain an array of attributes associated with this user
         $this->userAttributes = $this->authSimple->getAttributes();
         $returnValue = true;
       }
       return $returnValue;
    }

    /**
    * After we know user is authetnicated,
     * then we can call getAttributes() method
     * on $this->authSimple instance
    * @return associative array of attributes
    */
    public function getAttributes(){
      return $this->userAttributes;
    }

}
?>