<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class PluginManager
{
	/**
	 * @var PluginManager
	 */
	private static $_instance = null;
	
	private function __construct()
	{
	}

	/**
	 * @static
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

	/**
	 * @static
	 * @param $pluginManager PluginManager
	 * @return void
	 */
	public static function SetInstance($pluginManager)
	{
		self::$_instance = $pluginManager;
	}
	
	/**
	 * Loads the configured Authentication plugin, if one exists
	 * If no plugin exists, the default Authentication class is returned
	 *
	 * @return IAuthentication the authorization class to use
	 */
	public function LoadAuthentication()
	{
		require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

		$plugin = $this->LoadPlugin(ConfigKeys::PLUGIN_AUTHENTICATION, 'Authentication');

		if (!is_null($plugin))
		{
			return $plugin;
		}
		
		return new Authentication();
	}

	/**
	 * Loads the configured Permission plugin, if one exists
	 * If no plugin exists, the default PermissionService class is returned
	 *
	 * @return IPermissionService
	 */
	public function LoadPermission()
	{
		require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

		$plugin = $this->LoadPlugin(ConfigKeys::PLUGIN_PERMISSION, 'Permission');

		if (!is_null($plugin))
		{
			return $plugin;
		}

		$resourcePermissionStore = new ResourcePermissionStore(new ScheduleUserRepository());
		return new PermissionService($resourcePermissionStore);
	}

	/**
	 * Loads the configured Authorization plugin, if one exists
	 * If no plugin exists, the default PermissionService class is returned
	 *
	 * @return IAuthorizationService
	 */
	public function LoadAuthorization()
	{
		require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

		$plugin = $this->LoadPlugin(ConfigKeys::PLUGIN_AUTHORIZATION, 'Authorization');

		if (!is_null($plugin))
		{
			return $plugin;
		}

		return new AuthorizationService();
	}

	private function LoadPlugin($configKey, $pluginDirectory)
	{
		$plugin = Configuration::Instance()->GetKey($configKey);
		$pluginFile = ROOT_DIR . "plugins/$pluginDirectory/$plugin/$plugin.php";

		if (!empty($plugin) && file_exists($pluginFile))
		{
			require_once($pluginFile);
			return new $plugin();
		}

		return null;
	}
}

?>