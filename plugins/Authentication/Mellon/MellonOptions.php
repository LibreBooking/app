<?php

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class MellonOptions
{
    public function __construct()
    {
        require_once(dirname(__FILE__) . '/MellonConfig.php');

        Configuration::Instance()->Register(dirname(__FILE__) . '/Mellon.config.php', MellonConfig::CONFIG_ID);
    }

    private function GetConfig($keyName, $converter = null)
    {
        return Configuration::Instance()->File(MellonConfig::CONFIG_ID)->GetKey($keyName, $converter);
    }

    public function EmailDomain()
    {
        return $this->GetConfig(MellonConfig::EMAIL_DOMAIN);
    }

    public function KeyGivenName()
    {
        return $this->GetConfig(MellonConfig::KEY_GIVEN_NAME);
    }

    public function KeySurname()
    {
        return $this->GetConfig(MellonConfig::KEY_SURNAME);
    }

    public function KeyGroups()
    {
        return $this->GetConfig(MellonConfig::KEY_GROUPS);
    }

    public function GroupMappings()
    {
        $configValue = $this->GetConfig(MellonConfig::GROUP_MAPPINGS);
        $mappings = [];
        if (!empty($configValue)) {
            $mappingPairs = explode(',', $configValue);
            foreach ($mappingPairs as $map) {
                $pair = explode('=', trim($map));
                $mappings[trim($pair[1])] = trim($pair[0]);
            }
        }

        return $mappings;
    }
}
