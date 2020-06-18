<?php

/**
 * Copyright 2017-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceGroupsResponse extends RestResponse
{
    public $groups;

    public function __construct(IRestServer $server, ResourceGroupTree $groupTree)
    {
        $this->groups = $groupTree->GetGroups();
    }

    public static function Example()
    {
        return new ExampleResourceGroupsResponse();
    }
}

class ExampleResourceGroupsResponse extends ResourceGroupsResponse
{
    public function __construct()
    {
        $groups = new ResourceGroupTree();
        $group = new ResourceGroup(0, 'Resource Group 1');
        $group2 = new ResourceGroup(1, 'Resource Group 2');
        $group->AddResource(new ResourceGroupAssignment(0, 'Resource 1', 1, null, 2, ResourceStatus::AVAILABLE, null, false, true, true, 30, 10, 1, '#ffffff', 2));
        $group2->AddResource(new ResourceGroupAssignment(1, 'Resource 2', 1, null, 2, ResourceStatus::AVAILABLE, null, true, false, false, null, null, 2, '#000000', 1));
        $group->AddChild($group2);
        $groups->AddGroup($group);

        $this->groups = $groups->GetGroups();
    }
}
