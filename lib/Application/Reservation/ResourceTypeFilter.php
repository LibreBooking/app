<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class ResourceTypeFilter implements IResourceFilter
{
	/**
	 * @var $resourcetypename
	 */
	private $resourcetypeids = array();
	
	public function __construct($resourcetypename)
	{
		$reader = ServiceLocator::GetDatabase()
				  ->Query(new GetResourceTypeByNameCommand($resourcetypename));
		
		while($row = $reader->GetRow())
		{
			$this->resourcetypeids[] = $row[ColumnNames::RESOURCE_TYPE_ID];
		}
		
		$reader->Free();
	}

	/**
	 * @param IResource $resource
	 * @return bool
	 */
	public function ShouldInclude($assignment)
	{
		return in_array( $assignment->GetResourceTypeId(), $this->resourcetypeids );
	}
}
