<?php
/**
 * @file ShibbolethOptions.php
 */

require_once ROOT_DIR . '/lib/Config/namespace.php';
require_once ROOT_DIR . 'lib/Common/Converters/namespace.php';

/**
 * Plugin configuration object.
 *
 * @class ShibbolethOptions
 */
class ShibbolethOptions {

    /**
     * Options map.
     * @var array
     */
    protected $_options;

    /**
     * Constructor.
     */
    public function __construct () {
        require_once dirname(__FILE__) . '/Shibboleth.config.php';
        // load the plugin configuration from file.
        Configuration::Instance()->Register(
            dirname(__FILE__) . '/Shibboleth.config.php',
            ShibbolethConfig::CONFIG_ID);
    }

    /**
     * Returns a map of plugin configurations.
     *
     * @return array A map of configuration options.
     */
    public function GetShibbolethOptions () {
        if (! isset($this->_options)) {
            $this->InitShibbolethOptions();
        }
        return $this->_options;
    }

    /**
     * Initializes and populates the internal options map.
     */
    protected function InitShibbolethOptions () {
        $this->_options = array();
        $this->SetOption(ShibbolethConfig::USERNAME, $this->GetConfig(ShibbolethConfig::USERNAME));
        $this->SetOption(ShibbolethConfig::FIRSTNAME, $this->GetConfig(ShibbolethConfig::FIRSTNAME));
        $this->SetOption(ShibbolethConfig::LASTNAME, $this->GetConfig(ShibbolethConfig::LASTNAME));
        $this->SetOption(ShibbolethConfig::EMAIL, $this->GetConfig(ShibbolethConfig::EMAIL));
        $this->SetOption(ShibbolethConfig::PHONE, $this->GetConfig(ShibbolethConfig::PHONE));
        $this->SetOption(ShibbolethConfig::ORGANIZATION, $this->GetConfig(ShibbolethConfig::ORGANIZATION));
    }

    /**
     * Sets a configuration option.
     *
     * @param string $key The config key.
     * @param mixed $value The config value.
     */
    private function SetOption ($key, $value) {
        if (empty($value)) {
            $value = null;
        }

        $this->_options[$key] = $value;
    }

    /**
     * Retrieves a configuration option value by its key.
     *
     * @param string $keyName The config key.
     * @param IConvert $converter A value converter.
     * @return mixed The config value.
     */
    protected function GetConfig ($keyName, IConvert $converter = null) {
        return Configuration::Instance()->File(ShibbolethConfig::CONFIG_ID)->GetKey($keyName, $converter);
    }
}
