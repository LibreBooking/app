<?php

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class CASOptions
{
    public function __construct()
    {
        require_once(dirname(__FILE__) . '/CASConfig.php');

        Configuration::Instance()->Register(dirname(__FILE__) . '/CAS.config.php', CASConfig::CONFIG_ID);
    }

    private function GetConfig($keyName, $converter = null)
    {
        return Configuration::Instance()->File(CASConfig::CONFIG_ID)->GetKey($keyName, $converter);
    }

    public function IsCasDebugOn()
    {
        return $this->GetConfig(CASConfig::CAS_DEBUG_ENABLED, new BooleanConverter());
    }

    public function HasCertificate()
    {
        $cert = $this->Certificate();
        return !empty($cert);
    }

    public function Certificate()
    {
        return $this->GetConfig(CASConfig::CAS_CERTIFICATE);
    }

    public function CasVersion()
    {
        return $this->GetConfig(CASConfig::CAS_VERSION);
    }

    public function HostName()
    {
        return $this->GetConfig(CASConfig::CAS_SERVER_HOSTNAME);
    }

    public function Port()
    {
        return $this->GetConfig(CASConfig::CAS_PORT, new IntConverter());
    }

    public function ServerUri()
    {
        return $this->GetConfig(CASConfig::CAS_SERVER_URI);
    }

    public function DebugFile()
    {
        return $this->GetConfig(CASConfig::DEBUG_FILE);
    }

    public function ChangeSessionId()
    {
        return $this->GetConfig(CASConfig::CAS_CHANGESESSIONID, new BooleanConverter());
    }

    public function CasHandlesLogouts()
    {
        $servers = $this->LogoutServers();
        return !empty($servers);
    }

    public function LogoutServers()
    {
        $servers = $this->GetConfig(CASConfig::CAS_LOGOUT_SERVERS);

        if (empty($servers)) {
            return [];
        }

        $servers = explode(',', $servers);

        for ($i = 0; $i < count($servers); $i++) {
            $servers[$i] = trim($servers[$i]);
        }

        return $servers;
    }

    public function EmailSuffix()
    {
        return $this->GetConfig(CASConfig::EMAIL_SUFFIX);
    }
    public function AttributeMapping()
    {
        $attributes = [
            'surName' => 'sn',
            'givenName' => 'givenname',
            'email' => 'mail',
            'groups' => 'Role'];
        $configValue = $this->GetConfig(CASConfig::ATTRIBUTE_MAPPING);

        if (!empty($configValue)) {
            $attributePairs = explode(',', $configValue);
            foreach ($attributePairs as $attributePair) {
                $pair = explode('=', trim($attributePair));
                $attributes[trim($pair[0])] = trim($pair[1]);
            }
        }

        return $attributes;
    }
}
