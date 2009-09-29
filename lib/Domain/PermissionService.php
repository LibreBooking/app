<?php
interface IPermissionService
{
	public function CanAccessResource(IResource $resource);	
}

class PermissionService implements IPermissionService
{
	public function CanAccessResource(IResource $resource)
	{
		throw new Exception('not implemented');
	}
}
?>