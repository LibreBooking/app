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

		$authentication = new Authentication($this->LoadAuthorization());
				
		$plugin = $this->LoadPlugin(ConfigKeys::PLUGIN_AUTHENTICATION, 'Authentication', $authentication);

		if (!is_null($plugin))
		{
			return $plugin;
		}

		return $authentication;
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

		$resourcePermissionStore = new ResourcePermissionStore(new ScheduleUserRepository());
		$permissionService = new PermissionService($resourcePermissionStore);
		
		$plugin = $this->LoadPlugin(ConfigKeys::PLUGIN_PERMISSION, 'Permission', $permissionService);

		if (!is_null($plugin))
		{
			return $plugin;
		}

		return $permissionService;
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

		$authorizationService = new AuthorizationService(new UserRepository());

		$plugin = $this->LoadPlugin(ConfigKeys::PLUGIN_AUTHORIZATION, 'Authorization', $authorizationService);

		if (!is_null($plugin))
		{
			return $plugin;
		}

		return $authorizationService;
	}

	/**
	 * @param string $configKey key to use
	 * @param string $pluginSubDirectory subdirectory name under 'plugins'
	 * @param mixed $baseImplementation the base implementation of the plugin.  allows decorating
	 * @return mixed|null plugin implementation
	 */
	private function LoadPlugin($configKey, $pluginSubDirectory, $baseImplementation)
	{
		$plugin = Configuration::Instance()->GetSectionKey(ConfigSection::PLUGINS, $configKey);
		$pluginFile = ROOT_DIR . "plugins/$pluginSubDirectory/$plugin/$plugin.php";

		if (!empty($plugin) && file_exists($pluginFile))
		{
			require_once($pluginFile);
			return new $plugin($baseImplementation);
		}

		return null;
	}
}

?>