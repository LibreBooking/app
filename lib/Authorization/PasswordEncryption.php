<?php
class PasswordEncryption
{
	public function Encrypt($password, $salt)
	{
		return sha1($password . $salt);
	}
	
	public function Salt()
	{
		return substr( str_pad( dechex( mt_rand() ), 8, '0', STR_PAD_LEFT ), -8 );
	}
}

class RetiredPasswordEncryption
{
	public function Encrypt($password)
	{
		return md5($password);
	}
}
?>