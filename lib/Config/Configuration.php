<?php

require_once(ROOT_DIR . 'lib/external/pear/Config.php');
require_once(ROOT_DIR . 'config/ConfigurationFile.php');

interface IConfigurationFile {

    /**
     * @abstract
     * @param string $section
     * @param string $name
     * @param null|IConvert $converter
     * @return mixed|string
     */
    public function GetSectionKey($section, $name, $converter = null);

    /**
     * @abstract
     * @param string $name
     * @param null|IConvert $converter
     * @return mixed|string
     */
    public function GetKey($name, $converter = null);

    public function GetScriptUrl();
}

interface IConfiguration extends IConfigurationFile {

    public function Register($configFile, $configId);

    public function File($configId);
}

class Configuration implements IConfiguration {

	/**
	 * @var array|ConfigurationFile[]
	 */
    protected $_configs = array();

	/**
	 * @var Configuration
	 */
    private static $_instance = null;

    const SETTINGS = 'settings';
    const DEFAULT_CONFIG_ID = 'phpscheduleit';
    const DEFAULT_CONFIG_FILE_PATH = '/config/config.php';

    protected function __construct() {
    }

    /**
     * @return IConfigurationFile
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new Configuration();
            self::$_instance->Register(
                    dirname(__FILE__) . '/../../' . self::DEFAULT_CONFIG_FILE_PATH, self::DEFAULT_CONFIG_ID);
        }

        return self::$_instance;
    }

    public static function SetInstance($value) {
        self::$_instance = $value;
    }

    public function Register($configFile, $configId, $overwrite = false) {
        $config = new Config();
        $container = $config->parseConfig($configFile, "PHPArray");

        if (PEAR::isError($container)) {
            throw new Exception($container->getMessage());
        }

        $this->AddConfig($configId, $container, $overwrite);
    }

    public function File($configId) {
        return $this->_configs[$configId];
    }

    public function GetSectionKey($section, $keyName, $converter = null) {
        return $this->File(self::DEFAULT_CONFIG_ID)->GetSectionKey($section, $keyName, $converter);
    }

    public function GetKey($keyName, $converter = null) {
        return $this->File(self::DEFAULT_CONFIG_ID)->GetKey($keyName, $converter);
    }

    public function GetScriptUrl() {
        return $this->File(self::DEFAULT_CONFIG_ID)->GetScriptUrl();
    }

    protected function AddConfig($configId, $container, $overwrite) {
        if (!$overwrite) {
            if (array_key_exists($configId, $this->_configs)) {
                throw new Exception('Configuration already exists');
            }
        }

        $this->_configs[$configId] = new ConfigurationFile($container->getItem("section", self::SETTINGS)->toArray());
    }

}

?>