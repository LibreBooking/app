<?php

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class LdapOptions
{
    private $_options = array();

    public function __construct()
    {
        require_once(dirname(__FILE__) . '/Ldap.config.php');

        Configuration::Instance()->Register(
            dirname(__FILE__) . '/Ldap.config.php',
            LdapConfig::CONFIG_ID);
    }

    public function Ldap2Config()
    {
        $hosts = $this->GetHosts();
        $this->SetOption('host', $hosts);
        $this->SetOption('port', $this->GetConfig(LdapConfig::PORT), new IntConverter());
        $this->SetOption('starttls', $this->GetConfig(LdapConfig::STARTTLS, new BooleanConverter()));
        $this->SetOption('version', $this->GetConfig(LdapConfig::VERSION), new IntConverter());
        $this->SetOption('binddn', $this->GetConfig(LdapConfig::BINDDN));
        $this->SetOption('bindpw', $this->GetConfig(LdapConfig::BINDPW));
        $this->SetOption('basedn', $this->GetConfig(LdapConfig::BASEDN));
        $this->SetOption('filter', $this->GetConfig(LdapConfig::FILTER));
        $this->SetOption('scope', $this->GetConfig(LdapConfig::SCOPE));

        return $this->_options;
    }

    public function RetryAgainstDatabase()
    {
        return $this->GetConfig(LdapConfig::RETRY_AGAINST_DATABASE, new BooleanConverter());
    }

    public function Controllers()
    {
        return $this->GetHosts();
    }

    private function SetOption($key, $value)
    {
        if (empty($value)) {
            $value = null;
        }

        $this->_options[$key] = $value;
    }

    private function GetConfig($keyName, $converter = null)
    {
        return Configuration::Instance()->File(LdapConfig::CONFIG_ID)->GetKey($keyName, $converter);
    }

    private function GetHosts()
    {
        $hosts = explode(',', $this->GetConfig(LdapConfig::HOST));

        for ($i = 0; $i < count($hosts); $i++) {
            $hosts[$i] = trim($hosts[$i]);
        }

        return $hosts;
    }

    public function BaseDn()
    {
        return $this->_options[LdapConfig::BASEDN];
    }

    public function IsLdapDebugOn()
    {
        return $this->GetConfig('ldap.debug.enabled', new BooleanConverter());
    }

    public function Attributes()
    {
        $attributes = $this->AttributeMapping();
        return array_values($attributes);
    }

    public function AttributeMapping()
    {
        $attributes = array('sn' => 'sn',
            'givenname' => 'givenname',
            'mail' => 'mail',
            'telephonenumber' => 'telephonenumber',
            'physicaldeliveryofficename' => 'physicaldeliveryofficename',
            'title' => 'title');
        $configValue = $this->GetConfig(LdapConfig::ATTRIBUTE_MAPPING);

        if (!empty($configValue)) {
            $attributePairs = explode(',', $configValue);
            foreach ($attributePairs as $attributePair) {
                $pair = explode('=', trim($attributePair));
                $attributes[trim($pair[0])] = trim($pair[1]);
            }
        }

        return $attributes;
    }

    /**
     * @return string
     */
    public function GetUserIdAttribute()
    {
        $attribute = $this->GetConfig(LdapConfig::USER_ID_ATTRIBUTE);

        if (empty($attribute)) {
            return 'uid';
        }

        return $attribute;
    }

    /**
     * @return string
     */
    public function GetRequiredGroup()
    {
        return $this->GetConfig(LdapConfig::REQUIRED_GROUP);
    }

    /**
     * @return string
     */
    public function Filter()
    {
        return $this->GetConfig(LdapConfig::FILTER);
    }

    /**
     * @return bool
     */
    public function SyncGroups()
    {
        return $this->GetConfig(LdapConfig::SYNC_GROUPS, new BooleanConverter());
    }

    /**
     * @return bool
     */
    public function CleanUsername()
    {
        return !$this->GetConfig(LdapConfig::PREVENT_CLEAN_USERNAME, new BooleanConverter());
    }
}
