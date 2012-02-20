<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

interface IPermissionService
{
	/**
	 * @param IResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IResource $resource, UserSession $user);
}

class PermissionService implements IPermissionService
{
	/**
	 * @var IResourcePermissionStore
	 */
	private $_store;
	
	private $_allowedResourceIds;
	
	/**
	 * @param IResourcePermissionStore $store
	 */
	public function __construct(IResourcePermissionStore $store)
	{
		$this->_store = $store;
	}

	/**
	 * @param IResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IResource $resource, UserSession $user)
	{
		if ($this->_allowedResourceIds == null)
		{
			$this->_allowedResourceIds = $this->_store->GetPermittedResources($user->UserId);
		}
		
		return $user->IsAdmin || in_array($resource->GetResourceId(), $this->_allowedResourceIds);
	}
}

?>