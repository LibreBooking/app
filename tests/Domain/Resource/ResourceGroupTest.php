<?php

class ResourceGroupTest extends TestBase
{
    public function setUp(): void
    {
        parent::setup();
    }

    public function testGetsAllResourceIdsForGroup()
    {
        $group1 = new ResourceGroup(1, 'group1');
        $group1a = new ResourceGroup(2, 'group1a', 1);
        $group1a1 = new ResourceGroup(3, 'group1a1', 2);

        $resourceGroupTree = new ResourceGroupTree();
        $resourceGroupTree->AddGroup($group1);
        $resourceGroupTree->AddGroup($group1a1);
        $resourceGroupTree->AddGroup($group1a);

        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1a1->id, 'resource1', 1, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null, null));
        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1a1->id, 'resource2', 2, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null, null));
        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1a->id, 'resource3', 3, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null, null));
        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1->id, 'resource4', 4, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null, null));

        $group1a1ResourceIds = $resourceGroupTree->GetResourceIds($group1a1->id);
        $group1aResourceIds = $resourceGroupTree->GetResourceIds($group1a->id);
        $group1ResourceIds = $resourceGroupTree->GetResourceIds($group1->id);

        $this->assertEquals(2, count($group1a1ResourceIds));
        $this->assertEquals(3, count($group1aResourceIds));
        $this->assertEquals(4, count($group1ResourceIds));

        $this->assertEquals([1,2], $group1a1ResourceIds);
        $this->assertEquals([1,2,3], $group1aResourceIds);
        $this->assertEquals([1,2,3,4], $group1ResourceIds);
    }

    public function testGetsGroupById()
    {
        $group1 = new ResourceGroup(1, 'group1');
        $group1a = new ResourceGroup(2, 'group1a', 1);
        $group1a1 = new ResourceGroup(3, 'group1a1', 2);

        $resourceGroupTree = new ResourceGroupTree();
        $resourceGroupTree->AddGroup($group1);
        $resourceGroupTree->AddGroup($group1a);
        $resourceGroupTree->AddGroup($group1a1);

        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1a1->id, 'resource1', 1, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null));
        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1a1->id, 'resource2', 2, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null));
        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1a->id, 'resource3', 3, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null));
        $resourceGroupTree->AddAssignment(new ResourceGroupAssignment($group1->id, 'resource4', 4, null, 1, ResourceStatus::AVAILABLE, null, false, false, false, null, null, 1, null, null));

        $this->assertEquals($group1, $resourceGroupTree->GetGroup(1));
        $this->assertEquals($group1a, $resourceGroupTree->GetGroup(2));
        $this->assertEquals($group1a1, $resourceGroupTree->GetGroup(3));
    }
}
