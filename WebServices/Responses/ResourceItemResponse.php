<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceItemResponse extends RestResponse
{
	public $id;
	public $name;
    public $type;
    public $groups;
    
	public function __construct(IRestServer $server, $id, $name)
	{
		$this->id = $id;
		$this->name = $name;

        /*
         * Unfortunately we have to get the full resource here to be able to get the
         * resource_type_id
         */
        $resourceRepository = new ResourceRepository();
        $resource = $resourceRepository->LoadById($id);

        if ($resource->HasResourceType())
		{
            $this->type = $resourceRepository->LoadResourceType($resource->GetResourceTypeId())->Name();
       }
        
        /*
         * For every resource we want to see the full hierarchical path of groups it belongs to.
         * This will add an array containing first parent and consecutive ancestors.
         * This is added here so it is not necessary to retrieve this in separate queries for
         * every resource and group it's assigned to.
         */
		$this->groups = array();
        
        foreach( $resource->GetResourceGroupIds() as $resourceGroupId )
        {
            $this->groups[$resourceGroupId] = $this->BuildParentList($resourceGroupId);
        }
        
		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $id));
	}

    private function BuildParentList($resourceGroupId,&$parents=array())
    {
        $groupsReader = ServiceLocator::GetDatabase()->Query(new GetResourceGroupCommand($resourceGroupId));
        if ($group = $groupsReader->GetRow())
        {
            $parents[$group[ColumnNames::RESOURCE_GROUP_ID]] = new ResourceGroup($group[ColumnNames::RESOURCE_GROUP_ID], 
                                                                                 $group[ColumnNames::RESOURCE_GROUP_NAME],
                                                                                 $group[ColumnNames::RESOURCE_GROUP_PARENT_ID]);
            
            $this->BuildParentList($group[ColumnNames::RESOURCE_GROUP_PARENT_ID],$parents);
        }
        $groupsReader->Free();
        
        return $parents;
    }
    
	public static function Example()
	{
		return new ExampleResourceItemResponse();
	}
}

class ExampleResourceItemResponse extends ResourceItemResponse
{
	public function __construct()
	{
		$this->id = 123;
		$this->name = 'resource name';
	}
}
