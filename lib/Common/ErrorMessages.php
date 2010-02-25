<?php 
class ErrorMessages
{
	const INSUFFICIENT_PERMISSIONS = 1;
	
	private static $resourceKeys = array();
		
	private function __construct()
	{
		self::SetKey(ErrorMessages::INSUFFICIENT_PERMISSIONS, 'InsufficientPermissionsError');
	}
	
	private static function SetKey($errorMessageId, $resourceKey)
	{
		self::$resourceKeys[$errorMessageId] = $resourceKey;
	
	}
	
	public static function GetResourceKey($errorMessageId)
	{
		return self::$resourceKeys[$errorMessageId];
	}
}
?>