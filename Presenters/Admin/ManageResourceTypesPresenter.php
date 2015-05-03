<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageResourceTypesPage.php');

class ManageResourceTypesActions
{
	const Add = 'Add';
	const Update = 'Update';
	const Delete = 'Delete';
	const ChangeAttributes = 'ChangeAttributes';
}

class ManageResourceTypesPresenter extends ActionPresenter
{
	/**
	 * @var IManageResourceTypesPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(
		IManageResourceTypesPage $page,
		UserSession $user,
		IResourceRepository $resourceRepository,
		IAttributeService $attributeService)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeService;

		$this->AddAction(ManageResourceTypesActions::Add, 'Add');
		$this->AddAction(ManageResourceTypesActions::Update, 'Update');
		$this->AddAction(ManageResourceTypesActions::Delete, 'Delete');
		$this->AddAction(ManageResourceTypesActions::ChangeAttributes, 'ChangeAttributes');
	}

	public function PageLoad()
	{
		$types = $this->resourceRepository->GetResourceTypes();

		$ids = array();
		foreach ($types as $type)
		{
			$ids[] = $type->Id();
		}

		$attributeList = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE_TYPE, $ids);
		$this->page->BindAttributeList($attributeList);

		$this->page->BindResourceTypes($types);
	}

	public function Add()
	{
		$name = $this->page->GetName();
		$description = $this->page->GetDescription();

		Log::Debug('Adding resource type. Name=%s', $name);

		$this->resourceRepository->AddResourceType(ResourceType::CreateNew($name, $description));
	}

	public function Update()
	{
		$id = $this->page->GetId();
		$name = $this->page->GetName();
		$description = $this->page->GetDescription();

		Log::Debug('Updating resource type id=%s', $id);

		$type = $this->resourceRepository->LoadResourceType($id);

		$type->SetName($name);
		$type->SetDescription($description);

		$this->resourceRepository->UpdateResourceType($type);
	}

	public function ChangeAttributes()
	{
		$id = $this->page->GetId();
		Log::Debug('Changing attributes for resource type id=%s', $id);

		$type = $this->resourceRepository->LoadResourceType($id);

		$attributes = $this->GetAttributeValues();

		$type->ChangeAttributes($attributes);

		$this->resourceRepository->UpdateResourceType($type);
	}

	public function Delete()
	{
		$id = $this->page->GetId();
		Log::Debug('Deleting resource type id=%s', $id);

		$this->resourceRepository->RemoveResourceType($id);
	}

	private function GetAttributeValues()
	{
		$attributes = array();
		foreach ($this->page->GetAttributes() as $attribute)
		{
			$attributes[] = new AttributeValue($attribute->Id, $attribute->Value);
		}
		return $attributes;
	}

	public function ProcessDataRequest($dataRequest)
	{
		if ($dataRequest == 'all')
		{
			$this->page->SetResourceTypesJson(array_map(array('ResourceTypeJson', 'FromResourceType'),
													$this->resourceRepository->GetResourceTypes()));
		}
	}

	protected function LoadValidators($action)
	{
		if ($action == ManageResourceTypesActions::ChangeAttributes)
		{
			$attributes = $this->GetAttributeValues();
			$this->page->RegisterValidator('attributeValidator',
										   new AttributeValidator($this->attributeService, CustomAttributeCategory::RESOURCE_TYPE, $attributes, $this->page->GetId()));
		}
	}
}

class ResourceTypeJson
{
	public $Id;
	public $Name;

	public function __construct($id, $name)
	{
		$this->Id = $id;
		$this->Name = $name;
	}

	/**
	 * @param ResourceType $resourceType
	 * @return ResourceTypeJson
	 */
	public static function FromResourceType($resourceType)
	{
		return new ResourceTypeJson($resourceType->Id(), $resourceType->Name());
	}
}

?>