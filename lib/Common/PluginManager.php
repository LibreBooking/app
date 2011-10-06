<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class PluginManager
{
	private static $_instance = null;
	
	private function __construct()
	{
	}
	
	/**
	 * @return PluginManager
	 */
	public static function Instance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new PluginManager();
		}
		return self::$_instance;
	}
	
	public static function SetInstance($value)
	{
		self::$_instance = $value;
	}
	
	/**
	 * Loads the configured Authentication plugin, if one exists
	 * If no plugin exists, the default Authentication class is returned
	 *
	 * @return IAuthentication the authorization class to use
	 */
	public function LoadAuth()
	{
		require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
		
		$authPlugin = Configuration::Instance()->GetKey(ConfigKeys::PLUGIN_AUTH);
		$pluginFile = ROOT_DIR . "plugins/Authentication/$authPlugin/$authPlugin.php";
		
		if (!empty($authPlugin) && file_exists($pluginFile))
		{					
			require_once($pluginFile);		
			return new $authPlugin();
		}
		
		return new Authentication();
	}
}
?>