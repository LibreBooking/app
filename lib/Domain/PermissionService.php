<?php
interface IPermissionService
{
	public function CanAccessResource(IResource $resource);	
}
?>